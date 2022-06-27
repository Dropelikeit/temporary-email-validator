<?php
declare(strict_types=1);

namespace MarcelStrahl\TemporaryValidator\Tests\Rule;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Translation\ArrayLoader;
use Illuminate\Translation\Translator;
use MarcelStrahl\TemporaryValidator\Rule\IsNotAnTemporaryEmailAddress;
use MarcelStrahl\TemporaryValidator\ServiceProvider;
use Orchestra\Testbench\TestCase;
use TemporaryEmailDetection\ClientFactory;
use TemporaryEmailDetection\ClientFactoryInterface;
use TemporaryEmailDetection\ClientInterface;
use TemporaryEmailDetection\Exception;

/**
 * @author Marcel Strahl <info@marcel-strahl.de>
 */
final class IsNotAnTemporaryEmailAddressTest extends TestCase
{
    public function getPackageProviders($app): array
    {
        return [
            ServiceProvider::class,
        ];
    }

    public function setUp(): void
    {
        parent::setUp();

        $this->app->singleton('Validator', static function () {
            $translator = new Translator(new ArrayLoader(), 'en');

            $validator = new \Illuminate\Validation\Validator($translator, [], []);

            $validator->addImplicitExtension('is_not_temporary', static function (): IsNotAnTemporaryEmailAddress {
                return new IsNotAnTemporaryEmailAddress(new ClientFactory());
            });
        });
    }

    /**
     * @test
     */
    public function canValid(): void
    {
        $email = 'info@marcel-strahl.de';

        $client = $this->createMock(ClientInterface::class);
        $client
            ->expects(self::once())
            ->method('isTemporary')
            ->with($email)
            ->willReturn(false);

        $clientFactory = $this->createMock(ClientFactoryInterface::class);
        $clientFactory
            ->expects(self::once())
            ->method('factorize')
            ->willReturn($client);

        $validatorRule = new IsNotAnTemporaryEmailAddress($clientFactory);

        $isValid = $validatorRule->passes('email', $email);

        $this->assertTrue($isValid);
    }

    /**
     * @test
     */
    public function canHandleInvalid(): void
    {
        $clientFactory = new ClientFactory();

        $validatorRule = new IsNotAnTemporaryEmailAddress($clientFactory);

        $isValid = $validatorRule->passes('email', 'mail@0815.ru');

        $this->assertFalse($isValid);
    }

    /**
     * @test
     */
    public function canAcceptedMessage(): void
    {
        $validator = Validator::make(['email' => 'mail@0815.ru'], [
            'email' => new IsNotAnTemporaryEmailAddress(new ClientFactory()),
        ]);

        $this->assertTrue($validator->fails());

        $errorMessage = $validator->errors()->messages()['email'];

        $this->assertNotEmpty($errorMessage);
        $this->assertSame(
            'The given email "mail@0815.ru" address is a temporary email!',
            current($errorMessage),
        );
    }

    /**
     * @test
     */
    public function canHandleException(): void
    {
        $email = 'info@marcel-strahl.de';

        Log::shouldReceive('error')
            ->once()
            ->with('passes catched an error with Value info@marcel-strahl.de : some error');

        $client = $this->createMock(ClientInterface::class);
        $client
            ->expects(self::once())
            ->method('isTemporary')
            ->with($email)
            ->willThrowException(new Exception('some error'));

        $clientFactory = $this->createMock(ClientFactoryInterface::class);
        $clientFactory
            ->expects(self::once())
            ->method('factorize')
            ->willReturn($client);

        $validatorRule = new IsNotAnTemporaryEmailAddress($clientFactory);

        $isValid = $validatorRule->passes('email', $email);

        $this->assertFalse($isValid);
    }

    /**
     * @test
     */
    public function canHandleEmptyEmail(): void
    {
        $clientFactory = new ClientFactory();

        $validatorRule = new IsNotAnTemporaryEmailAddress($clientFactory);

        $isValid = $validatorRule->passes('email', '');

        $this->assertFalse($isValid);
    }
}
