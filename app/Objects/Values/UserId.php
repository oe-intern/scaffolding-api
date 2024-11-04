<?php

namespace App\Objects\Values;

use Funeralzone\ValueObjects\Scalars\IntegerTrait;
use Funeralzone\ValueObjects\ValueObject;

final class UserId implements ValueObject
{
    use IntegerTrait;
}
