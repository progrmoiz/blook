<?php
include_once '../../lib/bootstrap.php';
header('Content-Type: text/html; charset=UTF-8');

$location = isset($_SESSION['location']) ? $_SESSION['location'] : null;

include_once ACC . 'logout.php';
?>
