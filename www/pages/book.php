<?php
include_once '../../lib/bootstrap.php';
setLocation($_SERVER['REQUEST_URI']);

require_once CLS . 'Pagination.class.php';

// get total books from this genre
$sql = "SELECT COUNT(DISTINCT book.id) FROM `book`";

$stmt = $db->prepare($sql);
$stmt->execute();
$catrow = $stmt->fetch(PDO::FETCH_NUM);
$total = $catrow[0];

if ($_SERVER['HTTP_ACCEPT'] == 'application/json') {
  header('Content-Type: application/json; charset=UTF-8');
} else {
  header('Content-Type: text/html; charset=UTF-8');
}

$page = isset($_GET['page']) ? ((int) $_GET['page']) : 1;
$rpp  = isset($_GET['result']) ? ((int) $_GET['result']) : 25;
$year = isset($_GET['year']) ? ((int) $_GET['year']) : null;
$month  = isset($_GET['month']) ? ((int) $_GET['month']) : null;

$sorts = array('title', 'avg_rating', 'date_pub');
$key = array_search(isset($_GET['sort']) ? $_GET['sort'] : 'date_pub', $sorts);
$sort = $sorts[$key];

$orders = array('a', 'd');
$key = array_search(isset($_GET['order']) ? $_GET['order'] : 'd', $orders);
$order = $orders[$key];

if ($_SERVER['HTTP_ACCEPT'] == 'application/json') {
  include_once LIB . 'book/get_books.php';
  $books = get_books($sort, $order, $rpp, $page-1, $year, $month);
  echo json_encode($books);
  die();
}

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
  include_once LIB . 'book/echo_filter.php';
  include_once LIB . 'book/get_books.php';
?>
<!-- Main -->
<div class="flex flex-1">
  <!-- Side Nav -->
  <?php include_once INC . 'aside_menu.php' ?>
  <!-- Content -->
  <div class="flex flex-1 flex-col md:px-6 pt-10" id="content">
    <!-- Title -->
    <div class="px-6 md:px-0 flex justify-between items-center -order-1">
      <div>
        <h2 class="font-normal">Explore Books</h2>
      </div>
      <button class="bg-indigo-dark hover:bg-indigo-darker text-white text-sm py-2 px-4 rounded-full transition-normal hover:shadow hover:translate-y-1 active:translate-y-1 focus:outline-none">Add New Book</button>
    </div>

    <?php include_once INC . 'filter.php' ?>

    <div class="hidden px-2 pt-2 md:px-0 flex-wrap js-tab-pane active" id="section-library">
      <?php foreach(get_books($sort, $order, $rpp, $page-1, $year, $month) as $book) { ?>
        <?php include INC . 'library_book.php'; ?>
      <?php } ?>
    </div>
    <?= $markup ?>
  </div>

  <?php
    include_once INC . 'aside_profile.php';
  ?>
</div>

<?php
  include_once INC . 'popup.php';
  include_once INC . 'footer.php';
