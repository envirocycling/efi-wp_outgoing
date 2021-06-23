<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

use Firebase\JWT\JWT;

/**
 * Generate JWT Token
 * 
 * @return STRING
 */
if (!function_exists('generateToken')) {
    function generateToken($data) {

        try {
            $key = getenv('JWT_KEY');

            $payload = array(
                "iss" => getenv('BASE_URL'),
                "aud" => getenv('BASE_URL'),
                "iat" => null,
                "nbf" => null,
                "data" => $data
            );

            $jwt = JWT::encode($payload, $key);

            return $jwt;

        } catch (Exception $e) {
            return null;
        }

    }
}

/**
 * Verify JWT Token
 * 
 * @return BOOLEAN
 */
if(!function_exists('verifyToken')) {

    function verifyToken($token) {
        try {

            $decoded = JWT::decode($token, getenv('JWT_KEY'), array('HS256'));

            return TRUE;
           
        } catch (Exception $e) {

            return FALSE;
            
        }
    }

}

if(!function_exists('check_auth')) {

    function check_auth() {

        
        $token = get_cookie('token');

        die(var_dump($token));


        if(!verifyToken($token)) {
        return redirect('/api/auth/unauthorized'); 
        }

        return;        
    }

}