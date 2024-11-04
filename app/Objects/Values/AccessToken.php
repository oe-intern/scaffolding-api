<?php

namespace App\Objects\Values;

use App\Contracts\Objects\Values\AccessToken as IAccessToken;
use Funeralzone\ValueObjects\Scalars\StringTrait;

final class AccessToken implements IAccessToken
{
    use StringTrait;

    /**
     * {@inheritdoc}
     */
    public function isEmpty(): bool
    {
        return empty($this->toNative());
    }
}
