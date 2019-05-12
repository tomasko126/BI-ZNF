<?php

namespace App\Presenters;

use App\Model\StatisticModel;

class StatisticPresenter extends BasePresenter {

    /** @var StatisticModel - model pro statistiky */
    private $statisticModel;

    public function injectDependencies(StatisticModel $statisticModel) {
        parent::__construct();
        $this->statisticModel = $statisticModel;
    }

    /**
     * Metoda pro naplnění dat pro šablonu dané akce
     */
    public function renderDefault() {
       $this->template->statistics = $this->statisticModel->listStatistic();
    }
}
