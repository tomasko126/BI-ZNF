<?php

namespace App\Model;

use Nette\Database\Table\ActiveRow;

class PidModel extends BaseModel {
    /**
     * Metoda vrací seznam všech rodných čísel
     */
    public function listPids() {
        return $this->database->table('pid')->order('name ASC')->fetchAll();
    }

    /**
     * Metoda vrací rodné číslo se zadaným id, pokud neexistuje vrací NoDataFound.
     * @param int $id
     * @return false|ActiveRow
     * @throws NoDataFound
     */
    public function getPid($id) {
        $res = $this->database->table('pid')->where(['id' => $id])->fetch();

        if (!$res) {
            throw new NoDataFound();
        }

        return $res;
    }

    /**
     * Metoda vrací vloží nové rodné číslo
     * @param array $values
     * @return mixed|ActiveRow $id vloženého rodného čísla
     */
    public function insertPid($values) {
        $row = $this->database->table('pid')->insert([
            'name' => $values['name']
        ]);

        return $row->id;
    }

    /**
     * Metoda edituje rodné číslo, pokud neexistuje vrací NoDataFound.
     * @param $id
     * @param array $values
     * @throws NoDataFound
     */
    public function updatePid($id, $values) {
        try {
            $pid = $this->getPid($id);
            $pid->update($values);
        } catch (NoDataFound $exception) {
            throw new NoDataFound();
        }
    }

    /**
     * Metoda odebere rodné číslo, pokud neexistuje vrací NoDataFound.
     * @param $id
     * @throws NoDataFound
     */
    public function deletePid($id) {
        try {
            $pid = $this->getPid($id);
            $pid->delete();
        } catch (NoDataFound $exception) {
            throw new NoDataFound();
        }
    }
}