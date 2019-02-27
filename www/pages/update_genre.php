<?php
// Change book status for current user

include_once '../../lib/bootstrap.php';
setLocation(ROOT . '/update_genre');

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
  // header("HTTP/1.1 405 Method Not Allowed");
  // include_once '404.php';
  // die();
}

if (!isUserLoggedIn()) {
  include_once '404.php';
  // header("HTTP/1.1 401 Unauthorized");
  die();
}

$user_id = $user->id;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  $genre = isset($_POST['genre']) ? $_POST['genre'] : null;
  $genre_list = isset($_POST['genre_list']) ? $_POST['genre_list'] : null;
  $removed = isset($_POST['removed']) ? true : false;
  $redirect = isset($_POST['redirect']);

  if (!isset($genre)) {
    header("HTTP/1.1 400 Bad Request");
    die();
  }

  $gen_to_del = array_diff($genre_list, $genre);

  include_once LIB . 'user/update_genre.php';

  if ($genre_list) {
    update_genre($user_id, $gen_to_del, true); // deleted
    update_genre($user_id, $genre); // insert
  } else {
    $row_count = update_genre($user_id, $genre, $removed);
  }

  if (isset($_POST['location'])) {
    header("Location: ". $_POST['location']);
  } else {
    header('Content-Type: application/json; charset=UTF-8');

    echo json_encode(array(
      'status' => ($row_count == 1 ? 'success' : 'failed'),
      'user_id' => $user_id,
      'genre' => $genre,
    ));
  }

  die();
}

header('Content-Type: text/html; charset=UTF-8');

include INC . 'head.php';

$title = "Follow Your Favorite Genre";
include_once LIB . 'book/echo_filter.php';
?>

<!-- Main -->
<div class="flex flex-1">
  <!-- Side Nav -->
  <?php include_once INC . 'aside_menu.php'; ?>
  <!-- Content -->
  <div class="flex flex-1 flex-col md:px-6 pt-10" id="content">
  <div class="px-6 md:px-0 flex items-center">
      <div>
        <h2 class="font-normal text-3xl"><?= $title ?></h2>
      </div>
      <button hidden id="submit-gen" class="bg-indigo-dark hover:bg-indigo-darker text-white text-xs py-1 pt-2 px-2 font-mono uppercase rounded transition-normal hover:shadow hover:translate-y-1 active:translate-y-1 focus:outline-none ml-2" form="genresForm">Save Changes</button>
  </div>
<form id="genresForm" action="<?= ROOT ?>/update_genre" method="POST">
<input type="hidden" name="location" value="<?= $_SERVER['REQUEST_URI'] ?>" />
<?= echo_filter_heading('Popular Genre') ?>
  <div class="px-6 md:px-0 pt-2 md:px-0 flex flex-wrap flex-row">
<?php
  include_once LIB . 'user/get_user_genre.php';

  $all_user_genre = get_user_genre($user->id);
  $ml_genres_list = array_chunk($popular_genres, count($popular_genres) / 3);
  foreach ($ml_genres_list as $col) {
  echo '<div class="px-2 flex flex-col w-1/3">';
  foreach ($col as $genre) { ?>
      <div class='text-sm'>
          <?php
            $checked = isset($all_user_genre->{$genre}) ? 'checked' : '';
            echo "<input id='pop-$genre' class='js-submit-btn-toggle' $checked value='$genre' type='checkbox' name='genre[]'>";
            echo "<input $checked value='$genre' type='hidden' name='genre_list[]'>";
         ?>
          <label class='text-grey-darkest hover:text-black no-underline hover:underline' for="pop-<?=$genre?>"><?= $genre ?></a>
      </div>

  <?php }
  echo '</div>';
  }
?>
  </div>
<?php
$all_user_genre_arr = array_map(function($a) { return $a->genre; }, get_object_vars($all_user_genre));
$left_genre_list = array_diff($all_user_genre_arr, $popular_genres);
if (!empty($left_genre_list)) {
  echo_filter_heading('Other Genre');
}
?>
   <div class="px-6 md:px-0 pt-2 md:px-0 flex flex-wrap flex-row">
    <?php

if (count($left_genre_list) >= 3) {
  $ml_genres_list = array_chunk($left_genre_list, count($left_genre_list) / 3);
} else {
  $ml_genres_list = array_chunk($left_genre_list, 1);
}
foreach ($ml_genres_list as $col) {
echo '<div class="px-2 flex flex-col w-1/3">';
foreach ($col as $genre) { ?>
  <div class='text-sm'>
      <?php
        $checked = isset($all_user_genre->{$genre}) ? 'checked' : '';
        echo "<input id='fav-$genre' class='js-submit-btn-toggle' $checked value='$genre' type='checkbox' name='genre[]'>";
        echo "<input $checked value='$genre' type='hidden' name='genre_list[]'>";
     ?>
      <label class='text-grey-darkest hover:text-black no-underline hover:underline' for="fav-<?=$genre?>"><?= $genre ?></a>
  </div>

<?php }
echo '</div>';
}
?>
    </div>
</form>
  </div>

  <?php include_once INC . 'aside_profile.php'; ?>
</div>

<?php
  include_once INC . 'popup.php';
  include_once INC . 'footer.php';
?>

