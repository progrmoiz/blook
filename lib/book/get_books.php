<?php
    function get_books($sort='published', $order='d', $limit=25, $offset=0, $filter_year=null, $filter_month=null) {
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


        $sql = "
        SELECT
            *,
            book.average_rating as avg_rating
        FROM `book`
        WHERE year(published) = COALESCE(:year, year(published))
              AND month(published) = COALESCE(:month, month(published))
        ORDER BY $sort $order
        LIMIT :limit OFFSET :offset
        ";

        $handle = $db->prepare($sql);
        $handle->bindValue(':limit', $limit, PDO::PARAM_INT);
        $handle->bindValue(':offset', $limit * $offset, PDO::PARAM_INT);
        $handle->bindValue(':year', $filter_year, PDO::PARAM_INT);
        $handle->bindValue(':month', $filter_month, PDO::PARAM_INT);
        $handle->execute();

        $result = $handle->fetchAll(\PDO::FETCH_OBJ);

        return $result;
    }