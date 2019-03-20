<?php

namespace App\Forms;

use App\Model\UserModel;
use Exception;
use Nette\Application\UI\Form;
use Nette\Forms\Container;
use Nette\Forms\Controls\TextInput;
use Nette\Object;
use Nette\Utils\ArrayHash;
use Nette\Utils\Strings;
use Tracy\Debugger;


/**
 * Továrnička na tvorbu formulářů pro správu uživatelů.
 *
 * @author     Jiří Chludil
 * @author     Jindřich Máca
 * @copyright  Copyright (c) 2017 Jiří Chludil
 * @package    App\Forms
 */
class UserFormFactory extends Object
{
    /** @var UserModel Model pro uživatele. */
    private $userModel;

    /**
     * DI setter pro model pro uživatele.
     * @param UserModel $userModel automaticky injectovaná třída modelu pro uživatele
     */
    public function injectDependencies(UserModel $userModel)
    {
        $this->userModel = $userModel;
    }

    /** @inheritdoc */
    protected function addCommonFields(Container &$form, $args = null)
    {
        $form->addText('surname', 'Příjmení')
            ->setAttribute('placeholder', 'Vyplň příjmení')
            ->setRequired('Je třeba vyplnit jméno');
        $form->addText('firstname', 'Jméno')
            ->setAttribute('placeholder', 'Vyplń jméno')
            ->setRequired('Je třeba vyplnit jméno');
        $form->addCheckbox('is_admin', 'Administrátor?');
    }


    /**
     * Vytváří komponentu formuláře pro přidávání nového uživatele.
     * @param null|array $args další argumenty
     * @return Form formulář pro přidávání nového uživatele
     */
    public function createAddForm($args = null)
    {
        $form = new Form(NULL, 'addForm');
        $form->addProtection('Ochrana');
        $this->addCommonFields($form);
        $form->addSubmit('send', 'Přidej');
        $form->onSuccess[] = [$this, "newFormSucceeded"];
        return $form;
    }

    /**
     * Vytváří komponentu formuláře pro editaci uživatele.
     * @param null|array $args další argumenty
     * @return Form formulář pro editaci uživatele
     */
    public function createEditForm($args = null)
    {
        $form = new Form(NULL, 'editForm');
        $form->addProtection('Ochrana');
        $this->addCommonFields($form);
        $form->addSubmit('send', 'Aktualizuj');
        $form->addHidden('id');
        $form->onSuccess[] = [$this, "editFormSucceeded"];
        return $form;
    }

    /**
     * Vytváří komponentu formuláře pro smazání uživatele.
     * @param null|array $args další argumenty
     * @return Form formulář pro smazání uživatele
     */
    public function createDeleteForm($args = null)
    {
        $form = new Form(NULL, 'deleteForm');
        $form->addProtection('Ochrana');
        $form->addSubmit('send', 'Odeber');
        $form->addHidden('id');
        $form->onSuccess[] = [$this, "deleteFormSucceeded"];
        return $form;
    }

    /**
     * Zpracování validních dat z formuláře a následného přidání uživatele.
     * @param Form      $form   formulář
     * @param ArrayHash $values data
     */
    public function newFormSucceeded(Form $form, ArrayHash $values)
    {
        try {
            $this->userModel->insertUser($values);
        } catch (Exception $exception) {
            $form->addError($exception);
        }
    }

    /**
     * Zpracování validních dat z formuláře a následné aktualizace uživatele.
     * @param Form      $form   formulář
     * @param ArrayHash $values data
     */
    public function editFormSucceeded(Form $form, ArrayHash $values)
    {
        try {
            $id = $values['id'];
            unset($values['id']);
            $this->userModel->updateUser($id, $values);
        } catch (Exception $exception) {
            Debugger::log($e);
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
            $this->userModel->deleteUser($values['id']);
        } catch (Exception $exception) {
            $form->addError($exception);
        }
    }

}
