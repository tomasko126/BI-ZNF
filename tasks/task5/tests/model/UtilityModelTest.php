<?php

require '../bootstrap.php';

use App\Bootstrap;
use Tester\Assert;

/**
 * TEST: Test class for UtilityModel
 * @testCase
 */

class UtilityModelTestCase extends Tester\TestCase {

    private $utilityModel;

    public function __construct(Nette\DI\Container $container) {
        $this->utilityModel = $container->getService('utilitymodel');
    }

    /**
     * @dataProvider getBirthDayData
     * @param $birthNumber
     * @param $result
     */
    public function testGetBirthDay($birthNumber, $result) {
        Assert::same($this->utilityModel->getBirthDay($birthNumber), $result);
    }

    public function getBirthDayData() {
        return [
            ['123456/1211', '!!'],
            ['bcfsad/5424', '!!'],
            ['960527/1111', '27.5.1996'],
            ['025802/1234', '2.8.2002'],
            ['180229/1232', '!!']
        ];
    }
}

$container = Bootstrap::getContainer();

$test = new UtilityModelTestCase($container);
$test->run();
