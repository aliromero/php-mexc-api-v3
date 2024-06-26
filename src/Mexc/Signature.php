<?php

namespace Romero\Mexc\Mexc;

class Signature
{
	public static function signature(array $params): string
	{
		ksort($params);
		return hash_hmac('sha256', http_build_query($params), config('my_settings.MEXC_API_SECRET'));
	}
}
