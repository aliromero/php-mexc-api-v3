<?php

namespace Romero\Mexc\Mexc;

class Trade extends Time
{
	public static function trade(string $symbol, string $side, string $type, string $quantity, string $price=null): array|bool
	{


        if ($price != null) {
            $buildQuery = [
                'symbol' => $symbol,
                'side' => $side,
                'type' => $type,
                'quantity' => $quantity,
                'price' => $price,
                'recvWindow' => 10000,
                'timestamp' => Time::time(5000)
            ];
        }else {
            $buildQuery = [
                'symbol' => $symbol,
                'side' => $side,
                'type' => $type,
                'quantity' => $quantity,
                'recvWindow' => 10000,
                'timestamp' => Time::time(5000)
            ];
        }


		$url = MEXC_CONFIG['MEXC_URL_API'] . '/order?' . BuildHttpQuery::build($buildQuery) . '&signature=' . Signature::signature($buildQuery);
		$ch = curl_init($url);

		curl_setopt_array($ch, [
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_HTTPHEADER => [
				'X-MEXC-APIKEY: ' . MEXC_CONFIG['MEXC_API_ACCESS_KEY'] . ''
			],
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_SSL_VERIFYPEER => false,
		]);

		$res = curl_exec($ch);

		if (!$res) {
			curl_close($ch);
			return false;
		}

		$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);

		if ($status_code != 200)
			return json_decode($res, true);

		return json_decode($res, true);
	}


}
