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

        <form id="loginForm">
          @csrf
          <center><h1 class="p-2 m-3">Login Page</h1></center>
          <div class="form-group" id="emailContainer" >
            <label for="">Email</label>
            <input type="email" class="form-control" name="email" placeholder="Enter your Email..">
            <input type="hidden" class="form-control" name="csrf_token" value="{{csrf_token()}}">
          </div>
          <div class="form-group" id="passwordContainer" >
            <label for="">Password</label>
            <input type="password" class="form-control" name="password" placeholder="Enter your Password..">
          </div>
          <div class="form-group" id="optCodeContainer" style="display: none;">
            <label for="">OTP Code</label>
            <input type="number" class="form-control" name="otp" placeholder="Enter your Otp Code..">
          </div>
            <button class="btn mt-3 btn-success" id="submitButton" type="submit">login</button>
            <p>New To website ? <a href="{{route('user.register')}}">Register Here</a></p>
            </form>
    </div>
</body>
</html>
<script src="{{asset("asset/js/jquery.js")}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.min.js" integrity="sha512-WW8/jxkELe2CAiE4LvQfwm1rajOS8PHasCCx+knHG0gBHt8EXxS6T6tJRTGuDQVnluuAvMxWF4j8SNFDKceLFg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="{{asset("asset/js/custom/register.js")}}"></script>
@if(Session::has('error'))
<script>
Swal.fire({
title: 'Error!',
text: '{{Session::get('error')}}',
icon: 'error',
confirmButtonText: 'Close it' ,
confirmButtonColor:"red"
})
</script>
@endif
<script>
    let generateOtp =  "{{route('otp.generate')}}" ;
    let loginRoute  =  "{{route('Auth.signing')}}";
    let dashboardUrl = "{{route('all.users')}}";
    $("#submitButton").on('click' , function(e){
       let  isValid = true ;
        if($('input[name="email"]').val() == ""){
            e.preventDefault();
            Swal.fire({
                    title: 'Error!',
                    text: 'Email is required!',
                    icon: 'error',
                    confirmButtonText: 'Close it' ,
                    confirmButtonColor:"error"
                    });
                    return false;
        }
        if($('input[name="password"]').val() == ""){
            e.preventDefault();

            Swal.fire({
                    title: 'Error!',
                    text: 'Password is required!',
                    icon: 'error',
                    confirmButtonText: 'Close it' ,
                    confirmButtonColor:"error"
                    });
                    return false;
          }

        if(isValid && $(this).text() == "login"){
        e.preventDefault();
        $(this).text("Sending Otp Please Wait...")
        $.ajax({
            url : generateOtp  ,
            type: 'get' ,
            data : {email : $('input[name="email"]').val()},

            success:function(response){
                if(response.message == 'Success'){
                    $('#optCodeContainer').fadeIn();
                    $('#emailContainer').fadeOut();
                    $('#passwordContainer').fadeOut();
                    $('#submitButton').text('Verify');
                    Swal.fire({
                    title: 'Success!',
                    text: 'Opt Code Has Been Sent Verify To Login',
                    icon: 'success',
                    confirmButtonText: 'Close it' ,
                    confirmButtonColor:"success"
                    });
                    // Sending An Email


                }
            }

        })
        }
        if(isValid == true && $(this).text() == "Verify"){
            e.preventDefault();
            $.ajax({
                        url : loginRoute ,
                        type : 'Post' ,
                        data : $("#loginForm").serialize(),
                        headers:{
                            "X-CSRF-TOKEN" : $('input[name="csrf_token"]').val()
                        },
                        success:function(response){
                            if(response == "success"){
                                window.location.href  = dashboardUrl ;
                             }
                            if(response == "invalid otp"){
                                Swal.fire({
                                title: 'Error!',
                                text: 'Invalid Otp code ',
                                icon: 'error',
                                confirmButtonText: 'Close it' ,
                                confirmButtonColor:"error"
                                });
                             }
                            if(response == "invalid Data"){
                                $("#loginForm")[0].reset();
                                $('#optCodeContainer').fadeOut();
                                $('#emailContainer').fadeIn();
                                $('#passwordContainer').fadeIn();
                                $('#submitButton').text('login');
                                Swal.fire({
                                title: 'Error!',
                                text: 'Provided Crediental Not exists in our data',
                                icon: 'error',
                                confirmButtonText: 'Close it' ,
                                confirmButtonColor:"error"
                                });
                            }
                        }
                    })
        }
    });


</script>

