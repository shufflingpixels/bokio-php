<?php

namespace Shufflingpixels\BokioApi\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Field
{
    public function __construct(public ?string $name = null)
    {
    }
}
