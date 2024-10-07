# Laravel Mail Log

Creates a log of all mail sending and sent in a database table to help with auditing mail.

Able to store and provide:

- Date
- To emails
- From emails
- CC emails
- BCC emails
- Subject
- Body
- Status
- Error


## Installation


```bash
composer require hxm/laravel-mail-log
```

* Run migrations to create database table:
```bash
php artisan migrate
```
* Publishing the config file
```bash
php artisan vendor:publish --tag=maillog
```
* This is the default content of the config file:

```php
return [
    'send_message' => [
        'save_error' => true, // enable save error to database,
        'throw_exception' => true, //If set false, exceptions during email sending will not be thrown.
    ],
    'send_swift_message' => [
        'save_error' => true, // enable save error to database,
        'throw_exception' => false, //If set false, exceptions during email sending swift message will not be thrown.
    ],
    // route config
    'route' => [
        'enable' => true,
        'domain' => null,
        'middleware' => ['web'],
        'prefix' => 'mail-logs',
        'as' => 'mail-logs'
    ],
    //prune config
    'prune' => [
        'enable' => true,  
        'days' => 30 //integer
    ]
];
```

This package will automatically register the event listeners and data will be inserted into database.

An eloquent model exists if you wish to query the data back out as: `HXM\LaravelMailLog\Models\MailLog`

Please note currently for Laravel 7+ until tested and verified in lower versions.
