<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\Page;
use App\Models\Author;
use App\Models\Language;
use App\Mail\Websitemail;
use App\Helper\Helpers;



class LoginController extends Controller
{
    public function index()
    {
        Helpers::read_json();
        if(!session()->get('session_short_name')){
            $current_short_name = Language::where('is_default','Yes')->first()->short_name;
        }else 
        {
            $current_short_name = session()->get('session_short_name');
        }
        $current_language_id = Language::where('short_name',$current_short_name)->first()->id;
        $page_data = Page::where('language_id',$current_language_id)->first();
        return view('front.login',compact('page_data'));
    }

    public function login_submit(Request $request)
    {
        Helpers::read_json();
         $request->validate([
            'email'=> 'required|email',
            'password' => 'required'
         ]);

         $credential = [
            'email' => $request->email,
            'password' => $request->password
         ];

         if(Auth::guard('author')->attempt($credential))
         {
            return redirect()->route('author_home');
         }else {
            return redirect()->route('login')->with('error',ERROR_INFORMATION_NOT_CORRET);
         }
    }

    public function logout()
    {
        Auth::guard('author')->logout();
        return redirect()->route('login');
    }


    public function forget_password()
    {
        Helpers::read_json();
        return view('front.forget_password');
    }

    public function forget_password_submit(Request $request)
    {
        Helpers::read_json();
        $request->validate([
            'email' => 'required|email'
        ]);

        $author_data = Author::where('email',$request->email)->first();
        if(!$author_data)
        {
            return redirect()->back()->with('error',ERROR_EMAIL_NOT_FOUND);
        }

        $token = hash('sha256',time());
        
        $author_data->token = $token;
        $author_data->update();

        $reset_link =url('reset-password/' .$token . '/' .$request->email);
        $subject = 'Reset Password';
        $message = 'Please click on the following link: <br>';
        $message.= '<a href="'.$reset_link.'">Click here</a>';

        Mail::to($request->email)->send(new Websitemail($subject,$message));

        return redirect()->route('login')->with('success',SUCCESS_FORGET_PASSWORD);
    }

    public function reset_password($token,$email)
    {
        Helpers::read_json();
        $author_data = Author::where('token',$token)->where('email',$email)->first();
        if(!$author_data)
        {
            return redirect()->route('login');
        }

        return view('front.reset_password', compact('token','email'));
    }
    
    public function reset_password_submit(Request $request)
    {
        $request->validate([
            'password'=> 'required',
            'retype_password' => 'required|same:password'
         ],[
            'password.required' => ERROR_PASSWORD_REQUIRED,
            'retype_password.required' => ERROR_PASSWORD_RETYPE_REQUIRED,
            'retype_password.same' => ERROR_PASSWORD_RETYPE_SAME,
         ]);   
         
         $author_data = Author::where('token',$request->token)->where('email',$request->email)->first();
         
        // echo 'Success';
        $author_data->password = Hash::make($request->password);
        $author_data->token ='';
        $author_data->update();
        return redirect()->route('login')->with('success',SUCCESS_RESET_PASSWORD);
    }
}
