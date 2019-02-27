<nav class="absolute lg:relative lg:flex lg:text-sm bg-indigo-darker lg:bg-transparent pin-l pin-r py-4 px-6 lg:pt-10 lg:pl-12 lg:pr-6 -mt-1 lg:mt-0 overflow-y-auto lg:w-1/5 lg:border-r z-40 hidden">
    <ul class="list-reset mb-8 w-full">
    <li class="ml-2 mb-4 flex items-center">
        <a class="uppercase font-mono font-semibold text-xs lg:text-grey-darker hover:cursor-pointer text-white no-underline font-medium mobile-home-trigger" href="<?= ROOT ?>">Home</a>
    </li>
    <li class="ml-2 mb-4 flex items-center">
        <a class="uppercase font-mono font-semibold text-xs lg:text-grey-darker hover:cursor-pointer text-white no-underline font-medium mobile-home-trigger" href="<?= ROOT ?>/genre">Genre</a>
    </li>
    <?php
        $genres = $popular_genres;
        $menu_title = "Popular Genre";
        include 'aside_menu_genre.php';
    ?>
    <li class="ml-2 mb-4 flex items-center">
        <a class="uppercase font-mono font-semibold text-xs lg:text-grey-darker hover:cursor-pointer text-white no-underline font-medium mobile-home-trigger" href="<?= ROOT ?>/book">Explore Books</a>
    </li>
    <?php if (isUserLoggedIn()) { ?>
    <li class="ml-2 mb-4 flex">
        <a class="uppercase font-mono font-semibold text-xs lg:text-grey-darker hover:cursor-pointer text-white no-underline font-medium mobile-home-trigger" href="<?= ROOT ?>/update_genre">Favorite Genre</a>
    </li>
    <li class="ml-2 mb-4 flex">
        <a class="uppercase font-mono font-semibold text-xs lg:text-grey-darker hover:cursor-pointer text-white no-underline font-medium mobile-home-trigger" href="<?= ROOT ?>/mybook">Wishlist</a>
    </li>
    <li class="ml-2 mb-4 flex lg:hidden">
        <div class="uppercase font-mono font-semibold text-xs lg:text-grey-darker hover:cursor-pointer text-white no-underline font-medium" id="mobile-profile-trigger">Profile</div>
    </li>
    <li class="ml-2 mb-4 flex">
        <a class="uppercase font-mono font-semibold text-xs lg:text-grey-darker hover:cursor-pointer text-white no-underline font-medium mobile-home-trigger" href="<?= ROOT ?>/logout">Logout</a>
    </li>
    <?php } ?>
    </ul>
</nav>
