<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\Websitemail;
use Illuminate\Http\Request;
use App\Models\Subcriber;
use Illuminate\Support\Facades\Mail;

class AdminSubcriberController extends Controller
{
    public function show_all()
    {
        $subcribers = Subcriber::where('status','Active')->get();
        return view('admin.subcriber_all',compact('subcribers'));
    }
    
    public function send_email()
    {
        return view('admin.subcriber_send_email');
    }
    
    public function send_email_submit(Request $request)
    {
        $request->validate([
            'subject' => 'required',
            'message' => 'required'
        ]);
        
        $subject = $request->subject;
        $message = $request->message;

        $subscribers =Subcriber::where('status','Active')->get();
        foreach($subscribers as $row)
        {
            Mail::to($row->email)->send(new Websitemail($subject,$message));
        }
        return redirect()->back()->with('Success','Email is sent successfully');
    }
}
