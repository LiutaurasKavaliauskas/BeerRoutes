<?php

namespace Tests\Unit;

use App\Models\Category;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    protected $category;

    public function setUp()
    {
        $this->category = new Category([
            'id'       => 1,
            'cat_name' => 'Test category',
            'last_mod' => '2017-08-26 UTC',
        ]);
    }

    public function testCategoryHasId()
    {
        $this->assertEquals(1, $this->category->id);
    }

    public function testCategoryHasCategoryName()
    {
        $this->assertEquals('Test category', $this->category->cat_name);
    }

    public function testCategoryHasLastModDate()
    {
        $this->assertEquals('2017-08-26 UTC', $this->category->last_mod);
    }
}
