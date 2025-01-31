<?php
session_start();

$client_id = "102756817810-k9nr640vehnr3il0rt2sfl98v1ej773s.apps.googleusercontent.com";
$client_secret = "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";
$redirect_uri = "http://localhost/callback.php";

if (!isset($_GET['code'])) {
    die("Authorization code not received.");
}

// ขอ Access Token
$token_request = [
    "code" => $_GET['code'],
    "client_id" => $client_id,
    "client_secret" => $client_secret,
    "redirect_uri" => $redirect_uri,
    "grant_type" => "authorization_code",
];

$ch = curl_init("https://oauth2.googleapis.com/token");
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($token_request));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

$token_data = json_decode($response, true);

if (!isset($token_data['access_token'])) {
    die("Error getting access token.");
}

// ขอข้อมูลผู้ใช้จาก Google
$ch = curl_init("https://www.googleapis.com/oauth2/v2/userinfo");
curl_setopt($ch, CURLOPT_HTTPHEADER, ["Authorization: Bearer " . $token_data['access_token']]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$user_info = json_decode(curl_exec($ch), true);
curl_close($ch);

// เก็บข้อมูลผู้ใช้ใน Session
$_SESSION['user'] = $user_info;

// ส่งไปหน้า Dashboard
header("Location: dashboard.php");
exit;
?>