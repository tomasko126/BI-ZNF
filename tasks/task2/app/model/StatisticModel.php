<?php

namespace App\Model;

use Tracy\Debugger;


class StatisticModel extends BaseModel
{

    /**
     * Metoda vrací seznam všech statistik, záznam bude mít položky name, min, max, avg a sum.
     */
    public function listStatistic()
    {
        $users = $this->database->table("user")->fetchAll();

        $stats = [];

        foreach ($users as $user) {
            $name = $user->surname;
            $userOrders = $this->database->table('order')->where('user_id', $user->id)->fetchAll();

            $min = 0;
            $max = 0;
            $sum = 0;
            $noOfTotalOrders = 0;

            //$min = $userOrders->fetch()->price;
            //$max = $userOrders->fetch()->price;

            foreach ($userOrders as $order) {
                $sum += $order->price * $order->quantity;
                $noOfTotalOrders += 1;

                if ($min === 0) {
                    $min = $order->price * $order->quantity;
                }

                if ($max === 0) {
                    $max = $order->price * $order->quantity;
                }

                if ($order->price < $min) {
                    $min = $order->price * $order->quantity;
                }

                if ($order->price > $max) {
                    $max = $order->price * $order->quantity;
                }
            }

            //$min = $userOrders->min('price');
            //$max = $userOrders->max('price');
            //$sum = $userOrders->sum('price');
            if ($noOfTotalOrders === 0) {
                $avg = 0;
            } else {
                $avg = $sum/$noOfTotalOrders;
            }

            $stats[] = array(
                "name" => $name,
                "min" => $min,
                "max" => $max,
                "sum" => $sum,
                "avg" => $avg
            );
        }

        return $stats;
    }
  }