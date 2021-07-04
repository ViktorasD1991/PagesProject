<?php

namespace Tests\Unit;

use App\Models\Columns;
use App\Models\Elements;
use App\Models\Images;
use App\Models\Pages;
use App\Models\Rows;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ImagesTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Return Images
     *
     * @return void
     */
    public function testReturnImages()
    {
        $this->json('GET', 'api/images',
            ['Accept' => 'application/json'])
            ->assertStatus(200);
    }

    /**
     * Assign an image to column
     *
     * @return void
     */
    public function testDeleteImageBelongingToColumn()
    {
        $image = Images::first();

        $page = Pages::create([
            'name' => $this->faker->name
        ]);

        $row = Rows::create([
            'name' => $this->faker->name,
            'order' => 1,
            'page_id' => $page->id
        ]);

        $column = Columns::create([
            'name' => $this->faker->name,
            'row_id' => $row->id,
            'order' => 1,
        ]);

        Elements::create([
            'column_id' => $column->id,
            'type' => 'image',
            'data' => $image->path
        ]);

        $this->json('DELETE', 'api/images/'.$image->id)->assertStatus(403);
    }
}
