
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="{{asset("asset/js/custom/style.css")}}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js" integrity="sha512-2rNj2KJ+D8s1ceNasTIex6z4HWyOnEYLVC3FigGOmyQCZc2eBXKgOxQmo3oKLHyfcj53uz4QMsRCWNbLd32Q1g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="{{asset("asset/js/jquery-ui.css")}}">
<link rel="stylesheet" href="{{asset("asset/js/jquery-ui.min.css")}}">
</head>
<style>

 </style>
<body>

    <div class="table-container position-relative container mt-3">

        <div class="notification-button d-flex justify-content-between">
            <span>Welcome Back <b>{{Session::get('admin')['name']}}!</b> </span>
            <a href="{{route('logout')}}" class="btn btn-danger " style="width: max-content!important;" ><i class="fa fa-power-off fa-bounce"></i> </a>

            <div class="dropdown ">

                <button class="btn btn-success dropdown-toggle" style="width: max-content!important;" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-bell"></i> <small style="padding: 5px 10px ;background:red; border-radius:50%; font-size:10px ;position: relative; bottom:10px; right:10px" id="notificationCount"></small></button>
                <ul class="dropdown-menu p-3" aria-labelledby="dropdownMenuButton1" id="notificationContainer">


                </ul>
              </div>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Profile</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <input type="hidden" class="csrfToken" value="{{csrf_token()}}">
                <tbody id="userTableData">
                    @foreach ($data['allusers'] as $user )
                    <tr>
                        <td>{{$loop->iteration}}  <input type="hidden" class="order-id" name="id" value="{{$user->id}}"></td>
                        <td><center><img src="{{asset("Profiles/".$user->profileImage)}}" style="width:50px;height:40px;object-fit:cover" alt=""></center></td>
                        <td>{{$user->name}}</td>
                        <td>{{$user->email}}</td>
                        <td><a href="" class="btn btn-danger"><i class="fa fa-trash"></i></a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
<script src="{{asset("asset/js/jquery.js")}}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js" integrity="sha512-uKQ39gEGiyUJl4AI6L+ekBdGKpGw4xJ55+xyJG7YFlJokPNYegn9KwQ3P8A7aFQAUtUsAQHep+d/lrGqrbPIDQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="{{asset("asset/js/custom/notification.js")}}"></script>
<script src="{{asset("asset/js/jquery-ui.js")}}"></script>
<script src="{{asset("asset/js/jquery-ui.min.js")}}"></script>
<script src="{{asset("asset/js/custom/draganddrop.js")}}"></script>
<script>
let notificationUrl = "{{route('all.notifications')}}";
let changeIds       =  "{{route('change.ids')}}";
let baseUrl         =  "{{asset("")}}";
let checkSession    =  "{{route('check.session')}}";
let login           =  "{{route('Auth.login')}}";
$(document).ready(function(){
    var csrfToken = $('.csrfToken')
    $( function() {
    $( "#userTableData" ).sortable({

       update: function(event, ui) {
      var sortedIDs = $(this).find('.order-id').map(function() {
        return $(this).val().trim();
      }).get();
     $(this).find('.order-id').each(function(index){
        $(this).text(sortedIDs[index])
     });
     $.ajax({
        url : changeIds ,
        type:"post" ,
        data: {ids : sortedIDs} ,
        headers: {
                    "X-CSRF-TOKEN": csrfToken.val()
                },
        success:function(response){
            let table = "" ;
            $(response).each(function(index , value){
                table+= `
                <tr>
                        <td>${index + 1 }<input type="hidden" class="order-id" name="id" value="${value.id}"></td>
                        <td><center><img src="${baseUrl}Profiles/${value.profileImage}" style="width:50px;height:40px;object-fit:cover" alt=""></center></td>
                        <td>${value.name}</td>
                        <td>${value.email}</td>
                        <td><a href="" class="btn btn-danger"><i class="fa fa-trash"></i></a></td>
                    </tr>`;
            })
            $("#userTableData").html(table);
        }
     })
    }
    });
  } );
//   checking Session Data
  setInterval(() => {
    $.ajax({
        url : checkSession ,
        type: 'Get' ,
        success:function(response){
            if(response == false){
                window.location.href =  login ;
            }
        }
    })
  }, 2000);
})
</script>
