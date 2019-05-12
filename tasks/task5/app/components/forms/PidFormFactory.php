<?php

namespace App\Forms;

use App\Model\PidModel;
use Nette\SmartObject;
use Exception;
use Nette\Application\UI\Form;
use Nette\Forms\Container;
use Nette\Utils\ArrayHash;
use Tracy\Debugger;

/**
 * Továrnička na tvorbu formulářů pro správu rc.
 *
 * @author     Jiří Chludil
 * @author     Jindřich Máca
 * @copyright  Copyright (c) 2017 Jiří Chludil
 * @package    App\Forms
 */
class PidFormFactory {
    use SmartObject;

    /** @var PidModel Model pro urc. */
    private $pidModel;

    public function injectDependencies(PidModel $pidModel) {
        $this->pidModel = $pidModel;
    }

    /** @inheritdoc */
    protected function addCommonFields(Container &$form, $args = null)
    {
        $form->addText('name', 'Rodné číslo')
            ->setAttribute('placeholder', 'Vyplň rodné číslo');
    }


    /**
     * Vytváří komponentu formuláře pro přidávání nového rc.
     * @param null|array $args další argumenty
     * @return Form formulář pro přidávání nového rc
     */
    public function createAddForm($args = null)
    {
        $form = new Form(NULL, 'addForm');
        $form->getElementPrototype()->novalidate('novalidate');
        $form->addProtection('Ochrana');
        $this->addCommonFields($form);
        $form->addSubmit('send', 'Přidej');
        $form->onSuccess[] = [$this, "newFormSucceeded"];
        return $form;
    }

    /**
     * Vytváří komponentu formuláře pro editaci rc.
     * @param null|array $args další argumenty
     * @return Form formulář pro editaci rc
     */
    public function createEditForm($args = null)
    {
        $form = new Form(NULL, 'editForm');
        $form->getElementPrototype()->novalidate('novalidate');
        $form->addProtection('Ochrana');
        $this->addCommonFields($form);
        $form->addSubmit('send', 'Aktualizuj');
        $form->addHidden('id');
        $form->onSuccess[] = [$this, "editFormSucceeded"];
        return $form;
    }

    /**
     * Vytváří komponentu formuláře pro smazání rc.
     * @param null|array $args další argumenty
     * @return Form formulář pro smazání rc
     */
    public function createDeleteForm($args = null)
    {
        $form = new Form(NULL, 'deleteForm');
        $form->getElementPrototype()->novalidate('novalidate');
        $form->addProtection('Ochrana');
        $form->addSubmit('send', 'Odeber');
        $form->addHidden('id');
        $form->onSuccess[] = [$this, "deleteFormSucceeded"];
        return $form;
    }

    /**
     * Zpracování validních dat z formuláře a následného přidání rc.
     * @param Form      $form   formulář
     * @param ArrayHash $values data
     */
    public function newFormSucceeded(Form $form, ArrayHash $values)
    {
        try {
            $this->pidModel->insertPid($values);
        } catch (Exception $exception) {
            $form->addError($exception);
        }
    }

    /**
     * Zpracování validních dat z formuláře a následné aktualizace rc.
     * @param Form      $form   formulář
     * @param ArrayHash $values data
     */
    public function editFormSucceeded(Form $form, ArrayHash $values)
    {
        try {
            $id = $values['id'];
            unset($values['id']);
            $this->pidModel->updatePid($id, $values);
        } catch (Exception $exception) {
            Debugger::log($e);
            $form->addError($exception);
        }
    }

    /**
     * Zpracování validních dat z formuláře a následného odebrání rc.
     * @param Form      $form   formulář
     * @param ArrayHash $values data
     */
    public function deleteFormSucceeded(Form $form, ArrayHash $values)
    {
        try {
            $this->pidModel->deletePid($values['id']);
        } catch (Exception $exception) {
            $form->addError($exception);
        }
    }
}
