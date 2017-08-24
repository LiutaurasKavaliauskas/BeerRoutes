<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(BreweriesTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(GeocodesTableSeeder::class);
        $this->call(StylesTableSeeder::class);
        $this->call(BeersTableSeeder::class);
    }
}
