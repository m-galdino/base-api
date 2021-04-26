<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ForgotPasswordService;

class ForgotPasswordController extends Controller
{
    
    public function resetPassword(Request $request) {

        $this->validate($request, [
            'login' => 'required',
        ]);

        try {
            
            $forgotPasswordService = new ForgotPasswordService();
            $forgotPasswordService->sendLinkResetPassword($request->login);
            
            return response()->json([
                "menssage" => "E-mail of password update, send with success"
            ]);

        } catch (\Exception $e) {
            return response()->json($this->getMessageError($e), 500);
        }

    }
}
