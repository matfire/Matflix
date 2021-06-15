<?php
$id = $_GET["id"];


$detail_url = "https://api.themoviedb.org/3/movie/" . $id . "?api_key=2005b3a7fc676c3bd69383469a281eff&language=en-US&append_to_response=videos,images,recommendations";

$response = file_get_contents($detail_url);

$data = json_decode($response);

include("./utils.php");
$backdrop = "";
if ($data->backdrop_path) {
    $backdrop = getPoster($data->backdrop_path, "w1280");
} else {
    $backdrop = "https://source.unsplash.com/J39X2xX_8CQ/1920x1080";
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/index.css">
    <link rel="stylesheet" href="/movieDetails.css">
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">


</head>

<body>
    <?php include("../navbar.php"); ?>
    <main>
        <div class="h-full container mx-auto grid grid-cols-1 md:grid-cols-3 justify-evenly">
            <div class="col-span-1 md:col-span-2">
                <?php echo "<img class=\"rounded-xl shadow-xl\" src=\"" . getPoster($data->poster_path) . "\" />"; ?>
            </div>
            <div class="flex flex-col">
                <h1 class="text-2xl mb-5"><?php echo $data->original_title ?></h1>
                <p><?php echo $data->overview ?></p>
                <br />
                <p>Released on <span class="font-bold"><?php echo $data->release_date ?></span></p>
                <p>For a budget of <span class="font-bold"><?php echo number_format($data->budget) ?>$</span></p>
                <br />
                <h5 class="text-lg">Genres</h5>
                <span>
                    <?php
                    foreach ($data->genres as $g) {
                        echo <<< EOT
                                <a href="/movie/genre/$g->id" class="inline-block rounded-full text-white 
                                bg-blue-400 hover:bg-blue-500 duration-300 
                                text-xs font-bold 
                                mr-1 md:mr-2 mb-2 px-2 md:px-4 py-1 
                                opacity-90 hover:opacity-100">
                                    $g->name
                                </a>
                                EOT;
                    }
                    ?>
                </span>
                <br />
                <?php
                function isTrailer($e)
                {
                    return $e->type == "Trailer";
                }
                function sortBySize($a, $b)
                {
                    return $a->size > $b->size;
                }
                if ($data->videos->results) {
                    $filter = array_filter($data->videos->results, "isTrailer");
                    $filtered = usort($filter, "sortBySize");

                    if (count($filter) > 0) {
                        $embed = generateVideoOutput(array_values($filter)[0]);
                        echo $embed;
                    }
                }
                ?>
            </div>
            <div class="col-span-1 md:col-span-3 mt-12">
                <h5 class="text-2xl text-center mb-5">Recommendations</h5>
                <div class="grid grid-cols-1 md:grid-cols-3 justify-evenly gap-5">
                    <?php
                    $recs = array_slice($data->recommendations->results, 0, 3);
                    foreach ($recs as $r) {
                        echo generateMovieCard($r);
                    }
                    ?>
                </div>
            </div>
        </div>
    </main>
    <?php include("../footer.php"); ?>
</body>

</html>