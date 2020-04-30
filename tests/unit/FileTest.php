<?php

namespace kowi\lemonway\tests;

use Codeception\Specify;
use Codeception\Test\Unit;
use ddroche\shasta\resources\Account;
use ddroche\shasta\resources\File;
use yii\base\InvalidConfigException;

class FileTest extends Unit
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

    /**
     * @var File
     * @specify
     */
    private $file;

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    /**
     * @throws InvalidConfigException
     */
    public function testUpload()
    {
        $this->file = new File();
        $this->file->public = true;
        $this->assertTrue($this->file->upload(__DIR__ . DIRECTORY_SEPARATOR . 'File-Header-600x315.jpg'));
    }
}