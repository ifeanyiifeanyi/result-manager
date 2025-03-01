<?php

namespace App\Services;

use App\Models\Question;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class QuestionService
{
    /**
     * Store multiple questions in bulk.
     */
    public function storeBulk(array $validatedData): bool
    {
        try {
            DB::beginTransaction();

            $academicSessionId = $validatedData['academic_session_id'];
            $questions = $validatedData['questions'];

            foreach ($questions as $questionData) {
                // If an ID exists, we're updating an existing question
                if (isset($questionData['id'])) {
                    $question = Question::findOrFail($questionData['id']);
                    $question->update([
                        'title' => $questionData['title'],
                        'type' => $questionData['type'],
                        'options' => $questionData['options'] ?? null,
                        'is_required' => $questionData['is_required'] ?? true,
                    ]);
                } else {
                    // Otherwise, create a new question
                    Question::create([
                        'academic_session_id' => $academicSessionId,
                        'title' => $questionData['title'],
                        'type' => $questionData['type'],
                        'options' => $questionData['options'] ?? null,
                        'is_required' => $questionData['is_required'] ?? true,
                    ]);
                }
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to store questions in bulk: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Update a specific question.
     */
    public function update(Question $question, array $validatedData): bool
    {
        try {
            // We only update the first question in the array since we're updating a single question
            if (isset($validatedData['questions']) && count($validatedData['questions']) > 0) {
                $questionData = reset($validatedData['questions']);

                $question->update([
                    'title' => $questionData['title'],
                    'type' => $questionData['type'],
                    'options' => $questionData['options'] ?? null,
                    'is_required' => $questionData['is_required'] ?? true,
                ]);
            }

            return true;
        } catch (\Exception $e) {
            Log::error('Failed to update question: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Delete a question.
     */
    public function delete(Question $question): bool
    {
        try {
            return $question->delete();
        } catch (\Exception $e) {
            Log::error('Failed to delete question: ' . $e->getMessage());
            return false;
        }
    }


    public function updateOrder(array $orderData): bool
    {
        try {
            DB::beginTransaction();

            // Update each question with its new position
            foreach ($orderData as $position => $questionId) {
                Question::where('id', $questionId)->update(['display_order' => $position + 1]);
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to update question order: ' . $e->getMessage());
            return false;
        }
    }
}
