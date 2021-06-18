<?php
session_start();

function get_url($endpoint, $query = [])
{

    return "https://api.themoviedb.org/3/" . $endpoint . "?api_key=2005b3a7fc676c3bd69383469a281eff" . (count($query) > 0 ? "&" . join("&", $query) : "");
}

function request($url)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    return $response;
}

function getPoster($path, $size = "w500")
{
    return "https://image.tmdb.org/t/p/" . $size . "/" . $path;
}

function generateMovieCard($m)
{
    $backdrop = "";

    if ($m->poster_path) {
        $backdrop = getPoster($m->poster_path, "w500");
    } else {
        $backdrop = "https://source.unsplash.com/J39X2xX_8CQ/1920x1080";
    }

    $card = <<< "EOT"
    <div class="bg-gray-100 m-auto w-full h-96 bg-cover shadow-xl rounded-lg transition transform hover:scale-105" style="background-image:url('$backdrop')" >
        <div class="flex flex-row items-end h-full w-full">
            <div class="flex flex-col w-full pb-3 pt-10 px-3 bg-gradient-to-t from-black text-gray-200">
                <h3 class="text-base font-bold leading-5 uppercase">$m->title</h3>

                <div class="flex flex-row justify-between">
                <div class="flex flex-row flex-end">
                </div>
                <div class="w-max">
                <a href="/movies/details.php?id=$m->id">
                    <svg class="w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                    </svg>
                  </a>
                </div>
              </div>
            </div>
        </div>
    </div>
    EOT;

    return $card;
}

function generateVideoOutput($e)
{
    return <<< "EOT"
        <iframe src="https://www.youtube-nocookie.com/embed/$e->key" title="$e->name" allowFullScreen height=300>
        </iframe>
    EOT;
}
