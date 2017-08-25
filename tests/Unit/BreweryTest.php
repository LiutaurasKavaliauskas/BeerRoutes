<?php

namespace Tests\Unit;

use App\Models\Brewery;
use Tests\TestCase;

class BreweryTest extends TestCase
{
    protected $brewery;

    public function setUp()
    {
        $this->brewery = new Brewery([
            'id'       => 1,
            'name'     => 'Test Brewery',
            'address1' => 'Address 1',
            'address2' => 'Address 2',
            'city'     => 'Test city',
            'state'    => 'Test state',
            'code'     => 'Test code',
            'country'  => 'Test Country',
            'phone'    => 'Test Phone',
            'website'  => 'Test Website',
            'filepath' => 'Test/file',
            'descript' => 'Testing brewery',
            'add_user' => 1,
            'last_mod' => '2017-08-26 UTC',
        ]);
    }

    public function testBreweryHasId()
    {
        $this->assertEquals(1, $this->brewery->id);
    }

    public function testBreweryHasName()
    {
        $this->assertEquals('Test Brewery', $this->brewery->name);
    }

    public function testBreweryHasAddress1()
    {
        $this->assertEquals('Address 1', $this->brewery->address1);
    }

    public function testBreweryHasAddress2()
    {
        $this->assertEquals('Address 2', $this->brewery->address2);
    }

    public function testBreweryHasCity()
    {
        $this->assertEquals('Test city', $this->brewery->city);
    }

    public function testBreweryHasState()
    {
        $this->assertEquals('Test state', $this->brewery->state);
    }

    public function testBreweryHasCode()
    {
        $this->assertEquals('Test code', $this->brewery->code);
    }

    public function testBreweryHasCountry()
    {
        $this->assertEquals('Test Country', $this->brewery->country);
    }

    public function testBreweryHasPhone()
    {
        $this->assertEquals('Test Phone', $this->brewery->phone);
    }

    public function testBreweryHasWebsite()
    {
        $this->assertEquals('Test Website', $this->brewery->website);
    }

    public function testBreweryHasFilepath()
    {
        $this->assertEquals('Test/file', $this->brewery->filepath);
    }

    public function testBreweryHasDescription()
    {
        $this->assertEquals('Testing brewery', $this->brewery->descript);
    }

    public function testBreweryHasAddUser()
    {
        $this->assertEquals(1, $this->brewery->add_user);
    }

    public function testBreweryHasLastModDate()
    {
        $this->assertEquals('2017-08-26 UTC', $this->brewery->last_mod);
    }
}
