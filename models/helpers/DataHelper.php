<?php

namespace app\models\helpers;


class DataHelper
{
    public static function renderDate($startDate, $endDate)
    {

        $startDate = strtotime($startDate);
        $startDay = date("d",$startDate);
        $startMonth = date("m",$startDate);

        $endDate = strtotime($endDate);
        $endDay = date("d",$endDate);
        $endMonth = date("m",$endDate);

        if($startMonth == $endMonth && $startDay == $endDay){
            return $startDay.' '.self::getMonthLabelRus($startMonth).', '.self::getDayLabelRus(date("N",$startDate));
        }

        if($startMonth == $endMonth && $startDay != $endDay){
            return $startDay.'-'.$endDay.' '.self::getMonthLabelRus($startMonth);
        }

        if($startMonth != $endMonth && $startDay != $endDay){
            return $startDay.' '.self::getMonthLabelRus($startMonth).' - '.$endDay.' '.self::getMonthLabelRus($endMonth);
        }

        return 'err_date';
    }

    public static function getMonthLabelRus($numMonth)
    {
        $spr = [
            '01' => 'Января',
            '02' => 'Февраля',
            '03' => 'Марта',
            '04' => 'Апреля',
            '05' => 'Мая',
            '06' => 'Июня',
            '07' => 'Июля',
            '08' => 'Августа',
            '09' => 'Сентября',
            '10' => 'Октября',
            '11' => 'Ноября',
            '12' => 'Декабря'
        ];

        return $spr[$numMonth];
    }

    public static function getDayLabelRus($numDay)
    {
        $spr = [
            1 => 'Пн',
            2 => 'Вт',
            3 => 'Ср',
            4 => 'Чт',
            5 => 'Пт',
            6 => 'Сб',
            7 => 'Вс'
        ];

        return $spr[$numDay];
    }
}