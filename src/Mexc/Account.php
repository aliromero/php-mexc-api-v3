<?php

namespace Romero\Mexc\Mexc;

class Account extends Time
{
	/*
	* get detail account
	*/
	public static function get(): array|bool
	{
		$buildQuery = [
			'recvWindow' => 10000,
			'timestamp' => Time::time(5000)
		];

		$url = config('my_settings.MEXC_URL_API') . '/account?' . BuildHttpQuery::build($buildQuery) . '&signature=' . Signature::signature($buildQuery);
		$ch = curl_init($url);

		curl_setopt_array($ch, [
			CURLOPT_CUSTOMREQUEST => 'GET',
			CURLOPT_HTTPHEADER => [
				'X-MEXC-APIKEY: ' . config('my_settings.MEXC_API_ACCESS_KEY') . ''
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

	/*
	* get spot balance by name ou null to all
	*/
	public static function getSpotBalance(string $assetName = null): array|bool
	{
		$assetName = strtoupper($assetName ?? '');

		$r = self::get();

		if (!$r)
			return false;

		if (empty($assetName)) {
			return $r['balances'];
		}

		$balances = array_filter($r['balances'], function ($balance) use ($assetName) {
			return $balance['asset'] === $assetName;
		});

		$balances = reset($balances);

		if (!$balances)
			return $r['balances'];

		return $balances;
	}


    public static function getDepositHistory(string $coin = null,
                                             string $status = null,
                                             string $startTime = null,
                                             string $endTime = null,
                                             string $limit = null,
    ): array|bool
    {
        $coin = strtoupper($coin ?? '');

        $buildQuery = [
            'coin' => $coin,
            'status' => $status,
            'startTime' => $startTime,
            'endTime' => $endTime,
            'limit' => $limit,
            'timestamp' => Time::time(5000)
        ];

        $url = config('my_settings.MEXC_URL_API') . '/capital/deposit/hisrec?' . BuildHttpQuery::build($buildQuery) . '&signature=' . Signature::signature($buildQuery);
        $ch = curl_init($url);

        curl_setopt_array($ch, [
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => [
                'X-MEXC-APIKEY: ' . config('my_settings.MEXC_API_ACCESS_KEY') . ''
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

    public static function generateDepositWallet(string $coin = null,
                                             string $network = null,
    ): array|bool
    {
        $coin = strtoupper($coin ?? '');

        $buildQuery = [
            'coin' => $coin,
            'network' => $network,
            'timestamp' => Time::time(5000)
        ];

        $url = config('my_settings.MEXC_URL_API') . '/capital/deposit/address?' . BuildHttpQuery::build($buildQuery) . '&signature=' . Signature::signature($buildQuery);
        $ch = curl_init($url);

        curl_setopt_array($ch, [
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_HTTPHEADER => [
                'X-MEXC-APIKEY: ' . config('my_settings.MEXC_API_ACCESS_KEY') . ''
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
