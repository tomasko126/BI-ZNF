<?php

namespace App\Model;

use Tracy\Debugger;


class OrderModel extends BaseModel
{
    /**
     * Metoda vrací seznam všech uživatelů
     */
    public function listOrders()
    {
        return $this->database->table('order');
    }

    /**
     * Metoda vrací nákup se zadaným id, pokud neexistuje vrací NoDataFound.
     * @param int  $id
     */
    public function getOrder($id)
    {
        $order = $this->listOrders()->where('id', $id);

        if ($order != null) {
            return $order->fetch();
        }

        return NoDataFound::class;
    }

    /**
     * Metoda vloží nový nákup
     * @param array  $values
     * @return $id vloženého nákupu
     */
    public function insertOrder($values)
    {
        if (strlen($values["name"]) === 0 || strlen($values["quantity"]) === 0 || strlen($values["price"]) === 0 ||
            strlen($values["user_id"]) === 0) {
            return InvalidArgument::class;
        }

        if (!preg_match('/[0-9]/', $values["user_id"]) || !preg_match('/[0-9]/', $values["quantity"]) ||
            !preg_match('/[0-9]/', $values["price"])) {
            return InvalidArgument::class;
        }

        if ($values["user_id"] < 1 || $values["quantity"] < 1 || $values["price"] < 1) {
            return InvalidArgument::class;
        }

        $order = $this->listOrders()->insert($values);

        return $order->getPrimary();
    }

    /**
     * Metoda edituje nákup, pokud neexistuje vrací NoDataFound.
     * @param int  $id
     * @param array  $values
     */
    public function updateOrder($id, $values)
    {
        $order = $this->getOrder($id);

        if ($order === null) {
            return NoDataFound::class;
        }

        $this->listOrders()->where('id', $id)->update($values);
    }

    /**
     * Metoda odebere nákup, pokud neexistuje vrací NoDataFound.
     * @param array  $values
     */
    public function deleteOrder($id)
    {
        $order = $this->listOrders()->where('id', $id);

        if ($order === null) {
            return InvalidArgument::class;
        }

        $order->delete();
    }
}