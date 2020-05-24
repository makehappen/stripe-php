<?php

namespace StripeV2;

/**
 * Class InvoiceLineItem.
 *
 * @property string $id
 * @property string $object
 * @property int $amount
 * @property string $currency
 * @property string $description
 * @property bool $discountable
 * @property string $invoice_item
 * @property bool $livemode
 * @property \StripeV2\StripeObject $metadata
 * @property \StripeV2\StripeObject $period
 * @property \StripeV2\Plan $plan
 * @property bool $proration
 * @property int $quantity
 * @property string $subscription
 * @property string $subscription_item
 * @property array $tax_amounts
 * @property array $tax_rates
 * @property string $type
 */
class InvoiceLineItem extends ApiResource
{
    const OBJECT_NAME = 'line_item';
}
