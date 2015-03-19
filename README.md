Weather APIs
============
Simple and coherent interface on top of several weather APIs.

Status
======
It's a bit more than a proof of concept so things may still change drastically.
No help welcomed yet.

Interface
=========
* wapis_services(): returns an array of services (names only)
* wapis_query($service, $queryinfo): query the given $service as specified by $queryinfo and returns the response data

Services
========
Currently implemented services are:

* Forecast: [forecast.io](http://forecast.io)
* OpenWeatherMap: [openweathermap.org](http://openweathermap.org)
* WorldWeatherOnline: [worldweatheronline.com](http://worldweatheronline.com)
