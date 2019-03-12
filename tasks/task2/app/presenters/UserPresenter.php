<?php

namespace App\Presenters;

use App\Model\UserModel;
use App\Forms\UserFormFactory;
use Nette\Application\UI\Form;
use App\Model\NoDataFound;
use Tracy\Debugger;



class UserPresenter extends BasePresenter
{
    /** @var UserFormFactory - Formulářová továrnička pro správu uživatelů */
    private $formFactory;

    /** @var UserModel - model pro management uživatelů*/
    private $userModel;


    /**
     * Setter pro formulářovou továrničku a model správy uživatelů.
     * @param UserFormFactory $formFactory automaticky injectovaná formulářová továrnička pro správu uživatelů
     * @param UserModel $userModel automatiky injetovaný model pro správu uživatelů
     */
    public function injectDependencies(
        UserFormFactory $formFactory,
        UserModel $userModel
    )
    {
        $this->formFactory = $formFactory;
        $this->userModel = $userModel;
    }


    /**
     * Akce pro vložení

     */
    public function actionAdd() {
        $form = $this['addForm'];
        try {


        } catch (NoDataFound $e) {
            $form->addError('Nelze načíst data');
        }
    }

    /**
     * Akce pro editaci
     * @param int $id id uživatele
     */
    public function actionEdit($id) {
        $form = $this['editForm'];
        try {

            /** TODO naplnění dat do editačního formuláře $user = */
            $form->setDefaults($user);
        } catch (NoDataFound $e) {
            $form->addError('Nelze načíst data');
        }
    }

    /**
     * Akce pro mazání
     * @param int $id id uživatele
     */
    public function actionDelete($id) {
        $form = $this['deleteForm'];
        $form['id']->setDefaultValue($id);
    }

    /**
     * Metoda pro vytvoření formuáře pro vložení
     * @return Form - formulář
     */
    public function createComponentAddForm()
    {
        $form = $this->formFactory->createAddForm();
        $form->onSuccess[] = function (Form $form) {
            $this->redirect('User:default');
        };
        return $form;
    }

    /**
     * Metoda pro vytvoření formuáře pro editaci
     * @return Form - formulář
     */
    public function createComponentEditForm()
    {
        $form = $this->formFactory->createEditForm();
        $form->onSuccess[] = function (Form $form) {
            $this->redirect('User:default');
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
            $this->redirect('User:default');
        };
        return $form;
    }

    /**
     * Metoda pro naplnění dat pro šablonu dané akce
     */
    public function renderEdit($id) {
        /** TODO - nastavení atributu šablony name $users = */
        $this->template->name = $user['surname'].' '.$user['firstname'];

    }

    /**
     * Metoda pro naplnění dat pro šablonu dané akce
     */
    public function renderDelete($id) {
        /** TODO - nastavení atributu šablony name  $user = */
        $this->template->name = $user['surname'].' '.$user['firstname'];
    }

    /**
     * Metoda pro naplnění dat pro šablonu dané akce
     */
    public function renderDefault() {
        /** TODO - nastavení atributu šablony users $users*/
        $this->template->users = $users;
    }
}