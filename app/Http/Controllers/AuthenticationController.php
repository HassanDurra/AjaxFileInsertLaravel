<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Hash ;
class AuthenticationController extends Controller
{
    public $parentModel   = User::class ;
    public $parentView    = 'register';

    public function index(){
        return view($this->parentView);
    }

    public function store(Request $request){

        $userName           = $request->name;
        $email              = $request->email;
        $password           = $request->password;
        $hashedPassword     = Hash::make($password);
        if($request->hasFile("userImage")){
            $fileName  = $userName . "." . $request->file("userImage")->getClientOriginalExtension();
            $request->file("userImage")->move("Profiles" , $fileName);

            $saveUser = $this->parentModel::create([
                'profileImage' => $fileName ,
                'name'         => $userName ,
                'password'     => $hashedPassword ,
                'email'        => $email
            ]);
            if($saveUser == true){
                echo "Success";
            }
            else{
                echo "Error" ;
            }
         }



    }
    public function check_email(Request $request){
        $email          = $request->email ;
        $checkEmail     = $this->parentModel::where('email' , $email)->count();
        if($checkEmail > 0){
            echo "NotAvailable";
        }
        else
        {
            echo "Available";
        }
    }
}
