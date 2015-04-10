#### Weather APIs
Simple and coherent interface on top of several weather APIs.

##### Status
It's a bit more than a proof of concept so things may still change drastically.
No help welcomed yet.

##### Interface
* wapis_services(): returns an array of services (names only)
* wapis_query($service, $latitude, $longitude, $count): query the given $service as for specified coordinates

The ``$service`` argument is a string representing the service (see *services*
below). No explanation needed for ``$latitude`` and ``$longitude``. The
``$count`` parameter set the number of records to retrieve, if supported by the
services. Note that the ``$count`` parameter may not be honored.

A call to wapis_query() produces a response data like this:
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

Optionally, the ``current`` key may be filled with the current weather
informations. More data and documentation will be added soon.

##### Services
Here are the currently implemented services:
* [Forecast.io](http://forecast.io) - forecast
* [OpenWeatherMap](http://openweathermap.org) - owmap
* [WorldWeatherOnline](http://worldweatheronline.com) - wwonline
