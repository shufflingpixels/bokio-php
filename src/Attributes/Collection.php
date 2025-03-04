<?php

namespace Shufflingpixels\BokioApi\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Collection extends Field
{
    public function __construct(public string $type, ?string $name = null)
    {
        parent::__construct($name);
    }
}
