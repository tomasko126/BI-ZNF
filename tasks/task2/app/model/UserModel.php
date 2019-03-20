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
        return $this->database->table('user');
    }

    /**
     * Metoda vrací uživatele se zadaným id, pokud neexistuje vrací NoDataFound.
     * @param int  $id
     */
    public function getUser($id)
    {
        $user = $this->listUsers()->where('id', $id);

        if ($user != null) {
            return $user->fetch();
        }

        return NoDataFound::class;
    }

    /**
     * Metoda vrací vloží nového uživatele
     * @param array  $values
     * @return $id vloženého uživatele
     */
    public function insertUser($values)
    {

        if (strlen($values["firstname"]) === 0 ||
            strlen($values["surname"]) === 0 ||
            ($values["is_admin"] !== false && $values["is_admin"] !== true)) {
            return InvalidArgument::class;
        }

        if (preg_match('/[0-9]/', $values["firstname"]) || preg_match('/[0-9]/', $values["surname"])) {
            return InvalidArgument::class;
        }

        $user = $this->listUsers()->insert($values);

        return $user->getPrimary();
    }

    /**
     * Metoda edituje uživatele, pokud neexistuje vrací NoDataFound.
     * @param array  $values
     */
    public function updateUser($id, $values)
    {
        $user = $this->getUser($id);

        if ($user === null) {
            return NoDataFound::class;
        }

        $this->listUsers()->where('id', $id)->update($values);
    }

    /**
     * Metoda odebere uživatele, pokud neexistuje vrací NoDataFound.
     * @param array  $values
     */
    public function deleteUser($id)
    {
        $user = $this->listUsers()->where('id', $id);

        if ($user === null) {
            return InvalidArgument::class;
        }

        $user->delete();
    }
}