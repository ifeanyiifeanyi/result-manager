<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Question;
use Illuminate\Auth\Access\HandlesAuthorization;

class QuestionPolicy
{
    use HandlesAuthorization;

    /**
     * Check if the user is an admin.
     */

     private function isAdmin(User $user): bool
     {
         return $user->role && $user->role->name === 'admin'; // Matches your check
     }
     
    /**
     * Determine whether the user can view any questions.
     */
    public function viewAny(User $user): bool
    {
        return $this->isAdmin($user);
    }

    public function view(User $user, Question $question): bool
    {
        return $this->isAdmin($user);
    }

    /**
     * Determine whether the user can create questions.
     */
    public function create(User $user): bool
    {
        return $this->isAdmin($user);
    }

    public function update(User $user, Question $question): bool
    {
        return $this->isAdmin($user);
    }

    public function delete(User $user, Question $question): bool
    {
        return $this->isAdmin($user);
    }
}
