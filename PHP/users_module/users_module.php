<?php 
require_once __DIR__ . "/../data_base.php";
require_once __DIR__ . "/../constants.php";

class Users{
   
    public $userID;
    public $userName;
    public $session;
    private $count;

    public function checkIfTheUserExists($name, $email){
        // Checks in the database if there is a user with the same email and name (true/false)
        $allUsers = Data_Base::read();

        if(count($allUsers) == 0) return _NOT_FOUND;

        foreach ($allUsers as $index => $user) {

            if($email == $user->email){
                if($name == $user->name){
                    $this->updateDetails($user);
                    return _SUCCESS; //There is a user
                }
                return _FAILED; //There is an email but the username is not the same (error)
            }
            
        }

        return _NOT_FOUND; //The user does not exist in the database The system will create a new user    

    }

    //update user details
    public function updateDetails($user){ 
        $this->userID = $user->id;
        $this->session = $user->sessionKey;
        $this->count = $user->visits_count;
    }

    // create new user
    public function createUser($name ,$email,$userAgent, $userIP){

        $session = session_create_id();
        date_default_timezone_set("israel");
        $date = date("Y-m-d h:i:s");

        $array = array('id' => 1, 'name' => $name, 'email' => $email, 'user_agent' => $userAgent, 'entrance_time' => $date,
         'last_update_time' => $date, 'IP' => $userIP, 'visits_count' => 1, 'sessionKey' => $session);

        $allUsers = Data_Base::read();

        if(count($allUsers) > 0){
 
            foreach ($allUsers as $index => $user) $id = $user->id;
            $array['id'] = $id + 1;
 
        }
 
        array_push($allUsers, $array);

        $createUser = Data_Base::write($allUsers);

        if($createUser){
            $_SESSION['session'] = $session;
            return _SUCCESS; //user successfully created
        }
        return _FAILED; //Error creating user
    }

    //login
    public function login($userAgent,$userIP){

        $visitsCount = $this->count + 1;
        date_default_timezone_set("israel");
        $date = date("Y-m-d h:i:s"); 

        $array = array('id' => $this->userID, 'user_agent' => $userAgent, 'entrance_time' => $date,
        'last_update_time' => $date, 'visits_count' => $visitsCount, 'IP' => $userIP);

        $updateUserDetails = Data_Base::update($array);

        if($updateUserDetails){
            $_SESSION['session'] = $this->session;
            return _SUCCESS; // User logged in successfully
        }
        return _FAILED; //Login error
    }

    //logOut
    public function logOut(){
        //logout Request from user
        session_start();
        unset($_SESSION['session']);
        return _SUCCESS; // User logout successfully
    }

}

?>