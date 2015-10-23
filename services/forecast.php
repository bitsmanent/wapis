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
		'exclude' => 'minutely,alerts,flags'
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
	foreach($data->daily->data as $d) {
		if(--$cnt < 0)
			break;
		$hourly = [];
		$ret['weather'][] = [
			'ts' => $d->time,
			'temp' => (($d->temperatureMin + $d->temperatureMax) / 2),
			'windspeed' => number_format($d->windSpeed, 2),
			'hourly' => []
		];
	}

	/* Handle hourly... */
	$i = 0;
	$idx = 0;
	$hourly = [];
	foreach($data->hourly->data as $h) {

		/* next day */
		if($i && !($i % 24)) {
			$ret['weather'][$idx]['hourly'] = $hourly;
			$hourly = [];
			++$idx;
		}

		$hourly[] = [
			'ts' => $h->time,
			'temp' => $h->temperature,
			'windspeed' => number_format($h->windSpeed, 2)
		];

		++$i;
	}
	$ret['weather'][$idx]['hourly'] = $hourly;

	return $ret;
}

?>
