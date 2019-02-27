<?php
    function get_genre_by_book($book_id) {
        global $db;

        $sql = "SELECT * FROM `category` WHERE `bookId` = :book_id ORDER BY `category`.`count` DESC";
        $handle = $db->prepare($sql);
        $handle->bindValue(':book_id', $book_id, PDO::PARAM_INT);
        $handle->execute();

        $result = $handle->fetchAll(\PDO::FETCH_OBJ);

        return $result;
    }