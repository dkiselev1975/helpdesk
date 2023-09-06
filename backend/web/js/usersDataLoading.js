$(()=>{
let usersData=$('#usersData');
console.log( "ready!",usersData.length);
usersData.load('/apiGetUsersData',(data)=>
    {
        usersData.html(data);
    });
}
);
