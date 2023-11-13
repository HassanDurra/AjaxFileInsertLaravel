$(document).ready(function(e){

    let formSubmit   = $("#submitForm");
    let csrfToken    = $('input[name="csrf_token"]');
    let userName     = $('input[name="name"]');
    let email        = $('input[name="email"]');
    let password     = $('input[name="password"]');
    $(formSubmit).submit(function(e){
        e.preventDefault();
        isValid = true ;
        if(userName.val() == ""){
            e.preventDefault();
            Swal.fire({
                title: 'Error!',
                text: 'Name is Required!',
                icon: 'error',
                confirmButtonText: 'Try Again' ,
                confirmButtonColor:"red"
              });
              isValid = false ;
              return false ;

        }
        if(email.val() == ""){
            e.preventDefault();
            Swal.fire({
                title: 'Error!',
                text: 'Email is Required!',
                icon: 'error',
                confirmButtonText: 'Try Again' ,
                confirmButtonColor:"red"
              });
              isValid = false ;
              return false ;
        }

        if(password.val() == ""){
            e.preventDefault();
            Swal.fire({
                title: 'Error!',
                text: 'Password is Required!',
                icon: 'error',
                confirmButtonText: 'Try Again' ,
                confirmButtonColor:"red"
              })
              isValid = false ;
              return false ;

        }

        if(password.val() != "" && password.val().length < 8) {
            e.preventDefault();
            Swal.fire({
                title: 'Error!',
                text: 'Password Must be Greater Then 8!',
                icon: 'error',
                confirmButtonText: 'Try Again' ,
                confirmButtonColor:"red"
              })
              isValid = false ;
              return false ;

        }
        if(isValid){
            e.preventDefault();
            $.ajax({
                url: checkEmail ,
                type : "Post" ,
                data: formSubmit.serialize(),
                headers: {
                    "X-CSRF-TOKEN": csrfToken.val()
                },
                success:function(response){
                    if(response == "NotAvailable"){
                        e.preventDefault();
                        Swal.fire({
                            title: 'Error!',
                            text: 'Email Already Exists!',
                            icon: 'error',
                            confirmButtonText: 'Try Again' ,
                            confirmButtonColor:"red"
                          })
                    }
                    else{
                        e.preventDefault();
                        const profileImage = $('input[name="profileImage"]');
                        const generatedFile = profileImage[0].files;

                        if (generatedFile.length > 0) {
                            const spliitedProfile = generatedFile[0];
                            console.log(spliitedProfile);
                            const fileExtension = spliitedProfile.name.split('.').pop();
                            const extensions    = ["jpeg" ,"Jpeg" , "JPG" , "jpg" , 'png'];
                            if(extensions.includes(fileExtension.toLowerCase())){
                                const formData = new FormData();
                            formData.append('userImage', spliitedProfile, `profileImage.${fileExtension}`);
                            formData.append("name" , userName.val());
                            formData.append("email" , email.val());
                            formData.append("password" , password.val())
                            $.ajax({
                                url: UserRegisterRoute,
                                type: "POST",
                                data: formData,
                                contentType: false,
                                processData: false,
                                headers: {
                                    "X-CSRF-TOKEN": csrfToken.val()
                                },
                                success: function(response) {
                                    if(response == "Success"){
                                        Swal.fire({
                                            title: 'Success!',
                                            text: 'User Has Been Registered!',
                                            icon: 'success',
                                            confirmButtonText: 'Cool' ,
                                            confirmButtonColor:"green"
                                          })
                                    }
                                    else
                                    {
                                        Swal.fire({
                                            title: 'Error!',
                                            text: 'An error  occured While Saving User Info!',
                                            icon: 'error',
                                            confirmButtonText: 'Try Again' ,
                                            confirmButtonColor:"red"
                                          })
                                    }
                                },
                                error: function(xhr, status, error) {

                                }
                            });
                            }
                            else{
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Un-supported File Supported Files Are Jpeg  , Jpg and Png!',
                                    icon: 'error',
                                    confirmButtonText: 'Try Again' ,
                                    confirmButtonColor:"red"
                                  })
                            }
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: 'No File Selected!',
                                icon: 'error',
                                confirmButtonText: 'Try Again' ,
                                confirmButtonColor:"red"
                              })
                        }
                    }
                }
            })
        }
    })
})
