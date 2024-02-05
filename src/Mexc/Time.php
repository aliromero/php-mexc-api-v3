<?php

namespace Romero\Mexc\Mexc;

class Time
{

	public static function time(int $recvWindow): int
	{
        date_default_timezone_set('Asia/Tehran');

        $ts = round(microtime(true) * 1000);
		$ts -= $ts % $recvWindow;
		return $ts;
	}
}