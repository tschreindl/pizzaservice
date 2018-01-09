<?php
/**
 * @file
 * @version 0.1
 * @copyright 2017 CN-Consult GmbH
 * @author Tim Schreindl <tim.schreindl@cn-consult.eu>
 */

session_start();

$pizzaID = $_GET["pizzaid"];
$amount = $_GET["amount"];

if (!isset($_SESSION["order"]))
{
    $_SESSION["order"] = array(array($pizzaID, $amount));
}
else
{
    foreach ($_SESSION["order"] as $i => $order)
    {
        if ($order[0] == $pizzaID)
        {
            $_SESSION["order"][$i] = array($pizzaID, $order[1] + $amount);
            return;
        }
    }
    $_SESSION["order"][] = array($pizzaID, $amount);
}