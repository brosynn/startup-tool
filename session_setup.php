<?php 
// makes session IDs cookie-only
ini_set('session.use_only_cookies', 1);
ini_set('session.use_strict_mode', 1);

// sets up cookies
session_set_cookie_params([
    'lifetime'  => 0,
    'path' => '/',
    'domain' => '',
    'secure' => false,
    'httponly' => true,
    'samesite' => 'Lax'
]);

session_start();
?>