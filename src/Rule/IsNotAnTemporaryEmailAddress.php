<?php
declare(strict_types=1);

namespace MarcelStrahl\TemporaryValidator\Rule;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;
use TemporaryEmailDetection\ClientFactoryInterface;
use TemporaryEmailDetection\ClientInterface;
use TemporaryEmailDetection\Exception as TemporaryEmailDetectionException;
use Webmozart\Assert\Assert;

/**
 * @author Marcel Strahl <info@marcel-strahl.de>
 */
final class IsNotAnTemporaryEmailAddress implements Rule
{
    private ClientInterface $client;

    private string $email;

    public function __construct(ClientFactoryInterface $clientFactory)
    {
        $this->client = $clientFactory->factorize();
        $this->email = '';
    }

    /**
     * {@inheritDoc}
     */
    public function passes($attribute, $value)
    {
        try {
            Assert::stringNotEmpty($value);
            $this->email = $value;
        } catch (InvalidArgumentException $exception) {
            return false;
        }

        try {
            $isTemporary = $this->client->isTemporary($value);
        } catch (TemporaryEmailDetectionException $exception) {
            $errorMessage = $exception->getMessage();
            Assert::stringNotEmpty($errorMessage);

            $this->logError(__FUNCTION__, $value, $errorMessage);
            return false;
        }

        return !$isTemporary;
    }

    /**
     * @psalm-return non-empty-string
     */
    public function message(): string
    {
        $message = trans('temporary-email-validator::validation.is_temporary_email', [
            'email' => $this->email
        ]);

        Assert::stringNotEmpty($message);

        return $message;
    }

    /**
     * @psalm-param non-empty-string $functionName
     * @psalm-param non-empty-string $exceptionMessage
     */
    private function logError(string $functionName, string $email, string $exceptionMessage): void
    {
        $errorMessage =
            sprintf('%s catched an error with Value %s : %s', $functionName, $email, $exceptionMessage);
        Log::error($errorMessage);
    }
}
