<?php

declare(strict_types=1);

namespace App\Core;

use DateTime;
use DateTimeZone;

class Token
{
    public $decoded;

    /**
     * Populate token
     *
     * @param array $decoded
     * @return void
     */
    public function populate(array $decoded): void
    {
        $this->decoded = $decoded;
    }

    /**
     * Get uuid
     *
     * @return string
     */
    public function getUuid(): string
    {
        return $this->decoded['sub'];
    }

    /**
     * Check if token is expired
     *
     * @return boolean
     */
    public function isExpired(): bool
    {
        $dateTimeZone = new DateTimeZone('UTC');
        $dateTime = new DateTime('now', $dateTimeZone);

        return $dateTime->getTimestamp() > $this->decoded['exp'] ? true : false;
    }
}
