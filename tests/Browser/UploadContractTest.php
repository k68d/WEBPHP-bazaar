<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class UploadContractTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     */
    public $text = 'Dit is een test contract.';

    public function testAdminCanCreateContract()
    {
        $adminUser = User::where('name', 'Admin User')->first(); // Vervang dit met een geschikte methode om een admin gebruiker te verkrijgen
        $user1 = User::where('id', '!=', $adminUser->id)->first();
        $user2 = User::where('id', '!=', $adminUser->id)->where('id', '!=', $user1->id)->first();
        dump($this->text);

        $this->browse(function (Browser $browser) use ($adminUser, $user1, $user2) {
            $browser->loginAs($adminUser)
                ->visit('/contracts/create')
                ->assertSee('Maak een nieuw contract')
                ->select('user_id_one', $user1->id)
                ->select('user_id_two', $user2->id)
                ->type('description', "{$this->text}")
                ->type('contract_date', now()->format('d-m-Y'))
                ->type('status', 'Concept')
                ->click('@submit-contract-button')
                ->assertPathIs('/contracts')
                ->assertSee($user1->name)
                ->assertSee($user2->name)
                ->assertSee($this->text);
        });

        $this->assertDatabaseHas('contracts', ['description' => $this->text]);
    }

    public function testConfirmContract()
    {
        $adminUser = User::where('name', 'Admin User')->first();
        $user1 = User::where('id', '!=', $adminUser->id)->first();
        $user2 = User::where('id', '!=', $adminUser->id)->where('id', '!=', $user1->id)->first();
        dump($this->text);

        $this->browse(function (Browser $browser) use ($adminUser, $user1, $user2) {
            $browser->loginAs($user1)
                ->visit('/contracts')
                ->assertSee($this->text)
                ->assertSee($user1->name)
                ->assertSee($user2->name);
        });
    }

    public function testNonAdminCannotCreateContract()
    {
        $user1 = User::where('name', 'Standard User')->first();
        $user2 = User::where('name', 'Business User')->first();
        $user3 = User::where('name', 'Private User')->first();

        $this->browse(function (Browser $browser) use ($user1, $user2, $user3) {
            $browser->loginAs($user1)
                ->visit('/contracts/create')
                ->assertPathIs('/');

            $browser->loginAs($user2)
                ->visit('/contracts/create')
                ->assertPathIs('/');
            $browser->loginAs($user3)
                ->visit('/contracts/create')
                ->assertPathIs('/');
        });
    }

    public function testCannotSelectSameUserForContract()
    {
        $adminUser = User::where('name', 'Admin User')->first(); // Vervang dit met een geschikte methode om een admin gebruiker te verkrijgen
        $user1 = User::where('id', '!=', $adminUser->id)->first();
        $user2 = User::where('id', '!=', $adminUser->id)->where('id', '!=', $user1->id)->first();

        $this->browse(function (Browser $browser) use ($adminUser, $user1, $user2) {
            $browser->loginAs($adminUser)
                ->visit('/contracts/create')
                ->assertSee('Maak een nieuw contract')
                ->select('user_id_one', $user1->id)
                ->select('user_id_two', $user1->id)
                ->type('description', 'Dit is een test contract.')
                ->type('contract_date', now()->format('d-m-Y'))
                ->type('status', 'Concept')
                ->click('@submit-contract-button')
                ->assertPathIs('/contracts/create')
                ->assertSee('The user id one field and user id two must be different.')
                ->assertSee('The user id two field and user id one must be different.');
        });
    }
}
