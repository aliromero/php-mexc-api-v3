<?php

namespace Romero\Mexc\Mexc;

class BuildHttpQuery
{
	public static function build(array $params): string
	{
		ksort($params);
        $params = http_build_query($params, '', '&', PHP_QUERY_RFC3986);
        return $params;
	}
}
