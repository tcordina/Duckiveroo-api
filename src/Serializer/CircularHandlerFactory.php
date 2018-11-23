<?php

namespace App\Serializer;

class CircularHandlerFactory
{
    /**
     * @return \Closure
     */
    public static function getId()
    {
        return function ($object) {
            return $object->getId();
        };
    }
}