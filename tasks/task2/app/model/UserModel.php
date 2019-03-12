<?php

namespace App\Model;

use Tracy\Debugger;


class UserModel extends BaseModel
{


    /**
     * Metoda vrací seznam všech uživatelů
     */
    public function listUsers()
    {
        /** TODO */

    }

    /**
     * Metoda vrací uživatele se zadaným id, pokud neexistuje vrací NoDataFound.
     * @param int  $id
     */
    public function getUser($id)
    {
        /** TODO */

    }

    /**
     * Metoda vrací vloží nového uživatele
     * @param array  $values
     * @return $id vloženého uživatele
     */
    public function insertUser($values)
    {
        /** TODO */

    }

    /**
     * Metoda edituje uživatele, pokud neexistuje vrací NoDataFound.
     * @param array  $values
     */
    public function updateUser($id, $values)
    {
        /** TODO */

    }

    /**
     * Metoda odebere uživatele, pokud neexistuje vrací NoDataFound.
     * @param array  $values
     */
    public function deleteUser($id)
    {
        /** TODO */

    }
}