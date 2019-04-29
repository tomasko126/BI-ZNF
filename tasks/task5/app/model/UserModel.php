<?php

namespace App\Model;

use Tracy\Debugger;
use Nette\Utils\DateTime;


class UserModel extends BaseModel
{
    /**
     * Metoda vrací seznam všech uživatelů
     */
    public function listUsers()
    {
        return  $this->database->table('user')->order('surname ASC')->fetchAll();
    }

    /**
     * Metoda vrací uživatele se zadaným id, pokud neexistuje vrací NoDataFound.
     * @param int  $id
     */
    public function getUser($id)
    {
        $res = $this->database->table('user')->where(['id' => $id])->fetch();

        if (!$res) {
            throw new NoDataFound();
        }

        return $res;
    }

    /**
     * Metoda vrací vloží nového uživatele
     * @param array  $values
     * @return $id vloženého uživatele
     */
    public function insertUser($values)
    {
        $date = new DateTime();
        $row = $this->database->table('user')->insert([
              'firstname' => $values['firstname'],
              'surname' => $values['surname'],
              'phone' => $values['phone'],
              'registered' => $date,
              'is_admin' => $values['is_admin'],
              'personal_number' => $values['personal_number'],
              'pid_id' => $values['pid_id']
        ]);
        return $row->id;
    }

    /**
     * Metoda edituje uživatele, pokud neexistuje vrací NoDataFound.
     * @param array  $values
     */
    public function updateUser($id, $values)
    {
        $this->getUser($id);

        if($values['pid_id']==0)
            $values['pid_id'] = NULL;

        $row = $this->database->table('user')
            ->where(['id' => $id])
            ->update($values);
    }

    /**
     * Metoda odebere uživatele, pokud neexistuje vrací NoDataFound.
     * @param array  $values
     */
    public function deleteUser($id)
    {
        $this->getUser($id);

        $row = $this->database->table('user')
            ->where(['id' => $id])
            ->delete();
    }
}