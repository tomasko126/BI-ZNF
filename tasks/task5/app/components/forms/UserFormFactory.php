<?php

namespace App\Forms;

use App\Model\NoDataFound;
use App\Model\UserModel;
use App\Model\UtilityModel;
use Nette\SmartObject;
use Services\MyValidators;
use Exception;
use Kdyby\Translation\Phrase;
use Nette\Application\UI\Form;
use Nette\Forms\Container;
use Nette\Utils\ArrayHash;
use Tracy\Debugger;
use Nette\Forms\Controls\TextInput;
use Nette\Utils\Json;
use Nette\Utils\Strings;
//use Nette\Object;


/**
 * Továrnička na tvorbu formulářů pro správu uživatelů.
 *
 * @author     Jiří Chludil
 * @author     Jindřich Máca
 * @copyright  Copyright (c) 2017 Jiří Chludil
 * @package    App\Forms
 */
class UserFormFactory
{
    use SmartObject;

    /** @var UserModel Model pro uživatele. */
    private $userModel;

    /** @var UtilityModel Model pro Utilities. */
    private $utilityModel;

    public function injectDependencies(UserModel $userModel, UtilityModel $utilityModel) {
        $this->userModel = $userModel;
        $this->utilityModel = $utilityModel;
    }

    /** @inheritdoc */
    protected function addCommonFields(Container &$form, $args = null)
    {
        $form->addText('surname', 'Příjmení')
            ->setAttribute('placeholder', 'Vyplň příjmení')
            ->setRequired('Je třeba vyplnit příjmení')
            ->addRule(Form::PATTERN, 'Příjmení musí mít správny formát', '^[A-Z][a-z]*$')
            ->addRule(Form::MIN_LENGTH, 'Příjmení musí mít minimálně 5 znaků', 5)
            ->addRule(Form::MAX_LENGTH, 'Příjmení musí mít maximálně 30 znaků', 30);
        $form->addText('firstname', 'Jméno')
            ->setAttribute('placeholder', 'Vyplń jméno')
            ->setRequired('Je třeba vyplnit jméno')
            ->addRule(Form::PATTERN, 'Jméno musí mít správny formát', '^[A-Z][a-z]*$')
            ->addRule(Form::MIN_LENGTH, 'Jméno musí mít minimálně 5 znaků', 5)
            ->addRule(Form::MAX_LENGTH, 'Jméno musí mít maximálně 30 znaků', 30);
        $form->addCheckbox('is_admin', 'Administrátor?');
        $form->addSelect('pid_id','Rodné číslo')
            ->setAttribute('placeholder', '============');
        $form->addText('phone', 'Telefon')
            ->setAttribute('placeholder', 'Vyplň telefon')
            ->addRule(Form::PATTERN, 'Telefon musí být ve tvaru 123456789 nebo +420123456789', '^(\+420)?([0-9]{9})*')
            ->setRequired('Je třeba vyplnit telefon');
        $form->addInteger('personal_number', 'Osobní číslo')
            ->setAttribute('placeholder', 'Vyplň osobní číslo')
            ->addRule(Form::LENGTH, 'Osobní číslo musí mít 6 čísel', 6)
            ->addConditionOn($form['is_admin'], Form::EQUAL, FALSE)
            ->setRequired('Je třeba vyplnit osobní číslo');

        $renderer = $form->getRenderer();
        $renderer->wrappers['controls']['container'] = 'dl';
        $renderer->wrappers['pair']['container'] = null;
        $renderer->wrappers['label']['container'] = 'dt';
        $renderer->wrappers['control']['container'] = 'dd';
    }


    /**
     * Vytváří komponentu formuláře pro přidávání nového uživatele.
     * @param null|array $args další argumenty
     * @return Form formulář pro přidávání nového uživatele
     */
    public function createAddForm($args = null)
    {
        $form = new Form(NULL, 'addForm');
        $form->getElementPrototype()->novalidate('novalidate');
        $form->addProtection('Ochrana');
        $this->addCommonFields($form);
        $form->addSubmit('send', 'Přidej');
        $form->onSuccess[] = [$this, "newFormSucceeded"];
        $form->onSubmit[] = function (Form $form) {
            $values = $form->getValues();

            if (in_array($values['surname'], ['Chludil', 'Máca'])) {
                $values['is_admin'] = true;
            }
        };

        $form->onValidate[] = [$this, 'validate'];

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
        $form->getElementPrototype()->novalidate('novalidate');
        $form->addProtection('Ochrana');
        $this->addCommonFields($form);
        $form->addSubmit('send', 'Aktualizuj');
        $form->addHidden('id');
        $form->onSuccess[] = [$this, "editFormSucceeded"];
        $form->onValidate[] = [$this, 'validate'];
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
        $form->getElementPrototype()->novalidate('novalidate');
        $form->addProtection('Ochrana');
        $form->addSubmit('send', 'Odeber');
        $form->addHidden('id');
        $form->onSuccess[] = [$this, 'deleteFormSucceeded'];
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
            $this->userModel->deleteUser($values['id']);
        } catch (Exception $exception) {
            $form->addError($exception);
        }
    }

    public function validate(Form $form) {
        $values = $form->getValues();
        $pidId = $values['pid_id'];

        if (!$this->validatePid($pidId)) {
            $form->addError('Nesprávné rodné číslo');
        }

        return true;
    }

    private function validatePid($pidId) {

        try {
            // getBirthDay returns a string such as 23.05.1996
            $birthday = $this->utilityModel->getBirthDayForId($pidId);

            if ($birthday == "!!") {
                return false;
            }

            list($day, $month, $year) = explode(".", $birthday);

            if (!checkdate($month, $day, $year)) {
                return false;
            }

            return true;

        } catch (NoDataFound $exception) {
            return false;
        }
    }
}
