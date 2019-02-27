<?php
    function delete_user_book($user_id, $book_id) {
        global $db;

        $sql = "DELETE
        FROM
            `userReadStatus`
        WHERE
            user_id = :user_id AND book_id = :book_id";

        $handle = $db->prepare($sql);
        $handle->bindValue(':user_id', $user_id);
        $handle->bindValue(':book_id', $book_id);
        $handle->execute();

        return $handle->rowCount();
    }