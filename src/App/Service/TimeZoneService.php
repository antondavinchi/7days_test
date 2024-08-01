<?php

namespace App\Service;

use DateTime;
use DateTimeZone;
use Exception;

class TimeZoneService
{
    /**
     * @param string $inputTimezone
     * @return string
     * @throws Exception
     */
    public function getOffsetInMinutes(string $inputTimezone): string
    {
        $timezone = new DateTimeZone($inputTimezone);
        $offsetSeconds = $timezone->getOffset(new DateTime());
        $offsetMinutes = $offsetSeconds / 60;

        return $offsetMinutes > 0 ? '+' . $offsetMinutes : $offsetMinutes;
    }

    /**
     * @param string $inputDate
     * @return int
     */
    public function getFebruaryDaysCount(string $inputDate): int
    {
        $currentYear = (int) date($inputDate);
        $february = new DateTime("$currentYear-02-01");

        return (int) $february->format('t');
    }
}
