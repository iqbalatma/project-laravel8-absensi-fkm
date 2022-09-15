<?php

namespace Tests\Feature\Http\Controllers\API\Auth;

use App\Models\RegistrationCredential;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Illuminate\Support\Str;

class AuthControllerTest extends TestCase
{

    // public function getRegistrationCredentialToken()
    // {
    //     RegistrationCredential::create([
    //         'role_id'=> 4,
    //         'limit'=>100,
    //         'is_active'=> 1,
    //         'token'=> $token =Str::random(8)
    //     ]);

    //     return $token;
    // }

    // public function test_register_success()
    // {
        
    //     $requestData = [
    //         "name"=>"iqbalatma",
    //         "email"=> time()."testregister@gmail.com",
    //         "password"=> "admin123",
    //         "student_id"=>"10117124",
    //         "generation"=>"2017",
    //         "organization_id"=>9,
    //     ];
    //     $token = $this->getRegistrationCredentialToken();

    //     $response = $this->post("/api/register/$token", $requestData);
        
    //     $response->assertStatus(200)
    //         ->assertJson([
    //             'success'=> true,
    //             'name'=> 'Registration',
    //             'message'=> 'Registration user successfully',
    //         ]);
    // }

    // public function test_login_success()
    // {
    //     $password = 'admin1234';
    //     User::create([
    //         "name"=>"iqbalatma",
    //         "email"=> $email = time()."testlogin@gmail.com",
    //         "password"=> Hash::make($password),
    //         "student_id"=>"10117124",
    //         "generation"=>"2017",
    //         "organization_id"=>9,
    //     ]);
    //     $requestData = [
    //         'email'=> $email,
    //         'password'=> $password
    //     ];

    //     $response = $this->post('/api/login', $requestData);
        
    //     $response->assertStatus(200)
    //         ->assertJson([
    //             'success'=>true,
    //             'name'=> 'Login',
    //             'message'=> 'Login user successfully',
    //         ]);
    // }

    // public function testLogin()
    // {
    //     //preparation / prepare
    //     $requestData = [
    //         'email'=> 'iqbalatma@gmail.com',
    //         'password'=> 'admin'
    //     ];

    //     //action / perform
    //     $response = $this->postJson(route('auth.login'), $requestData);

    //     //assertion / predict
    //     $response->assertStatus(200);
    // }


    public function test_while_login_email_field_is_required()
    {
        $this->withExceptionHandling();

        $response = $this->postJson(route('auth.login'));

        // $this->assertStatus(406);

    }
   
}
