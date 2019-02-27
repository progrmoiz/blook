<?php
    function get_book_by_genre($genre, $limit, $offset=0, $sort='title', $order='d', $filter_year=null, $filter_month=null) {
        global $db;

        switch($sort) {
            case 'title':
                $sort = 'title';
                break;
            case 'avg_rating':
                $sort = 'average_rating';
                break;
            case 'date_pub':
                $sort = 'published';
                break;
            default:
                $sort = 'published';
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

        $sql = "SELECT DISTINCT
            id,
            goodread_id,
            title,
            image_url,
            published,
            description
        FROM
            `book`
        INNER JOIN `category` ON goodread_id = category.bookId
        WHERE
            category.name = :genre
        AND year(published) = COALESCE(:year, year(published))
        AND month(published) = COALESCE(:month, month(published))
        ORDER BY
            $sort $order
        LIMIT :limit OFFSET :offset";
        $handle = $db->prepare($sql);
        $handle->bindValue(':genre', $genre);
        $handle->bindValue(':limit', $limit, PDO::PARAM_INT);
        $handle->bindValue(':offset', $offset * $limit, PDO::PARAM_INT);
        $handle->bindValue(':year', $filter_year, PDO::PARAM_INT);
        $handle->bindValue(':month', $filter_month, PDO::PARAM_INT);
        $handle->execute();

        $result = $handle->fetchAll(\PDO::FETCH_OBJ);
        
        return $result;
    }