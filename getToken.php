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

$user = $_GET["user"];
$password = $_GET["password"];

$res = checkUserData($user, $password);

if($res == 1) {
    echo json_encode(generateToken($user, $expireDays, $tokenLength));
}

function generateToken($user, $expireDays, $tokenLength) {
    global $tokenLength;
    $token = hash('sha256',generateRandomToken($tokenLength).$user);
    return storeToken($user, $token, $expireDays);
}

function generateRandomToken($tokenLength) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $tokenLength; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

?>