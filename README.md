# Lumen Request Log Middleware
Log every request and response of [Lumen PHP Framework](https://github.com/laravel/lumen).
  
 ## Installation
```
$ composer require malvik-lab/lumen-request-log-middleware
```

## Registering Middleware
###### bootstrap/app.php
```php
$app->middleware([
    MalvikLab\LumenRequestLogMiddleware::class,
]);
```

## Set REQUEST_LOG_CHANNEL
###### .env
```
REQUEST_LOG_CHANNEL="request-log"
```
## Set logging
###### config/logging.php
```php
return [
    'channels' => [
        'request-log' => [
            'driver' => 'daily',
            'path' => storage_path('logs/' . php_sapi_name() . '/requests.log'),
            'days' => 30,
        ],
    ],
];
```