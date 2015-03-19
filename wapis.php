<?php
define('PATH_SERVICES', 'services');

/* include all services */
foreach(glob(PATH_SERVICES.'/*.php') as $s)
	include($s);

global $WAPIS;
$WAPIS = [
	'forecast' => 'forecast_query',
	'openweathermap' => 'owmap_query',
	'worldweatheronline' => 'wwonline_query',
	//'ilmeteoit' => 'ilmeteoit_query',
];

function wapis_getall() {
	global $WAPIS;
	return $WAPIS;
}

function wapis_get($service, $qi) {
	global $WAPIS;
	return (isset($WAPIS[$service]) ? $WAPIS[$service]($qi) : null);
}

/* facilities */
function str2coords($str) {
	$str = rawurlencode($str);
	$uri = "http://maps.googleapis.com/maps/api/geocode/json?address=${str}&sensor=true";
	$d = json_decode(file_get_contents($uri), 1);
	return (@$d['results'][0]['geometry']['location']);
}

function wapis_for($str, $callback) {
	$t = str2coords($str);
	if(!$t)
		die("${str}: no coordinates found.\n");
	$lat = $t['lat'];
	$lon = $t['lng'];
	$qi = [
		'lat' => $lat,
		'lon' => $lon,
		'cnt' => 7,
		'raw' => 0
	];
	$services = wapis_getall();
	foreach($services as $s => $h)
		$callback($s, $h, $qi);
}

/* debug */
/*
wapis_for('Palermo, Italy', function($s, $h, $qi) {
	echo strtoupper($s).":\n".print_r(wapis_get($s, $qi), 1)."\n\n";
});
*/

?>
