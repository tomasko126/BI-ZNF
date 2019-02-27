<?php

use App\Model\CalculatorManager;
use Tester\Assert;
use Tester\TestCase;

require_once __DIR__ . '/../bootstrap.php';

/**
 * Test class for CalculatorManager
 * @testCase
 */
class CalculatorManagerTest extends TestCase
{
	/** @var CalculatorManager */
	private $calculatorManager;

	protected function setUp()
	{
		parent::setUp();
		$this->calculatorManager = new CalculatorManager();
	}

	protected function getDataForAddition()
	{
		return [
			[1, 1, 2],
			[3, 4, 7],
			[-1, 1, 0],
			[1, -1, 0],
			[0, 0, 0],
			[9, 1, 10]
		];
	}

	/**
	 * @dataProvider getDataForAddition
	 * @param int $x
	 * @param int $y
	 * @param int $result
	 */
	public function testAdd($x, $y, $result)
	{
		Assert::same($result, $this->calculatorManager->add($x, $y));
	}

	protected function getDataForSubtraction()
	{
		return [
			[1, 1, 0],
			[3, 4, -1],
			[-1, 1, -2],
			[1, -1, 2],
			[0, 0, 0],
			[9, 1, 8]
		];
	}

	/**
	 * @dataProvider getDataForSubtraction
	 * @param int $x
	 * @param int $y
	 * @param int $result
	 */
	public function testSubtract($x, $y, $result)
	{
		Assert::same($result, $this->calculatorManager->subtract($x, $y));
	}

	protected function getDataForMultiplication()
	{
		return [
			[1, 1, 1],
			[3, 4, 12],
			[-1, 1, -1],
			[1, -1, -1],
			[0, 0, 0],
			[9, 1, 9]
		];
	}

	/**
	 * @dataProvider getDataForMultiplication
	 * @param int $x
	 * @param int $y
	 * @param int $result
	 */
	public function testMultiply($x, $y, $result)
	{
		Assert::same($result, $this->calculatorManager->multiply($x, $y));
	}

	protected function getDataForDivision()
	{
		return [
			[1, 1, 1],
			[12, 4, 3],
			[-1, 1, -1],
			[1, -1, -1],
			[9, 1, 9]
		];
	}

	/**
	 * @dataProvider getDataForDivision
	 * @param int $x
	 * @param int $y
	 * @param int $result
	 */
	public function testDivide($x, $y, $result)
	{
		Assert::same($result, $this->calculatorManager->divide($x, $y));
	}

	protected function getDataForModule()
    {
    	return [
    		[1, 1, 0],
    		[12, 4, 0],
    		[-8, 5, -3],
    		[-8, -5, -3],
    		[9, 5, 4],
    		[12, -5, 2],
    	];
    }

    /**
     * @dataProvider getDataForModule
     * @param int $x
     * @param int $y
     * @param int $result
     */
    public function testModule($x, $y, $result)
    {
    	Assert::same($result, $this->calculatorManager->module($x, $y));
    }

    protected function getDataForPower()
    {
       	return [
       		[9, 1, 9],
       		[12, 0, 1],
       		[-8, 2, 64],
       		[8, 2, 64],
       		[3, 3, 27],
       		[12, 2, 144],
       	];
    }

    /**
     * @dataProvider getDataForPower
     * @param int $x
     * @param int $y
     * @param int $result
     */
    public function testPower($x, $y, $result)
    {
     	Assert::same($result, $this->calculatorManager->power($x, $y));
    }

    protected function getDataForSquareRoot()
    {
       	return [
       		[9, 3.0],
       		[4, 2.0],
       		[1, 1.0]
       	];
    }

    /**
     * @dataProvider getDataForSquareRoot
     * @param int $x
     * @param int $result
     */
    public function testSquareRoot($x, $result)
    {
      	Assert::same($result, $this->calculatorManager->squareroot($x));
    }

}

$testCase = new CalculatorManagerTest();
$testCase->run();
