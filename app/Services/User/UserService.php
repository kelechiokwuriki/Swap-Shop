<?php

namespace App\Services\User;

use App\Repositories\User\UserRepository;
use Illuminate\Support\Facades\Hash;

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
        return $this->userRepository->create($user);
    }
}
