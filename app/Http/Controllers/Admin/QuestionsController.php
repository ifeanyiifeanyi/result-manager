<?php

namespace App\Http\Controllers\Admin;

use App\Models\Question;
use Illuminate\Http\Request;
use App\Models\AcademicSession;
use App\Http\Controllers\Controller;
use App\Http\Requests\BulkStoreQuestionRequest;
use App\Services\QuestionService;

class QuestionsController extends Controller
{
    public function __construct(private QuestionService $questionService) {}


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $activeSession = AcademicSession::active();
        $questions = $activeSession->questions;
        return view('admin.questions.index', compact('questions', 'activeSession'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $activeSession = AcademicSession::active();
        // $questions = $activeSession->questions;
        return view('admin.questions.create', compact('activeSession'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeBulk(BulkStoreQuestionRequest $request)
    {
        $result = $this->questionService->storeBulk($request->validated());

        if ($result) {
            return redirect()->route('admin.questions')
                ->with('success', 'Questions have been successfully created.');
        }

        return back()->with('error', 'Failed to create questions. Please try again.')
            ->withInput();
    }

    /**
     * Show the form for editing the specified question.
     */
    public function edit(Question $question)
    {
        $activeSession = AcademicSession::active();

        return view('admin.questions.edit', compact('question', 'activeSession'));
    }

    /**
     * Update the specified question.
     */
    public function update(BulkStoreQuestionRequest $request, Question $question)
    {
        $result = $this->questionService->update($question, $request->validated());

        if ($result) {
            return redirect()->route('admin.questions')
                ->with('success', 'Question has been successfully updated.');
        }

        return back()->with('error', 'Failed to update question. Please try again.')
            ->withInput();
    }

    /**
     * Remove the specified question.
     */
    public function destroy(Question $question)
    {
        $result = $this->questionService->delete($question);

        if ($result) {
            return redirect()->route('admin.questions')
                ->with('success', 'Question has been successfully deleted.');
        }

        return back()->with('error', 'Failed to delete question. Please try again.');
    }

    /**
     * Update the display order of questions.
     */
    public function reorder(Request $request)
    {


        $orderData = json_decode($request->input('order'), true);

        if (!is_array($orderData)) {
            return back()->with('error', 'Invalid order data provided.');
        }

        $result = $this->questionService->updateOrder($orderData);

        if ($result) {
            return back()->with('success', 'Question order has been updated successfully.');
        }

        return back()->with('error', 'Failed to update question order. Please try again.');
    }
}
