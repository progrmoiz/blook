<?php
  include_once '../../lib/bootstrap.php';
  setLocation(ROOT . '/book/' . $_GET['id']);

  $book_id = $_GET['id'];

  require_once LIB . 'book/get_book_by_id.php';
  $books = get_book_by_id($book_id);

  if (empty($books)) {
    include_once '404.php';
    die();
  }

  header('Content-Type: text/html; charset=UTF-8');

  include_once INC . 'head.php';
  include_once LIB . 'book/echo_filter.php';
  include_once LIB . 'book/get_book_by_ids.php';

?>
  <!-- Main -->
  <div class="flex flex-1">
    <!-- Side Nav -->
    <?php include_once INC . 'aside_menu.php'; ?>
    <!-- Content -->
    <div class="flex flex-1 flex-col md:px-6 pt-10" id="content">
      <?php foreach ($books as $book) { ?>
        <div class="px-2 pt-2 md:px-0 flex-wrap flex w-full">
          <div class="flex-wrap flex flex-row">
            <div class="w-1/5">
              <img src="<?= $book->image_url ?>" alt="<?= $book->title ?>" class="shadow-md transition-normal hover:brighter hover:translate-y-1 hover:shadow-lg hover:border-indigo w-full">
              <div class="block relative mt-3">
                  <select <?= isUserLoggedIn() ? '' :'onclick="location.href = \'' . ROOT . '/login\'"' ?> data-book_title="<?= $book->title ?>" data-book_id="<?= $book->id ?>" class="js-change-status block appearance-none w-full text-sm bg-white border border-grey-light hover:border-grey pl-3 py-1 pr-8 rounded shadow leading-normal focus:outline-none focus:shadow-outline">
                    <option selected value='' disabled>Add to</option>
                    <?php foreach(readStatusCodeToStdClass($read_status_codes, true) as $_k => $_v) {
                        $is_selected = isset($user_book->{$book->id}) && $user_book->{$book->id}->status_id == $_k ? 'selected' : '';
                        echo "<option $is_selected value='$_k'>$_v</option>";
                    } ?>
                  </select>
                  <div class="pointer-events-none absolute pin-y pin-r flex items-center px-2 text-grey-darker">
                  <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                      <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                  </svg>
                  </div>
              </div>
            </div>
            <div class="w-4/5 pl-5">
              <h2 class="font-normal text-3xl"><?= $book->title ?></h2>
              <p class="text-grey-dark mt-1 text-sm">by <?= $book->authors ?></p>
              <div class="flex flex-row items-center mt-1">
              <div class="relative text-xl p-0 text-grey inline-block">
                <?php $perc = $book->avg_rating / 5 * 100 ?>
                <div class="text-indigo p-0 absolute z-10 block pin-l overflow-hidden" style="width: <?= $perc ?>%"><span>★</span><span>★</span><span>★</span><span>★</span><span>★</span></div>
                <div class="z-0"><span>☆</span><span>☆</span><span>☆</span><span>☆</span><span>☆</span></div>
              </div>
              <span class="text-grey-dark text-sm ml-1"><?= $book->avg_rating ?></span>
              </div>
              <p class="text-grey-darker mt-2 text-base"><?= $book->description ?></p>
              <div class="text-xs mt-3 mb-3 font-mono border-t pt-4">
                <span class="mr-2 text-grey-darker">Get a copy</span>
                <a href="http://www.amzn.com/<?= $book->isbn ?>" class="tracking-wide text-grey-darkest no-underline bg-white border border-grey hover:border-grey p-2 rounded-sm shadow leading-normal focus:outline-none focus:shadow-outline">Amazon</a>
              </div>
              <table class="border-collapse text-sm font-mono text-left text-grey-darker mt-6">
                <?php
                  $isbn13 = !empty($book->isbn13) ? "(ISBN13: $book->isbn13)" : '';
                  $info = array(
                    'Language Code' => $book->language_code,
                    'ISBN' => "$book->isbn $isbn13",
                    'Format' => $book->format,
                    'Number of pages' => $book->num_pages,
                    'Published' => $book->published,
                    'Publisher' => $book->publisher
                  );
                  foreach ($info as $th => $td) {
                    if (!empty($td)) {
                      echo "<tr>";
                      echo "<th class='font-semibold pr-2 pb-1'>$th</th>";
                      echo "<td class='text-grey-darkest'>$td</td>";
                      echo "</tr>";
                    }
                  }
                ?>
              </table>
            </div>
          </div>
          <div class="flex-wrap flex flex-row mt-2 pt-4 border-t-2 w-full">
            <div class="w-1/5">
                <h3 class="md:inline-block text-grey-dark font-semibold tracking-wide text-sm font-mono uppercase subpixel-antialiased antialiased">Genre</h3>
            </div>
            <div class="w-4/5 flex">
                <?php
                  include_once LIB . 'book/get_genre_by_book.php';
                  $curr_book_genre = get_genre_by_book($book->goodread_id);
                  $mcurr_book_genre = array_chunk($curr_book_genre, count($curr_book_genre) / 4);
                  foreach ($mcurr_book_genre as $col) {
                    echo '<div class="px-2 flex flex-col w-1/4">';
                    foreach ($col as $genre) { ?>
                        <div class='text-xs'>
                            <a class='text-grey-darkest hover:text-black no-underline hover:underline' href='<?= ROOT ?>/genre/<?= $genre->name ?>'><?= $genre->name ?></a>
                            <span class='float-right text-grey text-xs'><?= $genre->count ?></span>
                        </div>

                    <?php }
                    echo '</div>';
                    }
                ?>
            </div>
          </div>
        </div>
      <?php
        $ids = array_map('intval', explode(',', $book->similar_books_id ));
        }
        $books = get_book_by_ids($ids);
        if (!empty($books)) {
          echo_filter_heading("Similar Books");
        }
      ?>

      <div class="hidden px-2 pt-2 md:px-0 flex-wrap js-tab-pane active" id="section-library">
        <?php foreach($books as $book) {
          include INC . 'library_book.php';
        } ?>
      </div>

      <div class="hidden px-2 pt-2 md:px-0 flex-wrap js-tab-pane active" id="section-library1">
        <!-- <?php include_once INC . 'goodread_widget.php' ?> -->
      </div>
    </div>

    <?php include_once INC . 'aside_profile.php'; ?>
  </div>

  <?php
    include_once INC . 'popup.php';
    include_once INC . 'footer.php';
  ?>
