# WebmunkeezCQRSBundle

This bundle unleashes the __Command-Query-Responsibility-Segregation__ pattern on Symfony applications.

## Installation

Use Composer to install this bundle:

```console
$ composer require webmunkeez/cqrs-bundle
```

Add the bundle in your application kernel:

```php
// config/bundles.php

return [
    // ...
    Webmunkeez\ADRBundle\WebmunkeezCQRSBundle::class => ['all' => true],
    // ...
];
```