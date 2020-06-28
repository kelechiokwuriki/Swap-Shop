<?php

namespace App\Services\User;

use App\Repositories\User\UserRepository;
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

    public function registerUser(array $user)
    {
        $user['password'] = Hash::make(self::DEFAULT_PASS);
        $user = $this->userRepository->create($user);

        return $user;
    }
}