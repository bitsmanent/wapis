<?php
define('FORECAST_BASE', 'https://api.forecast.io/forecast/');

function forecast_query($qi) {
	if(!defined('FORECAST_APIKEY'))
		return 'FORECAST_APIKEY not set';
	$d = forecast_exec($qi['lat'], $qi['lon'], 0);
	if($qi['raw'])
		return $d;
	return forecast_refine($d);
}

function forecast_exec($lat, $lon, $tm) {
	$uri = FORECAST_BASE.FORECAST_APIKEY."/${lat},${lon}";
	if($tm)
		$uri .= ",${tm}";
	$uri .= '?units=ca';
	if(!($d = file_get_contents($uri)))
		return NULL;
	return json_decode($d);
}

function forecast_refine($data) {
	$ret = [
		'service' => 'forecast',
		'weather' => []
	];

	$ret['weather'][] = [
		'ts' => $data->currently->time,
		'temp' => $data->currently->temperature,
		'windspeed' => number_format($data->currently->windSpeed, 2),
	];

	$cnt = count($data->daily->data);
	for($i = 0; $i < $cnt; ++$i) {
		$ret['weather'][] = [
			'ts' => $data->daily->data[$i]->time,
			'temp' => (($data->daily->data[$i]->temperatureMin + $data->daily->data[$i]->temperatureMax) / 2),
			'windspeed' => number_format($data->daily->data[$i]->windSpeed, 2),
		];
	}

	return $ret;
}

?>
