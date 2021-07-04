<?php

namespace Tests\Unit;

use App\Models\Columns;
use App\Models\Pages;
use App\Models\Rows;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ColumnTest extends TestCase
{
    use RefreshDatabase, WithFaker;


    public function createPage()
    {
        $page = Pages::create([
            'name' => $this->faker->name
        ]);

        return $page->id;
    }

    public function createRow()
    {
        $row = Rows::create([
            'name' => $this->faker->name,
            'order' => 1,
            'page_id' => $this->createPage(),
        ]);

        return $row;
    }


    /**
     * Test request validation for row creation
     *
     * @return void
     */
    public function testCreateColumn()
    {
        $row = $this->createRow();

        $this->json('POST', 'api/pages/' . $row->page_id . '/rows/' . $row->id . '/columns',
            ['Accept' => 'application/json'])
            ->assertStatus(201);
    }

    /**
     * Update row
     *
     * @return void
     */
    public function testUpdateColumn()
    {
        $row = $this->createRow();

        $column = Columns::create([
            'name' => $this->faker->name,
            'row_id' => $row->id,
            'order' => 1,
        ]);

        $this->json('PATCH',
            'api/pages/' . $row->page_id . '/rows/' . $row->id . '/columns/' . $column->id,
            ['name' => 'A new updated Column'],
            ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJson([
                "data" => [
                    "name" => "A new updated Column",
                ]
            ]);
    }

    /**
     * Test return page
     *
     * @return void
     */
    public function testReturnColumn()
    {
        $row = $this->createRow();

        $column = Columns::create([
            'name' => $this->faker->name,
            'row_id' => $row->id,
            'order' => 1,
        ]);

        $this->json('GET',
            'api/pages/' . $row->page_id . '/rows/' . $row->id . '/columns/' . $column->id
        )->assertStatus(200);
    }

    /**
     * Test return page
     *
     * @return void
     */
    public function testDeleteColumn()
    {
        $row = $this->createRow();

        $column = Columns::create([
            'name' => $this->faker->name,
            'row_id' => $row->id,
            'order' => 1,
        ]);

        $this->json('DELETE',
            'api/pages/' . $row->page_id . '/rows/' . $row->id . '/columns/' . $column->id
        )->assertStatus(204);
    }

    /**
     * Test add element in columns
     *
     * @return void
     */
    public function testAddElementInColumn()
    {
        $row = $this->createRow();

        $column = Columns::create([
            'name' => $this->faker->name,
            'row_id' => $row->id,
            'order' => 1,
        ]);

        $this->json('POST',
            'api/pages/' . $row->page_id . '/rows/' . $row->id . '/columns/' . $column->id . '/elements',
            [
                'data' => $this->faker->catchPhrase,
                'type' => 'quote',
            ],
            ['Accept' => 'application/json'])
            ->assertStatus(201);
    }

    /**
     * Test add wrong element in column
     *
     * @return void
     */
    public function testAddWrongTypeElement()
    {
        $row = $this->createRow();

        $column = Columns::create([
            'name' => $this->faker->name,
            'row_id' => $row->id,
            'order' => 1,
        ]);

        $this->json('POST',
            'api/pages/' . $row->page_id . '/rows/' . $row->id . '/columns/' . $column->id . '/elements',
            [
                'data' => $this->faker->catchPhrase,
                'type' => 'randomType',
            ],
            ['Accept' => 'application/json'])
            ->assertStatus(422);
    }
}
