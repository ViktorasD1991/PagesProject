<?php

namespace Tests\Unit;

use App\Models\Pages;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PageTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Test request validation for page creation
     *
     * @return void
     */
    public function testRequestValidationPageCreation()
    {
        $this->json('POST', 'api/pages', ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "name" => ["The name field is required."],
                ]
            ]);
    }

    /**
     * Test page creation
     *
     * @return void
     */
    public function testPageCreation()
    {
        $this->json('POST', 'api/pages',
            ['name' => 'TestPage'],
            ['Accept' => 'application/json'])
            ->assertStatus(201);
    }

    /**
     * Test return page
     *
     * @return void
     */
    public function testReturnPage()
    {
        $page = Pages::create(['name' => $this->faker->name]);

        $this->json('GET', 'api/pages/' . $page->id)->assertStatus(200);
    }

    /**
     * Update page
     *
     * @return void
     */
    public function testUpdatePage()
    {
        $page = Pages::create(['name' => $this->faker->name]);

        $this->json('PATCH', 'api/pages/' . $page->id,
            ['name' => 'A new updated Page'],
            ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJson([
                "data" => [
                    "name" => "A new updated Page",
                ]
            ]);
    }
}
