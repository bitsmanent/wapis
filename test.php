<?php
require('wapis.php');

define('FORECAST_APIKEY', '');
define('WWONLINE_APIKEY', '');

function main() {
	$str = 'Palermo, Italy';
	$t = str2coords($str);
	if(!$t)
		die("${str}: no coordinates found.\n");
	$services = wapis_services();
	foreach($services as $s) {
		$d = wapis_query($s, $t['lat'], $t['lng'], 7);
		if($d) {
			foreach($d['weather'] as &$w)
				$w['ht'] = date('d-m-Y h:m', $w['ts']);
		}
		echo strtoupper($s).":\n".print_r($d, 1)."\n\n";
	}
}

main();
?>
