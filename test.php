<?php
require('wapis.php');

define('FORECAST_APIKEY', '');
define('WWONLINE_APIKEY', '');
define('OWMAP_APIKEY', '');

function main() {
	$str = 'Palermo, Italy';
	$geo = strgeo($str);
	if(!($geo && ($coords = $geo['coords'])))
		die("${str}: no coordinates found.\n");

	global $WAPIS_SERVICES;
	$WAPIS_SERVICES = ['forecast'];

	$services = wapis_services();
	echo "GEO:\n".print_r($geo, 1)."\n\n";
	foreach($services as $s) {
		$d = wapis_query($s, $coords['lat'], $coords['lng'], 7);
		if($d) {
			foreach($d['weather'] as &$w) {
				$w['ht'] = date('d-m-Y', $w['ts']);
				foreach($w['hourly'] as &$h)
					$h['ht'] = date('d-m-Y H:i', $h['ts']);
			}
		}
		echo strtoupper($s).":\n".print_r($d, 1)."\n\n";
	}
}

main();
?>
