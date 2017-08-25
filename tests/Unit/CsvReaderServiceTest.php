<?php

namespace Tests\Unit;

use App\Services\CsvReaderService;
use Tests\TestCase;

class CsvReaderServiceTest extends TestCase
{
    protected $service;

    public function setUp()
    {
        $filename = '/tests/Resources/csv/styles.csv';
        $this->service = new CsvReaderService($filename, ',');
    }

    public function testServiceSetsUpFilenameCorrectly()
    {
        $filename = '/tests/Resources/csv/styles.csv';
        $this->assertEquals($filename, $this->service->getFilename());
    }

    public function testServiceSetsUpDeliminatorCorrecly()
    {
        $this->assertEquals(',', $this->service->getDeliminator());
    }

    public function testServiceGetsDataAndIsNotNull()
    {
        $this->assertNotNull($this->service->getDataFromCsv());
    }

    public function testFileDoesNotExist()
    {
        $filename = '/tests/Resources/csv/not_existing_file.csv';
        $this->service = new CsvReaderService($filename, ',');

        $this->assertFalse($this->service->getDataFromCsv());
    }

    public function testFileIsNotReadable()
    {
        $filename = '/tests/Resources/csv/not_existing_file.csv';
        $this->service = new CsvReaderService($filename, ',');

        $this->assertFalse($this->service->getDataFromCsv());
    }
}
