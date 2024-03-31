<?php

namespace Tests\Browser;

use App\Models\Advertisement;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTruncation;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Tests\TestCase;

class ApiAccessTest extends TestCase
{


    use DatabaseTruncation;

    /**
     * Test authenticatie vereist voor toegang tot API endpoints.
     */
    public function testAuthenticationRequiredForApiAccess()
    {
        $response = $this->get('/api/advertenties');
        $response->assertRedirect('/login');

        $response = $this->get('/api/advertentie/1');
        $response->assertRedirect('/login');
    }

    /**
     * Test rolgebaseerde toegang en advertenties ophalen functionaliteit.
     */
    public function testRoleBasedAccessAndFetchAdvertisements()
    {
        $role = Role::create(['name' => 'Business']);
        $businessUser = User::factory()->create(['role_id' => $role->id]);

        Advertisement::factory(2)->create(['user_id' => $businessUser->id]);

        $this->actingAs($businessUser, 'sanctum')->get('/api/generateToken');

        $response = $this->actingAs($businessUser, 'sanctum')->getJson('/api/advertenties');
        $response->assertOk()->assertJsonCount(2);
    }

    /**
     * Test toegang weigering voor niet-business gebruikers.
     */
    public function testAccessDeniedForNonBusinessUsers()
    {
        $nonBusinessUser = User::factory()->create([
            'role_id' => Role::where('name', '!=', 'Business')->first()->id, // Niet-business rol.
        ]);
        Advertisement::factory(1)->create(['id' => 1, 'user_id' => $nonBusinessUser->id]);

        $response = $this->actingAs($nonBusinessUser, 'sanctum')->get('/api/advertenties');
        $response->assertForbidden();
        $response = $this->actingAs($nonBusinessUser, 'sanctum')->get('/api/advertentie/1');
        $response->assertForbidden();
    }

    /**
     * Test correcte data wordt opgehaald voor geauthenticeerde business gebruikers.
     */
    public function testDataIntegrityForBusinessUsers()
    {
        $businessUser = User::factory()->create([
            'role_id' => Role::where('name', 'Business')->first()->id,
        ]);

        $advertentie = Advertisement::factory()->create(['user_id' => $businessUser->id]);

        $this->actingAs($businessUser, 'sanctum')->get('/api/generateToken');

        $response = $this->actingAs($businessUser, 'sanctum')->getJson("/api/advertentie/{$advertentie->id}");
        $response->assertOk()->assertJsonFragment(['id' => $advertentie->id]); // Verifieer dat de juiste gegevens worden opgehaald.
    }
}
