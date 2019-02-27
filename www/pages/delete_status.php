<?php
// Change book status for current user

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
  // header("HTTP/1.1 405 Method Not Allowed");
  include_once '404.php';
  die();
}

include_once '../../lib/bootstrap.php';

if (!isUserLoggedIn()) {
  header("HTTP/1.1 401 Unauthorized");
  die();
}

$user_id = $user->id;

$book_id = isset($_POST['book_id']) ? $_POST['book_id'] : null;

if (!isset($book_id)) {
  header("HTTP/1.1 400 Bad Request");
  die();
}

include_once LIB . 'book/delete_user_book.php';

$res = delete_user_book($user_id, $book_id);

echo json_encode(array(
  'status' => ($res == 1 ? 'success' : 'failed'),
  'user_id' => $user_id,
  'book_id' => $book_id,
));
