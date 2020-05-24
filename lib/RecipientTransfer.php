<?php

namespace StripeV2;

/**
 * Class RecipientTransfer.
 *
 * @property string $id
 * @property string $object
 * @property int $amount
 * @property int $amount_reversed
 * @property string $balance_transaction
 * @property string $bank_account
 * @property string $card
 * @property int $created
 * @property string $currency
 * @property int $date
 * @property string $description
 * @property string $destination
 * @property string $failure_code
 * @property string $failure_message
 * @property bool $livemode
 * @property \StripeV2\StripeObject $metadata
 * @property string $method
 * @property string $recipient
 * @property \StripeV2\Collection $reversals
 * @property bool $reversed
 * @property string $source_type
 * @property string $statement_descriptor
 * @property string $status
 * @property string $type
 */
class RecipientTransfer extends ApiResource
{
    const OBJECT_NAME = 'recipient_transfer';
}
