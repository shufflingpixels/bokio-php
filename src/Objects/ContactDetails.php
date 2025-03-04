<?php

namespace Shufflingpixels\BokioApi\Objects;

use Shufflingpixels\BokioApi\Attributes\Field;

class ContactDetails
{
    #[Field]
    public ?string $id = null;

    #[Field]
    public ?string $name = null;

    #[Field]
    public ?string $email = null;

    #[Field]
    public ?string $phone = null;

    #[Field]
    public ?bool $isDefault = false;
}
