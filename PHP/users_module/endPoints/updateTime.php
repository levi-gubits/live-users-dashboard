<?php

require_once __DIR__ . "/../../data_base.php";

header("Content-Type:application/json; charset=utf-8");
$body = trim(file_get_contents("php://input"));
$request = json_decode($body, true);

$session = $request['sessionKey'];
date_default_timezone_set("israel");
$date = date("Y-m-d h:i:s");

//Updated detail seen recently for now
$allUsers = Data_Base::read();

foreach ($allUsers as $index => $user) {
    $session == $user->sessionKey ? $user->last_update_time = $date : '';
}

Data_Base::write($allUsers);

//$updateUserDetails =  Database::update("UPDATE `users` SET `lastSeen` = NOW() WHERE `sessionKey` = '$session'");


//Sends a success message to the client
$status = json_encode(Array('userDetails' => 'success'));
echo $status;


?>