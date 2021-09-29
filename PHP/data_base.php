<?php

class Data_Base{

    private static $DBfile = __DIR__ .'\data_base_file.txt';

    public static function read(){

        $text = file_get_contents(self::$DBfile);        
        $allUsers = $text ? json_decode($text) : [];

        return $allUsers;

    }


    public static function write($array){

        $text = file_put_contents(self::$DBfile, json_encode($array));

        return true;

    }


    public static function update($array){

        $allUsers = self::read();
        $userID = $array['id'];
        
        foreach ($allUsers as $index => $user) {

            if($userID == $user->id){
                $user->user_agent = $array['user_agent'];
                $user->entrance_time = $array['entrance_time'];
                $user->last_update_time = $array['last_update_time'];
                $user->visits_count = $array['visits_count'];
                $user->IP = $array['IP'];
            }

        }

        self::write($allUsers);
        return true;

    }

}

?>