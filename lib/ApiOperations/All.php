<?php

namespace StripeV2\ApiOperations;

/**
 * Trait for listable resources. Adds a `all()` static method to the class.
 *
 * This trait should only be applied to classes that derive from StripeObject.
 */
trait All
{
    /**
     * @param null|array $params
     * @param null|array|string $opts
     *
     * @throws \StripeV2\Exception\ApiErrorException if the request fails
     *
     * @return \StripeV2\Collection of ApiResources
     */
    public static function all($params = null, $opts = null)
    {
        self::_validateParams($params);
        $url = static::classUrl();

        list($response, $opts) = static::_staticRequest('get', $url, $params, $opts);
        $obj = \StripeV2\Util\Util::convertToStripeObject($response->json, $opts);
        if (!($obj instanceof \StripeV2\Collection)) {
            throw new \StripeV2\Exception\UnexpectedValueException(
                'Expected type ' . \StripeV2\Collection::class . ', got "' . \get_class($obj) . '" instead.'
            );
        }
        $obj->setLastResponse($response);
        $obj->setFilters($params);

        return $obj;
    }
}
