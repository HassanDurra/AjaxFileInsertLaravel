$(document).ready(function(){

    setInterval(() => {
        let notificationContainer = $("#notificationContainer");
        $.ajax({
            url : notificationUrl,
            type:'get' ,
            success:function(response){
            let dropDowndata = "" ;
            $(response).each(function(index , value){
                dropDowndata +=`  <li><a class="dropdown-item mb-3 notificationBar" href="#"><span><b>${value.subject}</b></span><br>${value.message}</a></li>`;
            });
            $("#notificationCount").html(response.length)
            $(notificationContainer).html(dropDowndata);
            }
        });

    }, 3000);
});
