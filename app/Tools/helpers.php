<?php
/**
 * Created by PhpStorm.
 * User: purelightme
 * Date: 2018/10/22
 * Time: 17:10
 */
if (!function_exists('getImageUrl')){
    function getImageUrl($name){
        if (empty($name))
            return '';
        if (\Illuminate\Support\Str::startsWith($name,['http']))
            return $name;
        return 'http://'.env('ENDPOINT').'/'.$name;
    }
}

if (!function_exists('getImageUrls')){
    function getImageUrls($names){
        if (empty($names))
            return [];
        return array_map(function ($name){
            if (\Illuminate\Support\Str::startsWith($name,['http']))
                return $name;
            return 'http://'.env('ENDPOINT').'/'.$name;
        },$names);
    }
}


if (!function_exists('getDateArray')) {
    function getDateArray($start,$end, $format = 'Y-m-d')
    {
        $dateData = [];
        $startDay = \Illuminate\Support\Carbon::createFromTimeString($start);
        $endDay = \Illuminate\Support\Carbon::createFromTimeString($end)->addDay();
        $dateData[] = $startDay->format($format);
        while(true){
            $next = $startDay->addDays(1);
            if ($next->gte($endDay))
                break;
            if ($next->between($startDay,$endDay))
                $dateData[] = $next->format($format);
            $startDay = $next;
        }
        return $dateData;
    }
}

if (!function_exists('arraySort')){
    function arraySort($array, $keys, $sort = 'SORT_DESC') {
        $keysValue = [];
        foreach ($array as $k => $v) {
            $keysValue[$k] = $v[$keys];
        }
        array_multisort($keysValue, $sort, $array);
        return $array;
    }
}

if (!function_exists('buildLabel')){
    function buildLabel($type,$text){
        return "<span class='label label-{$type}'>{$text}</span>";
    }
}

if (!function_exists('buildLink')){
    function buildLink($type,$href,$text){
        return "<a class='btn btn-xs btn-{$type}' role='button' href='{$href}'>{$text}</a>";
    }
}

if (!function_exists('displayHumanTime')){
    function displayHumanTime($time){
        return \Illuminate\Support\Carbon::createFromTimeString($time)->diffForHumans();
    }
}

