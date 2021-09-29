<?php
    include_once __DIR__ . "/../users_module.php";
    require_once __DIR__ . "/../../constants.php";

    $users = new Users;
    $logOut = $users->logOut();

    //Checks if the disengagement was successful
    //Sends information to the client
    $status = $logOut == _SUCCESS ? json_encode(Array('status' => "You are offline")) 
    : json_encode(Array('status' => "System error Try again"));

    echo $status;
?>