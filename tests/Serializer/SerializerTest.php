<?php

namespace Tests\Serializer;

use PHPUnit\Framework\TestCase;
use Shufflingpixels\BokioApi\Attributes\Field;
use Shufflingpixels\BokioApi\Enum\CustomerType;
use Shufflingpixels\BokioApi\Serializer\Serializer;

class BuiltinsClassMock
{
    #[Field]
    public string $my_string;
    #[Field]
    public int $my_int;
    #[Field]
    public float $my_float;
    #[Field]
    public bool $my_bool;
    #[Field]
    public CustomerType $company_type;
}

class SerializerTest extends TestCase
{
    public function test_builtin() : void
    {
        $value = new BuiltinsClassMock();
        $value->my_string = "my string value";
        $value->my_int = 10;
        $value->my_float = 3.14;
        $value->my_bool = true;
        $value->company_type = CustomerType::PRIVATE;

        $serializer = new Serializer();
        $actual = $serializer->serialize($value);

        $expected = [
            'my_string' => 'my string value',
            'my_int' => 10,
            'my_float' => 3.14,
            'my_bool' => true,
            'company_type' => 'private'
        ];

        $this->assertEquals($expected, $actual);

        $actual = $serializer->deserialize($actual, BuiltinsClassMock::class);

        $this->assertEquals($value, $actual);
    }
}
