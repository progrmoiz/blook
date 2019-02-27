<?php

/* CONSTANTS */
include_once 'constants.php';

/* FUNCTIONS */
include_once 'functions.php';

/* DB */
include_once 'db.php';


if(!isset($_SESSION))
{
    session_start();
}

if (isUserLoggedIn()) {
    include_once LIB . 'user/get_user_by_uname.php';
    include_once LIB . 'book/get_user_book.php';

    $user = get_user_by_uname($_SESSION['login_user']);
    $user->avator = "https://www.gravatar.com/avatar/" . md5( strtolower( trim($user->email) ) ) . "?d=https://api.adorable.io/avatars/60/$user->email";
    $user_book = get_user_book($user->id);
    $ret = new stdClass;

    foreach ($user_book as $row) {
        $ret->{$row->book_id} = $row;
    }
    $user_book = $ret;
} else {
    $user = null;
    $user_book = null;
}

include_once LIB . 'book/get_read_status_codes.php';
$read_status_codes = get_read_status_code();
$read_status_color = new stdClass;

$read_status_color->{1} = "bg-indigo";
$read_status_color->{2} = "bg-blue";
$read_status_color->{3} = "bg-orange";
$read_status_color->{4} = "libre-bg-grey";

function readStatusCodeToStdClass($read_status_codes, $alt=false) {
    $ret = new stdClass;

    foreach ($read_status_codes as $row) {
        $ret->{$row->id} = $alt ? $row->status_alt : $row->status;
    }

    return $ret;
}

$popular_genres = array('art', 'biography', 'business', 'chick-lit', 'children\'s', 'christian', 'classics', 'comics', 'contemporary', 'cookbooks', 'crime', 'ebooks', 'fantasy', 'fiction', 'gay-and-lesbian', 'graphic-novels', 'historical-fiction', 'history', 'horror', 'humor-and-comedy', 'manga', 'memoir', 'music', 'mystery', 'nonfiction', 'paranormal', 'philosophy', 'poetry', 'psychology', 'religion', 'romance', 'science', 'science-fiction', 'self-help', 'suspense', 'spirituality', 'sports', 'thriller', 'travel', 'young-adult');

// function sanitize_output($buffer) {

//     $search = array(
//         '/\>[^\S ]+/s',     // strip whitespaces after tags, except space
//         '/[^\S ]+\</s',     // strip whitespaces before tags, except space
//         '/(\s)+/s',         // shorten multiple whitespace sequences
//         '/<!--(.|\s)*?-->/' // Remove HTML comments
//     );

//     $replace = array(
//         '>',
//         '<',
//         '\\1',
//         ''
//     );

//     $buffer = preg_replace($search, $replace, $buffer);

//     return $buffer;
// }

// ob_start("sanitize_output");