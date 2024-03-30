<?php

namespace Tests\Browser;

use App\Models\Advertisement;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class AdvertisementQrCodeTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     */
    public function testQrCodeDisplayOnAdvertisementPage()
    {
        $user = User::factory()->create(['role_id' => Role::where('name', 'Standard')->first()->id]);
        $advertisement = Advertisement::factory()->create(['user_id' => $user->id]);

        $this->browse(function (Browser $browser) use ($user, $advertisement) {
            $browser->loginAs($user)
                ->visit('/advertenties/' . $advertisement->id)
                ->assertVisible('.qr-code');
        });
    }
}
