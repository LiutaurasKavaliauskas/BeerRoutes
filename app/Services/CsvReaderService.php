<?php

namespace App\Services;

class CsvReaderService
{
    /**
     * Path of the CSV file
     *
     * @var
     */
    protected $filename;

    /**
     * Deliminator which is used in file
     *
     * @var
     */
    protected $deliminator;

    public function __construct($filename, $deliminator)
    {
        $this->filename = $filename;
        $this->deliminator = $deliminator;
    }

    /**
     * Return filename
     *
     * @return mixed
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * Set filename
     *
     * @param $filename
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;
    }

    /**
     * Return deliminator
     *
     * @return mixed
     */
    public function getDeliminator()
    {
        return $this->deliminator;
    }

    /**
     * Set deliminator
     *
     * @param $deliminator
     */
    public function setDeliminator($deliminator)
    {
        $this->deliminator = $deliminator;
    }

    /**
     * Collect data from a given CSV file and return as array
     *
     * @return array|bool
     */
    public function getDataFromCsv()
    {
        $filename = $this->getFilename();
        $deliminator = $this->getDeliminator();

        if (!file_exists($filename) || !is_readable($filename)) {
            return false;
        }

        $header = null;
        $data = [];
        $handle = fopen($filename, 'r');

        while (($row = fgetcsv($handle, $deliminator)) !== false) {
            if (!$header) {
                $header = $row;
                continue;
            }

            if(count($header) == count($row)) {
                $data[] = array_combine($header, $row);
                continue;
            }
        }

        fclose($handle);

        return $data;
    }
}