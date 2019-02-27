<?php

// change user book status
function change_ub_status($user_id, $book_id, $status_id) {
    global $db;

    $sql = "REPLACE
    INTO userReadStatus(user_id, book_id, status_id)
    VALUES(:user_id, :book_id, :status_id)";

    $handle = $db->prepare($sql);
    $handle->bindValue(':user_id', $user_id);
    $handle->bindValue(':book_id', $book_id);
    $handle->bindValue(':status_id', $status_id);
    $handle->execute();

    return $handle->rowCount() == 1 || $handle->rowCount() == 2;
}

