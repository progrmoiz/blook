<?php

function get_user_genre($user_id) {
    global $db;

    $sql = "SELECT * FROM `userFavoriteCategory` WHERE user_id = :user_id";

    $handle = $db->prepare($sql);
    $handle->bindValue(':user_id', $user_id);
    $handle->execute();

    $result = $handle->fetchAll(\PDO::FETCH_OBJ);

    $ret = new stdClass;
    foreach ($result as $row) {
        $ret->{$row->genre} = $row;
    }

    return $ret;
}