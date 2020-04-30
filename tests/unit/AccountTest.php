<?php

namespace kowi\lemonway\tests;

use Codeception\Specify;
use Codeception\Test\Unit;
use ddroche\shasta\resources\Account;
use ddroche\shasta\resources\BankAccount;
use ddroche\shasta\resources\Customer;
use yii\base\InvalidConfigException;
use yii\httpclient\Exception;

class AccountTest extends Unit
{
    use Specify;

    /**
     * @var UnitTester
     */
    protected $tester;

    /**
     * @var Account
     * @specify
     */
    private $account;
    
    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests
    public function testValidationErrors()
    {
        $this->account = new Account();

        $this->specify("currency cannot be blank", function() {
            $this->account->currency = null;
            $this->assertFalse($this->account->save());
            $this->assertEquals(1, count($this->account->getErrors()));
        });

        $this->specify("currency is invalid", function() {
            $this->account->currency = 'USD';
            $this->assertFalse($this->account->save());
            $this->assertEquals(1, count($this->account->getErrors()));
        });

        $this->account->currency = 'EUR';

        $this->specify("customer_id is invalid", function() {
            $this->account->customer_id = 'customer_id';
            $this->assertFalse($this->account->save());
            $this->assertEquals(1, count($this->account->getErrors()));
        });

        $this->specify("allow_negative_balance default false", function() {
            $this->account->allow_negative_balance = null;
            $this->assertTrue($this->account->validate());
            $this->assertEquals(false, $this->account->allow_negative_balance);
        });

        $this->specify("allow_negative_balance type boolean", function() {
            $this->account->allow_negative_balance = 'balance';
            $this->assertFalse($this->account->save());
            $this->assertEquals(1, count($this->account->getErrors()));
        });

        $this->specify("auto_bank_payout not AutoBankPayout", function() {
            $this->account->auto_bank_payout = 'auto_bank_payout';
            $this->assertFalse($this->account->save());
            $this->assertEquals(1, count($this->account->getErrors()));
        });

        $this->specify("auto_bank_payout.min_balance not Value", function() {
            $this->account->auto_bank_payout = [
                'min_balance' => 'min_balance'
            ];
            $this->assertFalse($this->account->save());
            $this->assertEquals(1, count($this->account->getErrors()));
        });

        $this->specify("auto_bank_payout.min_balance.amount must be a number.", function() {
            $this->account->auto_bank_payout = [
                'min_balance' => [
                   'amount' => ''
                ]
            ];
            $this->assertFalse($this->account->save());
            $this->assertEquals(1, count($this->account->getErrors()));
        });

        $this->specify("auto_bank_payout.min_balance.currency is invalid", function() {
            $this->account->auto_bank_payout = [
                'min_balance' => [
                   'amount' => '1',
                   'currency' => 'currency',
                ]
            ];
            $this->assertFalse($this->account->save());
            $this->assertEquals(1, count($this->account->getErrors()));
        });

        $this->specify("auto_bank_payout.min_balance.bank_account_id is invalid", function() {
            $this->account->auto_bank_payout = [
                'min_balance' => [
                   'amount' => '1',
                   'currency' => 'EUR',
                ], // TODO review propagate errors
                'bank_account_id' => 'bank_account_id',
            ];
            $this->assertFalse($this->account->save());
            $this->assertEquals(1, count($this->account->getErrors()));
        });
    }

    /**
     * @throws Exception
     * @throws InvalidConfigException
     */
    public function testInsertOk()
    {
        $attributes = [
            'currency' => 'EUR',
            'customer_id' => Customer::findOne()->id,
            'allow_negative_balance' => true,
            'auto_bank_payout' => [
                'min_balance' => [
                    'amount' => '1.00',
                    'currency' => 'EUR',
                ],
                'bank_account_id' => BankAccount::findOne()->id,
                'concept' => 'concept',
            ],
        ];

        $this->account = new Account();
        $this->account->scenario = Account::SCENARIO_CREATE;
        $this->account->setAttributes($attributes);
        $this->assertTrue($this->account->save());

        $this->assertNotNull($this->account->id);
        $this->assertNotNull($this->account->created_at);
        $this->assertNotNull($this->account->project_id);

        $account = Account::findOne($this->account->id);
        unset($attributes['currency']);
        $this->assertArrayContains($attributes, $account);
    }

    /**
     * @throws InvalidConfigException
     * @throws Exception
     */
    /*public function testValidationAndInsert()
    {
        $attributes = [
            'first_name' => 'Javier',
            'last_name' => 'Hernandez',
            'email_address' => 'javi@example.com',
            'phone_number' => '123456789',
            'employment_status' => 'student',
            'nationality' => 'ES',
            'address' => [
                'line_1' => 'Avenida Omejos, 5',
                'line_2' => 'Atico 2a',
                'postal_code' => '08291',
                'city' => "L'Hospitalet de Llobregat",
                'region' => 'Barcelona',
                'country' => 'ES',
            ],
        ];

        $this->Account = new Account();
        $this->Account->scenario = Account::SCENARIO_CREATE;
        $this->Account->setAttributes($attributes);
        $this->assertTrue($this->Account->save());
        $this->assertNotNull($this->Account->id);
        $this->assertNotNull($this->Account->created_at);
        $this->assertNotNull($this->Account->project_id);

        $Account = Account::findOne($this->Account->id);
        $this->assertArrayContains($attributes, $Account);
    }*/

    /**
     * @throws Exception
     * @throws InvalidConfigException
     */
    /*public function testfindNone()
    {
        $this->Account = new Account();
        $this->assertfalse($this->Account->read());
        $this->assertEquals(1, count($this->Account->getErrors()));
    }*/

    /**
     * @throws InvalidConfigException
     * @throws Exception
     */
    /*public function testFindAllAndUpdateOne()
    {
        $this->Account = new Account();
        $this->assertfalse($this->Account->update());
        $this->assertEquals(1, count($this->Account->getErrors()));

        $Accounts = Account::findAll();
        $this->assertGreaterThan(1, count($Accounts));
        $this->Account = $Accounts[1];

        $this->Account->email_address = 'email_address';
        $this->assertfalse($this->Account->update());
        $this->assertEquals(1, count($this->Account->getErrors()));

        $attributes = [
            'first_name' => 'Javier1',
            'last_name' => 'Hernandez1',
            'email_address' => 'javi1@example.com',
            'phone_number' => '123456781',
            'employment_status' => 'employed',
            'nationality' => 'FR',
        ];
        $this->Account->setAttributes($attributes);
        $this->assertTrue($this->Account->save());

        $Account = Account::findOne($this->Account->id);
        $this->assertArrayContains($attributes, $Account);
    }*/

    /*public function assertArrayContains($needle, $haystack)
    {
        foreach ($needle as $key => $value) {
            $this->assertEquals($value, $haystack[$key]);
        }
    }*/

    public function assertArrayContains($needle, $haystack)
    {
        foreach ($needle as $key => $value) {
            $this->assertEquals($value, $haystack[$key]);
        }
    }
}