<?php

namespace App\domain\ValueObjects\Message;


class MessageFactoryImp implements MessageFactory
{

    public function create(string $messageText): Message
    {
        $this->validate($messageText);
        $message = $this->createMessage($messageText);

        return $message;
    }

    private function validate(string $message): void
    {
        if (empty($message)) {
            throw new MessageIsVoidException();
        }
    }

    private function createMessage(string $message): Message
    {
        return new MessageImp($message);
    }

}