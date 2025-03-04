<?php

namespace Shufflingpixels\BokioApi\Serializer;

use ReflectionProperty;
use Shufflingpixels\BokioApi\Attributes\Collection;

class CollectionSerializer implements ValueSerializerInterface
{
    public function serialize(Serializer $serializer, ReflectionProperty $property, mixed $value) : mixed
    {
        return array_map(fn ($item) => $serializer->serialize($item), $value ?? []);
    }

    public function deserialize(Serializer $serializer, ReflectionProperty $property, mixed $value) : mixed
    {
        $collectionAttr = $property->getAttributes(Collection::class)[0] ?? null;
        if (!$collectionAttr) {
            return [];
        }

        $itemClass = $collectionAttr->newInstance()->type;
        return array_map(fn ($item) => $serializer->deserialize($item, $itemClass), $value ?? []);
    }
}
