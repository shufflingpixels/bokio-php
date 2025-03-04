<?php

namespace Shufflingpixels\BokioApi\Requests;

use Shufflingpixels\BokioApi\Attributes\Collection;
use Shufflingpixels\BokioApi\Objects\JournalEntry;
use Shufflingpixels\BokioApi\Objects\JournalEntryItem;
use Shufflingpixels\BokioApi\Traits\InitializeFromArray;

class JournalEntryRequest extends JournalEntry
{
    use InitializeFromArray;

    /**
     * @var JournalEntryItem[]
     */
    #[Collection(JournalEntryItem::class)]
    public array $items;
}
