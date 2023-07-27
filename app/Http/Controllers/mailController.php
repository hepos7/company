<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeEmail;

use Illuminate\Http\Request;

class mailController extends Controller
{
    public function sendMail($name,$reciver)
    {
        $mailData = [
            "name" => $name,
        ];
        Mail::to($reciver)->send(new WelcomeEmail($mailData));    
    }
}
