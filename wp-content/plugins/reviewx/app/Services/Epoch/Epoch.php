<?php

namespace ReviewX\Services\Epoch;

class Epoch extends \DateTimeImmutable
{
    protected static $current = null;

    public static function now()
    {
        self::$current = new self('now');
        return self::$current;
    }

    public static function addDay($day = 1)
    {
        self::$current = (self::now())->modify("+$day day");
        return self::$current;
    }

    public static function subDay($day = 1)
    {
        self::$current = (self::now())->modify("-$day day");
        return self::$current;
    }

    public function startOfDay()
    {
        return (self::$current)->setTime(0,0,0);
    }

    public function endOfDay()
    {
        return (self::$current)->setTime(23,59,59);
    }

    public static function yesterday()
    {
        return self::subDay(1);
    }

    public static function lastWeekStartDay()
    {
        return (self::now())->modify("last week monday");
    }

    public static function lastWeekEndDay()
    {
        return (self::now())->modify("last sunday");
    }

    public static function lastMonth()
    {
        return (self::now())->modify('last month');
    }

    public static function lastYear()
    {
        return (self::now())->modify('last year');
    }
}