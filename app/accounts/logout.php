<?php

session_start();
session_unset();
session_destroy();

if ($location) {
    header("Location: " . $location);
} else {
    header("Location: " . ROOT);
}
exit();