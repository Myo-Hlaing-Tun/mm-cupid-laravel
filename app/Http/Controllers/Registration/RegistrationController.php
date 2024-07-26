<?php

namespace App\Http\Controllers\Registration;

use App\Http\Controllers\Controller;
use App\Mail\RegistrationConfirmMail;
use App\Utility;
use Mail;

class RegistrationController extends Controller
{
    public function index(){
        try{
            $mailData = [
                'company_name' => "mm-cupid",
                'email' => "mmcupid@gmail.com",
            ];
            Mail::to('razor1991.myo@gmail.com')->send(new RegistrationConfirmMail($mailData));
            dd('Mail sent successfully');
        }
        catch(\Exception $e){
            Utility::saveErrorLog((string) "RegistrationController:index - \n",(string) $e->getMessage());
            abort(500);
        }
    }
}
