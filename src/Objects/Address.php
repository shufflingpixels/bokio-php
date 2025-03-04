<?php

namespace Shufflingpixels\BokioApi\Objects;

use Shufflingpixels\BokioApi\Attributes\Field;

class Address
{
    #[Field]
    public string $line1;

    #[Field]
    public ?string $line2;

    #[Field]
    public string $city;

    #[Field]
    public string $postalCode;

    #[Field]
    public ?string $country = null;
}
