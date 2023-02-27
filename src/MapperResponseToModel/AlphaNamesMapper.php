<?php

namespace igormakarov\SmsByApiClient\MapperResponseToModel;

use igormakarov\SmsByApiClient\Model\AlphaName;

class AlphaNamesMapper
{
    public static function newList($responseContent): array
    {
        $listOfNames = [];
        foreach ($responseContent as $id => $name) {
            $listOfNames[] = new AlphaName($id,$name);
        }
        return $listOfNames;
    }
}