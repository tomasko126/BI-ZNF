<?php

namespace App\Model;

use Tracy\Debugger;


class StatisticModel extends BaseModel
{

    /**
     * Metoda vrací seznam všech statistik, záznam bude mít položky name, min, max, avg a sum.
     */
    public function listStatistic()
    {
        $stats = $this->database->table('order')->select(
            'user.surname AS `name`, MIN(price) AS `min`, MAX(price) AS `max`, AVG(price) AS `avg`, SUM(price) AS `sum`')->group(
            'user_id')->fetchAll();
        return $stats;
    }
  }