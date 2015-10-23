<?php
define('WWONLINE_BASE', 'http://api.worldweatheronline.com/free/v2/weather.ashx');

function wwonline_query($lat, $lon, $cnt) {
	if(!defined('WWONLINE_APIKEY'))
		return 'WWONLINE_APIKEY not set';
	$opts = array(
		'q' => "${lat},${lon}",
		'num_of_days' => $cnt,
		'key' => WWONLINE_APIKEY,
		'format' => 'json',
		'showmap' => 'no',
		'show_comments' => 'no',
		'tp' => '1',
		'date' => 'today'
	);
	$uri = WWONLINE_BASE.'?'.http_build_query($opts);
	if(!($d = file_get_contents($uri)))
		return NULL;
	return wwonline_refine(json_decode($d));
}

function wwonline_refine($data) {
	$data = $data->data;
	$ret = [
		'service' => 'wwonline',
		'weather' => []
	];

	$ret['current'] = [
		'ts' => strtotime($data->current_condition[0]->observation_time),
		'temp' => $data->current_condition[0]->temp_C,
		'windspeed' => $data->current_condition[0]->windspeedKmph,
	];

	$cnt = count($data->weather);
	for($i = 0; $i < $cnt; ++$i) {
		$ts = strtotime($data->weather[$i]->date);
		$hourly = [];
		foreach($data->weather[$i]->hourly as $h) {
			$hts = sprintf("%04d", $h->time); /* Always in four-digits format */
			$mm = substr($hts, -2);
			$hh = substr($hts, 0, 2);
			$hts = strtotime("${hh}:${mm}", $ts);
			$hourly[] = [
				'ts' => $hts,
				'temp' => $h->tempC,
				'windspeed' => $h->windspeedKmph
			];
		}

		$ret['weather'][] = [
			'ts' => $ts,
			'temp' => $data->weather[$i]->hourly[0]->tempC,
			'windspeed' => $data->weather[$i]->hourly[0]->windspeedKmph,
			'hourly' => $hourly
		];
	}

	return $ret;
}


?>
