# Underscore

[![Build Status](https://travis-ci.org/Im0rtality/Underscore.svg?branch=master)](https://travis-ci.org/Im0rtality/Underscore)
[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/Im0rtality/Underscore/badges/quality-score.png?s=a360715f49ea4bba225b7991146981ca80b61337)](https://scrutinizer-ci.com/g/Im0rtality/Underscore/)
[![Code Coverage](https://scrutinizer-ci.com/g/Im0rtality/Underscore/badges/coverage.png?s=e9c5669f300b4d8cb96d0fa8645119ab546fbd62)](https://scrutinizer-ci.com/g/Im0rtality/Underscore/)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/d7ef44af-707d-4638-b91e-8fd043dc99e0/mini.png)](https://insight.sensiolabs.com/projects/d7ef44af-707d-4638-b91e-8fd043dc99e0)

Functional programming library for PHP

# Code example

Library aims to be as easy to use as possible. Here is example of doing some not-so-meaningful operations to show off:

```php
    Underscore::from([1,2,3,4,5])
            // convert array format
        ->map(function($num) { return ['number' => $num];})
            // filter out odd elements
        ->filter(function($item) { return ($item['number'] % 2) == 0;})
            // vardump elements
        ->invoke(function($item) { var_dump($item);})
            // changed my mind, I only want numbers
        ->pick('number')
            // add numbers to 1000
        ->reduce(function($sum, $num) { $sum += $num; return $sum; }, 1000)
            // take result
        ->value();
            // 1006
```

# Motivation

Originaly I needed functional programming magic for other project, so had to pick one lib or write my own.

There is several PHP ports of UnderscoreJS, however none of those fit my requirements (nice code, easy to write, standardized):
 - [brianhaveri/Underscore.php](https://github.com/brianhaveri/Underscore.php) - not maintained, messy code
 - [Anahkiasen/underscore-php](https://github.com/Anahkiasen/underscore-php) - Laravel4 package => incompatible with PSR-2

# Installation

Via composer:

    $ composer require im0rtality/underscore:*

Composer docs recommend to use specific version. You can look them up in [Releases](https://github.com/Im0rtality/Underscore/releases).

# Documentation

See [wiki](https://github.com/Im0rtality/Underscore/wiki/Intro)

# Tests

Tests generate coverage reports in clover.xml format

    $ vendor/bin/phpunit

# License

MIT License: You can do whatever you want as long as you include the original copyright.
