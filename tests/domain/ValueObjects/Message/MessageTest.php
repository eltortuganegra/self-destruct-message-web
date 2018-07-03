<?php

use App\domain\ValueObjects\Message\MessageFactoryImp;
use App\domain\ValueObjects\Message\MessageIsVoidException;
use PHPUnit\Framework\TestCase;

class MessageTest extends TestCase
{
    public function testFactoryShouldReturnMessageWhenCreateMethodIsExecuted()
    {
        // Assert
        $this->expectException(MessageIsVoidException::class);

        // Arrange
        $message = '';
        $messageFactory = new MessageFactoryImp();

        // Act
        $message = $messageFactory->create($message);
    }
}