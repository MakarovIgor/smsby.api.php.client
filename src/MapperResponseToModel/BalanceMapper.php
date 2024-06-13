<?php

namespace igormakarov\SmsByApiClient\MapperResponseToModel;

use igormakarov\SmsByApiClient\Model\Balance;

class BalanceMapper
{
    public static function newInstance($responseContent): Balance
    {
        return new Balance(
            $responseContent['result'][0]['balance'],
            $responseContent['currency']
        );
    }
}