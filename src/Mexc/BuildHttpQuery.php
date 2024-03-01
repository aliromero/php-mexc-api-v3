<?php

namespace Romero\Mexc\Mexc;

class BuildHttpQuery
{
	public static function build(array $params): string
	{
		ksort($params);
        $params = str_replace('+', '%20', http_build_query($params));

        return $params;
	}
}
