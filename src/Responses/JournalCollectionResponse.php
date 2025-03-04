<?php

namespace Shufflingpixels\BokioApi\Responses;

use Shufflingpixels\BokioApi\Attributes\Collection;

class JournalCollectionResponse extends CollectionResponse
{
    /**
     * @var JournalEntryResponse[]
     */
    #[Collection(JournalEntryResponse::class)]
    public array $items = [];
}
