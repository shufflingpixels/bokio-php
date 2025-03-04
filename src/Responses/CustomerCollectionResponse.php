<?php

namespace Shufflingpixels\BokioApi\Responses;

use Shufflingpixels\BokioApi\Attributes\Collection;
use Shufflingpixels\BokioApi\Objects\Customer;

class CustomerCollectionResponse extends CollectionResponse
{
    /**
     * @var Customer[]
     */
    #[Collection(Customer::class)]
    public array $items = [];
}
