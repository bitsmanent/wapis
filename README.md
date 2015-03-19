#### Weather APIs
Simple and coherent interface on top of several weather APIs.

##### Status
It's a bit more than a proof of concept so things may still change drastically.
No help welcomed yet.

##### Interface
* wapis_services(): returns an array of services (names only)
* wapis_query($service, $queryinfo): query the given $service as specified by $queryinfo and returns the response data

The `$queryinfo` is configured like this:
```
$qi = [
        'lat' => 38.1405023, /* Latitude */
        'lon' => 13.3572886, /* Longitude */
        'cnt' => 7, /* Count - # of items (may not be honored) */
        'raw' => 0 /* If true, the response is returned as-is (only for debug) */
];
```

The response data is like this:
```
[service] => forecast
[weather] => Array
    (
        [0] => Array
            (
                [ts] => 1426789436
                [temp] => 57.25
                [windspeed] => 4.10
            )
        ...
```

More data and documentation will be added soon.

##### Services
Currently implemented services are:

* Forecast: [forecast.io](http://forecast.io)
* OpenWeatherMap: [openweathermap.org](http://openweathermap.org)
* WorldWeatherOnline: [worldweatheronline.com](http://worldweatheronline.com)
