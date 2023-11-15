@extends('pagecheck')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" integrity="sha512-b2QcS5SsA8tZodcDtGRELiGv5SaKSk1vDHDaQRda0htPYWZ6046lr3kJ5bAAQdpV2mmA/4v0wQF9MyU6/pDIAg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{asset("asset/js/custom/style.css")}}">
</head>
<style>
    *{
       margin: 0;
       padding: 0;

    }
    .error-container{
       background-color: rgba(0, 0, 0, 0.267);
       height: 100vh;
       z-index: 1000;
       width: 100%;
       position: fixed;
       display: none;
       animation : showFade 0.6s linear  ;
    }
    @keyframes showFade{
       from{
          opacity: 0;
       }
       to{
          opacity: 1;
       }
    }
    .error-content{
       background-color: white;
       padding: 30px;
       position: absolute;
       left: 50%;
       top: 50%;
       width: 320px;
       transform: translate(-50% , -50%);
       height: auto;
       border-radius: 5px;
       box-shadow: 0 0 10px black;
    }
    .h1{
       padding: 10px;
       margin-top: 30px;
       text-align: center;
       font-family: arial;
    }

    .error-content p{
       padding: 10px;
       margin-top: 10px;
       text-align: center;
       font-family: arial;
    }
 </style>
<body>
    <div class="error-container" id="error-container">
        <div class="error-content">
          <center><img width="85" height="85" src="https://img.icons8.com/external-filled-outline-icons-maxicons/85/external-ban-virus-and-medical-filled-outline-icons-maxicons.png" alt="external-ban-virus-and-medical-filled-outline-icons-maxicons"/></center>
           <h1 class="h1">Cannot Proceed to Page!</h1>
           <p>Cannot Open This Page Because Its Already Opened  In <span id="tabCount"> </span> to Continue</p>
        </div>
     </div>
    <div class="userRegisterContainer mt-3">

        <form action="" id="submitForm" enctype="multipart/form-data">
           <input type="hidden" name="csrf_token" value="{{ csrf_token() }}">
           <div class="form-group">
            <label for="">Profile Image</label>
            <input type="file" class="form-control" name="profileImage" >
          </div>
          <div class="form-group">
            <label for="">Name</label>
            <input type="text" class="form-control" name="name" placeholder="Enter your Name..">
          </div>
          <div class="form-group">
            <label for="">Email</label>
            <input type="email" class="form-control" name="email" placeholder="Enter your Email..">
          </div>
          <div class="form-group">
            <label for="">Password</label>
            <input type="password" class="form-control" name="password" placeholder="Enter your Password..">
          </div>

            <button class="btn mt-3 btn-success" type="submit">Submit</button>
            </form>
    </div>
</body>
</html>
<script src="{{asset("asset/js/jquery.js")}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.min.js" integrity="sha512-WW8/jxkELe2CAiE4LvQfwm1rajOS8PHasCCx+knHG0gBHt8EXxS6T6tJRTGuDQVnluuAvMxWF4j8SNFDKceLFg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="{{asset("asset/js/custom/register.js")}}"></script>
<script>
    let UserRegisterRoute = '{{route("user.store")}}';
    let checkEmail        = '{{route("user.check.email")}}';
</script>
