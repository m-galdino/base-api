<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;

class UserController extends Controller
{
    
    public function create(Request $request) {

        $this->validate($request, [
            'email'      => 'required',
            'password'   => 'required',
            'username'   => 'required'
        ]);

        try {
            
            $userService = new UserService();
            $userService->create($request->all());
            
            return response()->json([
                "menssage" => "User created with success!"
            ]);

        } catch (\Exception $e) {
            return response()->json($this->getMessageError($e), 500);
        }

    }

    public function updatePassword(Request $request) {
        $this->validate($request, [
            'password'   => 'required',
            'idUser' => 'required',
        ]);

        try {
            
            $userService = new UserService();
            $userService->updatePassword($request->idUser, $request->password);
            
            return response()->json([
                "menssage" => "Password updated with success!"
            ]);

        } catch (\Exception $e) {
            return response()->json($this->getMessageError($e), 500);
        }
    }
}