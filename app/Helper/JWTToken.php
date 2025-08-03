<?php

namespace App\Helper;

class JWTToken {
    public static function CreateToken(array $payload): string
    {
        $secretKey = env('JWT_SECRET');
        $payload=[
            'iss' => 'laravel-token',
            'iat' => time(), 
            'exp' => time() + 3600, 
            'userEmail' => $userEmail,
            'userID' => $userID,
        ]; 

        return JWT::encode($payload, $secretKey, 'HS256');
    }

    public static function verifyToken($token): string | object
    {
      try {
        if($token== null) {
            return 'User not authenticated';
            }
            else {
            $secretKey = env('JWT_SECRET');
            $decoded = JWT::decode($token, new Key($secretKey, 'HS256'));
            return $decoded;
            }
      } catch (Exception $e) {
            return 'User not authenticated';
      }
    }

    public static function CreateTokenForSetPassword($userEmail): string
    {
        $secretKey = env('JWT_SECRET');
        $payload = [
            'iss' => 'laravel-token',
            'iat' => time(),    
            'exp' => time() + 3600,
            'userEmail' => $userEmail,
            'userID' => '0',
        ];
        return JWT::encode($payload, $secretKey, 'HS256'); 

    }      
}