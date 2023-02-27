<?php

namespace igormakarov\SmsByApiClient\MapperResponseToModel;

use igormakarov\SmsByApiClient\Model\AlphaNameCategory;

class AlphaNameCategoriesMapper
{
    public static function newList($responseContent): array
    {
        $listOfCategories = [];
        foreach ($responseContent['result'] as $value) {
            $listOfCategories[] = new AlphaNameCategory($value['id'], $value['name']);
        }
        return $listOfCategories;
    }
}