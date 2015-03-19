<?php
require('wapis.php');

define('WWONLINE_APIKEY', '');
define('FORECAST_APIKEY', '');

function str2coords($str) {
	$str = rawurlencode($str);
	$uri = "http://maps.googleapis.com/maps/api/geocode/json?address=${str}&sensor=true";
	$d = json_decode(file_get_contents($uri), 1);
	return (@$d['results'][0]['geometry']['location']);
}

function main() {
	$str = 'Palermo, Italy';
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
	$services = wapis_services();
	foreach($services as $s => $h)
		echo strtoupper($s).":\n".print_r(wapis_query($s, $qi), 1)."\n\n";
}

main();
?>
