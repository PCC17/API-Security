<?php
/**
 * Created by PhpStorm.
 * User: paulc
 * Date: 09.06.2017
 * Time: 17:17
 */

 $db = new PDO('mysql:host=localhost;dbname=apisecurity', "root", "");

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

    if($result["password"]==hash('sha256', $p))
        return true;
    return false;
}

function storeToken($user, $token, $expireDays){
    global $db;
    $id = getId($user);
    $sql = "INSERT INTO `tokens` (`user_id`, `token`, `creation_date`, `expire_date`) VALUES (".$id.", '".$token."', CURRENT_TIMESTAMP, DATE_ADD(NOW(), INterval ".$expireDays." day))";
    $stmt = $db->prepare($sql);
    $res = $stmt->execute();

    if($res == true)
        return array("success"=>1, "userid"=>$id, "token"=>$token);
    else
        return array("success"=>0, "userid"=>$id, "token"=>"null");
}
?>