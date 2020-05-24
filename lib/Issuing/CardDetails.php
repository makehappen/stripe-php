<?php

namespace StripeV2\Issuing;

/**
 * Class CardDetails.
 *
 * @property string $id
 * @property string $object
 * @property Card $card
 * @property string $cvc
 * @property int $exp_month
 * @property int $exp_year
 * @property string $number
 */
class CardDetails extends \StripeV2\ApiResource
{
    const OBJECT_NAME = 'issuing.card_details';
}
