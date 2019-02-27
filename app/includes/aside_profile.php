<div class="hidden absolute pin-b z-10 lg:relative lg:block w-full lg:w-1/5 bg-grey-lighter-2 px-6 pt-10">
<?php if (isUserLoggedIn()) { ?>
    <div class="flex items-center mb-6" id="profile" data-tippy-content="<?= $user->name ?><br>(<?= $user->email ?>)">
    <img draggable="false" class="select-none rounded-full shadow-md transition-normal hover:brighter" width="60px" height="60px" src="<?= $user->avator ?>"/>
    <div  class="ml-3" >
        <p><?= $user->name ?></p>
        <?php
            $date = new DateTime($user->createdAt);
        ?>
        <p class="text-grey-dark mt-1 text-sm">Joined since <?= $date->format("Y") ?></p>
    </div>
    </div>
    <?php
        $sql = "
        SELECT
            userReadStatus.status_id,
            readStatus.status,
            COUNT(*) AS total
        FROM
            userReadStatus
        INNER JOIN readStatus ON readStatus.id = userReadStatus.status_id
        INNER JOIN userAccount ON userAccount.id = userReadStatus.user_id
        WHERE
            userAccount.id = ?
        GROUP BY
            userReadStatus.status_id";
        $handle = $db->prepare($sql);
        $handle->bindValue(1, $user->id, PDO::PARAM_INT);
        $handle->execute();

        $result = $handle->fetchAll(\PDO::FETCH_OBJ);

        $ret = new stdClass;

        foreach ($result as $row) {
            $ret->{$row->status_id} = $row;
        }

        $finished = 1;
        $want_to_read = 3;
        $current_reading = 2;

        $finished_total = isset($ret->{$finished}) ? $ret->{$finished}->total : 0;
        $total = isset($ret->{$want_to_read}) ? $ret->{$want_to_read}->total : 0;
        $total = isset($ret->{$finished}) ? $total + $finished_total : $finished_total;
    ?>

    <div class="my-4 border-t pt-4">
    <h3 class="text-indigo-dark font-normal">You have read <strong><?= $finished_total ?> of <?= $total ?> books</strong> since <?= $date->format("Y") ?></h3>
    <div class="flex flex-wrap -ml-2 justify-start items-center">
        <?php 
            foreach ($user_book as $book) { 
                if ($book->status_id == $finished) {
        ?>
            <a title="<?= $book->title ?>" href="<?= ROOT . '/book/' . $book->book_id?>" class="w-1/6 lg:w-1/5 max-w-tiny block m-2">
                <img src="<?= $book->cover ?>" alt="<?= $book->title ?>" class="shadow-md transition-normal hover:brighter">
            </a>
        <?php
                }
            }
        ?>
    </div>
    </div>
    <div class="mt-6">
    
    <?php
        if (!empty((array) $user_book)) {
            echo '<p class="text-grey-dark mt-1 text-sm">Currently Reading</p>';
        }
            foreach ($user_book as $book) {
                if ($book->status_id == $current_reading) {
                    ?>
            <div class="flex items-start mt-4">
                <img src="<?= $book->cover ?>" alt="read" class="w-1/6 lg:w-1/5 max-w-tiny shadow-md block transition-normal hover:brighter">
                <div class="ml-3">
                <p class="mt-1 leading-normal"><a class="no-underline text-grey-darker hover:text-grey-darkest hover:underline" href="<?= ROOT . '/book/' . $book->book_id?>"><?= $book->title ?></a></p>
                <p class="text-indigo text-sm mt-1"><?= $book->num_pages ?> pages</p>
                </div>
            </div>
        <?php
                }
            }
        ?>
    </div>
<?php } ?>
</div>