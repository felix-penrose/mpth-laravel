<?php

namespace Tests\Feature;

use App\Models\Organisation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrganisationControllerTest extends TestCase
{
    use RefreshDatabase;

//    /**
//     * Test creating an organisation.
//     *
//     * @return void
//     */
//    public function testCreateOrganisation()
//    {
//        $response = $this->json('POST', '/api/organisations', [
//            'name' => 'Test Organisation',
//            'address' => 'Test Address',
//            'postcode' => 'Test Postcode',
//            'city' => 'Test City',
//            'country' => 'Test Country',
//            'email' => '',
//        ]);
//    }

    /**
     * Get a list of organisations.
     *
     * @return void
     */
    public function testShowAllOrganisations()
    {
        $this->loginUser();

        $organisation = Organisation::factory()
            ->for($this->user, 'owner')
            ->create();

        $response = $this->get('/api/organisations');
        $response->assertStatus(200);

        $responseOrg = json_decode($response->getContent())->data[0];
        $responseUser = $responseOrg->owner;


        $this->assertSame($responseOrg->name, $organisation->name);
        $this->assertSame($responseOrg->trial_end, $organisation->trial_end);
        $this->assertSame($responseOrg->subscribed, $organisation->subscribed);

        $this->assertSame($responseUser->name, $this->user->name);
        $this->assertSame($responseUser->email, $this->user->email);
    }

    /**
     * Get a list of organisations.
     *
     * @return void
     */
    public function testShowAllOrganisationsWithFilter()
    {
        $this->loginUser();

        Organisation::factory()->for($this->user, 'owner')->create(['subscribed' => true]);
        Organisation::factory()->for($this->user, 'owner')->create(['subscribed' => false, 'trial_end' => now()->addDays(30)]);
        Organisation::factory()->for($this->user, 'owner')->create(['subscribed' => false, 'trial_end' => now()->addDays(30)]);
        Organisation::factory()->for($this->user, 'owner')->create(['subscribed' => false, 'trial_end' => now()->addDays(30)]);
        Organisation::factory()->for($this->user, 'owner')->create(['subscribed' => false, 'trial_end' => now()->subDay()]);
        Organisation::factory()->for($this->user, 'owner')->create(['subscribed' => false, 'trial_end' => now()->subDay()]);

        $response = $this->get('/api/organisations?filter=subbed');

        dump(json_decode($response->getContent()));

        $response->assertStatus(200);
        $response->assertJsonCount(1);

        $response = $this->get('/api/organisations?filter=trial');

        $response->assertStatus(200);
        $response->assertJsonCount(3);


        $response = $this->get('/api/organisations?filter=all');

        $response->assertStatus(200);
        $response->assertJsonCount(6);
    }
}
