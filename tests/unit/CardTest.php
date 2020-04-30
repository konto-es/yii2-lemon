<?php

namespace kowi\lemonway\tests;

use Codeception\Specify;
use Codeception\Test\Unit;
use ddroche\shasta\resources\Card;
use ddroche\shasta\resources\Customer;
use yii\base\InvalidConfigException;
use yii\httpclient\Exception;

class CardTest extends Unit
{
    use Specify;

    /**
     * @var UnitTester
     */
    protected $tester;

    /**
     * @var Card
     * @specify
     */
    private $card;
    
    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests
    public function testValidationErrors()
    {
        $this->card = new Card();

        $this->specify("customer_id is invalid", function() {
            $this->card->customer_id = 'customer_id';
            $this->assertFalse($this->card->save());
            $this->assertEquals(1, count($this->card->getErrors()));
        });

        $this->specify("card_info is invalid", function() {
            $this->card->card_info = 'card_info';
            $this->assertFalse($this->card->save());
            $this->assertEquals(1, count($this->card->getErrors()));
        });

        $this->specify("card_info is invalid", function() {
            $this->card->card_info = [
                'number' => 123
            ];
            $this->assertFalse($this->card->save());
            $this->assertEquals(1, count($this->card->getErrors()));
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
            'card_info' => [
                'number' => '5323601111111112',
                'expiration_month' => 10,
                'expiration_year' => 2030,
                'cvv' => '123',
            ],
        ];

        $this->card = new Card();
        $this->card->scenario = Card::SCENARIO_CREATE;
        $this->card->setAttributes($attributes);
        $this->assertTrue($this->card->save());

        $this->assertNotNull($this->card->id);
        $this->assertNotNull($this->card->created_at);
        $this->assertNotNull($this->card->project_id);

        $card = Card::findOne($this->card->id);
        $this->assertEquals($attributes['card_info']['expiration_month'], $card->card_info['expiration_month']);
        $this->assertEquals($attributes['card_info']['expiration_year'], $card->card_info['expiration_year']);
    }

    /**
     * @throws Exception
     * @throws InvalidConfigException
     */
    public function testUpdateError()
    {
        $attributes = [
            'customer_id' => Customer::findOne()->id,
            'card_info' => [
                'number' => '5323601111111112',
                'expiration_month' => 10,
                'expiration_year' => 2030,
                'cvv' => '123',
            ],
        ];
        // TODO customer_id not found
        $this->card = Card::findOne();
        $this->card->scenario = Card::SCENARIO_DEFAULT;
        $this->card->setAttributes($attributes);
        $this->assertTrue($this->card->save());

        $this->assertNotNull($this->card->id);
        $this->assertNotNull($this->card->created_at);
        $this->assertNotNull($this->card->project_id);

        $card = Card::findOne($this->card->id);
        $this->assertEquals($attributes['card_info']['expiration_month'], $card->card_info['expiration_month']);
        $this->assertEquals($attributes['card_info']['expiration_year'], $card->card_info['expiration_year']);
    }

    /**
     * @throws Exception
     * @throws InvalidConfigException
     */
    public function testList()
    {

        $cards = Card::findAll();

        $this->assertGreaterThan(1, count($cards));
    }

    public function assertArrayContains($needle, $haystack)
    {
        foreach ($needle as $key => $value) {
            $this->assertEquals($value, $haystack[$key]);
        }
    }
}