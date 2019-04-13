<?php

namespace App\Forms;

use App\Model\OrderModel;
use Exception;
use Nette\Application\UI\Form;
use Nette\Forms\Container;
use Nette\Forms\Controls\TextInput;
//use Nette\Object;
use Nette\SmartObject;
use Nette\Utils\ArrayHash;
use Nette\Utils\Strings;
use Tracy\Debugger;


/**
 * Továrnička na tvorbu formulářů pro správu nákupů.
 *
 * @author     Jiří Chludil
 * @author     Jindřich Máca
 * @copyright  Copyright (c) 2017 Jiří Chludil
 * @package    App\Forms
 */
class OrderFormFactory
{
    use SmartObject;

    /** @var OrderModel Model pro nákupy. */
    private $orderModel;

    public function injectDependencies(OrderModel $orderModel) {
        $this->orderModel = $orderModel;
    }

    /** @inheritdoc */
    protected function addCommonFields(Container &$form, $args = null)
    {
        $form->addSelect('user_id','Uživatel')
            ->setAttribute('placeholder', '============')
            ->setRequired('Je třeba vybrat uživatele');
        $form->addText('name', 'Název zboží')
            ->setAttribute('placeholder', 'Vyplň název zboží')
            ->setRequired('Je třeba název zboží');
        $form->addText('quantity', 'Množství')
            ->setType('number')
            ->setAttribute('placeholder', 'Vyplň množství')
            ->setRequired('Je třeba vyplnit množství')
            ->addRule(Form::INTEGER)
            ->addRule(Form::MIN, 'Množství musí být minimálně 1', 1)
            ->addRule(Form::MAX, 'Množství musí být maximálně 100', 100);
        $form->addText('price', 'Cena')
            ->setType('number')
            ->setAttribute('placeholder', 'Vyplň cenu')
            ->setRequired('Je třeba vyplnit cenu')
            ->addRule(Form::FLOAT)
            ->addRule(Form::MIN, 'Cena musí být alespoň 1', 1);
    }


    /**
     * Vytváří komponentu formuláře pro přidávání nového nákupu.
     * @param null|array $args další argumenty
     * @return Form formulář pro přidávání nového nákupu
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
     * Vytváří komponentu formuláře pro editaci nákupu.
     * @param null|array $args další argumenty
     * @return Form formulář pro editaci nákupu
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
     * Vytváří komponentu formuláře pro smazání nákupu.
     * @param null|array $args další argumenty
     * @return Form formulář pro smazání nákupu
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
     * Zpracování validních dat z formuláře a následného přidání nákupu.
     * @param Form      $form   formulář
     * @param ArrayHash $values data
     */
    public function newFormSucceeded(Form $form, ArrayHash $values)
    {
        try {
            $this->orderModel->insertOrder($values);
        } catch (Exception $exception) {
            $form->addError($exception);
        }
    }

    /**
     * Zpracování validních dat z formuláře a následné aktualizace nákupu.
     * @param Form      $form   formulář
     * @param ArrayHash $values data
     */
    public function editFormSucceeded(Form $form, ArrayHash $values)
    {
        try {
            $id = $values['id'];
            unset($values['id']);
            $this->orderModel->updateOrder($id, $values);
        } catch (Exception $exception) {
            Debugger::log($exception);
            $form->addError($exception);
        }
    }

    /**
     * Zpracování validních dat z formuláře a následného odebrání uživatele.
     * @param Form      $form   formulář
     * @param ArrayHash $values data
     */
    public function deleteFormSucceeded(Form $form, ArrayHash $values)
    {
        try {
            $this->orderModel->deleteOrder($values['id']);
        } catch (Exception $exception) {
            $form->addError($exception);
        }
    }
}
