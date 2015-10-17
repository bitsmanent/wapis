<?php
define('FORECAST_BASE', 'https://api.forecast.io/forecast/');

function forecast_query($lat, $lon, $cnt) {
	if(!defined('FORECAST_APIKEY'))
		return 'FORECAST_APIKEY not set';
	/* XXX $cnt not implemented */
	$uri = FORECAST_BASE.FORECAST_APIKEY."/${lat},${lon}";
	$tm = 0;
	if($tm)
		$uri .= ",${tm}";
	$qry = [
		'units' => 'ca',
		'exclude' => 'minutely,hourly,alerts,flags'
	];
	$uri .= '?'.http_build_query($qry);
	if(!($d = file_get_contents($uri)))
		return NULL;
	return forecast_refine(json_decode($d));
}

function forecast_refine($data) {
	$ret = [
		'service' => 'forecast',
		'weather' => []
	];

	$ret['current'] = [
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
