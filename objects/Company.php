<?php

namespace kowi\lemon\objects;

use yii\base\Model;

/**
 * Class Company
 * @package kowi\lemon\objects
 */
class Company extends Model
{
    /** @var string Name of the company (at least one alphabethic character is required). */
    public $name;
    /** @var string Company description. */
    public $description;
    /** @var string Website URL. */
    public $websiteUrl;
    /** @var string Company identification number. */
    public $identificationNumber;

    /**
     * Rules established according to the documentation
     *
     * @see https://apidoc.lemonway.com/
     * @return array
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            /** @see https://apidoc.lemonway.com/#operation/Accounts_LegalPost */
            [['name', 'description', 'websiteUrl','identificationNumber'], 'string', 'min' => 1, 'max' => 256],
            [['name', 'description', 'websiteUrl'], 'required'],
        ]);
    }
}