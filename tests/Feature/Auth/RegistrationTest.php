<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register(): void
    {
        $response = $this->post('/register', [
            'nom' => 'Ait Saleh',
            'prenom' => 'Amine',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'cin' => 'AB123456',              
            'date_naissance' => '2000-01-01',
            'telephone' => '0600000000',    
            
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect('/patient/dashboard');
    }
}
