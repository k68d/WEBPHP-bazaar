<?php

namespace Tests\Browser;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTruncation;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class BulkAdvertisementsUploadTest extends DuskTestCase
{
    use DatabaseTruncation;

    public function setUp(): void
    {
        parent::setUp();
        app()->setLocale('en');
    }

    /**
     * Test het uploaden van een CSV met advertenties en het toevoegen van afbeeldingen.
     */
    public function testCsvUploadAndImageAssignment()
    {
        $sampleCsvPath = base_path('tests/Browser/sample_advertisements.csv');
        $sampleImagePath = base_path('tests/Browser/sample_image.jpg');

        $user = User::factory()->create([
            'role_id' => Role::where('name', 'Business')->first()->id
        ]);

        $this->browse(function (Browser $browser) use ($user, $sampleCsvPath, $sampleImagePath) {
            $browser->loginAs($user)
                ->visit('/advertenties/upload')
                ->assertSee(__('texts.upload_csv'))
                ->attach('csv_file', $sampleCsvPath)
                ->press('@upload-csv-button')
                ->waitForRoute('advertenties.upload.overview', [], 7)
                ->assertSee(__('texts.csv_overview'));

            $advertentieIds = $browser->script('return Array.from(document.querySelectorAll("[dusk^=afbeelding-]")).map(function(el) { return el.getAttribute("data-id"); });')[0];

            foreach ($advertentieIds as $id) {
                $browser->attach("afbeeldingen[$id]", $sampleImagePath)
                    ->pause(100);
            }

            $browser->press('@upload-all')
                ->waitForRoute('advertenties.index', [], 7)
                ->assertPathIs('/advertenties');
        });
    }
}
