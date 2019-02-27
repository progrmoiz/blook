<?php
  include_once '../../lib/bootstrap.php';
  header('Content-Type: text/html; charset=UTF-8');
  header("HTTP/1.1 404 Not Found");

  include_once INC . 'head.php';
?>
  <!-- Main -->
  <div class="flex flex-1">
    <!-- Side Nav -->
    <?php include_once INC . 'aside_menu.php'; ?>
    <!-- Content -->
    <div class="flex flex-1 flex-col md:px-6 pt-10" id="content">
       <img class="select-none" draggable="false" src="<?= ROOT ?>/images/404.gif" alt="Not Found" />
    </div>

    <?php include_once INC . 'aside_profile.php'; ?>
  </div>

  <?php
    include_once INC . 'footer.php';
  ?>
