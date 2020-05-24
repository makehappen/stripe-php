<?php

namespace StripeV2\Terminal;

/**
 * A Location represents a grouping of readers.
 *
 * Related guide: <a
 * href="https://stripe.com/docs/terminal/readers/fleet-management#create">Fleet
 * Management</a>.
 *
 * @property string $id Unique identifier for the object.
 * @property string $object String representing the object's type. Objects of the same type share the same value.
 * @property \StripeV2\StripeObject $address
 * @property string $display_name The display name of the location.
 * @property bool $livemode Has the value <code>true</code> if the object exists in live mode or the value <code>false</code> if the object exists in test mode.
 * @property \StripeV2\StripeObject $metadata Set of key-value pairs that you can attach to an object. This can be useful for storing additional information about the object in a structured format.
 */
class Location extends \StripeV2\ApiResource
{
    const OBJECT_NAME = 'terminal.location';

    use \StripeV2\ApiOperations\All;
    use \StripeV2\ApiOperations\Create;
    use \StripeV2\ApiOperations\Delete;
    use \StripeV2\ApiOperations\Retrieve;
    use \StripeV2\ApiOperations\Update;
}
