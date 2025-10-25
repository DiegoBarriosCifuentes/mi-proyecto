<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Question;

class QuestionPolicy
{
    // Puede actualizar si es el autor
    public function update(User $user, Question $question): bool
    {
        return $question->user_id === $user->id;
    }

    // Puede eliminar si es el autor
    public function delete(User $user, Question $question): bool
    {
        return $question->user_id === $user->id;
    }
}
