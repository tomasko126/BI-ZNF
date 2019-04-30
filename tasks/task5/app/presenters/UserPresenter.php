<?php

namespace App\Presenters;

use App\Forms\UserFormFactory;
use App\Model\PidModel;
use App\Model\UserModel;
use App\Model\UtilityModel;
use Nette\Application\UI\Form;
use App\Model\NoDataFound;
use Tracy\Debugger;



class UserPresenter extends BasePresenter
{
    /** @var UserFormFactory - Formulářová továrnička pro správu uživatelů */
    private $formFactory;

    /** @var UserModel - model pro management uživatelů*/
    private $userModel;

    /** @var PidModel - model pro management rc*/
    private $pidModel;

    /** @var UtilityModel - model pro pomocné funkce uživatele*/
    private $utilityModel;

    public function injectDependencies(UserFormFactory $formFactory, UserModel $userModel, PidModel $pidModel, UtilityModel $utilityModel) {
        $this->formFactory = $formFactory;
        $this->userModel = $userModel;
        $this->pidModel = $pidModel;
        $this->utilityModel = $utilityModel;
    }


    /**
     * Akce pro vložení

     */
    public function actionAdd() {
        $form = $this['addForm'];
        try {
            $pids = $this->pidModel->listPids();
            $p = [0 => '==========='];
            foreach($pids as $pid)
                $p[$pid['id']] = $pid['name'];
            $form['pid_id']->setItems($p);

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
            $pids = $this->pidModel->listPids();
            $p = [0 => '==========='];
            foreach($pids as $pid)
                $p[$pid['id']] = $pid['name'];
            $form['pid_id']->setItems($p);
            $user = $this->userModel->getUser($id);
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
     * Metoda pro vytvoření formuláře pro editaci
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
     * Metoda pro vytvoření formuláře pro mazání
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
        $user = $this->userModel->getUser($id);
        $this->template->name = $user['surname'].' '.$user['firstname'];
    }

    /**
     * Metoda pro naplnění dat pro šablonu dané akce
     */
    public function renderDelete($id) {
        $user = $this->userModel->getUser($id);
        $this->template->name = $user['surname'].' '.$user['firstname'];
    }


    /**
     * Metoda pro naplnění dat pro šablonu dané akce
     */
    public function renderDefault() {
       $this->template->users = $this->userModel->listUsers();
    }

    protected function beforeRender() {
        parent::beforeRender();

        $this->template->addFilter('phone', function ($phoneNumber) {
            if (empty($phoneNumber)) {
                return "";
            }

            $phone = $this->utilityModel->getPhoneNumberInCZ($phoneNumber);

            return $phone;
        });

        $this->template->addFilter('birthday', function ($pidId) {
            $birthday = $this->utilityModel->getBirthDayForId($pidId);

            return $birthday;
        });

        $this->template->addFilter('sex', function ($pidId) {
            $sex = $this->utilityModel->isMan($pidId);

            if ($sex == -1) {
                return "NEDEF";
            } else if ($sex == 0) {
                return "ŽENA";
            } else if ($sex == 1) {
                return "MUŽ";
            } else {
                return "!!";
            }
        });
    }
}