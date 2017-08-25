<?php

namespace Tests\Unit;

use App\Models\Style;
use Tests\TestCase;

class StyleTest extends TestCase
{
    protected $style;

    public function setUp()
    {
        $this->style = new Style([
            'id'         => 1,
            'cat_id'     => 1,
            'style_name' => 'Test',
            'last_mod'   => '2017-08-26 UTC',
        ]);
    }

    public function testStyleHasId()
    {
        $this->assertEquals(1, $this->style->id);
    }

    public function testStyleHasCategoryId()
    {
        $this->assertEquals(1, $this->style->cat_id);
    }

    public function testStyleHasName()
    {
        $this->assertEquals('Test', $this->style->style_name);
    }

    public function testStyleHasLastModDate()
    {
        $this->assertEquals('2017-08-26 UTC', $this->style->last_mod);
    }
}
