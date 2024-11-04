<?php

namespace App\Jobs;

use App\Contracts\Shopify\Graphql\Shop;
use App\Contracts\Shopify\Graphql\ShopLocale;
use App\Lib\Utils;
use App\Models\User;
use App\Services\Shopify\UserContext;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class UpdateUserProfile implements ShouldQueue
{
    use Queueable;

    /**
     * @var User
     */
    protected User $user;

    /**
     * Create a new job instance.
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     */
    public function handle(Shop $shop, ShopLocale $shop_locale, UserContext $context): void
    {
        $context->setUser($this->user);
        $shop_detail = $shop->detail();
        $primary_locale = $shop_locale->primary();

        $transformed_data = $this->transform($shop_detail, $primary_locale);

        $this->user->fill($transformed_data);
        $this->user->save();
    }

    /**
     * Transform the data
     *
     * @param array $shop_detail
     * @param string $primary_locale
     * @return array
     */
    private function transform(array $shop_detail, string $primary_locale): array
    {
        return [
            'shop_id' => Utils::getIdFromGid(data_get($shop_detail, 'id')),
            'shop_name' => data_get($shop_detail, 'name'),
            'shop_email' => data_get($shop_detail, 'email'),
            'domain' => data_get($shop_detail, 'primaryDomain.host'),
            'province' => data_get($shop_detail, 'billingAddress.province'),
            'country' => data_get($shop_detail, 'billingAddress.countryCodeV2'),
            'address1' => data_get($shop_detail, 'billingAddress.address1'),
            'address2' => data_get($shop_detail, 'billingAddress.address2'),
            'zip' => data_get($shop_detail, 'billingAddress.zip'),
            'city' => data_get($shop_detail, 'billingAddress.city'),
            'phone' => data_get($shop_detail, 'billingAddress.phone'),
            'latitude' => data_get($shop_detail, 'billingAddress.latitude'),
            'longitude' => data_get($shop_detail, 'billingAddress.longitude'),
            'primary_locale' => $primary_locale,
            'shop_created_at' => data_get($shop_detail, 'createdAt'),
            'shop_updated_at' => data_get($shop_detail, 'updatedAt'),
            'country_code' => data_get($shop_detail, 'billingAddress.countryCodeV2'),
            'country_name' => data_get($shop_detail, 'billingAddress.country'),
            'currency' => data_get($shop_detail, 'currencyCode'),
            'customer_email' => data_get($shop_detail, 'contactEmail'),
            'timezone' => data_get($shop_detail, 'timezoneAbbreviation'),
            'iana_timezone' => data_get($shop_detail, 'ianaTimezone'),
            'shop_owner' => data_get($shop_detail, 'shopOwnerName'),
            'money_format' => data_get($shop_detail, 'currencyFormats.moneyFormat'),
            'money_with_currency_format' => data_get($shop_detail, 'currencyFormats.moneyWithCurrencyFormat'),
            'weight_unit' => data_get($shop_detail, 'weightUnit'),
            'province_code' => data_get($shop_detail, 'billingAddress.provinceCode'),
            'taxes_included' => data_get($shop_detail, 'taxesIncluded'),
            'tax_shipping' => data_get($shop_detail, 'taxShipping'),
            'plan_display_name' => data_get($shop_detail, 'plan.displayName'),
//            'plan_name',
            'myshopify_domain' => data_get($shop_detail, 'myshopifyDomain'),
            'money_in_emails_format' => data_get($shop_detail, 'currencyFormats.moneyInEmailsFormat'),
            'money_with_currency_in_emails_format' => data_get($shop_detail, 'currencyFormats.moneyWithCurrencyInEmailsFormat'),
            'checkout_api_supported' => data_get($shop_detail, 'checkoutApiSupported'),
            'setup_required' => data_get($shop_detail, 'setupRequired'),
            'enabled_presentment_currencies' => data_get($shop_detail, 'enabledPresentmentCurrencies')
        ];
    }
}
