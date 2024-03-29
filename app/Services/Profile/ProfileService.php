<?php

namespace App\Services\Profile;

use App\Repositories\User\UserRepository;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

use Illuminate\Auth\Events\Registered;


class UserService
{
    protected $userRepository;

    private const DEFAULT_PASS = 'password';

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getAllUsers()
    {
        return $this->userRepository->all();
    }

    public function getAllUsersEmailAddress()
    {
        return $this->userRepository->all()->pluck('email');
    }

    public function registerUser(array $user)
    {
        $user['password'] = Hash::make(self::DEFAULT_PASS);
        $user['password_needs_reset'] = 1;

        $user = $this->userRepository->create($user);

        return $user;
    }

    public function userAcceptTermsOfService(User $user)
    {
        $user->accepted_terms_of_service = Carbon::now()->toDateTime();

        return $user->save();
    }
}
