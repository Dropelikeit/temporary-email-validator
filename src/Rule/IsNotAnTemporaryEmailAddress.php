<?php

declare(strict_types=1);

namespace MarcelStrahl\TemporaryValidator\Rule;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Log;
use TemporaryEmailDetection\Client;
use TemporaryEmailDetection\ClientFactory;
use TemporaryEmailDetection\Exception as TemporaryEmailDetectionException;

/**
 * @author Marcel Strahl <info@marcel-strahl.de>
 */
class IsNotAnTemporaryEmailAddress implements Rule
{
    /**
     * @var Client
     */
    private $client;

    public function __construct(ClientFactory $clientFactory)
    {
        $this->client = $clientFactory->factorize();
    }

    /**
     * {@inheritDoc}
     */
    public function passes($attribute, $value)
    {
        try {
            $isTemporary = $this->client->isTemporary($value);
        } catch (TemporaryEmailDetectionException $exception) {
            $this->logError(__FUNCTION__, $value, $exception->getMessage());
            return false;
        }

        return !$isTemporary;
    }

    /**
     * {@inheritDoc}
     */
    public function message()
    {
        return trans('temporary-email-validator::validation.is_temporary_email');
    }

    private function logError(string $functionName, string $email, string $exceptionMessage): void
    {
        $errorMessage =
            sprintf('%s catched an error with Value %s : %s', $functionName, $email, $exceptionMessage);
        Log::error($errorMessage);
    }
}
