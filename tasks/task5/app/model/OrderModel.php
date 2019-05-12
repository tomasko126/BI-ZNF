<?php

namespace App\Model;

use Nette\Database\Table\ActiveRow;

class OrderModel extends BaseModel
{
    /**
     * Metoda vrací seznam všech nákupů
     */
    public function listOrders() {
        return $this->database->table('order')->order('name ASC')->fetchAll();
    }

    /**
     * Metoda vrací n8kup se zadaným id, pokud neexistuje vrací NoDataFound.
     * @param int $id
     * @return false|ActiveRow
     * @throws NoDataFound
     */
    public function getOrder($id) {
        $res = $this->database->table('order')->where(['id' => $id])->fetch();

        if (!$res) {
            throw new NoDataFound();
        }

        return $res;
    }

    /**
     * Metoda vrací vloží nový nákup
     * @param array $values
     * @return mixed|ActiveRow $id vloženého nákupu
     */
    public function insertOrder($values) {
        $row = $this->database->table('order')->insert($values);
        return $row->id;
    }

    /**
     * Metoda edituje nákup, pokud neexistuje vrací NoDataFound.
     * @param int $id
     * @param array $values
     * @throws NoDataFound
     */
    public function updateOrder($id, $values) {
        try {
            $order = $this->getOrder($id);
            $order->update($values);
        } catch (NoDataFound $exception) {
            throw new NoDataFound();
        }
    }

    /**
     * Metoda odebere nákup, pokud neexistuje vrací NoDataFound.
     * @param $id
     * @throws NoDataFound
     */
    public function deleteOrder($id) {
        try {
            $order = $this->getOrder($id);
            $order->delete();
        } catch (NoDataFound $exception) {
            throw new NoDataFound();
        }
    }
}