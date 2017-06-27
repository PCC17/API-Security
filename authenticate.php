<?php
/**
 * Created by PhpStorm.
 * User: paulc
 * Date: 09.06.2017
 * Time: 18:15
 */
require ("dbaccess.php");

$userIdentifier = $_POST["user_identifier"];
$token = $_POST["token"];

if(verifyToken($userIdentifier, $token))
{
    echo json_encode(array("success"=>1));
}
else
{
    echo json_encode(array("success"=>0));
}


