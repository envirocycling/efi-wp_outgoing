<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

use Firebase\JWT\JWT;

/**
 * Set Cookie 
 * @return void
 */
if(!function_exists('setToken')) {
    function setToken($token) {
        $exp = (3 * 24 * 60 * 60);
		$domain = getenv('COOKIE_DOMAIN');
		$path = getenv('COOKIE_PATH');
        $secure = getenv('COOKIE_SECURE');
		set_cookie('token', $token, $exp, $domain, $path, NULL, $secure, TRUE);
    }
}

/**
 * Get Specific Cookie
 * @return STRING | null
 */
if(!function_exists('getToken')) {
    function getToken($name) {
        $cookie = get_cookie($name);
        return ($cookie) ? $cookie : null;
    }
}

/**
 * Delete Specific Cookie
 * @return void
 */
if(!function_exists('removeToken')) {
    function removeToken($name) {
		$domain = getenv('COOKIE_DOMAIN');
		$path = getenv('COOKIE_PATH');
        delete_cookie($name, $domain, $path, null);
    }
}

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
                "sub" => $data['user_id'],
                "aud" => getenv('BASE_URL'),
                "iat" => (12 * 24 * 60 * 60),
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

/**
 * This will be the authentication middleware for all the private routes
 * @return void | Unauthorized
 */
if(!function_exists('checkAuth')) {
    function checkAuth() {
        $token = getToken('token');
        if(!verifyToken($token)) {
            return redirect('/api/auth/unauthorized'); 
        }
        return;        
    }

}

