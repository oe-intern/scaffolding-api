<?php

namespace App\Objects\Values;

use Funeralzone\ValueObjects\Scalars\StringTrait;
use Funeralzone\ValueObjects\ValueObject;
use Shopify\Utils;

final class UserDomain implements ValueObject
{
    use StringTrait;

    /**
     * Constructor.
     *
     * @param string $domain The shop's domain.
     *
     * @return void
     */
    public function __construct(string $domain)
    {
        $this->string = Utils::sanitizeShopDomain($domain);
    }
}
