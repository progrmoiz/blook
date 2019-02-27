<?php
  include '../../lib/bootstrap.php';
  setLocation(ROOT . '/mybooks');

  $user_id = isset($_GET['user']) ? ((int) $_GET['user']) : null;

  if (!isUserLoggedIn() || $user->id != $user_id) {
    // header('Location: ' . ROOT);
    include_once '404.php';
    die();
  }

  header('Content-Type: text/html; charset=UTF-8');

  $page = isset($_GET['page']) ? ((int) $_GET['page']) : 1;
  $rpp  = isset($_GET['result']) ? ((int) $_GET['result']) : 25;

  $sorts = array('title', 'author', 'isbn', 'avg_rating', 'date_pub', 'date_add');
  $key = array_search(isset($_GET['sort']) ? $_GET['sort'] : 'date_add', $sorts);
  $sort = $sorts[$key];

  $orders = array('a', 'd');
  $key = array_search(isset($_GET['order']) ? $_GET['order'] : 'd', $orders);
  $order = $orders[$key];

  $filters = array(null, 1, 2, 3, 4);
  $key = array_search(isset($_GET['filter']) ? $_GET['filter'] : null, $filters);
  $filter = $filters[$key];

  $sql = "SELECT COUNT(*) FROM `userReadStatus` WHERE user_id = ?";
  $stmt = $db->prepare($sql);
  $stmt->bindValue(1, $user_id);
  $stmt->execute();
  $catrow = $stmt->fetch(PDO::FETCH_NUM);
  $total = $catrow[0];

  include_once INC . 'head.php';
?>
  <?php
    include_once LIB . 'book/get_user_book.php';

    $user_book = get_user_book($user_id, $sort, $order, $rpp, $page - 1, $filter);

    $ret = new stdClass;

    foreach ($user_book as $row) {
        $ret->{$row->book_id} = $row;
    }
    $user_book = $ret;
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
            <h2 class="font-normal text-3xl">My Books</h2>
          </div>
      </div>
      <?php
        function e($_sort) {
          global $sort;
          global $order;

          if ($sort == $_sort) {
            if ($order == 'a') {
              echo "<img src='" . ROOT . "/images/up_arrow.gif'>";
            } else {
              echo "<img src='" . ROOT . "/images/down_arrow.gif'>";
            }
          }
        }
      ?>

      <table class="table mt-6">
        <thead>
          <tr class="text-xs font-light text-grey-darkest text-left lowercase">
            <th class="py-2 pl-2 border-b-2">Cover</th>
            <th class="py-2 pl-2 border-b-2">
              <a class="text-grey-darkest no-underline hover:underline hover:text-black" href="<?= merge_querystring(current_url(), '?sort=title&order=' . ($sort == 'title' && $order == 'a' ? 'd' : 'a')) ?>">
              Title <?php e("title") ?>
              </a>
            </th>
            <th class="py-2 pl-2 border-b-2">
              <a class="text-grey-darkest no-underline hover:underline hover:text-black" href="<?= merge_querystring(current_url(), '?sort=author&order=' . ($sort == 'author' && $order == 'a' ? 'd' : 'a')) ?>">
              Author <?php e("author") ?>
              </a>
            </th>
            <th class="py-2 pl-2 border-b-2">
              <a class="text-grey-darkest no-underline hover:underline hover:text-black" href="<?= merge_querystring(current_url(), '?sort=isbn&order=' . ($sort == 'isbn' && $order == 'a' ? 'd' : 'a')) ?>">
              Isbn <?php e("isbn") ?>
              </a>
            </th>
            <th class="py-2 pl-2 border-b-2">
              <a class="text-grey-darkest no-underline hover:underline hover:text-black" href="<?= merge_querystring(current_url(), '?sort=avg_rating&order=' . ($sort == 'avg_rating' && $order == 'a' ? 'd' : 'a')) ?>">
              Avg Rating <?php e("avg_rating") ?>
              </a>
            </th>
            <th class="py-2 pl-2 border-b-2">
              <a class="text-grey-darkest no-underline hover:underline hover:text-black" href="<?= merge_querystring(current_url(), '?sort=date_pub&order=' . ($sort == 'date_pub' && $order == 'a' ? 'd' : 'a')) ?>">
              Date Pub <?php e("date_pub") ?>
              </a>
            </th>
            <th class="py-2 pl-2 border-b-2">
              <a class="text-grey-darkest no-underline hover:underline hover:text-black" href="<?= merge_querystring(current_url(), '?sort=date_add&order=' . ($sort == 'date_add' && $order == 'a' ? 'd' : 'a')) ?>">
              Date Added <?php e("date_add") ?>
              </a>
            </th>
            <th class="py-2 pl-2 border-b-2"></th>
            <th class="py-2 pl-2 border-b-2"></th>
          </tr>
        </thead>
        <?php foreach ($user_book as $book) { ?>
          <tr id="book-<?= $book->book_id ?>" class="text-sm text-grey-darkest text-left">
            <td class="align-top"><img class="w-12 max-w-tiny shadow-md block m-2 transition-normal hover:brighter" src="<?= $book->cover ?>" alt="<?= $book->title ?>"></td>
            <td class="align-top p-2"><a class="text-grey-darkest hover:text-black no-underline hover:underline" href="<?= ROOT ?>/book/<?= $book->book_id ?>"><?= $book->title ?></a></td>
            <td class="align-top p-2 w-10"><?= $book->authors ?></td>
            <td class="align-top p-2"><?= $book->isbn ?></td>
            <td class="align-top p-2"><?= $book->avg_rating ?></td>
            <td class="align-top p-2"><?= $book->published ?></td>
            <td class="align-top p-2"><?= $book->date_added ?></td>
            <td class="align-top p-2 text-xs">
              <div class="block relative">
                  <select data-book_title="<?= $book->title ?>" data-book_id="<?= $book->book_id ?>" class="js-change-status block appearance-none w-full text-sm bg-white border border-grey-light hover:border-grey pl-3 py-1 pr-8 rounded shadow leading-normal focus:outline-none focus:shadow-outline">
                    <option selected value='' disabled>Add to</option>
                    <?php foreach(readStatusCodeToStdClass($read_status_codes, true) as $_k => $_v) {
                        $is_selected = isset($user_book->{$book->book_id}) && $user_book->{$book->book_id}->status_id == $_k ? 'selected' : 'sdsd';
                        echo "<option $is_selected value='$_k'>$_v</option>";
                    } ?>
                  </select>
                  <div class="pointer-events-none absolute pin-y pin-r flex items-center px-2 text-grey-darker">
                  <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                      <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                  </svg>
                  </div>
              </div>
            </td>
            <td class="align-top p-2">
              <button class="js-del-status" data-book_title="<?= $book->title ?>" data-book_id="<?= $book->book_id ?>"><img src="<?= ROOT ?>/images/baseline-close-24px.svg"></button>
            </td>
          </tr>
        <?php } ?>
      </table>
      <div class="navigation text-xs fixed pin-b w-screen bg-indigo-lightest border-t -mx-6 flex p-2 flex-row">
        <div class="flex items-center px-2">
            <?php include_once INC . 'list_pagination.php' ?>
        </div>
        <div class="flex items-center px-2 border-l border-grey">
          <span class="font-mono mr-2 text-grey-darker">Number of rows: </span>
          <select onchange="location.href='<?= merge_querystring(current_url(), '?result=result_var') ?>'.replace('result_var', this.value)" name="result" class="block bg-white border border-grey-light hover:border-grey pl-3 py-1 rounded-sm shadow leading-normal focus:outline-none focus:shadow-outline">
            <option <?= $rpp == 25 ? 'selected' : '' ?>>25</option>
            <option <?= $rpp == 50 ? 'selected' : '' ?>>50</option>
            <option <?= $rpp == 75 ? 'selected' : '' ?>>75</option>
            <option <?= $rpp == 100 ? 'selected' : '' ?>>100</option>
          </select>
        </div>
        <div class="flex items-center px-2 border-l border-grey">
          <span class="font-mono mr-2 text-grey-darker">Sort by: </span>
          <select onchange="location.href='<?= merge_querystring(current_url(), '?sort=sort_var') ?>'.replace('sort_var', this.value)" name="sort" class="block bg-white border border-grey-light hover:border-grey pl-3 py-1 rounded-sm shadow leading-normal focus:outline-none focus:shadow-outline">
            <?php foreach($sorts as $s) { ?>
              <option <?= $s == $sort ? 'selected' : '' ?> value="<?= $s ?>"><?= $s ?></option>
            <?php } ?>
          </select>
        </div>
        <div class="flex items-center px-2 border-l border-grey">
          <input onclick="location.href='<?= merge_querystring(current_url(), '?order=a') ?>'" <?= $order == 'a' ? 'checked' : '' ?> type="radio" id="order_asc" name="order" value="a">
          <label class="font-mono px-2 text-grey-darker" for="order_asc">ASC</label>
          <input onclick="location.href='<?= merge_querystring(current_url(), '?order=d') ?>'" <?= $order == 'd' ? 'checked' : '' ?> type="radio" id="order_desc" name="order" value="d">
          <label class="font-mono px-2 text-grey-darker" for="order_desc">DESC</label>
        </div>
        <div class="flex items-center px-2 border-l border-grey">
          <span class="font-mono mr-2 text-grey-darker">Filter: </span>
          <select onchange="location.href='<?= merge_querystring(current_url(), '?filter=filter_var') ?>'.replace('filter_var', this.value)" name="filter" class="block bg-white border border-grey-light hover:border-grey pl-3 py-1 rounded-sm shadow leading-normal focus:outline-none focus:shadow-outline">
            <option selected value=''>Noting</option>
            <?php foreach(readStatusCodeToStdClass($read_status_codes, true) as $_k => $_v) {
                $is_selected = $filter == $_k ? 'selected' : '';
                echo "<option $is_selected value='$_k'>$_v</option>";
            } ?>
          </select>
        </div>
        </div>
      </div>
    </div>
  </div>
  <script>



  </script>

  <?php



    include_once LIB . 'book/delete_user_book.php';

    delete_user_book(26, 16);
    include_once INC . 'footer.php';
  ?>
