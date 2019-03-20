<?php

namespace App\Presenters;

use Nette\Application\IResponse;

/**
 * Class HomepagePresenter
 * @package App\Presenters
 */
class HomepagePresenter extends BasePresenter
{
	/** */
	protected function startup()
	{
		parent::startup();
	}

	/** */
	public function actionDefault()
	{
	}

	/** */
	protected function beforeRender()
	{
		parent::beforeRender();
	}

	/** */
	public function renderDefault()
	{
	}

	/** */
	protected function afterRender()
	{
		parent::afterRender();
	}

	/**
	 *
	 * @param IResponse $response
	 */
	protected function shutdown($response)
	{
		parent::shutdown($response);
	}
}
