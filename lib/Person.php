<?php

namespace StripeV2;

/**
 * Class Person.
 *
 * @property string $id
 * @property string $object
 * @property string $account
 * @property \StripeV2\StripeObject $address
 * @property null|\StripeV2\StripeObject $address_kana
 * @property null|\StripeV2\StripeObject $address_kanji
 * @property int $created
 * @property bool $deleted
 * @property \StripeV2\StripeObject $dob
 * @property null|string $email
 * @property null|string $first_name
 * @property null|string $first_name_kana
 * @property null|string $first_name_kanji
 * @property null|string $gender
 * @property bool $id_number_provided
 * @property null|string $last_name
 * @property null|string $last_name_kana
 * @property null|string $last_name_kanji
 * @property null|string $maiden_name
 * @property \StripeV2\StripeObject $metadata
 * @property null|string $phone
 * @property \StripeV2\StripeObject $relationship
 * @property null|\StripeV2\StripeObject $requirements
 * @property bool $ssn_last_4_provided
 * @property \StripeV2\StripeObject $verification
 */
class Person extends ApiResource
{
    const OBJECT_NAME = 'person';

    use ApiOperations\Delete;
    use ApiOperations\Update;

    /**
     * Possible string representations of a person's gender.
     *
     * @see https://stripe.com/docs/api/persons/object#person_object-gender
     */
    const GENDER_MALE = 'male';
    const GENDER_FEMALE = 'female';

    /**
     * Possible string representations of a person's verification status.
     *
     * @see https://stripe.com/docs/api/persons/object#person_object-verification-status
     */
    const VERIFICATION_STATUS_PENDING = 'pending';
    const VERIFICATION_STATUS_UNVERIFIED = 'unverified';
    const VERIFICATION_STATUS_VERIFIED = 'verified';

    /**
     * @return string the API URL for this Stripe account reversal
     */
    public function instanceUrl()
    {
        $id = $this['id'];
        $account = $this['account'];
        if (!$id) {
            throw new Exception\UnexpectedValueException(
                'Could not determine which URL to request: ' .
                "class instance has invalid ID: {$id}",
                null
            );
        }
        $id = Util\Util::utf8($id);
        $account = Util\Util::utf8($account);

        $base = Account::classUrl();
        $accountExtn = \urlencode($account);
        $extn = \urlencode($id);

        return "{$base}/{$accountExtn}/persons/{$extn}";
    }

    /**
     * @param array|string $_id
     * @param null|array|string $_opts
     *
     * @throws \StripeV2\Exception\BadMethodCallException
     */
    public static function retrieve($_id, $_opts = null)
    {
        $msg = 'Persons cannot be retrieved without an account ID. Retrieve ' .
               "a person using `Account::retrievePerson('account_id', " .
               "'person_id')`.";

        throw new Exception\BadMethodCallException($msg);
    }

    /**
     * @param string $_id
     * @param null|array $_params
     * @param null|array|string $_options
     *
     * @throws \StripeV2\Exception\BadMethodCallException
     */
    public static function update($_id, $_params = null, $_options = null)
    {
        $msg = 'Persons cannot be updated without an account ID. Update ' .
               "a person using `Account::updatePerson('account_id', " .
               "'person_id', \$updateParams)`.";

        throw new Exception\BadMethodCallException($msg);
    }
}
