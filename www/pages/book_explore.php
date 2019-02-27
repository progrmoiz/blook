<?php
include_once '../../lib/bootstrap.php';
header('Content-Type: text/html; charset=UTF-8');
setLocation(ROOT);

if (!isUserLoggedIn()) {
  header('Location: ' . ROOT . '/book');
  die();
}
  include_once INC . 'head.php';
  include_once LIB . 'book/echo_filter.php';
  include_once LIB . 'book/get_best_book.php';
  include_once LIB . 'book/get_book_by_genre.php';
  ?>
  <!-- Main -->
  <div class="flex flex-1">
    <!-- Side Nav -->
    <?php include_once INC . 'aside_menu.php' ?>
    <!-- Content -->
    <div class="flex flex-1 flex-col md:px-6 pt-10 pb-5" id="content">
      <!-- Title -->
      <div class="px-6 md:px-0 flex justify-between items-center -order-1">
        <div>
          <h2 class="font-normal">Recent Updates</h2>
        </div>
      </div>

      <?php echo_filter_heading("Best Books") ?>
      <div class="hidden px-2 pt-2 md:px-0 flex-wrap js-tab-pane active" id="section-library">
        <?php foreach(get_best_book(5) as $book) {
          include INC . 'library_book.php';
        } ?>
      </div>

      <?php
        include_once LIB . 'user/get_user_genre.php';
        $all_user_genre = get_user_genre($user->id);
        $all_user_genre_arr = array_map(function($a) { return $a->genre; }, get_object_vars($all_user_genre));
        $inter_genre_list = array_intersect($all_user_genre_arr, $popular_genres);

        foreach ($inter_genre_list as $genre) {
          $books = get_book_by_genre($genre, 5);
          // Filter
          if (!empty($books)) {
          echo_filter_heading("New Releases in " . ucwords(str_replace('-', ' ', $genre)));
      ?>

      <!-- Library -->
      <div class="hidden px-2 pt-2 md:px-0 flex-wrap js-tab-pane active" id="section-library">
        <?php foreach($books as $book) {
          include INC . 'library_book.php';
        } ?>
      </div>

      <?php
          echo "<div class='font-mono text-right text-xs text-grey-dark'>More in <a class='font-semibold text-grey-darker hover:text-grey-darkest no-underline hover:underline' href='" . ROOT . "/genre/$genre'>" . ucwords(str_replace('-', ' ', $genre)) . "</a></div>";
          }
        }
      ?>

    </div>

    <?php
      include_once INC . 'aside_profile.php';
    ?>
  </div>

  <?php
    include_once INC . 'popup.php';
    include_once INC . 'footer.php';
  ?>
