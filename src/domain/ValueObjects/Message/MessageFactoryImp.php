<?php

namespace App\domain\ValueObjects\Message;


class MessageFactoryImp implements MessageFactory
{

    public function create(string $message): Message
    {
        if (empty($message)) {
            throw new MessageIsVoidException();
        }

        return new MessageImp($message);
    }


}