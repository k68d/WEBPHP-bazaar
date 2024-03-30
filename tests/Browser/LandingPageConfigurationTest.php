<?php

namespace Tests\Browser;

use App\Models\Advertisement;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTruncation;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LandingPageConfigurationTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     */
    use DatabaseTruncation;

    public function testBusinessRoleAccessToLandingPageSettings()
    {
        $businessUser = User::factory()->create(['role_id' => Role::where('name', 'Business')->first()->id]);
        $nonBusinessUser = User::factory()->create(['role_id' => Role::where('name', '!=', 'Business')->first()->id]);

        $this->browse(function (Browser $browser) use ($businessUser, $nonBusinessUser) {
            $browser->loginAs($nonBusinessUser)
                ->visit('/landingpage-settings/create')
                ->assertSee('403 | Forbidden');

            $browser->loginAs($businessUser)
                ->visit('/landingpage-settings/create')
                ->assertPathIs('/landingpage-settings/create');
        });
    }

    public function testComponentSelectionAndConfiguration()
    {
        $businessUser = User::factory()->create(['role_id' => Role::where('name', 'Business')->first()->id]);

        $this->browse(function (Browser $browser) use ($businessUser) {
            $browser->loginAs($businessUser)
                ->visit('/landingpage-settings/create')
                ->check('components[hero]')
                ->select('hero[template]', '1')
                ->type('hero[title]', 'My Hero Title')
                ->type('hero[secondaryTitle]', 'Secondary Hero Title')
                ->type('hero[image]', 'https://example.com/image.jpg')
                ->check('components[intro]')
                ->type('intro[text]', 'This is an introduction text.')
                ->check('components[highlighted_ads]')
                ->press('Opslaan')
                ->assertPathIs('/landingpage-settings/create');
        });

        $this->browse(function (Browser $browser) use ($businessUser) {
            $browser->loginAs($businessUser)
                ->visit('/landingpage-settings/create')
                ->type('page_url', 'unique-page-url')
                ->check('components[hero]')
                ->select('hero[template]', '1')
                ->type('hero[title]', 'My Hero Title')
                ->type('hero[secondaryTitle]', 'Secondary Hero Title')
                ->type('hero[image]', 'https://example.com/image.jpg')
                ->check('components[intro]')
                ->type('intro[text]', 'This is an introduction text.')
                ->type('text_style[font]', 'Arial')
                ->type('text_style[size]', '16')
                ->check('components[highlighted_ads]')
                ->press('Opslaan')
                ->assertPathIs('/dashboard');
        });


    }

    public function testContentEditingAndSaving()
    {
        $businessUser = User::factory()->create(['role_id' => Role::where('name', 'Business')->first()->id]);

        $this->browse(function (Browser $browser) use ($businessUser) {
            // Bezoek de pagina om een nieuwe landingspagina-configuratie te maken
            $browser->loginAs($businessUser)
                ->visit('/landingpage-settings/create')
                ->type('page_url', 'unique-page-url')
                ->check('components[intro]')
                ->type('intro[text]', 'This is an introduction text.')
                ->type('text_style[font]', 'Arial') // Verplicht veld
                ->type('text_style[size]', '16') // Verplicht veld
                ->press('Opslaan')
                ->assertPathIs('/dashboard'); // Pas dit aan aan je daadwerkelijke logica

            $browser->visit('/landingpage/unique-page-url')
                ->assertSee('This is an introduction text.');

            $browser->visit('/landingpage-settings/edit') // Pas de URL aan op basis van hoe je de bewerkpagina bereikt
                ->type('intro[text]', 'This is updated introduction text.') // Update de introductietekst
                ->press('Update')
                ->assertPathIs('/dashboard'); // Controle op succesvolle opslag

            $browser->visit('/landingpage/unique-page-url')
                ->assertSee('This is updated introduction text.');
        });
    }


    public function testCorrectDisplayOfConfiguredComponents()
    {
        $businessUser = User::factory()->create(['role_id' => Role::where('name', 'Business')->first()->id]);
        Advertisement::factory(10)->create(['user_id' => $businessUser->id]);

        $this->browse(function (Browser $browser) use ($businessUser) {
            $browser->loginAs($businessUser)
                ->visit('/landingpage-settings/create')
                ->type('page_url', 'display-test-page')
                ->type('text_style[font]', 'Arial') // Verplicht veld
                ->type('text_style[size]', '16') // Verplicht veld
                ->check('components[highlighted_ads]')
                ->type('palette[background]', '#000000')
                ->type('palette[text]', '#ffffff')
                ->type('palette[primary]', '#6c757d')
                ->type('palette[secondary]', '#007bff')
                ->type('palette[accent]', '#00FF00')

                ->press('Opslaan')
                ->visit('/landingpage/display-test-page')
                ->assertSee(__('highlighted adverisements'));
        });
    }

}
