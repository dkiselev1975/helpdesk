$(()=>
    {
    let usersData=$('#usersData');
    console.log( "apiGetUsersData data loading...");
    usersData.load('apiGetUsersData',function(response,status,xhr)
        {
        let text=['<strong>Ошибка загрузки данных:</strong>',xhr.status,xhr.statusText];
        if(status==='success')
            {
            console.log('Loaded successfully');
            }
        else
            {
            console.log(status);$(this).html(text.join(' ')+'.');
            }
        });
    });
