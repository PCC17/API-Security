<?php
/**
 * Created by PhpStorm.
 * User: paulc
 * Date: 09.06.2017
 * Time: 18:15
 */
require ("dbaccess.php");

$userid = $_POST["id"];
$token = $_POST["token"];

if(verifyToken($userid, $token))
{
    json_encode(array("success"=>1));
}
else
{
    json_encode(array("success"=>0));
}


