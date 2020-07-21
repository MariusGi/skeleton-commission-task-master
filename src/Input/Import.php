<?php

declare(strict_types=1);

namespace MyApp\Input;

class Import
{
    public $errorMessage;

    private $filePath;

    public function __construct(string $filePath)
    {
        if (!file_exists($filePath)) {
            $this->errorMessage = "File path {$filePath} does not exist!";

            return false;
        }

        $this->filePath = $filePath;
    }

    public function convertCsvToArr(): array
    {
        $file = fopen($this->filePath, 'r');
        $rawData = [];

        while ($row = fgetcsv($file)) {
            array_push($rawData, $row);
        }

        fclose($file);
        $header = array_shift($rawData);
        //Removing Byte Order Mark (BOM) in first cell of csv file.
        $header[0] = $this->removeBom($header[0]);
        $data = [];

        foreach ($rawData as $row) {
            $data[] = array_combine($header, $row);
        }

        return $data;
    }

    private function removeBom(string $string): string
    {
        $bom = pack('H*', 'EFBBBF');
        $string = preg_replace("/^$bom/", '', $string);

        return $string;
    }
}
