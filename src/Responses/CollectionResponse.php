<?php

namespace Shufflingpixels\BokioApi\Responses;

use Shufflingpixels\BokioApi\Attributes\Field;

abstract class CollectionResponse
{
    #[Field]
    public int $totalItems;

    #[Field]
    public int $totalPages;

    #[Field]
    public int $currentPage;
}
