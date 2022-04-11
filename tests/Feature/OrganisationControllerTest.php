<?php

namespace Tests\Feature;

use App\Models\Organisation;
use App\Services\OrganisationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrganisationControllerTest extends TestCase
{
    use RefreshDatabase;

    public $baseUrl = '/api';

   /**
    * Test creating an organisation.
    * @covers OrganisationController::store
    */
    public function testCreateOrganisationSuccess()
    {
         $this->loginUser();

         $this->json('POST', $this->baseUrl . '/organisations', [
                 'name' => 'Test Organisation',
                 'owner_user_id' => $this->user->id,
                 'trial_end' => null,
                 'subscribed' => true,
             ])
             ->assertStatus(201);

         $this->assertDatabaseHas('organisations', [
             'name' => 'Test Organisation',
             'owner_user_id' => $this->user->id,
             'trial_end' => null,
             'subscribed' => true,
         ]);
    }

    /**
    * Test creating an organisation.
    * @covers OrganisationController::store
    */
   public function testCreateOrganisationFailiure()
   {
        $this->loginUser();

        $response = $this->json('POST', $this->baseUrl . '/organisations', [
                'name' => 'Test Organisation',
                'owner_user_id' => 999,
                'trial_end' => 'something invalid',
                'subscribed' => true,
            ])
            ->assertStatus(422);

        $response->assertJson([
            'message' => 'The given data was invalid.',
            'errors' => [
                'owner_user_id' => ['The selected owner user id is invalid.'],
                'trial_end' => ['The trial end is not a valid date.'],
            ],
        ]);
   }

    /**
     * Get a list of organisations.
     * @covers OrganisationController::index
     */
    public function testShowAllOrganisations()
    {
        $this->loginUser();

        $organisation = Organisation::factory()
            ->for($this->user, 'owner')
            ->create();

        $response = $this->get($this->baseUrl . '/organisations');
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
     * @covers OrganisationController::index
     */
    public function testShowAllOrgsFilterSubbed()
    {
        $this->loginUser();
        $this->createOrgsWithVariousSubsriptions();

        $data = $this->json('GET', $this->baseUrl . '/organisations?filter=subbed')
            ->assertStatus(200)
            ->decodeResponseJson()['data'];
        $this->assertCount(1, $data);
    }

    /**
     * @covers OrganisationController::index
     */
    public function testShowAllOrgsFilterTrial()
    {
        $this->loginUser();
        $this->createOrgsWithVariousSubsriptions();

        $data = $this->json('GET', $this->baseUrl . '/organisations?filter=trial')
            ->assertStatus(200)
            ->decodeResponseJson()['data'];
        $this->assertCount(3, $data);
    }

    /**
     * @covers OrganisationController::index
     */
    public function testShowAllOrgsFilterAll()
    {
        $this->loginUser();
        $this->createOrgsWithVariousSubsriptions();

        $data = $this->json('GET', $this->baseUrl . '/organisations?filter=all')
            ->assertStatus(200)
            ->decodeResponseJson()['data'];
        $this->assertCount(6, $data);
    }

    /**
     * create some example organisations with various subscription statuses
     *
     * @return void
     */
    private function createOrgsWithVariousSubsriptions()
    {
        Organisation::factory()->for($this->user, 'owner')->create(['subscribed' => true, 'trial_end' => null]);
        Organisation::factory()->for($this->user, 'owner')->create(['subscribed' => false, 'trial_end' => now()->addDays(30)]);
        Organisation::factory()->for($this->user, 'owner')->create(['subscribed' => false, 'trial_end' => now()->addDays(30)]);
        Organisation::factory()->for($this->user, 'owner')->create(['subscribed' => false, 'trial_end' => now()->addDays(30)]);
        Organisation::factory()->for($this->user, 'owner')->create(['subscribed' => false, 'trial_end' => now()->subDay()]);
        Organisation::factory()->for($this->user, 'owner')->create(['subscribed' => false, 'trial_end' => now()->subDay()]);
    }
}
