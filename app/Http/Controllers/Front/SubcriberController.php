<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Middleware\Admin;
use App\Mail\Websitemail;
use Illuminate\Http\Request;
use App\Models\Subcriber;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Helper\Helpers;

class SubcriberController extends Controller
{
    public function index(Request $request)
    {
        Helpers::read_json();
        
        $validator = Validator::make($request->all(), [
            'email' => 'required|email'
        ],[
            'email.required' => ERROR_EMAIL_REQUIRED,
            'email.email' => ERROR_EMAIL_VALID,
        ]);
        if (!$validator->passes()) {
            return response()->json(['result' => false, 'error_message' => $validator->errors()->toArray()]);
        } else {
            
            $token = hash('sha256', time());
            $subcriber = new Subcriber();
            $subcriber->email= $request->email;
            $subcriber->token= $token;
            $subcriber->status= 'Pending';
            $subcriber->save();
            // Send email
            $subject = 'Subcriber Email Verify';
            $verfication_link = url('subcriber/verify/'.$token.'/'.$request->email);
            $message = 'Please click on the following link in order to verify as subcriber </br>';
            $message .= '<a href="'.$verfication_link.'">';
            $message .= $verfication_link;
            $message .= '</a>';

            Mail::to($request->email)->send(new Websitemail($subject, $message));

            return response()->json(['code' => 1, 'success_message' => SUCCESS_SUBCRIBER]);
        }
    }

    public function verify($token,$email)
    {
        Helpers::read_json();
        $subcriber_data =Subcriber::where('token',$token)->where('email',$email)->first();
        if($subcriber_data)
        {
            $subcriber_data->token = '';
            $subcriber_data->status = 'Active';
            $subcriber_data->update();
            return redirect()->back()->with('success',SUCCESS_SUBCRIBER_CONFIRM);
        }else 
        {
            return redirect()->route('home');
        }
    }
}
