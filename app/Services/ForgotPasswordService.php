<?php

namespace App\Services;

use Illuminate\Support\Facades\Mail;
use App\Services\JwtService;
use App\Services\UserService;

class ForgotPasswordService
{
    /**
     * Method to send email with link to reset password.
     * @param string $login
     * @return void
     */
    public function sendLinkResetPassword(string $login)
    {
        $userService = new UserService();
        $user = $userService->getUserLogin($login);

        if (empty($user)) {
            throw new \Exception("User don't found.", 401);
        };

        $jwtService = new JwtService();
        $token = $jwtService->createToken($user->id, 600, true); //600 seconds = 10 minutes
        
        $params = array (
            'url'=> 'https://url-configured-to-reset/',
            'token' => $token,
            'email' => $user->email
        );
        
        Mail::send('emails.recoverpassword', $params, function ($mgs) use ($params) {
            $mgs->from(env('MAIL_FROM_ADDRESS'));
            $mgs->subject('Update password');
            $mgs->to($params['email']);
            $mgs->replyTo(env('MAIL_FROM_ADDRESS'));
        });
    }
}