<?php

require_once __DIR__ . "/../../data_base.php";
require_once __DIR__ . "/../users_module.php";


header("Content-Type:application/json; charset=utf-8");

$body = trim(file_get_contents("php://input"));
$request = json_decode($body, true);

$userID = $request['userID']; //Gets userID

//Receives user data by ID number
$allUsers = Data_Base::read();

foreach ($allUsers as $index => $user) {
    $userID == $user->id ? $getUserDetails = $user : [];
}

$json[] = ["id" => $getUserDetails->id,"name" => $getUserDetails->name, "email" => $getUserDetails->email, "user_agent" => $getUserDetails->user_agent,
"entrance_time" => $getUserDetails->entrance_time, "visits_count" => $getUserDetails->visits_count];

//Sends all user information to the client
echo json_encode($json);


?>