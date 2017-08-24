<?php

use App\Services\CsvReaderService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BeersTableSeeder extends Seeder
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

        $this->table = 'beers';
        $this->filename = base_path() . '/database/resources/csv/beers.csv';
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table($this->table)->delete();

        $csvReader = new CsvReaderService($this->filename, ',');
        $seedData = $csvReader->getDataFromCsv();

        foreach ($seedData as $t) {
            if ($t['cat_id'] == '-1') {
                $t['cat_id'] = null;
            }

            if ($t['style_id'] == '-1') {
                $t['style_id'] = null;
            }

            DB::table($this->table)->insert($t);
        }
    }
}
