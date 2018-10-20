<?php

declare(strict_types=1);

namespace MarcelStrahl\TemporaryValidator;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use MarcelStrahl\TemporaryValidator\Rule\IsNotAnTemporaryEmailAddress;

/**
 * @author Marcel Strahl <info@marcel-strahl.de>
 */
class ServiceProvider extends BaseServiceProvider
{
    public function boot(): void
    {
        $this->loadTranslationsFrom(__DIR__ . '/../translations', 'temporary-email-validator');

        Validator::extend('not_temporary_email', function ($attribute, $value, $parameters, $validator) {
            $rule = App::make(IsNotAnTemporaryEmailAddress::class);
            return $rule->passes($attribute, $value);
        });
    }

    public function register(): void
    {

    }
}
