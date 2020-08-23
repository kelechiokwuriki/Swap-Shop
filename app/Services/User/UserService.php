<?php

namespace App\Services\User;

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
        return $this->userRepository->all()->loadCount(['events', 'listings']);
    }

    public function getAllUsersExceptLoggedInUser()
    {
        return $this->userRepository->whereCompare('id', '!=', auth()->id())->withCount(['events', 'listings'])->get();
    }

    public function getAllUsersEmailAddress()
    {
        return $this->userRepository->all()->pluck('email');
    }


    //Update user profile details from profile page
    public function updateUserProfileDetails(int $id, array $details)
    {
        $extractedUserData = $this->extractNameAndEmail($details);

        $extractedUserData['password'] = Hash::make($details['password']);

        return $this->userRepository->update($details['id'], $extractedUserData);
    }

    //the admin uses this method to update user details
    public function updateUserDetailsFromAdmin(int $id, array $details)
    {
        return $this->userRepository->update($id, $details);
    }

    public function deleteUser(int $id)
    {
        return $this->userRepository->delete($id);
    }

    public function retrieveUserProfile($id)
    {
        return $this->userRepository->find($id)->loadCount(['events', 'listings']);
    }

    public function registerUser(array $user)
    {
        $user['password'] = Hash::make(self::DEFAULT_PASS);
        $user['password_needs_reset'] = 1;

        $user = $this->userRepository->create($user);

        event(new Registered($user));


        return $user;
    }

    public function userAcceptTermsOfService(User $user)
    {
        $user->accepted_terms_of_service = Carbon::now()->toDateTime();

        return $user->save();
    }

    private function extractNameAndEmail(array $profile)
    {
        return [
            'name' => $profile['name'],
            'email' => $profile['email'],
        ];
    }
}
