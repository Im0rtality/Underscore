# Underscore

[![Build Status](https://travis-ci.org/Im0rtality/Underscore.png?branch=master)](https://travis-ci.org/Im0rtality/Underscore)

Functional programming library for PHP

# Code example
```php
    Underscore::from([1,2,3,4,5])
            // convert array format
        ->map(function($num) { return ['number' => $num]];})
            // filter out odd elements
        ->filter(function($item) { return $item['num'] % 2;})
            // vardump elements
        ->each('vardump')
            // changed my mind, I only want numbers
        ->pluck('number')
            // add numbers to 1000
        ->reduce(function($sum, $num) { $sum += $num; return $sum; }, 1000)
            // take result
        ->value();
            // should be 1006
```
# Motivation
Originaly I needed functional programming magic for other project, so had to pick one lib or write my own.

There is several PHP ports of UnderscoreJS, however none of those fit my requirements (nice code, easy to write, standardized):
 - [brianhaveri/Underscore.php](https://github.com/brianhaveri/Underscore.php) - not maintained, messy code
 - [Anahkiasen/underscore-php](https://github.com/Anahkiasen/underscore-php) - Laravel4 package => incompatible with PSR-2

# Installation
Via composer:

    $ composer require Im0rtality/Underscore:dev-master

Composer docs recommend to use specific version. You can look them up in [Releases](https://github.com/Im0rtality/Underscore/releases).

# API Reference

- toArray
- each
- map
- reduce
- reduceRight
- pluck
- contains

## TODO
- invoke
- any
- all
- filter
- reject
- find
- size
- head
- tail
- initial
- last
- compact
- flatten
- without
- uniq
- intersection
- union
- difference
- indexOf
- lastIndexOf
- range
- zip
- max
- min
- sortBy
- groupBy
- sortedIndex
- shuffle
- keys
- values
- extend
- defaults
- methods
- clone
- tap
- has
- isEqual
- isEmpty
- isObject
- isArray
- isString
- isNumber
- isBoolean
- isFunction
- isDate
- isNaN
- identity
- uniqueId
- times
- mixin
- memoize
- throttle
- once
- wrap
- compose
- after

# Tests
Tests generate coverage reports
    $ phpunit

# License
MIT License: You can do whatever you want as long as you include the original copyright.
