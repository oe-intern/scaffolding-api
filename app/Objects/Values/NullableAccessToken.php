<?php

namespace App\Objects\Values;

use Funeralzone\ValueObjects\Nullable;
use App\Contracts\Objects\Values\AccessToken as IAccessToken;

final class NullableAccessToken extends Nullable implements IAccessToken
{
    /**
     * {@inheritdoc}
     */
    public function isEmpty(): bool
    {
        return empty($this->value->toNative());
    }

    /**
     * @return string
     */
    protected static function nonNullImplementation(): string
    {
        return AccessToken::class;
    }

    /**
     * @return string
     */
    protected static function nullImplementation(): string
    {
        return NullAccessToken::class;
    }
}
