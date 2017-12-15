<?php
/**
 * @file
 * @version 0.1
 * @copyright 2017 CN-Consult GmbH
 * @author Tim Schreindl <tim.schreindl@cn-consult.eu>
 */

session_start();

if (!isset($_SESSION["order"]))
{
    $_SESSION["order"] = array(array($_GET["pizzaid"], $_GET["amount"]));
}
else
{
    $_SESSION["order"][] = array($_GET["pizzaid"], $_GET["amount"]);
}