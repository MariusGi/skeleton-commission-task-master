<?php

declare(strict_types=1);

namespace MyApp\Output;

class Output
{
    public static function displayResults(array $resultsArr)
    {
        foreach ($resultsArr as $result) {
            echo $result.PHP_EOL;
        }
    }
}
