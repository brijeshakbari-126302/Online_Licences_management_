<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class PublicAndAuthPagesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test the public home landing page renders successfully.
     */
    public function test_home_page_can_be_rendered(): void
    {
        $response = $this->get(route('home'));

        $response->assertStatus(200);
        $response->assertSee('Centralize, Track & Optimize Your', false);
        $response->assertSee('Software Licenses', false);
    }

    /**
     * Test the public about page renders successfully.
     */
    public function test_about_page_can_be_rendered(): void
    {
        $response = $this->get(route('about'));

        $response->assertStatus(200);
        $response->assertSee('About Us', false);
        $response->assertSee('Total Asset Transparency', false);
    }

    /**
     * Test the public contact page renders successfully.
     */
    public function test_contact_page_can_be_rendered(): void
    {
        $response = $this->get(route('contact'));

        $response->assertStatus(200);
        $response->assertSee('Send Us an Inquiry', false);
        $response->assertSee('support@licensehub.pro', false);
    }

    /**
     * Test submitting the contact form validates and redirects with success message.
     */
    public function test_contact_form_submission_validates_and_redirects(): void
    {
        $response = $this->post(route('contact.store'), [
            'name' => 'John Developer',
            'email' => 'john@example.com',
            'category' => 'Enterprise License Help',
            'subject' => 'Need 50 more Docker Desktop seats',
            'message' => 'Please provide information on bulk licensing discounts for engineering teams.',
        ]);

        $response->assertRedirect(route('contact'));
        $response->assertSessionHas('success');
    }

    /**
     * Test contact form requires mandatory fields.
     */
    public function test_contact_form_validation_requires_fields(): void
    {
        $response = $this->post(route('contact.store'), []);

        $response->assertSessionHasErrors(['name', 'email', 'category', 'subject', 'message']);
    }

    /**
     * Test login view renders for unauthenticated users.
     */
    public function test_login_page_can_be_rendered(): void
    {
        $response = $this->get(route('login'));

        $response->assertStatus(200);
        $response->assertSee('Sign In to Dashboard', false);
        $response->assertSee('Corporate Work Email', false);
    }

    /**
     * Test a user can log in with valid credentials.
     */
    public function test_user_can_login_with_valid_credentials(): void
    {
        $user = User::factory()->create([
            'email' => 'admin@licensehub.pro',
            'password' => Hash::make('password'),
        ]);

        $response = $this->post(route('login.submit'), [
            'email' => 'admin@licensehub.pro',
            'password' => 'password',
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertAuthenticatedAs($user);
    }

    /**
     * Test login fails with invalid password.
     */
    public function test_user_cannot_login_with_invalid_credentials(): void
    {
        User::factory()->create([
            'email' => 'admin@licensehub.pro',
            'password' => Hash::make('password'),
        ]);

        $response = $this->post(route('login.submit'), [
            'email' => 'admin@licensehub.pro',
            'password' => 'wrongpassword',
        ]);

        $response->assertSessionHasErrors(['email']);
        $this->assertGuest();
    }

    /**
     * Test registration view renders successfully.
     */
    public function test_register_page_can_be_rendered(): void
    {
        $response = $this->get(route('register'));

        $response->assertStatus(200);
        $response->assertSee('Create Your Account', false);
        $response->assertSee('Full Name', false);
    }

    /**
     * Test a user can register, account is persisted, and user is logged in.
     */
    public function test_user_can_register_and_is_authenticated(): void
    {
        $response = $this->post(route('register.submit'), [
            'name' => 'Sarah Connor',
            'email' => 'sarah.connor@cyberdyne.org',
            'password' => 'securePassword123',
            'password_confirmation' => 'securePassword123',
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertDatabaseHas('users', [
            'email' => 'sarah.connor@cyberdyne.org',
            'name' => 'Sarah Connor',
        ]);
        $this->assertAuthenticated();
    }

    /**
     * Test an authenticated user can log out.
     */
    public function test_authenticated_user_can_logout(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('logout'));

        $response->assertRedirect(route('home'));
        $this->assertGuest();
    }

    /**
     * Test an authenticated user sees their profile details and logout button in dashboard.
     */
    public function test_authenticated_user_sees_logout_button_and_profile_in_dashboard(): void
    {
        $user = User::factory()->create([
            'name' => 'Dr. Emmett Brown',
            'email' => 'emmett.brown@delorean.tech',
        ]);

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Dr. Emmett Brown', false);
        $response->assertSee('emmett.brown@delorean.tech', false);
        $response->assertSee('Log Out', false);
        $response->assertSee('js/jquery.min.js', false);
        $response->assertSee('js/jquery.validate.min.js', false);
        $response->assertSee('js/form-validation.js', false);
    }
}
