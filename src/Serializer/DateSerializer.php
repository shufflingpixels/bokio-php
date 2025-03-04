<?php

namespace Shufflingpixels\BokioApi\Serializer;

use DateTime;
use ReflectionProperty;

class DateSerializer implements ValueSerializerInterface
{
    public function serialize(Serializer $serializer, ReflectionProperty $property, mixed $value) : mixed
    {
        if (!($value instanceof DateTime)) {
            $value = new DateTime();
        }

        return $value->format('Y-m-d');
    }

    public function deserialize(Serializer $serializer, ReflectionProperty $property, mixed $value) : mixed
    {
        if ($value) {
            $date = DateTime::createFromFormat('Y-m-d', $value);
            if ($date !== false) {
                $date->setTime(0, 0);
                return $date;
            } 
        }
        return new DateTime('1970-01-01 00:00:00');
    }
}
