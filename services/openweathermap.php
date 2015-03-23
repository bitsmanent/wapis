<?php
define('OWMAP_BASE', 'http://api.openweathermap.org/data/2.5/forecast/daily');

function owmap_query($qi) {
	$d = owmap_exec($qi['lat'], $qi['lon'], $qi['cnt'], 'json');
	if($qi['raw'])
		return $d;
	return owmap_refine($d);
}

function owmap_exec($lat, $lon, $cnt, $mode) {
	$qry = [
		'lat' => $lat,
		'lon' => $lon,
		'cnt' => $cnt,
		'mode' => $mode,
		'units' => 'metric'
	];
	$uri = OWMAP_BASE.'?'.http_build_query($qry);
	if(!($d = file_get_contents($uri)))
		return NULL;
	return json_decode($d);
}

function owmap_refine($data) {
	$ret = [
		'service' => 'owmap',
		'weather' => []
	];

	$cnt = $data->cnt;
	for($i = 0; $i < $cnt; ++$i) {
		$ret['weather'][] = [
			'ts' => $data->list[$i]->dt,
			'temp' => $data->list[$i]->temp->day,
			'windspeed' => number_format($data->list[$i]->speed / 1000 * 3600, 2), /* mps -> kmph */
		];
	}
	return $ret;
}

?>
