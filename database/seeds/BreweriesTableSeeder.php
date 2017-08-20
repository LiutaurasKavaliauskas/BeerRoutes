<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BreweriesTableSeeder extends Seeder
{
    /**
     * DB table name
     *
     * @var string
     */
    protected $table;

    /**
     * CSV filename
     *
     * @var string
     */
    protected $filename;

    public function __construct(){

        $this->table = 'breweries';
        $this->filename = base_path() . '/database/resources/csv/breweries.csv';

    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table($this->table)->delete();
        $seedData = seedFromCSV($this->filename, ',');

        foreach ($seedData as $t) {
            DB::table($this->table)->insert($t);
        }
    }
}
