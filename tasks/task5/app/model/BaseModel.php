<?php

namespace App\Model;

use Nette;

class NoDataFound extends \Exception {};

class BaseModel {
    use Nette\SmartObject;

    protected $database;

    /**
     * @brief Konstruktor vytvarejici base model.
     * @param Nette\Database\Context $database
     */
    public function __construct(Nette\Database\Context $database) {
        $this->database = $database;
    }
}