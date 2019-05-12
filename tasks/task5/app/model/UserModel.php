<?php

namespace App\Model;

use Exception;
use Nette\Database\Table\ActiveRow;
use Nette\Utils\DateTime;


class UserModel extends BaseModel {
    /**
     * Metoda vrací seznam všech uživatelů
     */
    public function listUsers() {
        return  $this->database->table('user')->order('surname ASC')->fetchAll();
    }

    /**
     * Metoda vrací uživatele se zadaným id, pokud neexistuje vrací NoDataFound.
     * @param int $id
     * @return false|ActiveRow
     * @throws NoDataFound
     */
    public function getUser($id) {
        $res = $this->database->table('user')->where(['id' => $id])->fetch();

        if (!$res) {
            throw new NoDataFound();
        }

        return $res;
    }

    /**
     * Metoda vrací vloží nového uživatele
     * @param array $values
     * @return mixed|ActiveRow|null $id vloženého uživatele
     * @throws Exception
     */
    public function insertUser($values)
    {
        $date = new DateTime();

        try {
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
        } catch (Exception $exception) {
            return null;
        }
    }

    /**
     * Metoda edituje uživatele, pokud neexistuje vrací NoDataFound.
     * @param $id
     * @param array $values
     * @throws NoDataFound
     */
    public function updateUser($id, $values) {
        try {
            $user = $this->getUser($id);
            $user->update($values);
        } catch (NoDataFound $exception) {
            throw new NoDataFound();
        }
    }

    /**
     * Metoda odebere uživatele, pokud neexistuje vrací NoDataFound.
     * @param $id
     * @throws NoDataFound
     */
    public function deleteUser($id)
    {
        try {
            $user = $this->getUser($id);
            $user->delete();
        } catch (NoDataFound $exception) {
            throw new NoDataFound();
        }
    }
}