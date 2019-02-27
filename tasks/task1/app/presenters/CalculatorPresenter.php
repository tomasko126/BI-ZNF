<?php

namespace App\Presenters;

use App\Model\CalculatorManager;
use Nette\Application\UI\Presenter;

/**
 * Class CalculatorPresenter
 * @package App\Presenters
 */
class CalculatorPresenter extends Presenter
{
	/** @var CalculatorManager */
	private $calculatorManager;

	/**
	 * HomepagePresenter constructor.
	 * @param CalculatorManager $calculatorManager
	 */
	public function __construct(CalculatorManager $calculatorManager)
	{
		parent::__construct();
		$this->calculatorManager = $calculatorManager;
	}

	/** */
	protected function startup()
	{
		parent::startup();
		$number1 = $this->getRequest()->getParameter('number1');
		$number2 = $this->getRequest()->getParameter('number2');
		if ($this->getAction() !== 'default' && $this->getAction() !== 'sqrt' && (empty($number1) || empty($number2))) {
            $this->redirect('Calculator:');
        }
	}

	/** */
	public function beforeRender()
	{
		parent::beforeRender();
		$this->template->setFile(__DIR__ . "/templates/{$this->getName()}/default.latte");
	}

	/**
	 *
	 * @param int $number1
	 * @param int $number2
	 */
	public function renderAdd($number1, $number2)
	{
		$this->template->result = $this->calculatorManager->add($number1, $number2);
	}

	/**
	 *
	 * @param int $number1
	 * @param int $number2
	 */
	public function renderSub($number1, $number2)
	{
		$this->template->result = $this->calculatorManager->subtract($number1, $number2);
	}

	/**
	 *
	 * @param int $number1
	 * @param int $number2
	 */
	public function renderMul($number1, $number2)
	{
		$this->template->result = $this->calculatorManager->multiply($number1, $number2);
	}

	/**
	 *
	 * @param int $number1
	 * @param int $number2
	 */
	public function renderDiv($number1, $number2)
	{
		$this->template->result = $this->calculatorManager->divide($number1, $number2);
	}

    /**
     *
     * @param int $number1
     * @param int $number2
     */
    public function renderMod($number1, $number2)
    {
        $this->template->result = $this->calculatorManager->module($number1, $number2);
    }

    /**
     *
     * @param int $number1
     * @param int $number2
     */
    public function renderPow($number1, $number2)
    {
        $this->template->result = $this->calculatorManager->power($number1, $number2);
    }

    /**
     *
     * @param int $number1
     */
    public function renderSqrt($number1)
    {
        $this->template->result = $this->calculatorManager->squareroot($number1);
    }
}
