<?php
define('PATH_SERVICES', 'services');

/* include all services */
foreach(glob(PATH_SERVICES.'/*.php') as $s)
	include($s);

global $WAPIS;
$WAPIS = [
	'forecast' => 'forecast_query',
	'worldweatheronline' => 'wwonline_query',
	'openweathermap' => 'owmap_query',
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

?>
