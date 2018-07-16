<?php

use App\domain\ValueObjects\Message\MessageFactoryImp;
use App\domain\ValueObjects\Message\MessageIsVoidException;
use App\domain\ValueObjects\ValueObjectsFactory;
use PHPUnit\Framework\TestCase;

class MessageTest extends TestCase
{
    public function testFactoryShouldReturnMessageWhenCreateMethodIsExecuted()
    {
        // Assert
        $this->expectException(MessageIsVoidException::class);

        // Arrange
        $message = '';
        $messageFactory = ValueObjectsFactory::getMessageFactory();

        // Act
        $messageFactory->create($message);
    }
}