<?php

namespace App\Presenters;

use App\Forms\PidFormFactory;
use App\Model\PidModel;
use Nette\Application\UI\Form;
use App\Model\NoDataFound;
use Tracy\Debugger;


class PidPresenter extends BasePresenter
{
    /** @var PidFormFactory - Formulářová továrnička pro správu rc */
    private $formFactory;

    /** @var PidModel - model pro management rc*/
    private $pidModel;

    public function injectDependencies(PidFormFactory $formFactory, PidModel $pidModel) {
        parent::__construct();
        $this->formFactory = $formFactory;
        $this->pidModel = $pidModel;
    }

    /**
     * Akce pro editaci
     * @param int $id id rc
     */
    public function actionEdit($id) {
        $form = $this['editForm'];
        try {
            $pid = $this->pidModel->getPid($id);
            $form->setDefaults($pid);
        } catch (NoDataFound $e) {
            $form->addError('Nelze načíst data');
        }
    }

    /**
     * Akce pro mazání
     * @param int $id id pid
     */
    public function actionDelete($id) {
        $form = $this['deleteForm'];
        $form['id']->setDefaultValue($id);
    }

    /**
     * Metoda pro vytvoření formuláře pro vložení
     * @return Form - formulář
     */
    public function createComponentAddForm()
    {
        $form = $this->formFactory->createAddForm();
        $form->onSuccess[] = function (Form $form) {
            $this->redirect('Pid:default');
        };
        return $form;
    }

    /**
     * Metoda pro vytvoření formuláře pro editaci
     * @return Form - formulář
     */
    public function createComponentEditForm()
    {
        $form = $this->formFactory->createEditForm();
        $form->onSuccess[] = function (Form $form) {
            $this->redirect('Pid:default');
        };
        return $form;
    }

    /**
     * Metoda pro vytvoření formuáře pro mazání
     * @return Form - formulář
     */
    public function createComponentDeleteForm()
    {
        $form = $this->formFactory->createDeleteForm();
        $form->onSuccess[] = function (Form $form) {
            $this->redirect('Pid:default');
        };
        return $form;
    }

    /**
     * Metoda pro naplnění dat pro šablonu dané akce
     */
    public function renderEdit($id) {
        $pid = $this->pidModel->getPid($id);
        $this->template->name = $pid['name'];
    }

    /**
     * Metoda pro naplnění dat pro šablonu dané akce
     */
    public function renderDelete($id) {
        $pid = $this->pidModel->getPid($id);
        $this->template->name = $pid['name'];
    }

    /**
     * Metoda pro naplnění dat pro šablonu dané akce
     */
    public function renderDefault() {
       $this->template->pids = $this->pidModel->listPids();
    }
}