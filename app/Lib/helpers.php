<?php

use Illuminate\Support\Facades\DB;


/**
 * Dump and die with exception info
 *
 * @param mixed ...$args
 * @return void
 */
if (!function_exists('ddd'))
{
    function ddd(...$args)
    {
        $e = new \Exception();
        $src = [
                'File' => $e->getTrace()[0]['file'],
                'Line' => $e->getTrace()[0]['line'],
                'Class' => $e->getTrace()[1]['class'],
                'Method' => $e->getTrace()[1]['function']
        ];
        dd($src, ...$args);
    }
}


/**
 * Log or dump runtime query
 *
 * @param boolean $dump
 * @return void
 */
if (!function_exists('qqq'))
{
    function qqq($dump=false)
    {
        if(!$dump)
        {
            DB::enableQueryLog();
        }
        else
        {
            $qlog = DB::getQueryLog(); echo '<pre>'; print_r($qlog); die("\n END " . __METHOD__ . ':' . __LINE__);
        }
    }
}