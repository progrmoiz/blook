<?php
  include '../../lib/bootstrap.php';
  header('Content-Type: text/html; charset=UTF-8');
  setLocation($_SERVER['REQUEST_URI']);

  require_once CLS . 'Pagination.class.php';

  // get total books from this genre
  $sql = "SELECT COUNT(DISTINCT book.id) FROM `book` INNER JOIN `category` ON goodread_id = category.bookId WHERE category.name = ? ORDER BY `published` DESC";

  $stmt = $db->prepare($sql);
  $stmt->bindValue(1, $_GET['genre']);
  $stmt->execute();
  $catrow = $stmt->fetch(PDO::FETCH_NUM);
  $total = $catrow[0];

  $page = isset($_GET['page']) ? ((int) $_GET['page']) : 1;
  $rpp  = isset($_GET['result']) ? ((int) $_GET['result']) : 25;
  $year = isset($_GET['year']) ? ((int) $_GET['year']) : null;
  $month  = isset($_GET['month']) ? ((int) $_GET['month']) : null;

  // sort
  $sort = isset($_GET['sort']) ? ($_GET['sort']) : 'new';
  $sorts = array('date_pub', 'avg_rating', 'title');
  $key = array_search(isset($_GET['sort']) ? $_GET['sort'] : 'date_pub', $sorts);
  $sort = $sorts[$key];

  // order
  $orders = array('a', 'd');
  $key = array_search(isset($_GET['order']) ? $_GET['order'] : 'd', $orders);
  $order = $orders[$key];

  // instantiate; set current page; set number of records
  $pagination = (new Pagination());
  $pagination->setCurrent($page);
  $pagination->setRPP($rpp);
  $pagination->setTotal($total);

  // grab rendered/parsed pagination markup
  $markup = $pagination->parse();

  include_once INC . 'head.php';
?>

  <?php
    include_once INC . 'loader.php';
    include_once INC . 'header.php';
    include_once LIB . 'book/get_book_by_genre.php';

    $title = ucwords(str_replace('-', ' ', $_GET['genre']));
    $title = str_replace(' S ', '\'s ', $title);
    $title .= '<span class="text-grey-darker"> - ' . $total . ' book' . plural($total) . "</span>";
  ?>
  <div class="flex flex-1">
    <?php include_once INC . 'aside_menu.php' ?>
    <div class="flex flex-1 flex-col md:px-6 pt-10" id="content">
      <div class="px-6 md:px-0 flex justify-between items-center -order-1">
          <div>
            <h5 class="text-grey-darker text-xs uppercase font-mono tracking-wide">Genre</h5>
            <h2 class="font-normal text-3xl"><?= $title ?></h2>
          </div>
          <?php
            if (isUserLoggedIn()) {
              $sql = "SELECT COUNT(user_id) FROM userFavoriteCategory WHERE userFavoriteCategory.user_id = :user_id AND userFavoriteCategory.genre = :genre";

              $stmt = $db->prepare($sql);
              $stmt->bindValue(':user_id', $user->id);
              $stmt->bindValue(':genre', $_GET['genre'] );
              $stmt->execute();
              $catrow = $stmt->fetch(PDO::FETCH_NUM);
              $total = $catrow[0];
          ?>
          <form action="<?= ROOT ?>/update_genre" method="POST">
            <input type="hidden" value="<?= $_GET['genre'] ?>" name="genre">
            <input type="hidden" name="location" value="<?= $_SERVER['REQUEST_URI'] ?>" />
            <?php if ($total == 0) { ?>
              <button class="bg-indigo-dark hover:bg-indigo-darker text-white text-sm py-2 px-4 rounded-full transition-normal hover:shadow hover:translate-y-1 active:translate-y-1 focus:outline-none">Add to Favorite</button>
            <?php } else { ?>
              <input type="hidden" value="1" name="removed">
              <button class="bg-indigo-dark hover:bg-indigo-darker text-white text-sm py-2 px-4 rounded-full transition-normal hover:shadow hover:translate-y-1 active:translate-y-1 focus:outline-none">Remove from Favorite</button>
            <?php } ?>
          </form>
          <?php } ?>
      </div>
      <?php
        include_once INC . 'filter.php';
      ?>
      <div class="hidden px-2 pt-2 md:px-0 flex-wrap js-tab-pane active">
        <?php foreach(get_book_by_genre($_GET['genre'], $rpp, $page - 1, $sort, $order, $year, $month) as $book) {
          include INC . 'library_book.php';
        } ?>
      </div>
      <?= $markup ?>
    </div>

    <?php
      include_once INC . 'aside_profile.php';
    ?>
  </div>

  <?php
    include_once INC . 'footer.php';
    include_once INC . 'popup.php';
