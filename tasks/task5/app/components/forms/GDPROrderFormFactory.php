<?php

namespace App\Forms;

use Nette\SmartObject;
use Nette\Application\UI\Form;
use Nette\Utils\ArrayHash;

class GDPROrderFormFactory {
    use SmartObject;

    public static $questions = [
        [
            'question' => 'Kdo bdí nad bezpečností všech dat?',
            'answers'  => [
                'Facebook',
                'Google',
                'EU',
            ],
            'correctAnswer' => 2
        ],
        [
            'question' => 'Kdo nařídil GDPR?',
            'answers'  => [
                'SÚZ',
                'EU',
                'NSA',
            ],
            'correctAnswer'  => 1,
        ],
        [
            'question' => 'O co jde v GDPR?',
            'answers'  => [
                'O ochraně osobních údajů',
                'O sjednocení letního a zimního času',
                'O zvýšení platů pro učitelů',
            ],
            'correctAnswer'  => 0,
        ],
    ];


    public function createAccessForm() {
        $form = new Form(null, 'accessForm');
        $form->getElementPrototype()->novalidate('novalidate');
        $form->addProtection('Ochrana');
        $form->addSubmit('yes', 'Ano');
        $form->addSubmit('no', 'Ne');

        return $form;
    }

    public function createQuestionsForm() {
        $form = new Form(null, 'questionsForm');
        $form->getElementPrototype()->novalidate('novalidate');
        $form->addProtection('Ochrana');

        $maxIndexToChoose = count(self::$questions) - 1;
        $chosenIndex = random_int(0, $maxIndexToChoose);

        $form->addHidden('index', $chosenIndex)
            ->addRule(Form::INTEGER)
            ->setRequired('Chybí index');

        $form->addRadioList('answer', self::$questions[$chosenIndex]['question'], self::$questions[$chosenIndex]['answers'])
            ->setRequired('Chybí otázky');

        $form->addSubmit('submit', 'Odešli');

        $form->onValidate[] = function (Form $form, ArrayHash $values) use ($chosenIndex, $maxIndexToChoose) {
            if ($chosenIndex < 0 || $chosenIndex > $maxIndexToChoose) {
                $form->addError('Neplatné zadání');
            }

            if ($values['answer'] != self::$questions[$values['index']]['correctAnswer']) {
                $form->addError('Nesprávná odpověď');
            }
        };

        return $form;
    }
}