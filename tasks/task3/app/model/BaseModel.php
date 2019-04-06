<?php

namespace App\Model;

use Nette;

class NoDataFound extends \Exception {};

class BaseModel {
    use Nette\SmartObject;

    protected $database;
/**
* @brief Konstruktor vytvarejici base model.
*/
    public function __construct(Nette\Database\Context $database) {
        $this->database = $database;
    }
}