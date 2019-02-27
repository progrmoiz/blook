<li class="ml-2 mb-4">
    <div class="flex" id="sidenav-categories-trigger">
    <div class="uppercase font-mono font-semibold text-xs lg:text-grey-darker hover:cursor-pointer text-white no-underline font-medium w-full relative">
        <?= $menu_title ?>
        <div class="pointer-events-none absolute pin-y pin-r flex items-center px-1 text-grey-darker rotate" id="sidenav-icon">
        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
            <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
        </svg>
        </div>
    </div>
    </div>
    <ul class="text-grey lg:text-grey-dark list-reset leading-loose mt-2 hidden" id="sidenav-categories">
    <?php
        foreach ($genres as $genre) {
    ?>
        <li class="ml-1 border-l border-grey-dark pl-4 text-xs">
            <a class="no-underline text-grey lg:text-grey-dark hover:text-indigo-dark hover:cursor-pointer transition-normal" href="<?= ROOT ?>/genre/<?= $genre ?>"><?= ucwords(str_replace('-', ' ', $genre)) ?></a>
        </li>
    <?php
        }
    ?>
    </ul>
</li>
