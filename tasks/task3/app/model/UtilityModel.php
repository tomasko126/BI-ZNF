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
        } catch(\Exception $exc) {
            return -1;
        }

        if (empty($pid)) {
            return -1;
        }

        $rc = substr($pid->name,2,2);

        \Tracy\Logger::formatMessage($rc);
        return $rc < 50;
    }

    /**
     * Metoda detekuje datum narození
     * @param int  $id rodného čísla
     */
    public function getBirthDay($id) {
        if (!$id) {
            return -1;
        }

        $pid = $this->pidModel->getPid($id);

        if (!$pid) {
            return -1;
        }

        // birth number without last 4 numbers
        $birthDay = $pid->name;

        if (!$birthDay) {
            return -1;
        }

        $birthDay = substr($birthDay,0, 6);

        $day = intval($birthDay[4] . $birthDay[5]);
        $month = intval($birthDay[2] . $birthDay[3]);
        $year = 1900 + intval($birthDay[0] . $birthDay[1]);

        if ($month > 50) {
            $month = $month - 50;
        }

        $birthDay = $day . '.' . $month . '.' . $year;

        if ($month > 12 || $month < 1 || $day < 1 || $day > $this->getMaxDayInMonth($month, $year)) {
            return "!!";
        }

        return $birthDay;
    }

    public function getMaxDayInMonth($month, $year) {
        if ($month == 1 || $month == 3 || $month == 5 || $month == 7 || $month == 8 || $month == 10 || $month == 12) {
            return 31;
        } else if ($month == 4 || $month == 6 || $month == 9 || $month == 11) {
            return 30;
        } else if ($month == 2) {
            if ($this->isLeapYear($year)) {
                return 29;
            } else {
                return 28;
            }
        } else {
            return null;
        }
    }

    public function isLeapYear($year) {
        $leap = false;

        if ($year % 4 == 0) {
            $leap = true;
        }

        if ($year % 100 == 0) {
            $leap = false;
        }

        if ($year % 400 == 0) {
            $leap = true;
        }

        if ($year % 4000 == 0) {
            $leap = false;
        }

        return $leap;
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