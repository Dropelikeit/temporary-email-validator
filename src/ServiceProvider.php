<?php

declare(strict_types=1);

namespace MarcelStrahl\TemporaryValidator;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Illuminate\Support\Facades\Validator;
use MarcelStrahl\TemporaryValidator\Service\TemporaryValidator;

/**
 * @author Marcel Strahl <info@marcel-strahl.de>
 */
class ServiceProvider extends BaseServiceProvider
{
    public function boot(): void
    {
        $this->loadTranslationsFrom(__DIR__.'/../translations', 'validation');

        Validator::extend('not_temporary_email', function ($attribute, $value, $parameters, $validator) {
            return (new TemporaryValidator())->isTemporaryEmailAddress($value);
        });
    }

    public function register(): void
    {
        //
    }
}
