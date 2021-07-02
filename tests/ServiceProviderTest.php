<?php
declare(strict_types=1);

namespace MarcelStrahl\TemporaryValidator\Tests;

use Illuminate\Support\Facades\Lang;
use MarcelStrahl\TemporaryValidator\ServiceProvider;
use Orchestra\Testbench\TestCase;

/**
 * @author Marcel Strahl <info@marcel-strahl.de>
 */
final class ServiceProviderTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        // additional setup
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     *
     * @return string[]
     */
    protected function getPackageProviders($app): array
    {
        return [
            ServiceProvider::class,
        ];
    }

    /**
     * @test
     */
    public function hasProviderLoaded(): void
    {
        $this->assertTrue(
            $this->app->providerIsLoaded(ServiceProvider::class),
        );
    }

    /**
     * @test
     */
    public function hasLoadedTranslations(): void
    {
        $this->assertTrue(
            Lang::has('temporary-email-validator::validation.is_temporary_email', 'de'),
        );

        $this->assertTrue(
            Lang::has('temporary-email-validator::validation.is_temporary_email', 'en'),
        );
    }
}
