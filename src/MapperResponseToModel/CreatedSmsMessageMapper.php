<?php

namespace igormakarov\SmsByApiClient\MapperResponseToModel;

use igormakarov\SmsByApiClient\Model\CreatedSmsMessage;

class CreatedSmsMessageMapper
{
    public static function newInstance($responseContent): CreatedSmsMessage
    {
        return new CreatedSmsMessage
        (
            $responseContent['parts'],
            $responseContent['len'],
            $responseContent['message_id'],
            $responseContent['alphaname'],
            $responseContent['time']
        );
    }
}