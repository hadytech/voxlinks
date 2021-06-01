<?php

namespace ReviewX\Controllers\Admin\Email\Filter\Logic;

// use Carbon\Carbon;
use ReviewX\Services\Epoch\Epoch;

trait DateRanges
{
    protected function getRangeToday()
    {
        // $tz = wp_timezone();
        return [
            // Carbon::now($tz)->startOfDay()->format('Y-m-d H:i:s'),
            // Carbon::now($tz)->endOfDay()->format('Y-m-d H:i:s')
            Epoch::now()->startOfDay()->format('Y-m-d H:i:s'),
            Epoch::now()->endOfDay()->format('Y-m-d H:i:s')
        ];
    }

    protected function getRangeYesterday()
    {
        // $tz = wp_timezone();
        return [
            // Carbon::yesterday($tz)->startOfDay()->format('Y-m-d H:i:s'),
            // Carbon::yesterday($tz)->endOfDay()->format('Y-m-d H:i:s')
            Epoch::yesterday()->startOfDay()->format('Y-m-d H:i:s'),
            Epoch::yesterday()->endOfDay()->format('Y-m-d H:i:s')
        ];
    }

    protected function getRangeLastWeek()
    {
       $previous_week = strtotime("-1 week +1 day");

       $start_week = strtotime("last monday midnight",$previous_week);
       $end_week = strtotime("next sunday",$start_week);

       $start_week = date("Y-m-d H:i:s",$start_week);
       $end_week = date("Y-m-d H:i:s",$end_week);

       return [
           (new Epoch($start_week))->setTime(0,0,0)->format('Y-m-d H:i:s'),
           (new Epoch($end_week))->setTime(23, 59, 59)->format('Y-m-d H:i:s')
       ];

        // $tz = wp_timezone();

        // $previousWeekFirstDay = Carbon::now($tz)->startOfWeek()->subDay();
        // $previousWeekLastDay = Carbon::now($tz)->startOfWeek()->subDay();

        // return [
        //     $previousWeekFirstDay->startOfWeek()->startOfDay()->format('Y-m-d H:i:s'),
        //     $previousWeekLastDay->endOfWeek()->endOfDay()->format('Y-m-d H:i:s')
        // ];

    }

    protected function getRangeThisMonth()
    {
        $tz = wp_timezone();

        return [
            // Carbon::now($tz)->firstOfMonth()->format('Y-m-d H:i:s'),
            // Carbon::now($tz)->endOfMonth()->format('Y-m-d H:i:s'),
            Epoch::now()->modify('first day of this month')->setTime(0,0,0)->format('Y-m-d H:i:s'),
            Epoch::now()->modify('last day of this month')->setTime(23, 59, 59)->format('Y-m-d H:i:s'),
        ];
    }

    protected function getRangeLastMonth()
    {
        // $tz = wp_timezone();
        // $lastMonth = Carbon::now($tz)->firstOfMonth()->subDay();

        // return [
        //     $lastMonth->firstOfMonth()->format('Y-m-d H:i:s'),
        //     $lastMonth->endOfMonth()->format('Y-m-d H:i:s'),
        // ];
        return [
            Epoch::lastMonth()->modify('first day of this month')->setTime(0,0,0)->format('Y-m-d H:i:s'),
            Epoch::lastMonth()->modify('last day of this month')->setTime(23, 59, 59)->format('Y-m-d H:i:s'),
        ];        
    }

    protected function getRangeThisYear()
    {
        // $tz = wp_timezone();

        // return [
        //     Carbon::now($tz)->firstOfYear()->startOfDay()->format('Y-m-d H:i:s'),
        //     Carbon::now($tz)->endOfYear()->endOfDay()->format('Y-m-d H:i:s')
        // ];
        return [
            Epoch::now()->modify('first day of january this year')->setTime(0,0,0)->format('Y-m-d H:i:s'),
            Epoch::now()->modify('last day of december this year')->setTime(23, 59, 59)->format('Y-m-d H:i:s'),
        ];
    }

    protected function getRangeLastYear()
    {
        // $tz = wp_timezone();
        // $lastYear = Carbon::now($tz)->firstOfYear()->subDay();

        // return [
        //     $lastYear->firstOfYear()->startOfDay()->format('Y-m-d H:i:s'),
        //     $lastYear->endOfYear()->endOfDay()->format('Y-m-d H:i:s'),
        // ];
        return [
            Epoch::lastYear()->modify('first day of january this year')->setTime(0,0,0)->format('Y-m-d H:i:s'),
            Epoch::lastYear()->modify('last day of december this year')->setTime(23, 59, 59)->format('Y-m-d H:i:s'),
        ];
    }

    protected function getRangeAllTheTime()
    {
        // $tz = wp_timezone();

        // return [
        //     '1976-01-01 00:00:00',
        //     Carbon::now($tz)->format('Y-m-d H:i:s')
        // ];
        return [
            '1976-01-01 00:00:00',
            Epoch::now()->format('Y-m-d H:i:s')
        ];
    }

    protected function getRangeCustomDate()
    {
        return [
            (new Epoch($this->request['start_date']))->setTime(0,0,0)->format('Y-m-d H:i:s'),
            (new Epoch($this->request['end_date']))->setTime(23,59,59)->format('Y-m-d H:i:s'),
        ];
    }
}