<?php

namespace Shufflingpixels\BokioApi\Responses;

use Shufflingpixels\BokioApi\Attributes\Collection;
use Shufflingpixels\BokioApi\Attributes\Field;
use Shufflingpixels\BokioApi\Objects\JournalEntry;

class JournalEntryResponse extends JournalEntry
{
    #[Field]
    public string $id;

    #[Field]
    public string $journalEntryNumber;

    #[Field]
    public ?string $reversingjournalEntryId = null;

    #[Field]
    public ?string $reversedByjournalEntryId = null;

    /**
     * @var JournalEntryItemResponse[]
     */
    #[Collection(JournalEntryItemResponse::class)]
    public array $items;
}
