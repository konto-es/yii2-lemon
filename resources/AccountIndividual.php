<?php


namespace kowi\lemonway\resources;

use kowi\lemonway\objects\Adresse;
use kowi\lemonway\objects\Birth;

/**
 * Class AccountIndividual
 * @package kowi\lemonway\resources
 */
class AccountIndividual extends LemonwayResource
{
    /**
     * @var string Payment account ID that you use to identify the customer.Choose your unique number.
     * NOTE : If you plan to credit payments accounts by fund transfer, please use short alphanumeric payment
     * account identifiers (max 20 char.). Your customers will have to write their payment account identifier
     * in the transfer label/comment, a label of more that 20 characters could be cut when passing the the
     * banking system.
     */
    public $accountId;
    /** @var string Unique Email. */
    public $email;
    /** @var string CLIENT title. */
    public $title;
    /** @var string CLIENT first name. */
    public $firstName;
    /** @var string CLIENT last name. */
    public $lastName;
    /** @var Adresse  */
    public $adresse;
    /** @var Birth */
    public $birth;
    /** @var string Nationality of the client, using ISO 3166-1 alpha-3 format. Please separate multiple nationalities with a comma. */
    public $nationality;
    /** @var string Phone number with MSISDN format: international number with country code without "00" neither "+". */
    public $phoneNumber;
    /**
     * @var string Mobile phone number with MSISDN format: international number with country code without "00" neither "+".
     * This will be used by default when eletronically signing documents.
     */
    public $mobileNumber;
    /** @var boolean For crowdfunding/loan platforms, indicates if the wallet is created for a debtor. */
    public $isDebtor;
    /**
     * @var integer Indicates if the payment account is created for a payer or a beneficiary:
     *     Empty: unknown status (default).
     *     1: Payer.
     *     2: Beneficiary.
     */
    public $payerOrBeneficiary;
    /**
     * @var boolean Indicates if the payment account is for a one-time customer. If yes, the payment account will be
     * created with status 14, allowing only one payment. The maximum amount will be defined with Lemon Way.
     */
    public $isOneTimeCustomerAccount;
    /**
     * @var boolean This option is available depending on your contract. True, in case this option is enabled in your
     * contract. Otherwise it will be considered a client wallet.
     */
    public $isTechnicalAccount;

    /**
     * Rules established according to the documentation
     *
     * @see https://apidoc.lemonway.com/
     * @return array
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            /** @see https://apidoc.lemonway.com/#operation/Accounts_IndividualPut */
            [['accountId', 'email', 'firstName', 'lastName', 'nationality', 'payerOrBeneficiary'], 'required', 'on' => [static::SCENARIO_CREATE]],
            [['accountId'], 'string', 'min' => 1, 'max' => 100],
            [['email'], 'string',  'min' => 6, 'max' => 256],
            [['email'], 'match', 'pattern' => '^[12]\d{3}\/(0[1-9]|1[0-2])\/(0[1-9]|[12]\d|3[01])$'],
            ['title', 'in', 'range' => ['M', 'F', 'J', 'U']],
            [['firstName', 'lastName'], 'string', 'min' => 2, 'max' => 256],
            [['adresse'], 'kowi\lemonway\validators\ObjectValidator', 'targetClass' => 'kowi\lemonway\objects\Adresse'],
            [['birth'], 'kowi\lemonway\validators\ObjectValidator', 'targetClass' => 'kowi\lemonway\objects\Birth'],
            [['nationality'], 'string', 'min' => 0, 'max' => 19],
            [['phoneNumber', 'mobileNumber'], 'string', 'min' => 6, 'max' => 30],
            [['isDebtor', 'isOneTimeCustomerAccount', 'isTechnicalAccount'], 'boolean'],
            ['payerOrBeneficiary', 'in', 'range' => [1, 2, 3]],
        ]);
    }

    public static function resource()
    {
        return [
            static::SCENARIO_LOAD => '/accounts',
            static::SCENARIO_CREATE => '/accounts/individual',
            static::SCENARIO_UPDATE => '/accounts/individual',
        ];
    }
}