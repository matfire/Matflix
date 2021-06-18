<?php

include("./utils.php");
include("./alerts.php");
$alert = NULL;

if ($_GET["type"] && $_GET["message"])
    $alert = generateAlert($_GET["message"], $_GET["type"]);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Matflix</title>

    <link href="/index.css" rel="stylesheet">
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
</head>

<body>
    <?php include("./navbar.php") ?>
    <main>
        <?php
        if ($alert) {
            echo showAlert($alert);
        }
        ?>
        <div class="flex justify-center items-center h-full w-full flex-col">
            <h1>MATFLIX</h1>
            <h4>Built using PHP and TheMovieDB.org</h4>
        </div>
    </main>
    <?php include("./footer.php") ?>
</body>

</html>