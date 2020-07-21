<?php

declare(strict_types=1);

namespace MyApp\Service;

use MyApp\Support\Helper;

class User
{
    private $userData;

    public function saveUserOperation(string $date, string $userId, string $amount): bool
    {
        $year = Helper::getDateFormat($date, 'Y');
        $weekNumber = Helper::getDateFormat($date, 'W');

        if (isset($this->userData[$userId])) {
            if ($this->userData[$userId]['yearAndWeek'] === $year.$weekNumber) {
                ++$this->userData[$userId]['operationCount'];
                $this->userData[$userId]['amount'] += $amount;

                return true;
            }
        }

        $this->userData[$userId] = [
            'yearAndWeek' => $year.$weekNumber,
            'operationCount' => 1,
            'amount' => $amount,
        ];

        return true;
    }

    public function getUserData(): array
    {
        return $this->userData;
    }
}
