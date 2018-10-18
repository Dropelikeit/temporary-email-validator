### Recognition of temporary e-mail addresses as validator rule for Laravel

Installation:


```
composer update marcel-strahl/temporary-validator
```

Add the ServiceProvider to config/app.php

```
MarcelStrahl\TemporaryValidator\TemporaryValidatorServiceProvider::class,
```

Add the rule (it's the rule with the name not_temporary_email) like any other rule in Laravel to the validator where you want to use it
```
$rules = ['required|email|not_temporary_email']
```

Hint:

I am not the creator of the "Temporary Email Detection" but have changed the following package into a Laravel Validator rule!

Tempory E-Mail Detection: 
[https://github.com/jprangenbergde/temporary-email-detection](https://github.com/jprangenbergde/temporary-email-detection)