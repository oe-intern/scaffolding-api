<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('shop_id')->nullable();
            $table->text('scope')->nullable();
            $table->string('shop_name')->nullable();
            $table->string('shop_email')->nullable();
            $table->string('domain')->nullable();
            $table->string('province')->nullable();
            $table->string('country')->nullable();
            $table->string('address1')->nullable();
            $table->string('zip')->nullable();
            $table->string('city')->nullable();
            $table->string('phone')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('primary_locale')->nullable();
            $table->string('address2')->nullable();
            $table->string('shop_created_at')->nullable();
            $table->string('shop_updated_at')->nullable();
            $table->string('country_code')->nullable();
            $table->string('country_name')->nullable();
            $table->string('currency')->nullable();
            $table->string('customer_email')->nullable();
            $table->string('timezone')->nullable();
            $table->string('iana_timezone')->nullable();
            $table->string('shop_owner')->nullable();
            $table->string('money_format')->nullable();
            $table->string('money_with_currency_format')->nullable();
            $table->string('weight_unit')->nullable();
            $table->string('province_code')->nullable();
            $table->boolean('taxes_included')->nullable();
            $table->boolean('tax_shipping')->nullable();
            $table->string('plan_display_name')->nullable();
            $table->string('plan_name')->nullable();
            $table->string('myshopify_domain')->nullable();
            $table->string('money_in_emails_format')->nullable();
            $table->string('money_with_currency_in_emails_format')->nullable();
            $table->boolean('password_enabled')->nullable();
            $table->boolean('has_storefront')->nullable();
            $table->boolean('eligible_for_card_reader_giveaway')->nullable();
            $table->string('cookie_consent_level')->nullable();
            $table->string('visitor_tracking_consent_preference')->nullable();
            $table->boolean('checkout_api_supported')->nullable();
            $table->boolean('setup_required')->nullable();
            $table->json('enabled_presentment_currencies')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'shop_id',
                'shop_name',
                'shop_email',
                'domain',
                'province',
                'country',
                'address1',
                'zip',
                'city',
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
                'tax_shipping',
                'plan_display_name',
                'plan_name',
                'myshopify_domain',
                'money_in_emails_format',
                'money_with_currency_in_emails_format',
                'password_enabled',
                'has_storefront',
                'eligible_for_card_reader_giveaway',
                'cookie_consent_level',
                'visitor_tracking_consent_preference',
                'checkout_api_supported',
                'setup_required',
                'enabled_presentment_currencies',
            ]);
        });
    }
};
