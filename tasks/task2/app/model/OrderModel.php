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
        /** TODO */

    }

    /**
     * Metoda vrací uživatele se zadaným id, pokud neexistuje vrací NoDataFound.
     * @param int  $id
     */
    public function getOrder($id)
    {
        /** TODO */

    }

    /**
     * Metoda vrací vloží nový nákup
     * @param array  $values
     * @return $id vloženého nákupu
     */
    public function insertOrder($values)
    {
        /** TODO */

    }

    /**
     * Metoda edituje nákup, pokud neexistuje vrací NoDataFound.
     * @param int  $id
     * @param array  $values
     */
    public function updateOrder($id, $values)
    {
        /** TODO */

    }

    /**
     * Metoda odebere nákup, pokud neexistuje vrací NoDataFound.
     * @param array  $values
     */
    public function deleteOrder($id)
    {
        /** TODO */

    }
}