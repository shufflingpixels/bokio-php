<?php

namespace Shufflingpixels\BokioApi\Objects;

use Shufflingpixels\BokioApi\Attributes\Collection;
use Shufflingpixels\BokioApi\Attributes\Field;
use Shufflingpixels\BokioApi\Enum\CustomerType;
use Shufflingpixels\BokioApi\Enum\LanguageEnum;
use Shufflingpixels\BokioApi\Traits\InitializeFromArray;

class Customer
{
    use InitializeFromArray;

    #[Field]
    public ?string $id = null;

    #[Field]
    public string $name;

    #[Field]
    public CustomerType $type;

    #[Field]
    public ?string $vatNumber = null;

    #[Field]
    public ?string $orgNumber = null;

    #[Field]
    public Address $address;

    /**
     * @var ContactDetails[]
     */
    #[Collection(ContactDetails::class)]
    public array $contactsDetails = [];

    #[Field]
    public ?LanguageEnum $language = null;
}
