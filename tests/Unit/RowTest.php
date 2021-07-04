<?php

namespace Tests\Unit;

use App\Models\Pages;
use App\Models\Rows;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RowTest extends TestCase
{
    use RefreshDatabase, WithFaker;


    public function createPage()
    {
        $page = Pages::create([
            'name' => $this->faker->name
        ]);

        return $page->id;
    }

    /**
     * Test request validation for row creation
     *
     * @return void
     */
    public function testCreateRow()
    {
        $this->json('POST', 'api/pages/' . $this->createPage() . '/rows', ['Accept' => 'application/json'])
            ->assertStatus(201);
    }

    /**
     * Update row
     *
     * @return void
     */
    public function testUpdateRow()
    {
        $page = $this->createPage();

        $row = Rows::create([
            'name' => $this->faker->name,
            'page_id' => $page,
            'order' => 1,
        ]);

        $this->json('PATCH', 'api/pages/' . $page . '/rows/' . $row->id,
            ['name' => 'A new updated Row'],
            ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJson([
                "data" => [
                    "name" => "A new updated Row",
                ]
            ]);
    }

    /**
     * Test return page
     *
     * @return void
     */
    public function testReturnRow()
    {
        $page = $this->createPage();

        $row = Rows::create([
            'name' => $this->faker->name,
            'page_id' => $page,
            'order' => 1,
        ]);

        $this->json('GET', 'api/pages/' . $page . '/rows/' . $row->id)->assertStatus(200);
    }

    /**
     * Test return page
     *
     * @return void
     */
    public function testDeleteRow()
    {
        $page = $this->createPage();

        $row = Rows::create([
            'name' => $this->faker->name,
            'page_id' => $page,
            'order' => 1,
        ]);

        $this->json('DELETE', 'api/pages/' . $page . '/rows/' . $row->id)->assertStatus(204);
    }
}
