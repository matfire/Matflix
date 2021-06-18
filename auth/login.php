<?php
include("../utils.php");
$token_response = request(get_url("authentication/token/new"));
$token = json_decode($token_response)->request_token;
$callback_url = "http://$_SERVER[HTTP_HOST]/auth/callback.php";

header("Location: https://www.themoviedb.org/authenticate/$token?redirect_to=$callback_url");
