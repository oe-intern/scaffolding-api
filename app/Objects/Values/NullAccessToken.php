<?php

namespace App\Objects\Values;

use App\Contracts\Objects\Values\AccessToken as IAccessToken;
use Funeralzone\ValueObjects\NullTrait;

final class NullAccessToken implements IAccessToken
{
    use NullTrait;

    /**
     * {@inheritdoc}
     */
    public function isEmpty(): bool
    {
        return true;
    }
}
