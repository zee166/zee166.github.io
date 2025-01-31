<?php
session_start();

$client_id = "102756817810-k9nr640vehnr3il0rt2sfl98v1ej773s.apps.googleusercontent.com";
$redirect_uri = "https://zee166.github.io/callback.php";

$auth_url = "https://accounts.google.com/o/oauth2/auth?" . http_build_query([
    "response_type" => "code",
    "client_id" => $client_id,
    "redirect_uri" => $redirect_uri,
    "scope" => "https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email",
    "access_type" => "offline",
]);

header("Location: " . $auth_url);
exit;
?>
