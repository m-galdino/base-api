<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\JwtService;
use App\Services\UserService;

class AuthenticateController extends Controller
{
    
    public function authenticate(Request $request)
    {
        $this->validate($request, [
            'login' => 'required',
            'password' => 'required'
        ]);

        try {            
            $userService = new UserService();
            $user = $userService->validLogin($request->login, $request->password);

            $jwtService = new JwtService();
            $token = $jwtService->createToken($user->id, 2000); //2000 seconds = 33 minutes
            
            return response()->json([
                'token' => $token
            ]);
            
        } catch (\Exception $e) {
            return response()->json($this->getMessageError($e), 500);
        }
        
    }

    
}
