<?php
/* www/pages/genres.php */

include_once LIB . 'book/get_genre_list.php';

$u = isUserLoggedIn();

if ($u) {
    include_once LIB . 'user/get_user_genre.php';
    $user_genre = get_user_genre($user->id);
?>
<form id="genresForm" action="<?= ROOT ?>/update_genre" method="POST">
<input type="hidden" name="location" value="<?= $_SERVER['REQUEST_URI'] ?>" />
<?php } ?>
<div class="px-6 md:px-0 pt-2 md:px-0 flex flex-wrap flex-row">
<?php
$genres_list = get_genre_list($rpp, $page - 1);
$ml_genres_list = array_chunk($genres_list, count($genres_list) / 3);
foreach ($ml_genres_list as $col) {
echo '<div class="px-2 flex flex-col w-1/3">';
foreach ($col as $genre) { ?>
    <div class='text-sm'>
        <?php if ($u) {
            $checked = isset($user_genre->{$genre->name}) ? 'checked' : '';
            echo "<input class='js-submit-btn-toggle' $checked value='$genre->name' type='checkbox' name='genre[]'>";
            echo "<input $checked value='$genre->name' type='hidden' name='genre_list[]'>";
        } ?>
        <a class='text-grey-darkest hover:text-black no-underline hover:underline' href='<?= ROOT ?>/genre/<?= $genre->name ?>'><?= $genre->name ?></a>
        <span class='float-right text-grey text-xs'><?= $genre->num_books . " book " . plural(intval($genre->num_books)) ?></span>
    </div>

<?php }
echo '</div>';
}
?>
</div>
<?php if ($u) {
    echo '</form>';
}
?>
