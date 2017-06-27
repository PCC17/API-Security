<?php
/**
 * Created by PhpStorm.
 * User: paulc
 * Date: 09.06.2017
 * Time: 17:17
 */

 $db = new PDO('mysql:host=localhost;dbname=apisecurity', "root", "root");

 function getId($user){
     global $db;
     $sql = "SELECT id FROM users WHERE email='" . $user . "'";
     $stmt = $db->prepare($sql);
     $stmt->execute();
     $result = $stmt->fetch(PDO::FETCH_ASSOC);
     return $result["id"];
 }

function checkUserData($user, $p){
    global $db;
    $sql = "SELECT password FROM users WHERE email='" . $user . "'";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if(strtolower($result["password"])==strtolower(hash('sha256', $p)))
        return true;
    return false;
}

function storeToken($user, $userIdentifier, $token, $expireDays)
{
    global $db;
    $id = getId($user);

    $array = array("success" => 0, "user_identifier" => $userIdentifier, "token" => "null");


    $sql = "DELETE FROM `tokens` WHERE `user_id`=".$id;
    $stmt = $db->prepare($sql);
    $stmt->execute();

    $sql = "INSERT INTO `tokens` (`user_id`, `user_identifier`, `token`, `creation_date`, `expire_date`) VALUES (" . $id . ", '" . $userIdentifier . "', '" . $token . "', CURRENT_TIMESTAMP, DATE_ADD(NOW(), INterval " . $expireDays . " day))";
    $stmt = $db->prepare($sql);
    $res = $stmt->execute();

    if ($res == true) {
        $array["success"] = 1;
        $array["token"]=$token;
    }
    return $array;
}

function verifyToken($userIdentifier, $token){
    global $db;
    $sql = "SELECT token FROM tokens WHERE user_identifier='" . $userIdentifier . "'";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if($result["token"]==$token)
        return true;
    return false;
}
