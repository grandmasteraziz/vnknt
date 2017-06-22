<?php
/**
 * Created by PhpStorm.
 * User: win10
 * Date: 28.05.2017
 * Time: 01:19
 */

namespace VanBundle\Factory;


class Validation
{

    public function isNullAndIsEmpty($variable)
    {
         $isNull= is_null($variable);
        $isEmpty = empty($variable);

         $variable = $isNull && $isEmpty ;

        return $variable;
    }

}