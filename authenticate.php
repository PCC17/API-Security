<?php
/**
 * Created by PhpStorm.
 * User: paulc
 * Date: 09.06.2017
 * Time: 18:15
 */
require ("dbaccess.php");

$userid = $_GET["id"];
$token = $_GET["token"];

if(verifyToken($userid, $token))
{
}


