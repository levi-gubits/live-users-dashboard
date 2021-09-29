<?php
session_start();
require_once "users_module/users_module.php";
require_once "data_base.php";

class Pages{

    private $session;
    private $userName;

    function checkIfUserConnect(){
        //Checks if sessionKey is active
        if(isset($_SESSION['session'])){
            //sessionKey is active
            $this->session = $_SESSION['session'];
            $allUsers = Data_Base::read(); //get users list
            
            foreach ($allUsers as $index => $user) {
                if($this->session == $user->sessionKey) $getUserDetails = $user; //get all user details 
            }

            $this->userName = $getUserDetails->name; //get user name 
            return $this->getAllUsersDetails();
        } 

        //sessionKey is not active
        return $this->loginPage();
    }

    //login page component
    function loginPage(){
        ?>

        <!--login card component!-->
        <div class="center" style=" transition: none">
                <div class="card card_content" style="opacity: 1;">
                    <div class="login">
                        <h1>Login page</h1>
                        <form>
                            <div class="txt_field">
                                <input type="text" name="name" id="name">
                                <span></span>
                                <label>name</label>
                            </div>
                            <div class="txt_field">
                                <input type="email" name="email" id="email">
                                <span></span>
                                <label>email</label>
                            </div>
                            <input class="btn" name="submit" type="button" value="Login"><br>
                            <div class="status"><span class="loginStatus"></span></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script>
            //get userip and userAgent information
            const userIP = `<?php
            $ip = "Unknown";
            if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
                $ip = $_SERVER['HTTP_CLIENT_IP'];
            } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            } elseif(!empty($_SERVER['REMOTE_ADDR'])) {
                $ip = $_SERVER['REMOTE_ADDR'];
            }
            echo $ip ?>`;
            const userAgent = `<?php echo $_SERVER['HTTP_USER_AGENT'] ?>`;
            const button = document.querySelector('.btn');        
            button.addEventListener('click', ()=>{
                login(userAgent,userIP)
            });
        </script>
        
        <?php
    }

    //main page component
    function getAllUsersDetails(){
        ?>
        <p class="welcome">Welcome <?php echo $this->userName?>!</p>

        <!--user list component!-->
        <div class="box">
            <h2>User list</h2>
            <ul></ul>
        </div>
        <button class="logout">logout</button>

        <!--user details component!-->
        <div class="container">
            <div class="card" style="padding: 20px;">
            <span class="close_card" title="Close Modal">&times;</span>
                <div class="card_content">
                <h2>User Details</h2>
                <div class="details" style="padding: 20px;">
                    <p><strong>Name:</strong> </p>
                    <p><strong>Email:</strong> </p>
                    <p><strong>User agent:</strong> </p>
                    <p><strong>Entrance time:</strong> </p>
                    <p><strong>Visits count:</strong> </p>
                </div>
                </div>
            </div>
        </div>
        
        <script src="js/userList.js"></script>
        <script>
            const sessionKey = `<?php echo $this->session ?>`           
            const logoutbtn = document.querySelector('.logout'); 
            
            //Calls the logout function
            logoutbtn.addEventListener('click', ()=>{
                logout(sessionKey)
            });

            let loading = false;
            updateTime(sessionKey);

            //Checks which users are logged in and displays the result to the user
            //Repeat the operation every three seconds
            setInterval( () => {
                //If the function returned an answer the function will run again
                if(!loading) {
                    loading = true;
                    updateTime(sessionKey)
                }
            }, 3000);

            
        </script>
    <?php
    }
}


?>