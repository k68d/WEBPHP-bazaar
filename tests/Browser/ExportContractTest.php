<?php

namespace Tests\Browser;

use App\Models\Contract;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTruncation;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ExportContractTest extends DuskTestCase
{
    use DatabaseTruncation;

    public function setUp(): void
    {
        parent::setUp();
        app()->setLocale('en');
    }

    public function testAdminAccessToExportFunction()
    {
        Contract::factory(3)->create();
        $adminUser = User::where('name', 'Admin User')->first();
        $nonAdminUser = User::where('name', '!=', 'Admin User')->first();

        $this->browse(function (Browser $browser) use ($adminUser, $nonAdminUser) {
            $browser->loginAs($nonAdminUser)
                ->visit('/contracts')
                ->assertPathIs('/contracts')
                ->assertDontSee(__('texts.export_pdf'));

            $browser->loginAs($adminUser)
                ->visit('/contracts')
                ->assertPathIs('/contracts')
                ->assertSee(__('texts.export_pdf'));
        });
    }

    public function testExportFunctionalityForAdmin()
    {
        $adminUser = User::where('name', 'Admin User')->first();

        Contract::factory(3)->create();

        $this->browse(function (Browser $browser) use ($adminUser) {
            $browser->loginAs($adminUser)
                ->visit('/contracts')
                ->assertSee(__('texts.contracts_overview'))
                ->waitFor('@export-pdf-link') // Assuming you have a dusk selector named 'export-pdf-link'
                ->click('@export-pdf-link')
                ->assertPathIs('/contracts');
        });
    }

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
