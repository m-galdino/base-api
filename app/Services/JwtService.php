<?php

namespace App\Services;

use Firebase\JWT\JWT;

class JwtService
{
    /**
     * Create a new token.
     *
     * @param int $idUser, 
     * @param int $expirationTime,
     * @param bool $resertPassword = false
     * @return string
     */
    public function createToken(int $idUser, int $expirationTime, bool $resertPassword = false)
    {
        $payload = [
            'iss' => "apiAuth-jwt", // Issuer of the token
            'sub' => $idUser, // Subject of the token
            'iat' => time(), // Time when JWT was issued.
            'exp' => time() + $expirationTime, // Expiration time
        ];

        $token = env('TOKEN_AUTH');

        if ($resertPassword) {
            $payload['reset_password'] = true;
            $token = env('TOKEN_RESET_PASSWORD');
        }

        // As you can see we are passing `JWT_SECRET` as the second parameter that will
        // be used to decode the token in the future.
        return JWT::encode($payload, $token);
    }

    /**
     * Method to get payload of token.
     *
     * @param string $token,
     * @return object
     */
    public function getPayload(string $token)
    {
        $tks = explode('.', $token);
            
        if (count($tks) != 3) {
            throw new \UnexpectedValueException('Wrong number of segments');
        }
        
        list($headb64, $payloadb64, $cryptob64) = $tks;
        if (null === ($header = JWT::jsonDecode(JWT::urlsafeB64Decode($headb64)))) {
            throw new \UnexpectedValueException('Invalid segment encoding');
        }
        
        if (null === $payload = JWT::jsonDecode(JWT::urlsafeB64Decode($payloadb64))) {
            throw new \UnexpectedValueException('Invalid segment encoding');
        }

        return $payload;
    }
}