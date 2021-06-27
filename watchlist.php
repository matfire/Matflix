<?php

include("./utils.php");
$session_id = $_SESSION["id"];
$account_id = $_SESSION["account_id"];
$media_type = $_GET["media_type"];
$media_id = $_GET["media_id"];
$watchlist = $_GET["watchlist"];


$url = "https://api.themoviedb.org/3/account/" . $account_id . "/watchlist?api_key=2005b3a7fc676c3bd69383469a281eff&session_id=" . $session_id;
$ch = curl_init($url);
# Setup request to send json via POST.
$payload = json_encode(array("media_type" => $media_type, "media_id" => $media_id, "watchlist" => $watchlist));
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
# Return response instead of printing.
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
# Send request.
$result = curl_exec($ch);
curl_close($ch);


$success = "Movie added to watchlist";
header("Location: /movies/details.php?id=" . $media_id . "&type=success&message=$success");
