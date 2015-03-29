<?php

/* services */
include('services/forecast.php');
include('services/owmap.php');
include('services/wwonline.php');

/* globals */
global $WAPIS_SERVICES;
$WAPIS_SERVICES = ['forecast', 'owmap', 'wwonline'];

/* function implementations */
function wapis_services() {
	global $WAPIS_SERVICES;
	return $WAPIS_SERVICES;
}

function wapis_query($service, $lat, $lon, $cnt) {
	$fn = "${service}_query";
	if(!function_exists($fn))
		return null;
	return $fn($lat, $lon, $cnt);
}

?>
