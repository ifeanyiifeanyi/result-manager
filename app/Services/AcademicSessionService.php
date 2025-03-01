<?php

namespace App\Services;

use App\Models\AcademicSession;
use Illuminate\Support\Facades\DB;

class AcademicSessionService
{
    /**
     * Create a new academic session.
     *
     * @param array $data
     * @return AcademicSession
     */
    public function createSession(array $data)
    {
        // If this session is being set as active, deactivate all others
        if (isset($data['is_active']) && $data['is_active']) {
            $this->deactivateAllSessions();
        }

        return AcademicSession::create($data);
    }

     /**
     * Update an existing academic session.
     *
     * @param AcademicSession $session
     * @param array $data
     * @return AcademicSession
     */
    public function updateSession(AcademicSession $session, array $data)
    {
        // If this session is being set as active, deactivate all others
        if (isset($data['is_active']) && $data['is_active'] && !$session->is_active) {
            $this->deactivateAllSessions();
        }

        $session->update($data);
        return $session;
    }

    /**
     * Delete an academic session.
     *
     * @param AcademicSession $session
     * @return bool
     */
    public function deleteSession(AcademicSession $session)
    {
        // Additional logic could be added here, such as:
        // - Check if session has any associated records before deletion
        // - Archive instead of delete
        return $session->delete();
    }
      /**
     * Toggle active status for an academic session.
     *
     * @param AcademicSession $session
     * @return AcademicSession
     */
    public function toggleActive(AcademicSession $session)
    {
        DB::transaction(function () use ($session) {
            // If setting this session as active
            if (!$session->is_active) {
                $this->deactivateAllSessions();
                $session->is_active = true;
            } else {
                // If deactivating, just set to false
                $session->is_active = false;
            }
            $session->save();
        });

        return $session;
    }

    /**
     * Deactivate all academic sessions.
     *
     * @return void
     */
    private function deactivateAllSessions()
    {
        AcademicSession::where('is_active', true)
            ->update(['is_active' => false]);
    }
}
