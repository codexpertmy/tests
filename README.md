## Common PHP unit utility for testing
[![tests](https://github.com/codexpertmy/tests/actions/workflows/tests.yml/badge.svg)](https://github.com/codexpertmy/tests/actions/workflows/tests.yml)
This package is used to packaging collection of utility for unit testing in PHP

## Installation

You can install the package via composer:

```bash
composer require codexpertmy/tests 
```

### Usage basic

```php
<?php 

use Codexpert\Faker\HttpFaker;
use PHPUnit\Framework\TestCase as PHPUnit;

class DemoTest extends PHPUnit 
{
    public function test_should_create_task()
    {   
        $expected = HttpFaker::create()->shouldResponseJson(200,[],'{"status":200,"data":{}}');

        //this will return guzzle client interface
        $expected->faker();

        $response = $expected->faker()->post('/tasks');

        echo $response->getBody();
        echo $response->getStatusCode();

    }  
}

```


### Testing

```bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.


### Security

If you discover any security related issues, please email tajulasri@codexpert.my instead of using the issue tracker.

