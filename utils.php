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
    if (strncmp($path, "/http", 5) == 0) {
        return ltrim($path, '/');
    }
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


function generateReview($r)
{

    $profile_pic = $r->author_details->avatar_path ? getPoster($r->author_details->avatar_path, "h632") : "https://source.unsplash.com/VX0bsbyBxpM/1920x1080";
    $name = NULL;

    if ($r->author_details->username)
        $name = $r->author_details->username;
    else if ($r->author_details->name)
        $name = $r->author_details->name;
    else
        $name = "Anonymous";

    return <<< "EOT"
        <div class="flex flex-col mt-5 mb-5 rounded-md">
            <div class="w-full flex items-center mb-5">
                <div class="">
                    <img class="rounded-full w-24 h-24 transition transform hover:scale-105" src="$profile_pic" />
                </div>
                <div class="ml-4 flex flex-col">
                    <h5 class="text-xl">$name</h5>
                </div>
            </div>
            <div class="w-full">
                <div class="truncation">
                    $r->content
                </div>
                <div class="mt-5">
                    <a class="bg-blue-500 px-5 py-3 text-sm shadow-sm font-medium tracking-wider text-blue-100 rounded-full hover:shadow-lg hover:bg-blue-600" href="$r->url" target="_blank" rel="noopener noreferrer">Read More</a>
                </div>
            </div>
        </div>
    EOT;
}

function generateVideoOutput($e)
{
    return <<< "EOT"
        <iframe src="https://www.youtube-nocookie.com/embed/$e->key" title="$e->name" allowFullScreen height=300>
        </iframe>
    EOT;
}
