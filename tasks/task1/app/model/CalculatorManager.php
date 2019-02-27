<?php

namespace App\Model;

use Nette\NotImplementedException;
use Nette\SmartObject;

/**
 * Class CalculatorManager
 * @package App\Model
 */
class CalculatorManager
{
	use SmartObject;

	/**
	 *
	 * @param int $x
	 * @param int $y
	 * @return int
	 */
	public function add($x, $y)
	{
		return $x + $y;
	}

	/**
	 *
	 * @param int $x
	 * @param int $y
	 * @return int
	 */
	public function subtract($x, $y)
	{
		return $x - $y;
	}

	/**
	 *
	 * @param int $x
	 * @param int $y
	 * @return int
	 */
	public function multiply($x, $y)
	{
		return $x * $y;
	}

	/**
	 *
	 * @param int $x
	 * @param int $y
	 * @return double
	 */
	public function divide($x, $y)
	{
		return $x / $y;
	}

    /**
     *
     * @param int $x
     * @param int $y
     * @return int
     */
    public function module($x, $y)
    {
        return $x % $y;
    }

    /**
     *
     * @param int $x
     * @param int $y
     * @return int
     */
    public function power($x, $y)
    {
        return $x ** $y;
    }

    /**
     *
     * @param int $x
     * @return double
     */
    public function squareroot($x)
    {
        return sqrt($x);
    }
}
