<?php

require_once __DIR__ . "/../../constants.php";
require_once __DIR__ . "/../users_module.php";

header("Content-Type:application/json; charset=utf-8");

$body = trim(file_get_contents("php://input"));
$request = json_decode($body, true);

//Receives the information from the client
$name = $request['name'];
$email = $request['email'];
$userAgent = $request['userAgent'];
$userIP = $request['userIP'];

//Checks if there is a match in the database
$users = new Users;
$checkIfTheUserExists = $users->checkIfTheUserExists($name ,$email);


if($checkIfTheUserExists == _SUCCESS){
    //If there is a match you will connect
    session_start();
    $login = $users->login($userAgent,$userIP);

    $status = $login === _SUCCESS ? json_encode(Array('userStatus' => "You've logged in successfully!")) 
    : json_encode(Array('userStatus' => "There is a problem connecting"));

    echo $status;
} else if($checkIfTheUserExists == _NOT_FOUND){
    //If there is no match Create a new user (if the email does not already exist in the system)
    session_start();
    $createUser = $users->createUser($name ,$email,$userAgent, $userIP);

    $status = $createUser === _SUCCESS ? json_encode(Array('userStatus' => "You've created in successfully!")) 
    : json_encode(Array('userStatus' => "There is a problem connecting"));

    echo $status;
} else if($checkIfTheUserExists == _FAILED){
    //error message to user
    $status = json_encode(Array('userStatus' => "error: username does not match email!"));
    echo $status;
}

?>