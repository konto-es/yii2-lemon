<?php

namespace kowi\lemonway\resources;

use kowi\lemonway\objects\Company;

class AccountLegal extends AccountIndividual
{
    /** @var Company $company */
    public $company;

    public function rules()
    {
        return array_merge(parent::rules(), [
            /** @see https://apidoc.lemonway.com/#operation/Accounts_LegalPost */
            [['company'], 'required', 'on' => static::SCENARIO_CREATE],
            [['company'], 'kowi\lemonway\validators\ObjectValidator', 'targetClass' => 'kowi\lemonway\objects\Company'],
        ]);
    }

    public static function resource()
    {
        return [
            static::SCENARIO_LOAD => '/accounts',
            static::SCENARIO_CREATE => '/accounts/legal',
            static::SCENARIO_UPDATE => '/accounts/legal',
        ];
    }
}