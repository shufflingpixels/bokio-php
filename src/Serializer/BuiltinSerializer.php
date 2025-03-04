<?php

namespace Shufflingpixels\BokioApi\Serializer;

use BackedEnum;
use ReflectionClass;
use ReflectionNamedType;
use ReflectionProperty;

class BuiltinSerializer implements ValueSerializerInterface
{
    public function serialize(Serializer $serializer, ReflectionProperty $property, mixed $value) : mixed
    {
        if ($value instanceof BackedEnum) {
            return $value->value;
        }
        return $value;
    }

    public function deserialize(Serializer $serializer, ReflectionProperty $property, mixed $value) : mixed
    {
        $type = $property->getType();

        if (!$type || $value === null) {
            return $value;
        }

        if ($type instanceof ReflectionNamedType) {
            $typeName = $type->getName();

            if (enum_exists($typeName) && (is_string($value) || is_int($value))) {
                /** @phpstan-ignore-next-line */
                return $typeName::from($value);
            }

            if (is_array($value) && class_exists($typeName)) {
                return $serializer->deserialize($value, $typeName);
            }
        }

        return $value;
    }
}
