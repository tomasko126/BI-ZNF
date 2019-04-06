<?php

namespace App\Model;

use Tracy\Debugger;


class OrderModel extends BaseModel
{
    /**
     * Metoda vrací seznam všech nákupů
     */
    public function listOrders()
    {
        return  $this->database->table('order')->order('name ASC')->fetchAll();
    }

    /**
     * Metoda vrací n8kup se zadaným id, pokud neexistuje vrací NoDataFound.
     * @param int  $id
     */
    public function getOrder($id)
    {
        $res = $this->database->table('order')->where(['id' => $id])->fetch();
        if (!$res) throw new NoDataFound();
        return $res;
    }

    /**
     * Metoda vrací vloží nový nákup
     * @param array  $values
     * @return $id vloženého nákupu
     */
    public function insertOrder($values)
    {
        $row = $this->database->table('order')->insert($values);
        return $row->id;
    }

    /**
     * Metoda edituje nákup, pokud neexistuje vrací NoDataFound.
     * @param int  $id
     * @param array  $values
     */
    public function updateOrder($id, $values)
    {
        $this->getOrder($id);
        $row = $this->database->table('order')
            ->where(['id' => $id])
            ->update($values);
    }

    /**
     * Metoda odebere nákup, pokud neexistuje vrací NoDataFound.
     * @param array  $values
     */
    public function deleteOrder($id)
    {
        $this->getOrder($id);
        $row = $this->database->table('order')
            ->where(['id' => $id])
            ->delete();
    }
}