<?php

declare(strict_types=1);

namespace MyApp\Support;

class Error
{
    public static function displayDataValidationError(array $errorData)
    {
        echo "ERROR: value '{$errorData['value']}' is invalid in column '{$errorData['column']}' of id = {$errorData['id']}."
            .PHP_EOL;
    }

    public static function displayErrorMessage(string $errorMessage)
    {
        echo $errorMessage.PHP_EOL;
    }
}
