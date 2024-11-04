<?php

namespace App\Objects\Values;

use Funeralzone\ValueObjects\Scalars\StringTrait;
use Funeralzone\ValueObjects\ValueObject;

final class SessionId implements ValueObject
{
    use StringTrait;
}
