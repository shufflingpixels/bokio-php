<?php

namespace Shufflingpixels\BokioApi\Serializer;

use ReflectionClass;
use Shufflingpixels\BokioApi\Attributes\Collection;
use Shufflingpixels\BokioApi\Attributes\Date;
use Shufflingpixels\BokioApi\Attributes\Field;

class Serializer
{
    /**
     * @var ValueSerializerInterface[]
     */
    private array $handlers = [];

    public function __construct()
    {
        // Register handlers dynamically
        $this->handlers[Field::class] = new BuiltinSerializer();
        $this->handlers[Date::class] = new DateSerializer();
        $this->handlers[Collection::class] = new CollectionSerializer();
    }

    public function serialize(object $object) : array
    {
        $reflection = new ReflectionClass($object);

        $data = [];
        foreach ($reflection->getProperties() as $property) {
            $value = $property->getValue($object);

            foreach ($property->getAttributes() as $attribute) {
                $name = $property->getName();
                $attrName = $attribute->getName();
                if (isset($this->handlers[$attrName])) {


                    // $data[$name] = $this->handlers[$attrName]->serialize($this, $property, $value);
                    $value = $this->handlers[$attrName]->serialize($this, $property, $value);
                    if ($value !== null) {
                        $data[$name] = $value;
                    }
                }
            }
        }
        return $data;
    }

    /**
     * @template T
     * @param mixed[] $data
     * @param class-string<T> $class
     * @return T
     */
    public function deserialize(array $data, string $class) : mixed
    {
        $reflection = new ReflectionClass($class);
        $object = $reflection->newInstanceWithoutConstructor();

        foreach ($reflection->getProperties() as $property) {
            foreach ($property->getAttributes() as $attribute) {
                $attrName = $attribute->getName();
                if (isset($this->handlers[$attrName])) {
                    $value = $this->handlers[$attrName]->deserialize($this, $property, $data[$property->name] ?? null);
                    
                    if ($value === null && $property->getType()?->allowsNull() === false) {
                        continue;
                    }

                    $property->setValue($object, $value);
                }
            }
        }

        return $object;
    }
}
