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


## Installation


```bash
composer require hxm/laravel-mail-log
```

Run migrations to create database table:
```bash
php artisan migrate
```

This package will automatically register the event listeners and data will be inserted into database.

An eloquent model exists if you wish to query the data back out as: `HXM\LaravelMailLog\Models\MailLog`

Please note currently for Laravel 7+ until tested and verified in lower versions.
