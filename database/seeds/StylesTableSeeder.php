<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StylesTableSeeder extends Seeder
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

        $this->table = 'styles';
        $this->filename = base_path() . '/database/resources/csv/styles.csv';

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
