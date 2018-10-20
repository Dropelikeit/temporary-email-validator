### Recognition of temporary e-mail addresses as validator rule for Laravel

Installation:


```php
composer install marcel-strahl/temporary-email-validator
```

In versions from 5.3+ you don't need the following step, because we load our package with Discover in Laravel.
Add the ServiceProvider to config/app.php
```php
MarcelStrahl\TemporaryValidator\TemporaryValidatorServiceProvider::class,
```

Add the rule (it's the rule with the name not_temporary_email) like any other rule in Laravel to the validator where you want to use it
```php
$rules = ['required|email|not_temporary_email']
```

Hint:

I am not the creator of the "Temporary Email Detection" but have changed the following package into a Laravel Validator rule!

Tempory E-Mail Detection: 
[https://github.com/jprangenbergde/temporary-email-detection](https://github.com/jprangenbergde/temporary-email-detection)
