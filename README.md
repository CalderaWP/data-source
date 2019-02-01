# Caldera Data Source

This package provides a layer between the source of data and consumption. The idea is that if the database and other sources of data have the same interface, it will not matter what database -- or API -- the data comes from.

## 👀🌋 This Is A Module Of The [Caldera Framework](https://github.com/CalderaWP/caldera)
* 🌋 Find Caldera Forms Here:
    - [Caldera Forms on Github](http://github.com/calderawp/caldera-forms/)
    - [CalderaForms.com](http://calderaforms.com)
    
* 🌋 [Issues](https://github.com/CalderaWP/caldera/issues) and [pull requests](https://github.com/CalderaWP/caldera/pulls), should be submitted to the [main Caldera repo](https://github.com/CalderaWP/caldera/pulls).

    
## Overview
This is used in the forms package for the database, but not for the REST API, which is a bad smell that needs corrected.

## Usage

### Install
* Add to your package:
    - `composer require calderawp/http`
* Install for development:
    - `git clone git@github.com:CalderaWP/http.git && composer install`

### Examples


## Testing
* Run unit tests and integration tests
    - `composer tests`
* Run unit tests
    - `composer test:unit`
* Run integration tests
    - `composer test:integration`

    
## License, Copyright, etc.
Copyright 2018+ CalderaWP LLC and licensed under the terms of the GNU GPL license. Please share with your neighbor.
