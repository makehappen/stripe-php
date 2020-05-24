<?php

namespace StripeV2\Util;

use StripeV2\StripeObject;

abstract class Util
{
    private static $isMbstringAvailable = null;
    private static $isHashEqualsAvailable = null;

    /**
     * Whether the provided array (or other) is a list rather than a dictionary.
     * A list is defined as an array for which all the keys are consecutive
     * integers starting at 0. Empty arrays are considered to be lists.
     *
     * @param array|mixed $array
     *
     * @return bool true if the given object is a list
     */
    public static function isList($array)
    {
        if (!\is_array($array)) {
            return false;
        }
        if ($array === []) {
            return true;
        }
        if (\array_keys($array) !== \range(0, \count($array) - 1)) {
            return false;
        }

        return true;
    }

    /**
     * Converts a response from the Stripe API to the corresponding PHP object.
     *
     * @param array $resp the response from the Stripe API
     * @param array $opts
     *
     * @return array|StripeObject
     */
    public static function convertToStripeObject($resp, $opts)
    {
        $types = [
            // data structures
            \StripeV2\Collection::OBJECT_NAME => \StripeV2\Collection::class,

            // business objects
            \StripeV2\Account::OBJECT_NAME => \StripeV2\Account::class,
            \StripeV2\AccountLink::OBJECT_NAME => \StripeV2\AccountLink::class,
            \StripeV2\AlipayAccount::OBJECT_NAME => \StripeV2\AlipayAccount::class,
            \StripeV2\ApplePayDomain::OBJECT_NAME => \StripeV2\ApplePayDomain::class,
            \StripeV2\ApplicationFee::OBJECT_NAME => \StripeV2\ApplicationFee::class,
            \StripeV2\ApplicationFeeRefund::OBJECT_NAME => \StripeV2\ApplicationFeeRefund::class,
            \StripeV2\Balance::OBJECT_NAME => \StripeV2\Balance::class,
            \StripeV2\BalanceTransaction::OBJECT_NAME => \StripeV2\BalanceTransaction::class,
            \StripeV2\BankAccount::OBJECT_NAME => \StripeV2\BankAccount::class,
            \StripeV2\BitcoinReceiver::OBJECT_NAME => \StripeV2\BitcoinReceiver::class,
            \StripeV2\BitcoinTransaction::OBJECT_NAME => \StripeV2\BitcoinTransaction::class,
            \StripeV2\Capability::OBJECT_NAME => \StripeV2\Capability::class,
            \StripeV2\Card::OBJECT_NAME => \StripeV2\Card::class,
            \StripeV2\Charge::OBJECT_NAME => \StripeV2\Charge::class,
            \StripeV2\Checkout\Session::OBJECT_NAME => \StripeV2\Checkout\Session::class,
            \StripeV2\CountrySpec::OBJECT_NAME => \StripeV2\CountrySpec::class,
            \StripeV2\Coupon::OBJECT_NAME => \StripeV2\Coupon::class,
            \StripeV2\CreditNote::OBJECT_NAME => \StripeV2\CreditNote::class,
            \StripeV2\CreditNoteLineItem::OBJECT_NAME => \StripeV2\CreditNoteLineItem::class,
            \StripeV2\Customer::OBJECT_NAME => \StripeV2\Customer::class,
            \StripeV2\CustomerBalanceTransaction::OBJECT_NAME => \StripeV2\CustomerBalanceTransaction::class,
            \StripeV2\Discount::OBJECT_NAME => \StripeV2\Discount::class,
            \StripeV2\Dispute::OBJECT_NAME => \StripeV2\Dispute::class,
            \StripeV2\EphemeralKey::OBJECT_NAME => \StripeV2\EphemeralKey::class,
            \StripeV2\Event::OBJECT_NAME => \StripeV2\Event::class,
            \StripeV2\ExchangeRate::OBJECT_NAME => \StripeV2\ExchangeRate::class,
            \StripeV2\File::OBJECT_NAME => \StripeV2\File::class,
            \StripeV2\File::OBJECT_NAME_ALT => \StripeV2\File::class,
            \StripeV2\FileLink::OBJECT_NAME => \StripeV2\FileLink::class,
            \StripeV2\Invoice::OBJECT_NAME => \StripeV2\Invoice::class,
            \StripeV2\InvoiceItem::OBJECT_NAME => \StripeV2\InvoiceItem::class,
            \StripeV2\InvoiceLineItem::OBJECT_NAME => \StripeV2\InvoiceLineItem::class,
            \StripeV2\Issuing\Authorization::OBJECT_NAME => \StripeV2\Issuing\Authorization::class,
            \StripeV2\Issuing\Card::OBJECT_NAME => \StripeV2\Issuing\Card::class,
            \StripeV2\Issuing\CardDetails::OBJECT_NAME => \StripeV2\Issuing\CardDetails::class,
            \StripeV2\Issuing\Cardholder::OBJECT_NAME => \StripeV2\Issuing\Cardholder::class,
            \StripeV2\Issuing\Dispute::OBJECT_NAME => \StripeV2\Issuing\Dispute::class,
            \StripeV2\Issuing\Transaction::OBJECT_NAME => \StripeV2\Issuing\Transaction::class,
            \StripeV2\LoginLink::OBJECT_NAME => \StripeV2\LoginLink::class,
            \StripeV2\Mandate::OBJECT_NAME => \StripeV2\Mandate::class,
            \StripeV2\Order::OBJECT_NAME => \StripeV2\Order::class,
            \StripeV2\OrderItem::OBJECT_NAME => \StripeV2\OrderItem::class,
            \StripeV2\OrderReturn::OBJECT_NAME => \StripeV2\OrderReturn::class,
            \StripeV2\PaymentIntent::OBJECT_NAME => \StripeV2\PaymentIntent::class,
            \StripeV2\PaymentMethod::OBJECT_NAME => \StripeV2\PaymentMethod::class,
            \StripeV2\Payout::OBJECT_NAME => \StripeV2\Payout::class,
            \StripeV2\Person::OBJECT_NAME => \StripeV2\Person::class,
            \StripeV2\Plan::OBJECT_NAME => \StripeV2\Plan::class,
            \StripeV2\Product::OBJECT_NAME => \StripeV2\Product::class,
            \StripeV2\Radar\EarlyFraudWarning::OBJECT_NAME => \StripeV2\Radar\EarlyFraudWarning::class,
            \StripeV2\Radar\ValueList::OBJECT_NAME => \StripeV2\Radar\ValueList::class,
            \StripeV2\Radar\ValueListItem::OBJECT_NAME => \StripeV2\Radar\ValueListItem::class,
            \StripeV2\Recipient::OBJECT_NAME => \StripeV2\Recipient::class,
            \StripeV2\RecipientTransfer::OBJECT_NAME => \StripeV2\RecipientTransfer::class,
            \StripeV2\Refund::OBJECT_NAME => \StripeV2\Refund::class,
            \StripeV2\Reporting\ReportRun::OBJECT_NAME => \StripeV2\Reporting\ReportRun::class,
            \StripeV2\Reporting\ReportType::OBJECT_NAME => \StripeV2\Reporting\ReportType::class,
            \StripeV2\Review::OBJECT_NAME => \StripeV2\Review::class,
            \StripeV2\SetupIntent::OBJECT_NAME => \StripeV2\SetupIntent::class,
            \StripeV2\Sigma\ScheduledQueryRun::OBJECT_NAME => \StripeV2\Sigma\ScheduledQueryRun::class,
            \StripeV2\SKU::OBJECT_NAME => \StripeV2\SKU::class,
            \StripeV2\Source::OBJECT_NAME => \StripeV2\Source::class,
            \StripeV2\SourceTransaction::OBJECT_NAME => \StripeV2\SourceTransaction::class,
            \StripeV2\Subscription::OBJECT_NAME => \StripeV2\Subscription::class,
            \StripeV2\SubscriptionItem::OBJECT_NAME => \StripeV2\SubscriptionItem::class,
            \StripeV2\SubscriptionSchedule::OBJECT_NAME => \StripeV2\SubscriptionSchedule::class,
            \StripeV2\TaxId::OBJECT_NAME => \StripeV2\TaxId::class,
            \StripeV2\TaxRate::OBJECT_NAME => \StripeV2\TaxRate::class,
            \StripeV2\ThreeDSecure::OBJECT_NAME => \StripeV2\ThreeDSecure::class,
            \StripeV2\Terminal\ConnectionToken::OBJECT_NAME => \StripeV2\Terminal\ConnectionToken::class,
            \StripeV2\Terminal\Location::OBJECT_NAME => \StripeV2\Terminal\Location::class,
            \StripeV2\Terminal\Reader::OBJECT_NAME => \StripeV2\Terminal\Reader::class,
            \StripeV2\Token::OBJECT_NAME => \StripeV2\Token::class,
            \StripeV2\Topup::OBJECT_NAME => \StripeV2\Topup::class,
            \StripeV2\Transfer::OBJECT_NAME => \StripeV2\Transfer::class,
            \StripeV2\TransferReversal::OBJECT_NAME => \StripeV2\TransferReversal::class,
            \StripeV2\UsageRecord::OBJECT_NAME => \StripeV2\UsageRecord::class,
            \StripeV2\UsageRecordSummary::OBJECT_NAME => \StripeV2\UsageRecordSummary::class,
            \StripeV2\WebhookEndpoint::OBJECT_NAME => \StripeV2\WebhookEndpoint::class,
        ];
        if (self::isList($resp)) {
            $mapped = [];
            foreach ($resp as $i) {
                \array_push($mapped, self::convertToStripeObject($i, $opts));
            }

            return $mapped;
        }
        if (\is_array($resp)) {
            if (isset($resp['object']) && \is_string($resp['object']) && isset($types[$resp['object']])) {
                $class = $types[$resp['object']];
            } else {
                $class = \StripeV2\StripeObject::class;
            }

            return $class::constructFrom($resp, $opts);
        }

        return $resp;
    }

    /**
     * @param mixed|string $value a string to UTF8-encode
     *
     * @return mixed|string the UTF8-encoded string, or the object passed in if
     *    it wasn't a string
     */
    public static function utf8($value)
    {
        if (null === self::$isMbstringAvailable) {
            self::$isMbstringAvailable = \function_exists('mb_detect_encoding');

            if (!self::$isMbstringAvailable) {
                \trigger_error('It looks like the mbstring extension is not enabled. ' .
                    'UTF-8 strings will not properly be encoded. Ask your system ' .
                    'administrator to enable the mbstring extension, or write to ' .
                    'support@stripe.com if you have any questions.', \E_USER_WARNING);
            }
        }

        if (\is_string($value) && self::$isMbstringAvailable && 'UTF-8' !== \mb_detect_encoding($value, 'UTF-8', true)) {
            return \utf8_encode($value);
        }

        return $value;
    }

    /**
     * Compares two strings for equality. The time taken is independent of the
     * number of characters that match.
     *
     * @param string $a one of the strings to compare
     * @param string $b the other string to compare
     *
     * @return bool true if the strings are equal, false otherwise
     */
    public static function secureCompare($a, $b)
    {
        if (null === self::$isHashEqualsAvailable) {
            self::$isHashEqualsAvailable = \function_exists('hash_equals');
        }

        if (self::$isHashEqualsAvailable) {
            return \hash_equals($a, $b);
        }
        if (\strlen($a) !== \strlen($b)) {
            return false;
        }

        $result = 0;
        for ($i = 0; $i < \strlen($a); ++$i) {
            $result |= \ord($a[$i]) ^ \ord($b[$i]);
        }

        return 0 === $result;
    }

    /**
     * Recursively goes through an array of parameters. If a parameter is an instance of
     * ApiResource, then it is replaced by the resource's ID.
     * Also clears out null values.
     *
     * @param mixed $h
     *
     * @return mixed
     */
    public static function objectsToIds($h)
    {
        if ($h instanceof \StripeV2\ApiResource) {
            return $h->id;
        }
        if (static::isList($h)) {
            $results = [];
            foreach ($h as $v) {
                \array_push($results, static::objectsToIds($v));
            }

            return $results;
        }
        if (\is_array($h)) {
            $results = [];
            foreach ($h as $k => $v) {
                if (null === $v) {
                    continue;
                }
                $results[$k] = static::objectsToIds($v);
            }

            return $results;
        }

        return $h;
    }

    /**
     * @param array $params
     *
     * @return string
     */
    public static function encodeParameters($params)
    {
        $flattenedParams = self::flattenParams($params);
        $pieces = [];
        foreach ($flattenedParams as $param) {
            list($k, $v) = $param;
            \array_push($pieces, self::urlEncode($k) . '=' . self::urlEncode($v));
        }

        return \implode('&', $pieces);
    }

    /**
     * @param array $params
     * @param null|string $parentKey
     *
     * @return array
     */
    public static function flattenParams($params, $parentKey = null)
    {
        $result = [];

        foreach ($params as $key => $value) {
            $calculatedKey = $parentKey ? "{$parentKey}[{$key}]" : $key;

            if (self::isList($value)) {
                $result = \array_merge($result, self::flattenParamsList($value, $calculatedKey));
            } elseif (\is_array($value)) {
                $result = \array_merge($result, self::flattenParams($value, $calculatedKey));
            } else {
                \array_push($result, [$calculatedKey, $value]);
            }
        }

        return $result;
    }

    /**
     * @param array $value
     * @param string $calculatedKey
     *
     * @return array
     */
    public static function flattenParamsList($value, $calculatedKey)
    {
        $result = [];

        foreach ($value as $i => $elem) {
            if (self::isList($elem)) {
                $result = \array_merge($result, self::flattenParamsList($elem, $calculatedKey));
            } elseif (\is_array($elem)) {
                $result = \array_merge($result, self::flattenParams($elem, "{$calculatedKey}[{$i}]"));
            } else {
                \array_push($result, ["{$calculatedKey}[{$i}]", $elem]);
            }
        }

        return $result;
    }

    /**
     * @param string $key a string to URL-encode
     *
     * @return string the URL-encoded string
     */
    public static function urlEncode($key)
    {
        $s = \urlencode((string) $key);

        // Don't use strict form encoding by changing the square bracket control
        // characters back to their literals. This is fine by the server, and
        // makes these parameter strings easier to read.
        $s = \str_replace('%5B', '[', $s);

        return \str_replace('%5D', ']', $s);
    }

    public static function normalizeId($id)
    {
        if (\is_array($id)) {
            $params = $id;
            $id = $params['id'];
            unset($params['id']);
        } else {
            $params = [];
        }

        return [$id, $params];
    }

    /**
     * Returns UNIX timestamp in milliseconds.
     *
     * @return int current time in millis
     */
    public static function currentTimeMillis()
    {
        return (int) \round(\microtime(true) * 1000);
    }
}
