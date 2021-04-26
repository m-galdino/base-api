<?php

namespace App\Services;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use App\Models\User as User;

class UserService
{
    /**
     * Method to create a User
     *
     * @param  array  $params
     * @return int
     */
    public function create(array $params)
    {
        $this->validNewUser($params['email'], $params['username']);
        
        $params['password'] = Hash::make($params['password']);
        return User::create($params)->id;
    }

    /**
     * Method to update password of user
     *
     * @param int $idUser
     * @param string $password
     * @return int
     */
    public function updatePassword(int $idUser, string $password) {
        $user = User::find($idUser);

        if (empty($user)) {
            throw new \Exception("User not exist!", 401);
        }

        if (Hash::check($password, $user->password)) {
            throw new \Exception("The password cannot be identical.", 401);
        }
        
        $user->password = Hash::make($password);
        
        return $user->save();
    }

    /**
     * Method to validate login and password of user
     *
     * @param string $login
     * @param string $password
     * @return User
     */
    public function validLogin(string $login, string $password)
    {
        $user = $this->getUserLogin($login);

        if (empty($user)) {
            throw new \Exception("User don't found.", 401);
        };

        if (!Hash::check($password, $user->password)) {
            throw new \Exception("Password are incorrect.", 401);
        }

        return $user;
    }

    /**
     * Method to search user using login
     *
     * @param string $login
     * @return User
     */
    public function getUserLogin(string $login) {
        return User::where(DB::raw('lower(email)'), strtolower($login))
                    ->orWhere(DB::raw('lower(username)'), strtolower($login))
                    ->first();
    }

    /**
     * Method to valid email and username of new user
     *
     * @param string $login
     * @param string $username
     * @return bool
     */
    public function validNewUser(string $email, string $username) {
        $user = User::where(DB::raw('lower(email)'), strtolower($email))
                    ->orWhere(DB::raw('lower(username)'), strtolower($username))
                    ->first();
        
        if (!$user) {
            return true;
        }

        if ($user->email == $email) {
            throw new \Exception("E-mail exists.", 401);
        } else {
            throw new \Exception("Username exists.", 401);
        }
    }


}