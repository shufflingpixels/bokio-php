<?php

namespace Shufflingpixels\BokioApi\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Date extends Field
{
    public function __construct(public ?string $name = null)
    {
    }
}
