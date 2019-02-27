<?php

function get_user_by_uname($uname) {
    global $db;

    $sql = "SELECT * FROM `userAccount` WHERE `username` = ?";

    $handle = $db->prepare($sql);
    $handle->bindValue(1, $uname);
    $handle->execute();

    $result = $handle->fetchAll(\PDO::FETCH_OBJ);

    // $user = new stdClass;
    // $user->username  = $result[0]->username;
    // $user->name      = $result[0]->name;
    // $user->email     = $result[0]->email;
    // $user->createdAt = $result[0]->createdAt;
    // $user->isAdmin   = $result[0]->isAdmin;

    return !empty($result) ? $result[0] : null;
}