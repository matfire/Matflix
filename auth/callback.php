<?php
include("../utils.php");
$url = "https://api.themoviedb.org/3/authentication/session/new?api_key=2005b3a7fc676c3bd69383469a281eff";
$ch = curl_init($url);
# Setup request to send json via POST.
$payload = json_encode(array("request_token" => $_GET["request_token"]));
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
# Return response instead of printing.
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
# Send request.
$result = curl_exec($ch);
$data = json_decode($result);
curl_close($ch);
$_SESSION["id"] = $data->session_id;

$user_details = request(get_url("account", ["session_id=" . $data->session_id]));
$user_data = json_decode($user_details);
$_SESSION["account_id"] = $user_data->id;
$success = "Hey " . $user_data->username . " !";
header("Location: /?type=success&message=$success");



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Matflix</title>
</head>

<body>
    <main>
    </main>
</body>

</html>