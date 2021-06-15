<?php
$search = $_POST["search"];

include("./utils.php");


$search_movies = "https://api.themoviedb.org/3/search/movie?api_key=2005b3a7fc676c3bd69383469a281eff&language=en-US&page=1&query=" . $search;

$response = file_get_contents($search_movies);
$search_data = json_decode($response);



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/index.css">
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">

</head>

<body>
    <?php include("../navbar.php"); ?>
    <main>
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-5 container mx-auto ">
            <?php
            if ($search_data) {
                foreach ($search_data->results as $movie)
                    echo generateMovieCard($movie);
            }
            ?>
        </div>
    </main>
    <?php include("../footer.php"); ?>
</body>

</html>