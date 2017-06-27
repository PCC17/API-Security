<?php
/**
 * Created by PhpStorm.
 * User: paulc
 * Date: 09.06.2017
 * Time: 17:12
 */

require ("dbaccess.php");

$tokenLength = 64;
$expireDays = 7;

$user = $_POST["user"];
$password = $_POST["password"];

$res = checkUserData($user, $password);
if($res == 1) {
    echo json_encode(generateToken($user));
}
else
{
    echo json_encode(array("success" => 0));
}

function generateToken($user) {
    global $tokenLength, $expireDays;
    $token = hash('sha256',generateRandomString($tokenLength).$user);
    $userIdentifier = hash('sha256',generateRandomString($tokenLength).$user);
    return storeToken($user, $userIdentifier, $token, $expireDays);
}

function generateRandomString($length) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

?>