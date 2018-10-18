<?php

declare(strict_types=1);

namespace MarcelStrahl\TemporaryValidator\Service;

use TemporaryEmailDetection\Client;
use TemporaryEmailDetection\ClientFactory;
use TemporaryEmailDetection\Exception as TemporaryEmailDetectionException;

/**
 * @author Marcel Strahl <info@marcel-strahl.de>
 */
class TemporaryValidator
{

    /**
     * @var Client
     */
    private $client;

    public function __construct()
    {
        $factory = new ClientFactory();
        $this->client = $factory->factorize();
    }

    public function isTemporaryEmailAddress(string $email): bool
    {
        try {
            $isTemporary = $this->client->isTemporary($email);
        } catch (TemporaryEmailDetectionException $exception) {
            return false;
        }

        return !$isTemporary;
    }
}
