<?php


namespace kowi\lemon\resources;

use kowi\lemon\enums\IbanStatus;

class Iban extends Resource
{
    /**
     * @var string Payment account ID.
     */
    public $accountId;
    /**
     * @var string IBAN owner: first name and last name, or enterprise name.
     */
    public $holder;
    /**
     * @var string BIC/SWIFT code. Not mandatory.
     * The correct format is : [6 letters] + [2 numbers or letters] + [0 or 3 numbers or letters].
     */
    public $bic;
    /**
     * @var string IBAN
     */
    public $iban;
    /**
     * @var string First line of domiciliation. Generally, the name of the bank branch.
     * Can be left empty if the IBAN is from France or Monaco (starts with FR or MC).
     */
    public $domiciliation1;
    /**
     * @var string Second line of domiciliation. Generally, the street of the bank branch.
     * Can be left empty if the IBAN is from France or Monaco (starts with FR or MC).
     */
    public $domiciliation2;
    /**
     * @var string Reason for new IBAN if another IBAN is already linked to the wallet.
     */
    public $comment;
    /**
     * @var integer IBAN ID
     */
    public $ibanId;
    /**
     * @var integer IBAN Status
     */
    public $status;

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['accountId', 'holder', 'iban'], 'required', 'on' => [static::SCENARIO_CREATE]],
            [['accountId'], 'string', 'max' => 256, 'on' => [static::SCENARIO_CREATE]],
            [['holder'], 'string', 'min' => 1, 'max' => 100, 'on' => [static::SCENARIO_CREATE]],
            [['bic'], 'string', 'min' => 8, 'max' => 11, 'on' => [static::SCENARIO_CREATE]],
            [['iban'], 'string', 'min' => 15, 'max' => 34, 'on' => [static::SCENARIO_CREATE]],
            [['domiciliation1', 'domiciliation1'], 'string', 'min' => 1, 'max' => 256, 'on' => [static::SCENARIO_CREATE]],
            [['comment'], 'string', 'min' => 1, 'max' => 512, 'on' => [static::SCENARIO_CREATE]],
            [['ibanId', 'status'], 'integer', 'on' => [static::SCENARIO_LOAD]],
        ]);
    }

    public function getStatusLabel()
    {
        return IbanStatus::getLabel($this->status);
    }


    public static function resource()
    {
        return [
            static::SCENARIO_CREATE => '/v2/moneyouts/iban',
        ];
    }
}