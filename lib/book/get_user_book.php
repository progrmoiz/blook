<?php

function get_user_book($user_id, $sort='date_add', $order='d', $limit=25, $offset=0, $filter_status_id=null) {
    global $db;

    switch($sort) {
        case 'title':
            $sort = 'title';
            break;
        case 'author':
            $sort = 'authors';
            break;
        case 'isbn':
            $sort = 'isbn';
            break;
        case 'avg_rating':
            $sort = 'avg_rating';
            break;
        case 'date_pub':
            $sort = 'published';
            break;
        case 'date_add':
            $sort = 'date_added';
            break;
        default:
            $sort = 'date_added';
            break;

    }

    switch($order) {
        case 'a':
            $order = 'ASC';
            break;
        case 'd':
            $order = 'DESC';
            break;
        default:
            $order = 'DESC';
            break;
    }

    $sql = "
    SELECT
        book.id AS book_id,
        readStatus.id AS status_id,
        userAccount.id AS user_id,
        book.title,
        book.published,
        book.publisher,
        book.isbn,
        book.image_url AS cover,
        book.average_rating AS avg_rating,
        book.num_pages,
        readStatus.status,
        userReadStatus.updateAt as date_added,
        GROUP_CONCAT(author.name ORDER BY book.id) authors
    FROM
        `book`
    INNER JOIN `userAccount` INNER JOIN `userReadStatus` ON userReadStatus.user_id = userAccount.id AND userReadStatus.book_id = book.id
    INNER JOIN `readStatus` ON userReadStatus.status_id = readStatus.id
    INNER JOIN `linkBookAuthor` ON linkBookAuthor.bookId = book.goodread_id
    INNER JOIN `author` ON author.goodread_id = linkBookAuthor.authorId
    WHERE
        userAccount.id = :user_id
        AND status_id = COALESCE(:filter_status, status_id)
    GROUP BY book.id
    ORDER BY $sort $order
    LIMIT :limit OFFSET :offset";
    $handle = $db->prepare($sql);
    $handle->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $handle->bindValue(':limit', $limit, PDO::PARAM_INT);
    $handle->bindValue(':offset', $limit * $offset, PDO::PARAM_INT);
    $handle->bindValue(':filter_status', $filter_status_id, PDO::PARAM_INT);
    $handle->execute();

    $result = $handle->fetchAll(\PDO::FETCH_OBJ);

    return $result;
}