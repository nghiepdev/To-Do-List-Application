<?php

namespace App\Policies;

use App\Models\Todo;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TodoPolicy
{
    use HandlesAuthorization;

    public function updateAndDelete(User $user, Todo $todo)
    {
        return $user->id == $todo->user_id;
    }
}
