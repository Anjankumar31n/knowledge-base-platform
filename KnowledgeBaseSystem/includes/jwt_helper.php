<?php
require_once __DIR__ . '/../vendor/autoload.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$SECRET_KEY = "9f3d6c34f6b1e82660c58a9e347ff88a2fdca3e54e637c03b1f3bdf9f5e01f3e";
$ALGORITHM = 'HS256';

function generate_jwt($user_id) {
    global $SECRET_KEY, $ALGORITHM;
    $payload = [
        "iss" => "http://localhost",
        "iat" => time(),
        "exp" => time() + 3600,
        "user_id" => $user_id
    ];
    return JWT::encode($payload, $SECRET_KEY, $ALGORITHM);
}

function verify_jwt($token) {
    global $SECRET_KEY, $ALGORITHM;
    try {
        $decoded = JWT::decode($token, new Key($SECRET_KEY, $ALGORITHM));
        return $decoded->user_id;
    } catch (Exception $e) {
        return false;
    }
}
?>