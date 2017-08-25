<?php

namespace Tests\Unit;

use App\Models\Beer;
use Tests\TestCase;

class BeerTest extends TestCase
{
    protected $beer;

    public function setUp()
    {
        $this->beer = new Beer([
            'id'         => 1,
            'brewery_id' => 1,
            'name'       => 'Beer Name',
            'cat_id'     => 1,
            'style_id'   => 1,
            'abv'        => 1,
            'ibu'        => 1,
            'srm'        => 1,
            'upc'        => 1,
            'filepath'   => 'beer/filename',
            'descript'   => 'Delicious and cold beer',
            'add_user'   => 1,
            'last_mod'   => '2017-08-26 17:00 UTC',
        ]);
    }

    public function testBeerHasId()
    {
        $this->assertEquals(1, $this->beer->id);
    }

    public function testBeerHasBreweryId()
    {
        $this->assertEquals(1, $this->beer->brewery_id);
    }

    public function testBeerHasAName()
    {
        $this->assertEquals('Beer Name', $this->beer->name);
    }

    public function testBeerHasCategoryId()
    {
        $this->assertEquals(1, $this->beer->cat_id);
    }

    public function testBeerHasStyleId()
    {
        $this->assertEquals(1, $this->beer->style_id);
    }

    public function testBeerHasAbv()
    {
        $this->assertEquals(1, $this->beer->abv);

    }

    public function testBeerHasIbu()
    {
        $this->assertEquals(1, $this->beer->ibu);
    }

    public function testBeerHasSrm()
    {
        $this->assertEquals(1, $this->beer->srm);
    }

    public function testBeerHasUpc()
    {
        $this->assertEquals(1, $this->beer->upc);
    }

    public function testBeerHasFilepath()
    {
        $this->assertEquals('beer/filename', $this->beer->filepath);
    }

    public function testBeerHasDescription()
    {
        $this->assertEquals('Delicious and cold beer', $this->beer->descript);
    }

    public function testBeerHasAddUser()
    {
        $this->assertEquals(1, $this->beer->add_user);
    }

    public function testBeerHasLastModDate()
    {
        $this->assertEquals('2017-08-26 17:00 UTC', $this->beer->last_mod);
    }
}
