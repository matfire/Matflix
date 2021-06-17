<header class="flex items-center justify-between mb-10 shadow-lg dark-secondary">
    <div class="ml-5">
        <a href="/">MatFlix</a>
    </div>
    <div class="flex items-center">
        <nav class="mr-10   ">
            <a class="mr-2" href="/movies/trending.php">Trending</a>
            <a href="/movies/upcoming.php">Upcoming</a>
        </nav>
        <div class="w-56 my-2">
            <form action="/movies/search.php" method="POST">
                <div class="relative text-gray-600 ">
                    <input type="text" name="search" id="search" placeholder="Search" class="h-10 pl-4 pr-10 py-2 rounded-full text-sm focus:outline-none">
                    <button type="submit" class="absolute right-0 top-0 mt-3 mr-6">
                        <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 56.966 56.966" style="enable-background:new 0 0 56.966 56.966;" xml:space="preserve" width="512px" height="512px">
                            <path d="M55.146,51.887L41.588,37.786c3.486-4.144,5.396-9.358,5.396-14.786c0-12.682-10.318-23-23-23s-23,10.318-23,23  s10.318,23,23,23c4.761,0,9.298-1.436,13.177-4.162l13.661,14.208c0.571,0.593,1.339,0.92,2.162,0.92  c0.779,0,1.518-0.297,2.079-0.837C56.255,54.982,56.293,53.08,55.146,51.887z M23.984,6c9.374,0,17,7.626,17,17s-7.626,17-17,17  s-17-7.626-17-17S14.61,6,23.984,6z" />
                        </svg>
                    </button>
                </div>
            </form>
        </div>
    </div>
</header>