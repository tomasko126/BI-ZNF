<?php

namespace App\Model;

use Nette;

class UtilityModel extends BaseModel
{
    /** @var PidModel - model pro management rc*/
    private $pidModel;

    public function injectDependencies(Nette\Database\Context $database, PidModel $pidModel) {
        parent::__construct($database);
        $this->pidModel = $pidModel;
    }

    /**
     * Metoda detekuje pohlaví -1 = nedefinováno, 0 - žena, 1 - muž
     * @param int  $id rodného čísla
     */
    public function isMan($id) {
        if (empty($id)) {
            return -1;
        }

        try {
            $pid = $this->pidModel->getPid($id);

            if (empty($pid)) {
                return -1;
            }

            $rc = substr($pid->name,2,2);

            return $rc < 50;
        } catch(NoDataFound $exc) {
            return -1;
        }
    }

    public function getBirthDayForId($id) {
        if (!$id) {
            return "!!";
        }

        try {
            $pid = $this->pidModel->getPid($id);

            if (!$pid) {
                return "!!";
            }

            // birth number without last 4 numbers
            $birthNumber = $pid->name;

            if (!$birthNumber) {
                return "!!";
            }

            $birthDay = $this->getBirthDay($birthNumber);

            return $birthDay;

        } catch (NoDataFound $exception) {
            return "!!";
        }
    }

    /**
     * Metoda detekuje datum narození
     * @param int  $id rodného čísla
     */
    public function getBirthDay($birthNumber) {
        if (!$birthNumber) {
            return "!!";
        }

        $birthDay = substr($birthNumber,0, 6);

        $day = intval($birthDay[4] . $birthDay[5]);
        $month = intval($birthDay[2] . $birthDay[3]);
        $year = intval($birthDay[0] . $birthDay[1]);

        if ($year < 54) {
            $year = 2000 + $year;
        } else {
            $year = 1900 + $year;
        }

        if ($month > 70) {
            $month = $month - 70;
        } else if ($month > 50) {
            $month = $month - 50;
        } else if ($month > 20) {
            $month = $month - 20;
        }

        $birthDay = $day . '.' . $month . '.' . $year;

        if (!checkdate($month, $day, $year)) {
            return "!!";
        }

        return $birthDay;
    }

    public function getPhoneNumberInCZ($phoneNumber) {
        if (strlen(strval(intval($phoneNumber))) != 9) {
            return "!!";
        }

        $prefix = "+420 ";

        $formattedPhoneNumber = $prefix;
        $formattedPhoneNumber .= $phoneNumber[0] . $phoneNumber[1] . $phoneNumber[2];
        $formattedPhoneNumber .= " ";
        $formattedPhoneNumber .= $phoneNumber[3] . $phoneNumber[4] . $phoneNumber[5];
        $formattedPhoneNumber .= " ";
        $formattedPhoneNumber .= $phoneNumber[6] . $phoneNumber[7] . $phoneNumber[8];

        return $formattedPhoneNumber;
    }
}