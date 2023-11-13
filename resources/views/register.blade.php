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
<body>
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
