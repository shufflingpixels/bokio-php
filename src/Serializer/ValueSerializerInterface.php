<?php

namespace Shufflingpixels\BokioApi\Serializer;

use ReflectionProperty;

interface ValueSerializerInterface
{
    public function serialize(Serializer $serializer, ReflectionProperty $property, mixed $value) : mixed;

    public function deserialize(Serializer $serializer, ReflectionProperty $property, mixed $value) : mixed;
}

