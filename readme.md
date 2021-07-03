### Recognition of temporary e-mail addresses as validator rule for Laravel

[![Latest Stable Version](http://poser.pugx.org/marcel-strahl/temporary-email-validator/v)](https://packagist.org/packages/marcel-strahl/temporary-email-validator) [![Total Downloads](http://poser.pugx.org/marcel-strahl/temporary-email-validator/downloads)](https://packagist.org/packages/marcel-strahl/temporary-email-validator) [![Latest Unstable Version](http://poser.pugx.org/marcel-strahl/temporary-email-validator/v/unstable)](https://packagist.org/packages/marcel-strahl/temporary-email-validator) [![License](http://poser.pugx.org/marcel-strahl/temporary-email-validator/license)](https://packagist.org/packages/marcel-strahl/temporary-email-validator)
[![composer.lock](http://poser.pugx.org/marcel-strahl/temporary-email-validator/composerlock)](https://packagist.org/packages/marcel-strahl/temporary-email-validator)
[![License](http://poser.pugx.org/marcel-strahl/temporary-email-validator/license)](https://packagist.org/packages/marcel-strahl/temporary-email-validator)
![Gitworkflow](https://github.com/Dropelikeit/temporary-email-validator/actions/workflows/ci.yml/badge.svg)

Installation:


```bash
composer require marcel-strahl/temporary-email-validator
```

In versions from 5.3+ you don't need the following step, because we load our package with Discover in Laravel.
Add the ServiceProvider to config/app.php
```php
MarcelStrahl\TemporaryValidator\TemporaryValidatorServiceProvider::class,
```

Add the rule (it's the rule with the name not_temporary_email) like any other rule in Laravel to the validator where you want to use it
```php
$rules = ['required|email|not_temporary_email'];
```

Hint:

I am not the creator of the "Temporary Email Detection" but have changed the following package into a Laravel Validator rule!

Main Package 
```Temporary E-Mail Detection```: 
[https://github.com/jprangenbergde/temporary-email-detection](https://github.com/jprangenbergde/temporary-email-detection)
