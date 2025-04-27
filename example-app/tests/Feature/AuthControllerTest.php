<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

   public function test_user_can_login_with_correct_credentials()
   {
       $user = User::factory()->create([
           'email' => 'testowe@o2.pl',
           'password' => Hash::make('testowe'),
           'name' => 'Testowe',
       ]);

       $response = $this->postJson('/api/login', [
           'email' => $user->email,
           'password' => 'testowe',
       ]);

       $response->assertStatus(200)
           ->assertJsonStructure(['access_token','refresh_token','user']);

   }
}
