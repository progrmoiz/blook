<header class="bg-indigo-darker text-center p-4 px-6 flex items-center">
    <div class="hidden lg:block lg:w-1/4 xl:w-1/5 pr-8">
      <a href="<?= ROOT ?>" class="flex justify-start pl-6">
      <img class="select-none" draggable="false" src="<?= ROOT ?>/images/logo.png" style="object-fit: contain; width: 100px;" alt="logo">
    </a>
    </div>
    <div class="lg:hidden pr-3" id="mobile-nav-trigger">
      <div class="toggle p-2 block"><span></span></div>
    </div>
    <div class="flex flex-grow items-center lg:w-3/4 xl:w-4/5">
      <span class="relative w-full">
      <input type="search" placeholder="Search" class="w-full text-sm text-white transition border border-transparent focus:outline-none focus:border-indigo placeholder-white rounded bg-indigo-medium py-1 px-2 pl-10 appearance-none leading-normal ds-input">
      <div class="absolute search-icon" style="top: .5rem; left: .8rem;">
      <svg class="fill-current pointer-events-none text-white w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
        <path d="M12.9 14.32a8 8 0 1 1 1.41-1.41l5.35 5.33-1.42 1.42-5.33-5.34zM8 14A6 6 0 1 0 8 2a6 6 0 0 0 0 12z"></path>
      </svg>
      </div>
    </span>
      <div class="lg:w-1/3">
        <?php if (!isUserLoggedIn() && !isset($IsLoginOrRegisterPage)) { ?>
          <a class="hover:shadow-md hover:bg-grey-light hover:text-indigo-darkest transition-normal font-semibold rounded text-sm bg-indigo-lightest px-2 py-2 no-underline text-indigo-darker" href="<?= ROOT ?>/login">Sign in</a>
        <?php } else { ?>
          <!-- <a href="<?= ROOT ?>/logout" class="text-sm text-right text-white py-2 px-3 hover:text-grey-dark no-underline hidden lg:block px-6">Logout</a> -->
        <?php } ?>
      </div>
    </div>
  </header>