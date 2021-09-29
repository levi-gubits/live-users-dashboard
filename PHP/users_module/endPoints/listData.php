<?php

require_once __DIR__ . "/../../data_base.php";

header("Content-Type:application/json; charset=utf-8");

$json = [];
date_default_timezone_set("israel");
$d = strtotime("-4 Seconds");
$date = date("Y-m-d h:i:s",$d);

$allUsers = Data_Base::read();

//Prepares a list of all users
foreach($allUsers as $index => $user){

    $n=strtotime($user->last_update_time);
    $newDate = date("Y-m-d h:i:s",$n);

    if($date <= $newDate){
        $lastSeen = "now";
        $status = "onLine";
    } else {
        $lastSeen = $user->last_update_time;
        $status = "offLine";
    }

    $json[] = ["id" => $user->id,"name" => $user->name, "entrance_time" => $user->entrance_time,
    "lastSeen" => $lastSeen, "User_IP" => $user->IP,"status" => $status ]; 

}


//Sends a complete list to the client
echo json_encode($json);
?>