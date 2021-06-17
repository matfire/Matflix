<?php
$id = $_GET["id"];


$detail_url = "https://api.themoviedb.org/3/movie/" . $id . "?api_key=2005b3a7fc676c3bd69383469a281eff&language=en-US&append_to_response=videos,images,recommendations";

$response = file_get_contents($detail_url);

$data = json_decode($response);

$watch_response = file_get_contents("https://api.themoviedb.org/3/movie/" . $id . "/watch/providers?api_key=2005b3a7fc676c3bd69383469a281eff&language=en-US");

$providers = json_decode($watch_response);

include("./utils.php");
$backdrop = "";
if ($data->backdrop_path) {
    $backdrop = getPoster($data->backdrop_path, "w1280");
} else {
    $backdrop = "https://source.unsplash.com/J39X2xX_8CQ/1920x1080";
}


function generateProvider($p)
{
    $logo = getPoster($p->logo_path, "original");
    return <<< "EOT"
        <div class="inline-flex items-center h-16">
            <img src="$logo" class="h-full w-auto" />
        </div>
    EOT;
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
    <link rel="stylesheet" href="/movieDetails.css">
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

</head>

<body>
    <?php include("../navbar.php"); ?>
    <main>
        <div class="h-full container mx-auto grid grid-cols-1 md:grid-cols-3 justify-evenly">
            <div class="col-span-1 md:col-span-2 sm:flex sm:justify-center" id="posterWrapper">
                <?php echo "<img class=\"rounded-2xl shadow-xl transition transform hover:scale-105\" src=\"" . getPoster($data->poster_path) . "\" />"; ?>
            </div>
            <div class="flex flex-col" id="movieDetails">
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
                                <a href="/movies/genre/$g->id" class="inline-block rounded-full text-white 
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
                if ($providers->results->US) {
                    if ($providers->results->US->flatrate) {
                        echo "<h5 class=\"text-lg\">Watch Here (courtesy of JustWatch)</h5>";
                        echo "<div>";
                        foreach ($providers->results->US->flatrate as $pro) {
                            echo generateProvider($pro);
                        }
                        echo "</div>";
                    }
                }
                ?>

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
            <?php
            if ($data->recommendations->results) {
                echo '<div class="col-span-1 md:col-span-3 mt-12">';
                echo '<h5 class="text-2xl text-center mb-5">Recommendations</h5>';
                echo '<div class="grid grid-cols-1 md:grid-cols-3 justify-evenly gap-5" id="movieRecommendations">';
                $recs = array_slice($data->recommendations->results, 0, 3);
                foreach ($recs as $r) {
                    echo generateMovieCard($r);
                }
                echo '</div>';
                echo '</div>';
            }
            ?>
        </div>
    </main>
    <?php include("../footer.php"); ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.7.0/gsap.min.js"></script>
    <script>
        gsap.from("#posterWrapper", {
            duration: 1,
            x: -100,
            opacity: 0
        })
        gsap.from(document.getElementById("movieDetails").children, {
            opacity: 0,
            stagger: 0.1,
            delay: 0.5
        })
        gsap.from(document.getElementById("movieRecommendations").children, {
            opacity: 0,
            y: -100,
            ease: "sine",
            stagger: 0.1,
            delay: 2
        })
    </script>
</body>

</html>