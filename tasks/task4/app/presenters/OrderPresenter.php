<?php

namespace App\Presenters;

use App\Forms\GDPROrderFormFactory;
use App\Forms\OrderFormFactory;
use App\Model\OrderModel;
use App\Model\UserModel;
use Nette\Application\UI\Form;
use App\Model\NoDataFound;
use Nette\Utils\ArrayHash;
use Tracy\Debugger;



class OrderPresenter extends BasePresenter
{
    /** @var OrderFormFactory - Formulářová továrnička pro správu nákupů */
    private $formFactory;

    /** @var OrderModel - model pro management nákupů */
    private $orderModel;

    /** @var UserModel - model pro management uživatelů*/
    private $userModel;

    /** @var GDPROrderFormFactory - model pro gdpr funkcionalitu*/
    private $gdprOrderFormFactory;

    public function injectDependencies(OrderFormFactory $formFactory, OrderModel $orderModel, UserModel $userModel, GDPROrderFormFactory $gdprOrderFormFactory) {
        parent::__construct();
        $this->formFactory = $formFactory;
        $this->orderModel = $orderModel;
        $this->userModel = $userModel;
        $this->gdprOrderFormFactory = $gdprOrderFormFactory;
    }

    /**
     * Akce pro vkádání
     */
    public function actionAdd($gdpr = false) {
        $form = $this['addForm'];
        try {
            $users = $this->userModel->listUsers();
            $u = [];
            foreach ($users as $user) {
                if (!$gdpr) {
                    $u[$user['id']] = $user['surname'] . " " . $user['firstname'];
                } else {
                    $u[$user['id']] = $this->anonymize($user['firstname'], $user['surname']);
                }
            }
            $form['user_id']->setItems($u);
        } catch (NoDataFound $e) {
            $form->addError('Nelze načíst data');
        }
    }

    public function actionGdpr($method, $id = null) {
        $form = $this['accessForm'];
    }

    public function actionQuestions($method, $id = null) {
        $form = $this['questionsForm'];
    }

    /**
     * Akce pro editaci
     * @param int $id id uživatele
     */
    public function actionEdit($id, $gdpr = false) {
        $form = $this['editForm'];
        try {
            $users = $this->userModel->listUsers();
            $u = [];
            foreach ($users as $user) {
                if (!$gdpr) {
                    $u[$user['id']] = $user['surname'] . " " . $user['firstname'];
                } else {
                    $u[$user['id']] = $this->anonymize($user['firstname'], $user['surname']);
                }
            }
            $form['user_id']->setItems($u);
            $order = $this->orderModel->getOrder($id);
            $form->setDefaults($order);
        } catch (NoDataFound $e) {
            $form->addError('Nelze načíst data');
        }
    }

    /**
     * Akce pro mazání
     * @param int $id id uživatele
     */
    public function actionDelete($id, $gdpr = false) {
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
            $this->redirect('Order:default');
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
            $this->redirect('Order:default');
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
            $this->redirect('Order:default');
        };
        return $form;
    }

    public function createComponentAccessForm() {
        $form = $this->gdprOrderFormFactory->createAccessForm();
        $form->onSuccess[] = function (Form $form) {
            if ($form->isSubmitted()->getValue() === "Ano") {
                $this->redirect('Order:questions', $this->getHttpRequest()->getQuery('method'), $this->getHttpRequest()->getQuery('id'));
            } else {
                $this->redirect('Order:default');
            }
        };

        return $form;
    }

    public function createComponentQuestionsForm() {
        $form = $this->gdprOrderFormFactory->createQuestionsForm();
        $form->onSuccess[] = function (Form $form) {
            if ($this->getHttpRequest()->getQuery('method') === 'add') {
                $this->redirect('Order:' . $this->getHttpRequest()->getQuery('method'),true);
            } else {
                $this->redirect('Order:' . $this->getHttpRequest()->getQuery('method'), $this->getHttpRequest()->getQuery('id'), true);
            }
        };
        $form->onError[] = function (Form $form) {
            $this->redirect('Order:default');
        };
        return $form;
    }

    /**
     * Metoda pro naplnění dat pro šablonu dané akce
     */
    public function renderEdit($id) {
        $order = $this->orderModel->getOrder($id);
        $this->template->name = $order['name'];
    }

    /**
     * Metoda pro naplnění dat pro šablonu dané akce
     */
    public function renderDelete($id) {
        $order = $this->orderModel->getOrder($id);
        $this->template->name = $order['name'];
    }

    /**
     * Metoda pro naplnění dat pro šablonu dané akce
     */
    public function renderDefault() {
       $this->template->orders = $this->orderModel->listOrders();
    }

    public function anonymize($firstname, $lastname) {
        return preg_replace('/[^ ]/', '*', $firstname) . "*" . preg_replace('/[^ ]/', '*', $lastname);
    }
}
