<?php
include("../utils.php");
$page = $_GET["page"];

if (!$page) {
    $page = 1;
}

$response = request(get_url("movie/upcoming", ["page=$page"]));
$trending_data = json_decode($response);


function generateBackPagination($current)
{
    if ($current > 1) {
        return '<a href="/movies/upcoming.php?page=' . ($current - 1) . '">Back</a>';
    }
}

function generateFrontPagination($current, $total)
{
    if ($current < $total) {
        return '<a href="/movies/upcoming.php?page=' . ($current + 1) . '">Next</a>';
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Matflix</title>
<link href="/index.css" rel="stylesheet">
<link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">

</head>

<body>
    <?php include("../navbar.php"); ?>
    <main class="">
        <h1 class="text-center mb-5">Upcoming</h1>

        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-5 container mx-auto" id="movies">
            <?php
            if ($trending_data) {
                foreach ($trending_data->results as $movie)
                    echo generateMovieCard($movie);
            }
            ?>
        </div>
        <div class="flex justify-center text-xl mt-2 mb-2">
            <?php echo generateBackPagination($page); ?> &MediumSpace; Page <?php echo $page; ?> of <?php echo $trending_data->total_pages ?> &MediumSpace; <?php echo generateFrontPagination($page, $trending_data->total_pages); ?>
        </div>
    </main>
    <?php include("../footer.php"); ?>

</body>

</html>