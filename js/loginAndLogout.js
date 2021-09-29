//login function
async function login(userAgent,userIP){
    const url = 'PHP/users_module/endPoints/login.php';

    //User information reader
    const name = document.querySelector('#name').value;
    const email = document.querySelector('#email').value;
    const loginStatus = document.querySelector('.loginStatus');
    const status = document.querySelector('.status');

    //Sends data to server and waits for result
    const data = await postData(url, {
        "email": email,
        "name": name,
        "userAgent": userAgent,
        "userIP": userIP,
    })

    //Shows success / failure to the user
    status.style.display = "block";
    loginStatus.textContent = data.userStatus;
    if(data.userStatus === "error: username does not match email!"){
        status.style.borderColor = "red";
        status.style.background = "antiquewhite";
        status.style.color = "red";
    }
       
    setTimeout(() => {
        location.reload();
    }, 2000);

}

async function logout(sessionKey){
    const url = "PHP/users_module/endPoints/logout.php";
    const card = document.querySelector('.card_content');
    
    //Sends disconnection request from server
    const data = await postData(url)

    //Shows the user that he is disconnecting
    container.classList.add('show');
    card.innerHTML = `<h2>${data.status}</h2>`;

    //Finishes declaring the user as currently logged in
    clearInterval(updateTime(sessionKey))
    
    setTimeout(() => {
        location.reload();
    }, 2000);
}
