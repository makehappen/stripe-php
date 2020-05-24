<?php

namespace StripeV2\Radar;

/**
 * Value lists allow you to group values together which can then be referenced in
 * rules.
 *
 * Related guide: <a
 * href="https://stripe.com/docs/radar/lists#managing-list-items">Default Stripe
 * Lists</a>.
 *
 * @property string $id Unique identifier for the object.
 * @property string $object String representing the object's type. Objects of the same type share the same value.
 * @property string $alias The name of the value list for use in rules.
 * @property int $created Time at which the object was created. Measured in seconds since the Unix epoch.
 * @property string $created_by The name or email address of the user who created this value list.
 * @property string $item_type The type of items in the value list. One of <code>card_fingerprint</code>, <code>card_bin</code>, <code>email</code>, <code>ip_address</code>, <code>country</code>, <code>string</code>, or <code>case_sensitive_string</code>.
 * @property \StripeV2\Collection $list_items List of items contained within this value list.
 * @property bool $livemode Has the value <code>true</code> if the object exists in live mode or the value <code>false</code> if the object exists in test mode.
 * @property \StripeV2\StripeObject $metadata Set of key-value pairs that you can attach to an object. This can be useful for storing additional information about the object in a structured format.
 * @property string $name The name of the value list.
 */
class ValueList extends \StripeV2\ApiResource
{
    const OBJECT_NAME = 'radar.value_list';

    use \StripeV2\ApiOperations\All;
    use \StripeV2\ApiOperations\Create;
    use \StripeV2\ApiOperations\Delete;
    use \StripeV2\ApiOperations\Retrieve;
    use \StripeV2\ApiOperations\Update;
}
