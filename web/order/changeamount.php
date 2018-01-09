<?php
/**
 * @file
 * @version 0.1
 * @copyright 2017 CN-Consult GmbH
 * @author Tim Schreindl <tim.schreindl@cn-consult.eu>
 */

session_start();

$pizzaID = $_GET["pizzaId"];
$amount = $_GET["amount"];

foreach ($_SESSION["order"] as $i => $order)
{
    if ($order[0] == $pizzaID)
    {
        if ($amount == 0)
        {
            unset($_SESSION["order"][$i]);
        }
        else
        {
            $_SESSION["order"][$i] = array($pizzaID, $amount);
        }
        return;
    }
}
