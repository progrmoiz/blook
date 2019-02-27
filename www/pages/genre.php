<?php
  include '../../lib/bootstrap.php';
  header('Content-Type: text/html; charset=UTF-8');
  setLocation(ROOT . '/genre');

  require_once CLS . 'Pagination.class.php';

  // get total genres
  $sql = "SELECT COUNT(DISTINCT name) FROM category";

  $stmt = $db->prepare($sql);
  $stmt->execute();
  $catrow = $stmt->fetch(PDO::FETCH_NUM);
  $total = $catrow[0];

  $page = isset($_GET['page']) ? ((int) $_GET['page']) : 1;

  // result per page
  $rpp = 120;

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

    $title = 'Genres';
  ?>
  <div class="flex flex-1">
    <?php include_once INC . 'aside_menu.php' ?>
    <div class="flex flex-1 flex-col md:px-6 pt-10" id="content">
      <div class="px-6 md:px-0 flex items-center mb-3">
          <div>
            <h2 class="font-normal text-3xl"><?= $title ?></h2>
          </div>
          <button hidden id="submit-gen" class="bg-indigo-dark hover:bg-indigo-darker text-white text-xs py-1 pt-2 px-2 font-mono uppercase rounded transition-normal hover:shadow hover:translate-y-1 active:translate-y-1 focus:outline-none ml-2" form="genresForm">Save Changes</button>
      </div>

      <?php
        include_once INC . 'genre_list.php';
        echo $markup
      ?>
    </div>

  </div>

  <?php
    include_once INC . 'footer.php';
