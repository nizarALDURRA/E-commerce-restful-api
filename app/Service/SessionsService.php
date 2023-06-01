<?php


namespace App\Service;


use App\Models\Shopping_session;
use App\Models\User;

class SessionsService
{
    public function CheckSessions(User $user): bool
    {
       return (bool)$user->session;
    }

    public function CreateSessions(User $user)
    {
       return !$this->CheckSessions($user) ? $user->session()->create(['total' => 0]):$user->session;
    }

    public function DeleteSessions(User $user)
    {
        $user->session()->delete();
    }
}
