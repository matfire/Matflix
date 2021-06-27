<?php
include("./utils.php");
$type = $_GET["type"];
$account_id = $_SESSION["account_id"];
$session_id = $_SESSION["id"];
if (!$type) {
    $message = "Could not determine watchlist type; try again";
    header("Location: /?type=error&message=$message");
}

$data = NULL;

if ($type == "movie") {
    $data = json_decode(request(get_url("account/" . $account_id . "/watchlist/movies", ["session_id=" . $session_id])));
}



?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Matflix</title>

    <link rel="stylesheet" href="/index.css">
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
</head>

<body>
    <?php include("./navbar.php") ?>
    <main>
        <h1 class="text-center mb-5"><?php echo "Your " . $type . " Watchlist"; ?></h1>
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-5 container mx-auto" id="movies">
            <?php
            if ($data) {
                foreach ($data->results as $movie)
                    echo generateMovieCard($movie);
            }
            ?>
        </div>
    </main>
    <?php include("./footer.php") ?>
</body>

</html>