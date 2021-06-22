<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

use Firebase\JWT\JWT;

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