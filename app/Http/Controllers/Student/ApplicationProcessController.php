<?php

namespace App\Http\Controllers\Student;


use Yabacon\Paystack;
use App\Models\Answer;
use App\Models\School;
use App\Models\Payment;
use App\Models\Question;
use App\Models\Application;
use Illuminate\Http\Request;
use App\Models\AcademicSession;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use App\Services\StudentProfileService;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\ApplicationSubmitRequest;

class ApplicationProcessController extends Controller
{

    public function showAwaitingResults()
    {
        $application = Application::where('user_id', request()->user()->id)
            ->with(['payments', 'user'])
            ->latest()
            ->first();

        if (!$application || $application->payment_status !== Application::PAYMENT_PAID) {
            return redirect()->route('student.application.start')
                ->with('error', 'No successful application found.');
        }

        return view('student.application.awaiting-results', compact('application'));
    }

    public function showApplicationStatus()
    {
        return view('student.application.status');
    }

    public function showApplicationForm(StudentProfileService $profileService)
    {
        $activeSession = AcademicSession::active();
        $user = request()->user();
        $missingFields = $profileService->getMissingRequiredFields($user);

        if (!$activeSession) {
            return redirect()->back()->with('error', 'No active academic session available for applications');
        }

        //check if student already has an application
        $application = request()->user()->applications()
            ->where('academic_session_id', $activeSession->id)
            ->with('payments')
            ->latest()
            ->first();

        // application questions
        $questions = $activeSession->questions;
        return view('student.application.start', compact(
            'questions',
            'activeSession',
            'application',
            'missingFields',
            'user'
        ));
    }

    public function submitApplication(ApplicationSubmitRequest $request)
    {
        DB::beginTransaction();

        try {
            $validatedData = $request->validated();
            $activeSession = AcademicSession::active();
            $user = request()->user();

            // Check if application already exists
            $existingApplication = Application::where('user_id', $user->id)
                ->where('academic_session_id', $activeSession->id)
                ->first();

            if ($existingApplication) {
                return redirect()->back()->with('error', 'You have already submitted an application for this session');
            }

            // Get school details for fee
            $school = School::first();
            if (!$school || !$school->paystack_subaccount_code) {
                throw new \Exception('School configuration or Paystack subaccount code missing');
            }

            // Calculate fees
            $admissionFee = $school->admission_fee ?? 5000;
            $paystackFee = $this->calculatePaystackFee($admissionFee);
            $developerCharge = 500;
            $totalChargedAmount = $admissionFee + $paystackFee + $developerCharge;

            // Create application
            $application = Application::create([
                'user_id' => $user->id,
                'academic_session_id' => $activeSession->id,
                'application_number' => Application::generateApplicationNumber(),
                'status' => Application::STATUS_DRAFT,
                'payment_status' => Application::PAYMENT_PENDING,
                'submitted_at' => now()
            ]);

            // Process and save answers
            foreach ($validatedData['answers'] as $questionId => $answer) {
                $question = Question::findOrFail($questionId);

                if ($question->type === 'file' && $request->hasFile("answers.{$questionId}")) {
                    $filePath = $request->file("answers.{$questionId}")->store('application_files');
                    $answer = $filePath;
                }

                Answer::create([
                    'application_id' => $application->id,
                    'question_id' => $questionId,
                    'answer' => is_array($answer) ? json_encode($answer) : $answer
                ]);
            }

            // Prepare payment data with subaccount, main account as bearer
            $paymentData = [
                'amount' => $totalChargedAmount * 100, // Paystack uses kobo
                'email' => $user->email,
                'reference' => $application->id . '_' . uniqid(),
                'callback_url' => route('payment.callback'),
                'subaccount' => 'ACCT_3e7r99ufk6stte9',
                // 'subaccount' => $school->paystack_subaccount_code,
                'bearer' => 'account', // Main account bears the charges
            ];

            // Initialize Paystack transaction using HTTP
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . trim(config('services.paystack.secret_key')),
                'Content-Type' => 'application/json',
            ])->post('https://api.paystack.co/transaction/initialize', $paymentData);

            if (!$response->successful()) {
                throw new \Exception('Paystack initialization failed: ' . ($response->json()['message'] ?? 'Unknown error'));
            }

            $responseData = $response->json();
            if (!$responseData['status'] || !isset($responseData['data']['authorization_url'])) {
                throw new \Exception('Invalid Paystack response');
            }

            // Create payment record
            $payment = Payment::create([
                'application_id' => $application->id,
                'amount' => $admissionFee,
                'total_charged' => $totalChargedAmount,
                'paystack_fee' => $paystackFee,
                'developer_charge' => $developerCharge,
                'reference' => $paymentData['reference'],
                'status' => 'pending',
                'currency' => 'NGN'
            ]);

            DB::commit();

            return redirect($responseData['data']['authorization_url']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Application Submission Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Payment initialization failed: ' . $e->getMessage());
        }
    }
    /**
     * Calculate Paystack transaction fee
     *
     * @param float $amount Base amount
     * @return float Calculated Paystack fee
     */
    private function calculatePaystackFee($amount)
    {
        // Paystack fee structure (as of 2024)
        // 1.5% + ₦100 for amounts below 2,500
        // 1.5% for amounts 2,500 - 50,000
        // 1.5% for first 50,000, then 1% for amount above 50,000
        if ($amount < 2500) {
            return max(round($amount * 0.015, 2), 100);
        } elseif ($amount <= 50000) {
            return round($amount * 0.015, 2);
        } else {
            $fee = (50000 * 0.015) + (($amount - 50000) * 0.01);
            return round($fee, 2);
        }
    }

    public function handlePaymentCallback(Request $request)
    {
        DB::beginTransaction();
        try {
            $reference = $request->query('reference');
            if (!$reference) {
                throw new \Exception('No payment reference provided');
            }

            // Extract application ID and find records
            $applicationId = explode('_', $reference)[0];
            $application = Application::findOrFail($applicationId);
            $payment = $application->payments()->where('reference', $reference)->firstOrFail();

            // Verify transaction with Paystack
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . trim(config('services.paystack.secret_key')),
                'Content-Type' => 'application/json',
            ])->get("https://api.paystack.co/transaction/verify/{$reference}");

            if (!$response->successful()) {
                throw new \Exception('Paystack verification failed: ' . ($response->json()['message'] ?? 'Unknown error'));
            }

            $responseData = $response->json();
            if (!$responseData['status'] || strtolower($responseData['data']['status']) !== 'success') {
                $payment->update([
                    'status' => 'failed',
                    'paystack_response' => json_encode($responseData['data'])
                ]);
                DB::commit();
                return redirect()->route('student.application.start')
                    ->with('error', 'Payment verification failed');
            }

            // Update payment and application records
            $payment->update([
                'status' => 'success',
                'paid_at' => now(),
                'paystack_response' => json_encode($responseData['data'])
            ]);

            $application->update([
                'payment_status' => Application::PAYMENT_PAID,
                'status' => Application::STATUS_SUBMITTED
            ]);

            DB::commit();

            return view('student.application.awaiting-results', [
                'application' => $application
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Payment Callback Error: ' . $e->getMessage());
            return redirect()->route('student.application.start')
                ->with('error', 'Payment processing failed: ' . $e->getMessage());
        }
    }



}
