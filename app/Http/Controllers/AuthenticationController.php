<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\LoginUsers;
use App\Models\Notifications;
use Hash ;
use Mail;
class AuthenticationController extends Controller
{
    public $parentModel   = User::class ;
    public $parentView    = 'register';
    public $notification  = Notifications::class;
    public $loggedUser    = LoginUsers::class;
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
                'email'        => $email ,
                'sortIds'      => 0 ,
            ]);


            if($saveUser == true){
                $saveNotification = $this->notification::create([
                    'subject' => "New User Registered",
                    'message' => "$userName Has registered as a user in our portal at $saveUser->created_at"
                ]);
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
    public function allUsers(){
        $data['allusers'] = $this->parentModel::orderby("sortIds" ,"asc")->get();
        return view("allusers")->with('data',$data);
    }
    public function notifications(){
        $notifications = $this->notification::all();
        return response()->json($notifications);
    }
    public function changeIds(Request $request){
        $Ids = $request->ids ;
       foreach($Ids as $key => $value){
           $updated =  $this->parentModel::where("id" , $value)->update(["sortIds" => $key + 1]);
       }
       $userData = $this->parentModel::orderby("sortIds" , "asc")->get();
       return response()->json($userData);
    }
    // Login Section
    public function login(){
        return view('login');
    }

    public function authenticate(Request $request){
        $email      = $request->email;
        $password   = $request->password;

        if(session()->get('otp')['otp'] == $request->otp){
            $checkUser   = $this->parentModel::where('email'  , $email)->first();
            if($checkUser != null && Hash::check($password , $checkUser->password)){
                $this->logout($email) ;
                $addLoginUser = $this->loggedUser::create([
                    "email" => $email ,
                    "sessionId" => session()->getId(),
                ]);
                session()->put("admin" , $checkUser);
                return response()->json('success');
            }
            else
            {
                $this->logout($email) ;
                $addLoginUser = $this->loggedUser::create([
                    "email" => $email ,
                    "sessionId" => session()->getId(),
                ]);
                return response()->json('invalid Data');
            }
        }
        else
        {
            return response()->json('invalid otp');
        }
    }


    public function generate_otp(Request $request){

        $data = [
            'email' => $request->email,
            'otp' => rand(000000,999999)
        ];
        session()->put('otp' , $data);

        $sendMail    = Mail::send('verificationTemplate' , ['data' => $data] ,  function($message) use($data){
            $message->to($data['email']) ;
            $message->subject("Verification OTP Code");
            $message->from(env("MAIL_FROM_ADDRESS"));
        });
       if($sendMail == true){
        return response()->json(['otp'=> $data['otp'], 'message' => "Success" , 'sessioId' =>   session()->getId()]);
       }
    }


    public function logout($email = null){
        if($email == null){
            $deleteLogginUser  = $this->loggedUser::where('email' , session()->get('admin')['email'])->delete();

        }
        else{
            $deleteLogginUser  = $this->loggedUser::where('email' , $email)->delete();
        }
      
        session()->forget('admin');
        return redirect(Route("Auth.login"));
    }

}
