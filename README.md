#### Weather APIs
Simple and coherent interface on top of several weather APIs.

##### Status
It's a bit more than a proof of concept so things may still change drastically.
No help welcomed yet.

##### Interface
* wapis_services(): returns an array of services (names only)
* wapis_query($service, $queryinfo): query the given $service as specified by $queryinfo and returns the response data

``$service`` is a string representing the service (see *services* below).

The `$queryinfo` is configured like this:
```
$qi = [
        'lat' => 38.1405023,    /* Latitude */
        'lon' => 13.3572886,    /* Longitude */
        'cnt' => 7,             /* Count - # of items (may not be honored) */
        'raw' => 0              /* If true, the response is returned as-is (only for debug) */
];
```

Which produces a response data like this:
```
[service] => forecast
[weather] => Array
    (
        [0] => Array
            (
                [ts] => 1426789436      /* Timestamp of the weather observation, if available */
                [temp] => 57.25         /* temperature in celsius degrees */
                [windspeed] => 4.10     /* wind speed in kmph */
            )
        ...
```

More data and documentation will be added soon.

##### Services
Here are the currently implemented services along with the strings that wapis uses to identify them:
* [Forecast.io](http://forecast.io) - forecast
* [OpenWeatherMap](http://openweathermap.org) - owmap
* [WorldWeatherOnline](http://worldweatheronline.com) - wwonline
