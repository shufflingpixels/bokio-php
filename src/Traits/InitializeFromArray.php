<?php

namespace Shufflingpixels\BokioApi\Traits;

use InvalidArgumentException;
use Shufflingpixels\BokioApi\Serializer\Serializer;

trait InitializeFromArray
{
    /**
     * @param mixed[] $data
     */
    public function __construct(array $data = [])
    {
        $serializer = new Serializer();
        $obj = $serializer->deserialize($data, self::class);
        foreach ($obj as $k => $v) {
            if (!property_exists($this, $k)) {
                throw new InvalidArgumentException("$k does not exist");
            }
            $this->$k = $v;
        }
    }
}
