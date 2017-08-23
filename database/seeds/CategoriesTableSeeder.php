<?php

use App\Services\CsvReaderService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
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

        $this->table = 'categories';
        $this->filename = base_path() . '/database/resources/csv/categories.csv';
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
            DB::table($this->table)->insert($t);
        }
    }
}
