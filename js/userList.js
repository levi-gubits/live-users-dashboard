//Gets a list of all users in the system and shows who is connected and who is not
async function updateList(){
    const url = 'PHP/users_module/endPoints/listData.php';
    const ul = document.querySelector('ul');
    let li = '';
    let liTag;   

    const data = await postData(url)

    //Receives data from the server
    data.forEach(js => {
        //Checker with the received user is logged in or not
        if(js.status == "onLine") {
            liTag = '<li style="background: rgb(132, 255, 120); :hover {background-color: rgb(105, 223, 94);}">'
        }
        else{ 
            liTag = '<li>'
        }
        //Prepares user information for the user list component
        li += `${liTag}<span>${js.id}</span>name: ${js.name}<div style="margin-left: 30px;">userIP: ${js.User_IP}</div>
        <div>entrance time: ${js.entrance_time}</div><div>last update time: ${js.lastSeen}</div>
        <div>status: ${js.status}</div></li>`
    });
    //Uploads user information to the user list component
    ul.innerHTML = li;
    ulList();
    
}

//Updating current li list
function ulList(){
    const list = document.querySelectorAll('li');

    //Clicking on each li will give a specific userID number
    list.forEach(li => {
        li.addEventListener('click', ()=> {
            container.classList.add('show');
            const userID = li.children[0].textContent
            getUserDetails(userID) //Sends userID number to getUserDetails function
        })  
    });
}

//Gets on user information by userID number
async function getUserDetails(userID){
    const url = 'PHP/users_module/endPoints/getUserDetails.php';
    const details = document.querySelector('.details');

    const data = {
        userID: userID,
    };

    const sendData = await postData(url, data);

    sendData.forEach(js => {
        //Uploads user information to the user details component
        details.innerHTML = 
        `<p><strong>Name:</strong> ${js.name}</p><hr>
        <p><strong>Email:</strong> ${js.email}</p><hr>
        <p><strong>User agent:</strong> ${js.user_agent}</p><hr>
        <p><strong>Entrance time:</strong> ${js.entrance_time}</p><hr>
        <p><strong>Visits count:</strong> ${js.visits_count}</p><hr>`
    });
    
}

//Updates the system that the user is currently logged in to
async function updateTime(sessionKey){
    const url = 'PHP/users_module/endPoints/updateTime.php';

    const data = {
        sessionKey: sessionKey,
    }

    const sendData = await postData(url, data);

    if(sendData.userDetails == 'success'){
        updateList();
        loading = false;
    } 
}

const container = document.querySelector('.container');
const closeCard = document.querySelector('.close_card');
closeCard.addEventListener('click',()=>{
    container.classList.remove('show');
})

