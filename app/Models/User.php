<?php

namespace App\Models;

use App\Exceptions\ShopifyGraphqlException;
use App\Exceptions\ShopifyGraphqlUserError;
use App\Services\Shopify\Graphql\MetafieldService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Arr;
use Osiset\ShopifyApp\Contracts\ShopModel as IShopModel;
use Osiset\ShopifyApp\Traits\ShopModel;

class User extends Authenticatable implements IShopModel
{
    use HasFactory;
    use Notifiable;
    use ShopModel;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'shop_id',
        'shop_name',
        'shop_email',
        'domain',
        'province',
        'country',
        'address1',
        'zip',
        'city',
        'source',
        'phone',
        'latitude',
        'longitude',
        'primary_locale',
        'address2',
        'shop_created_at',
        'shop_updated_at',
        'country_code',
        'country_name',
        'currency',
        'customer_email',
        'timezone',
        'iana_timezone',
        'shop_owner',
        'money_format',
        'money_with_currency_format',
        'weight_unit',
        'province_code',
        'taxes_included',
        'auto_configure_tax_inclusivity',
        'tax_shipping',
        'county_taxes',
        'plan_display_name',
        'plan_name',
        'has_discounts',
        'has_gift_cards',
        'myshopify_domain',
        'google_apps_domain',
        'google_apps_login_enabled',
        'money_in_emails_format',
        'money_with_currency_in_emails_format',
        'eligible_for_payments',
        'requires_extra_payments_agreement',
        'password_enabled',
        'has_storefront',
        'cookie_consent_level',
        'visitor_tracking_consent_preference',
        'checkout_api_supported',
        'multi_location_enabled',
        'setup_required',
        'pre_launch_enabled',
        'enabled_presentment_currencies',
        'transactional_sms_disabled',
        'marketing_sms_consent_enabled_at_checkout',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'taxes_included' => 'boolean',
        'auto_configure_tax_inclusivity' => 'boolean',
        'tax_shipping' => 'boolean',
        'county_taxes' => 'boolean',
        'has_discounts' => 'boolean',
        'has_gift_cards' => 'boolean',
        'eligible_for_payments' => 'boolean',
        'requires_extra_payments_agreement' => 'boolean',
        'password_enabled' => 'boolean',
        'has_storefront' => 'boolean',
        'eligible_for_card_reader_giveaway' => 'boolean',
        'checkout_api_supported' => 'boolean',
        'multi_location_enabled' => 'boolean',
        'setup_required' => 'boolean',
        'pre_launch_enabled' => 'boolean',
        'enabled_presentment_currencies' => 'array',
    ];


    /**
     * Request graphql to Shopify
     *
     * @param $query
     * @param array $variables
     * @param int $tries
     *
     * @throws ShopifyGraphqlException
     *
     * @return array|\GuzzleHttp\Promise\Promise
     */
    public function graph($query, array $variables = [], $tries = 0)
    {
        $max_tries = config('shopify-app.graphql_max_tries', 3);
        $response = $this->api()->graph($query, $variables);
        $body = Arr::get($response, 'body');

        $container = data_get($body, 'data.container');
        $first_key = array_key_first((array) $container);
        $user_errors = data_get($container, $first_key . '.userErrors');

        if ($user_errors) {
            throw new ShopifyGraphqlUserError($user_errors);
        }

        $errors = Arr::get($body, 'errors');

        if ($errors) {
            if (count($errors) === 1) {
                $error_code = data_get($errors, '0.extensions.code');

                if ($error_code === 'THROTTLED' && $tries < $max_tries) {
                    sleep(1);

                    return $this->graph($query, $variables, $tries + 1);
                }
            }

            throw new ShopifyGraphqlException($errors);
        }

        return $response;
    }
}
