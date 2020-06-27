<?php

use Carbon\Carbon;

/**
 * @param DateTimeInterface $startDate
 * @param DateTimeInterface $endDate
 * @return DateTimeInterface
 * @throws Exception
 */
function generateRandomDate(DateTimeInterface $startDate, DateTimeInterface $endDate): DateTimeInterface
{
    $timestamp = random_int($startDate->getTimestamp(), $endDate->getTimestamp());

    return Carbon::createFromTimestamp($timestamp);
}
