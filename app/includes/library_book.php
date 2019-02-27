<div class="flex flex-col sm:flex-col items-center sm:items-start w-1/2 xs:w-1/2 sm:w-1/5 md:w-1/5 p-4 js-book" id="book-<?= $book->id ?>" data-id="<?= $book->id ?>" data-title="<?= $book->title ?>" data-rating="<?= ($book->avg_rating / 5 * 100) ?>" data-desc="<?= htmlspecialchars($book->description) ?>">
    <img src="<?= $book->image_url ?>" alt="book-01" class="shadow-md transition-normal hover:brighter hover:translate-y-1 hover:shadow-lg hover:border-indigo w-full">
    <div class="ml-3 sm:ml-0 w-2/3 sm:w-full">
        <p class="text-sm my-2 font-medium sm:font-normal">
            <a class="no-underline text-grey-darker hover:text-grey-darkest hover:underline" href="<?= ROOT . '/book/' . $book->id?>"><?= !empty($book->title) ? $book->title : 'No title' ?></a>
        </p>
    </div>
    <?php if (isUserLoggedIn()) { ?>
    <div class="js-status">
        <?php
            $curr_user_book = isset($user_book->{$book->id}) ? $user_book->{$book->id} : null;
            if ($curr_user_book) {
                switch ($curr_user_book->status_id) {
                    case 1: // FINISHED
                        $bg_color = "bg-indigo";
                        break;
                    case 2: // CURRENTLY READING
                        $bg_color = "bg-blue";
                    case 3: // WANT TO READ
                        $bg_color = "bg-orange";
                    case 4: // LOANED
                        $bg_color = "libre-bg-grey";
                        break;
                }
        ?>
        <label for="" class="hidden sm:inline-block rounded-full <?= $read_status_color->{$curr_user_book->status_id} ?> text-white px-2 py-1/2 text-xs">
            <?= $curr_user_book->status ?>
        </label>
        <?php } ?>
    </div>
    <?php if (isUserLoggedIn()) { ?>
    <div class="block sm:hidden relative">
        <select data-book_id="<?= $book->id ?>" class="block appearance-none w-full text-sm bg-white border border-grey-light hover:border-grey pl-3 py-1 pr-8 rounded shadow leading-normal focus:outline-none focus:shadow-outline">
            <option selected value='' disabled>Want to Read</option>
            <option value="2">Currently Reading</option>
            <option value="3">Want to Read</option>
            <option value="4">Loaned</option>
            <option value="1">Read</option>
        </select>
        <div class="pointer-events-none absolute pin-y pin-r flex items-center px-2 text-grey-darker">
        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
            <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
        </svg>
        </div>
    </div>
    <?php } ?>
    <?php } ?>
</div>