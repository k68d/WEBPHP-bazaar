<?php

namespace Tests\Browser;

use App\Models\Contract;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ExportContractTest extends DuskTestCase
{

    use DatabaseMigrations;


    public function testAdminAccessToExportFunction()
    {
        Contract::factory(3)->create();
        $adminUser = User::where('name', 'Admin User')->first();
        $nonAdminUser = User::where('name', '!=', 'Admin User')->first();

        $this->browse(function (Browser $browser) use ($adminUser, $nonAdminUser) {
            $browser->loginAs($nonAdminUser)
                ->visit('/contracts')
                ->assertPathIs('/contracts')
                ->assertDontSee('Exporteer PDF');

            $browser->loginAs($adminUser)
                ->visit('/contracts')
                ->assertPathIs('/contracts')
                ->assertSee('Exporteer PDF');
        });
    }


    public function testExportFunctionalityForAdmin()
    {
        $adminUser = User::where('name', 'Admin User')->first();

        $this->browse(function (Browser $browser) use ($adminUser) {
            $browser->loginAs($adminUser)
                ->visit('/contracts')
                ->assertPathIs('/contracts');
        });
    }

    /**
     * Test of non-admins geen toegang hebben tot de export URL.
     */
    public function testNonAdminAccessToExportURL()
    {
        $nonAdminUser = User::where('name', '!=', 'Admin User')->first();

        $this->browse(function (Browser $browser) use ($nonAdminUser) {
            $browser->loginAs($nonAdminUser)
                ->visit('/contracts/1/download')
                ->assertPathIs('/');
        });
    }
}

