<?php

function update_genre($user_id, $genre, $removed=false) {
    global $db;

    if (is_array($genre)) {
        if ($removed) {
            $sql = 'DELETE FROM `userFavoriteCategory` WHERE user_id = :user_id AND genre IN ("' . implode('", "', $genre) . '")';
        } else {
            $sql = "REPLACE INTO userFavoriteCategory(user_id, genre) VALUES";
            $tmp = array();
            foreach ($genre as $g) {
                $tmp[] = "($user_id, '$g')";
            }
            $sql .= implode(", ", $tmp);
        }
    } else {
        if ($removed) {
            $sql = "DELETE FROM `userFavoriteCategory` WHERE user_id = :user_id AND genre = :genre";
        } else {
            $sql = "INSERT INTO userFavoriteCategory(user_id, genre) VALUES(:user_id, :genre)";
        }
    }

    $handle = $db->prepare($sql);
    $handle->bindValue(':user_id', $user_id);
    if (!is_array($genre)) {
        $handle->bindValue(':genre', $genre);
    }
    $handle->execute();

    return $handle->rowCount();
}