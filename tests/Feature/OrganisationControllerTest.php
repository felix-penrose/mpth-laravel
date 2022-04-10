<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrganisationControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test creating an organisation.
     *
     * @return void
     */
    public function testCreateOrganisation()
    {
        $response = $this->json('POST', '/api/organisations', [
            'name' => 'Test Organisation',
            'address' => 'Test Address',
            'postcode' => 'Test Postcode',
            'city' => 'Test City',
            'country' => 'Test Country',
            'email' => '',
        ]);
    }

    /**
     * Get a list of organisations.
     *
     * @return void
     */
    public function testShowAllOrganisations()
    {
        $response = $this->get('/api/organisations');

        $response->assertStatus(200);
    }
}
