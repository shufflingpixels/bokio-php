<?php

namespace Shufflingpixels\BokioApi\Objects;

use Shufflingpixels\BokioApi\Attributes\Field;

class JournalEntryItem
{
    #[Field]
    public ?float $debit = null;

    #[Field]
    public ?float $credit = null;

    #[Field]
    public ?float $account = null;
}
