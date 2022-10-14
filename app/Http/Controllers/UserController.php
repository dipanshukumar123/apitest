<?php

namespace App\Http\Controllers;

use App\Mail\ForgetPassword;
use App\Models\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Testing\Fluent\Concerns\Has;
use function Ramsey\Uuid\v1;

class UserController extends Controller
{
     public function profile(Request $request)
     {
        $details = $request->user();
         return response()->json(['profile'=>$details]);
     }

     public function register()
     {
         return view('register');
     }

     public function saveregister(Request $request)
     {
         $name = $request->get('name');
         $email = $request->get('email');
         $pass = Hash::make($request->get('password'));
         $api = sha1(time());

         $register = new User();
         $register->name = $name;
         $register->email = $email;
         $register->password = $pass;
         $register->api_token = $api;
         $register->save();
         return response()->json(['register'=>$register,'api'=>$api,'status'=>'success','msg' => "Register Successfully"]);
     }

     public function login()
     {
         return view('login');
     }

     public function savelogin(Request $request)
     {
         $this->validate($request,[
             'email' => 'required',
             'password' => 'required'
         ]);
         $credentials = $request->only('email', 'password');

         if (Auth::attempt($credentials)) {
             $user = User::where(["email" => $credentials['email']])->first();
             Auth::login($user);
             return response()->json(['status' => 'success','data'=>$user,'api_token'=>$user['api_token'],'msg' => "Login Successfully"]);
         }
         else{
             return response()->json(['status' => 'error','msg' => "Login failed Please valid email & password"]);
         }
     }

     public function updatepassword(Request $request,$id)
     {
         $msg = [
             'new_password' => 'New Password is required',
             'conf_password' => 'Confirm Password is required',
         ];
         $validator = Validator::make($request->all(),[
             'new_password' => 'required',
             'conf_password' => 'required'
         ],$msg);
         $old_password = User::where('id',Auth::user()->id)->value('password');
         $password = $request->get('new_password');
         $conf_password = $request->get('conf_password');
         if ($validator->passes())
         {
             if (!Hash::check($password,$old_password))
             {
                 if ($password == $conf_password)
                 {
                     $update = User::where('id',$id)->first();
                     $update->password = Hash::make($password);
                     if ($update->save())
                     {
                         return response()->json(['status' => 'success','msg' => "Password has been Updated"],200);
                     }
                     else{
                         return response()->json(['status' => 'error','msg' => "Password has been Updated failed"]);
                     }
                 }
                 else{
                     return response()->json(['status' => 'error','msg' => "Password mis match!!"]);
                 }
             }
             else{
                 return response()->json(['status' => 'error','msg' => "Old Password and New Password should be different"]);
             }
         }
         else{
             return response()->json(['error' => $validator->errors()->getMessageBag()->toArray()],401);
         }

     }

     public function forget_password(Request $request)
     {
         $msg = [
             'email' => 'Email is required',
         ];
         $validator = Validator::make($request->all(),[
             'email' => 'required',
         ],$msg);
         $email = $request->get('email');

         if ($validator->passes())
         {
             $forget = User::where('email',$email)->first();
             Mail::send('resetpass', ['id' =>$forget['id']], function($message) use($request){
                 $message->to($request->get('email'));
                 $message->subject('Reset Password');
             });
             return response()->json(['status' => "success",'msg'=>"message sent successfully"]);
         }
         else{
             return response()->json([$validator->errors()->getMessageBag()->toArray()],401);
         }

     }

//     public function show_reset_password($id)
//     {
//         return view('');
//     }

     public function reset_password(Request $request,$id)
     {
         $msg = [
             'password' => 'Password is required',
         ];
         $validator = Validator::make($request->all(),[
             'password' => 'required',
         ],$msg);

         $pass = Hash::make($request->get('password'));

         if ($validator->passes())
         {
             User::where('id', $id)
                 ->update(['password' => $pass]);
             return response()->json(['success',"Password Changed Successfully"]);
         }else
         {
             return response()->json(['error',$validator->errors()->getMessageBag()->toArray()]);
         }

     }

     public function math()
     {
         return view('math');
     }
}
