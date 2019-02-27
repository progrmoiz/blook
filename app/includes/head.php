<!doctype html>
<html class="no-js" lang="">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?= isset($PageTitle) ? $PageTitle . ' | Blook' : "Blook"?></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="manifest" href="<?= ROOT ?>/site.webmanifest">
    <link rel="apple-touch-icon" href="<?= ROOT ?>/icon.png">

    <link rel="stylesheet" href="<?= ROOT ?>/output.css">
    <link rel="stylesheet" href="<?= ROOT ?>/css/main.css?random=<?php echo uniqid(); ?>">
    <link rel="stylesheet" href="<?= ROOT ?>/node_modules/tippy.js/dist/themes/light.css">
    <link rel="stylesheet" href="<?= ROOT ?>/node_modules/izitoast/dist/css/iziToast.min.css">

    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

    <?php if (function_exists('customPageHeader')){
        customPageHeader();
    }?>

    <script type="text/javascript">
        const ROOT = '<?= ROOT ?>';
        const readStatusColor = <?= json_encode((array) $read_status_color) ?>;
        const ABSOLUTE_ROOT = '<?= ABSOLUTE_ROOT ?>';
        const readStatusCodes = <?= json_encode((array) readStatusCodeToStdClass($read_status_codes, true)); ?>;
        const readStatusCodes1 = <?= json_encode((array) readStatusCodeToStdClass($read_status_codes, false)); ?>;
        const userBooks = <?= $user_book ? json_encode((array) $user_book) : 'null' ?>;
    </script>

    <style>
        .bg-blue { background: #3490DC; }
        .bg-orange { background: #F6993F; }
        .text-red { color: #E3342F; }
    </style>
</head>

<body class="bg-grey-lighter font-sans antialiased flex flex-col min-h-screen">
  <!--[if lt IE 7]>
    <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="#">upgrade your browser</a> to improve your experience.</p>
  <![endif]-->
<?php
    include_once INC . 'loader.php';
    include_once INC . 'header.php';