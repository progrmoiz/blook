<?php
    function get_genre_list($limit=120, $offset) {
        global $db;

        $sql = "SELECT COUNT(bookId) as num_books, name FROM `category` GROUP BY name LIMIT ? OFFSET ?";
        $handle = $db->prepare($sql);
        $handle->bindValue(1, $limit, PDO::PARAM_INT);
        $handle->bindValue(2, $offset * $limit, PDO::PARAM_INT);
        $handle->execute();

        $result = $handle->fetchAll(\PDO::FETCH_OBJ);

        return $result;
    }