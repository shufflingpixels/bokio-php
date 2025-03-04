<?php

namespace Shufflingpixels\BokioApi\Objects;

use DateTime;
use Shufflingpixels\BokioApi\Attributes\Date;
use Shufflingpixels\BokioApi\Attributes\Field;

class JournalEntry
{
    #[Field]
    public ?string $title;

    #[Date]
    public DateTime $date;
}
