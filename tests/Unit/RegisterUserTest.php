<?php

namespace Tests\Unit;

use App\Repositories\User\UserRepository;
use Tests\TestCase;
use App\User;
use App\Role;
use App\Services\User\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class RegisterUserTest extends TestCase
{
    use RefreshDatabase;

    protected $userService;
    protected $userRepository;
    protected $userToCreate;

    public function setup(): void
    {
        parent::setup();

        //user setup
        $this->user = User::create([
            'name' => 'Test User',
            'email' => 'test@test.com',
            'password' => Hash::make('password'),
            'api_token' => Str::random(80),
            'remember_token' => Str::random(10)
        ]);

        $adminRole = Role::create([
            'name' => 'admin'
        ]);

        $this->user->roles()->attach($adminRole);

        $this->actingAs($this->user);

        $this->userRepository = new UserRepository(new User());
        $this->userService = new UserService($this->userRepository);

        //listing request setup
        $this->userRequest = new \stdClass();
        $this->userRequest->name = 'name testing';
        $this->userRequest->email = 'emailtesting@emailtesting.com';

        //listing to be sent from front end
        $this->userToCreate = [
            'name' => $this->userRequest->name,
            'email' => $this->userRequest->email,
        ];
    }
    public function testPostUser()
    {
        $response = $this->json(
            'POST',
            '/api/users',
            $this->userToCreate,
            [
                'Authorization' => 'Bearer ' . $this->user->api_token
            ]
        );

        $response->assertStatus(201);
        $this->assertDatabaseHas('users', $this->userToCreate);
    }

    public function testCreateUser()
    {
        $user = [
            'name' => 'test name',
            'email' => 'fakeemail@fake.com',
            'password' => Hash::make('testpassword')
        ];

        $user = $this->userService->registerUser($user);

        $foundUser = User::where('name', $user['name'])->first();

        $this->assertEquals($user['email'], $foundUser->email);
    }
}
