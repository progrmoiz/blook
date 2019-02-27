<?php
    function get_best_book($limit) {
        global $db;

        $sql = "SELECT id, goodread_id, title, image_url, description FROM `book` ORDER BY `average_rating` DESC LIMIT ?";
        $handle = $db->prepare($sql);
        $handle->bindValue(1, $limit, PDO::PARAM_INT);
        $handle->execute();

        $result = $handle->fetchAll(\PDO::FETCH_OBJ);
        
        return $result;
    }