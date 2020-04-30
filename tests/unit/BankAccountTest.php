<?php

namespace kowi\lemonway\tests;

use Codeception\Specify;
use Codeception\Test\Unit;
use \ddroche\shasta\resources\BankAccount;
use ddroche\shasta\resources\Customer;
use yii\base\InvalidConfigException;
use yii\httpclient\Exception;

class BankAccountTest extends Unit
{
    use Specify;

    /**
     * @var UnitTester
     */
    protected $tester;

    /**
     * @var BankAccount
     * @specify
     */
    private $bankAccount;
    
    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests
    public function testValidationErrors()
    {
        $this->bankAccount = new BankAccount();

        $this->specify("customer_id is invalid", function() {
            $this->bankAccount->customer_id = 'customer_id';
            $this->assertFalse($this->bankAccount->save());
            $this->assertEquals(1, count($this->bankAccount->getErrors()));
        });

        $this->specify("bank_account_info is invalid", function() {
            $this->bankAccount->bank_account_info = 'bank_account_info';
            $this->assertFalse($this->bankAccount->save());
            $this->assertEquals(1, count($this->bankAccount->getErrors()));
        });

        $this->specify("bank_account_info is invalid", function() {
            $this->bankAccount->bank_account_info = [
                'beneficiary_swift' => 123
            ];
            $this->assertFalse($this->bankAccount->save());
            $this->assertEquals(1, count($this->bankAccount->getErrors()));
        });
    }

    /**
     * @throws Exception
     * @throws InvalidConfigException
     */
    public function testInsertOk()
    {
        $attributes = [
            'customer_id' => Customer::findOne()->id,
            // TODO Allow objects attributes null in next version
            'bank_account_info' => [
                'beneficiary_name' => 'Tester',
                'beneficiary_swift' => '',
                'beneficiary_zip_code' => '',
                'beneficiary_phone_number' => '',
                'beneficiary_email' => '',
                'iban' => 'ES6621000418401234567891',
            ],
        ];

        $this->bankAccount = new BankAccount();
        $this->bankAccount->scenario = BankAccount::SCENARIO_CREATE;
        $this->bankAccount->setAttributes($attributes);
        $this->assertTrue($this->bankAccount->save());

        $this->assertNotNull($this->bankAccount->id);
        $this->assertNotNull($this->bankAccount->created_at);
        $this->assertNotNull($this->bankAccount->project_id);

        $bankAccount = BankAccount::findOne($this->bankAccount->id);
        $this->assertEquals($attributes['bank_account_info']['beneficiary_name'], $bankAccount->bank_account_info['beneficiary_name']);
        $this->assertEquals($attributes['bank_account_info']['iban'], $bankAccount->bank_account_info['iban']);
    }

    /**
     * @throws Exception
     * @throws InvalidConfigException
     */
    public function testUpdateError()
    {
        $attributes = [
            'customer_id' => Customer::findOne()->id,
            'bank_account_info' => [
                'beneficiary_name' => 'Tester',
                'iban' => 'ES6621000418401234567891',
            ],
        ];
        // TODO customer_id not found
        $this->bankAccount = BankAccount::findOne();
        $this->bankAccount->scenario = BankAccount::SCENARIO_DEFAULT;
        $this->bankAccount->setAttributes($attributes);

        // TODO Failed asserting that false is true.
        // TODO Invalid JSON in request body: json: unknown field "customer_id"
        $this->assertTrue($this->bankAccount->save());

        $this->assertNotNull($this->bankAccount->id);
        $this->assertNotNull($this->bankAccount->created_at);
        $this->assertNotNull($this->bankAccount->project_id);

        $bankAccount = BankAccount::findOne($this->bankAccount->id);
        $this->assertEquals($attributes['bank_account_info']['beneficiary_name'], $bankAccount->bank_account_info['beneficiary_name']);
        $this->assertEquals($attributes['bank_account_info']['iban'], $bankAccount->bank_account_info['iban']);
    }

    /**
     * @throws Exception
     * @throws InvalidConfigException
     */
    public function testList()
    {

        $bankAccounts = BankAccount::findAll();

        $this->assertGreaterThan(1, count($bankAccounts));
    }

    public function assertArrayContains($needle, $haystack)
    {
        foreach ($needle as $key => $value) {
            $this->assertEquals($value, $haystack[$key]);
        }
    }
}