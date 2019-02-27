<?php
    function get_book_by_ids($ids) {
        global $db;

        $ids = implode(', ', $ids);

        $sql = "SELECT
            book.id,
            book.goodread_id AS goodread_id,
            book.title,
            book.published,
            book.publisher,
            book.description,
            book.language_code,
            book.format,
            book.isbn,
            book.isbn13,
            book.image_url,
            book.average_rating AS avg_rating,
            book.num_pages,
            book.similar_books_id,
            GROUP_CONCAT(author.name ORDER BY book.id) authors
        FROM
            `book`
        INNER JOIN `linkBookAuthor` ON linkBookAuthor.bookId = book.goodread_id
        INNER JOIN `author` ON author.goodread_id = linkBookAuthor.authorId
        WHERE
            book.goodread_id in ($ids)
        GROUP BY book.id";

        $handle = $db->prepare($sql);
        $handle->execute();

        $result = $handle->fetchAll(\PDO::FETCH_OBJ);

        return $result;
    }