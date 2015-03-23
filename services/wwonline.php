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
		'show_comments' => 'no',
		'tp' => 24, /* 24h intval (daily) */
		'date' => 'today',
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

	$ret['weather'][] = [
		'ts' => strtotime($data->current_condition[0]->observation_time),
		'temp' => $data->current_condition[0]->temp_C,
		'windspeed' => $data->current_condition[0]->windspeedKmph,
	];

	$cnt = count($data->weather);
	for($i = 0; $i < $cnt; ++$i) {
		$ret['weather'][] = [
			'ts' => strtotime($data->weather[$i]->date),
			'temp' => $data->weather[$i]->hourly[0]->tempC,
			'windspeed' => $data->weather[$i]->hourly[0]->windspeedKmph,
		];
	}

	return $ret;
}


?>
