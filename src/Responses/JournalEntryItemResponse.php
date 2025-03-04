<?php

namespace Shufflingpixels\BokioApi\Responses;

use Shufflingpixels\BokioApi\Attributes\Field;
use Shufflingpixels\BokioApi\Objects\JournalEntryItem;

class JournalEntryItemResponse extends JournalEntryItem
{
    /**
     *
     */
    #[Field]
    public int $id;
}
