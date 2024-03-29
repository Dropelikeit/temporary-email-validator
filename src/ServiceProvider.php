<?php
declare(strict_types=1);

namespace MarcelStrahl\TemporaryValidator;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use MarcelStrahl\TemporaryValidator\Rule\IsNotAnTemporaryEmailAddress;
use TemporaryEmailDetection\ClientFactory;
use TemporaryEmailDetection\ClientFactoryInterface;

/**
 * @author Marcel Strahl <info@marcel-strahl.de>
 */
final class ServiceProvider extends BaseServiceProvider
{
    public function boot(): void
    {
        $this->loadTranslationsFrom(__DIR__ . '/../translations', 'temporary-email-validator');

        $this->app->bind(ClientFactoryInterface::class, static function (): ClientFactoryInterface {
            return new ClientFactory();
        });

        Validator::extend('not_temporary_email', function ($attribute, $value, $parameters, $validator): bool {
            /** @var IsNotAnTemporaryEmailAddress $rule */
            $rule = App::make(IsNotAnTemporaryEmailAddress::class);
            return $rule->passes($attribute, $value);
        });
    }

    public function register(): void
    {
        //
    }
}
