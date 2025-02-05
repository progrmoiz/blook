<?php
    // total page count calculation
    $pages = ((int) ceil($total / $rpp));

    // if it's an invalid page request
    if ($current < 1) {
        return;
    } elseif ($current > $pages) {
        return;
    }

    // if there are pages to be shown
    if ($pages > 1 || $alwaysShowPagination === true) {
?>
<ul class="<?= implode(' ', $classes) ?> list-reset mt-6 mb-6">
<?php
        /**
         * Previous Link
         */

        // anchor classes and target
        $classes = array('copy', 'previous', );
        $params = $get;
        $params[$key] = ($current - 1);
        $href = ($target) . '?' . http_build_query($params);
        $href = preg_replace(
            array('/=$/', '/=&/'),
            array('', '&'),
            $href
        );
        if ($current === 1) {
            $href = '#';
            array_push($classes, 'disabled');
        }
?>
    <li class="<?= implode(' ', $classes) ?> float-left px-1 text-sm"><a class="text-grey-dark hover:text-grey-darkest no-underline" href="<?= ($href) ?>"><?= ($previous) ?></a></li>
<?php
        /**
         * if this isn't a clean output for pagination (eg. show numerical
         * links)
         */
        if ($clean === false) {

            /**
             * Calculates the number of leading page crumbs based on the minimum
             *     and maximum possible leading pages.
             */
            $max = min($pages, $crumbs);
            $limit = ((int) floor($max / 2));
            $leading = $limit;
            for ($x = 0; $x < $limit; ++$x) {
                if ($current === ($x + 1)) {
                    $leading = $x;
                    break;
                }
            }
            for ($x = $pages - $limit; $x < $pages; ++$x) {
                if ($current === ($x + 1)) {
                    $leading = $max - ($pages - $x);
                    break;
                }
            }

            // calculate trailing crumb count based on inverse of leading
            $trailing = $max - $leading - 1;

            // generate/render leading crumbs
            for ($x = 0; $x < $leading; ++$x) {

                // class/href setup
                $params = $get;
                $params[$key] = ($current + $x - $leading);
                $href = ($target) . '?' . http_build_query($params);
                $href = preg_replace(
                    array('/=$/', '/=&/'),
                    array('', '&'),
                    $href
                );
?>
    <li class="number float-left px-1 text-sm"><a class="text-grey-dark hover:text-grey-darkest no-underline" data-pagenumber="<?= ($current + $x - $leading) ?>" href="<?= ($href) ?>"><?= ($current + $x - $leading) ?></a></li>
<?php
            }

            // print current page
?>
    <li class="number active float-left px-1 text-sm"><a class="text-grey-darker no-underline" data-pagenumber="<?= ($current) ?>" href="#"><?= ($current) ?></a></li>
<?php
            // generate/render trailing crumbs
            for ($x = 0; $x < $trailing; ++$x) {

                // class/href setup
                $params = $get;
                $params[$key] = ($current + $x + 1);
                $href = ($target) . '?' . http_build_query($params);
                $href = preg_replace(
                    array('/=$/', '/=&/'),
                    array('', '&'),
                    $href
                );
?>
    <li class="number float-left px-1 text-sm"><a class="text-grey-dark hover:text-grey-darkest no-underline" data-pagenumber="<?= ($current + $x + 1) ?>" href="<?= ($href) ?>"><?= ($current + $x + 1) ?></a></li>
<?php
            }
        }

        /**
         * Next Link
         */

        // anchor classes and target
        $classes = array('copy', 'next');
        $params = $get;
        $params[$key] = ($current + 1);
        $href = ($target) . '?' . http_build_query($params);
        $href = preg_replace(
            array('/=$/', '/=&/'),
            array('', '&'),
            $href
        );
        if ($current === $pages) {
            $href = '#';
            array_push($classes, 'disabled');
        }
?>
    <li class="<?= implode(' ', $classes) ?> float-left px-1 text-sm"><a class="text-grey-dark hover:text-grey-darkest no-underline" href="<?= ($href) ?>"><?= ($next) ?></a></li>
</ul>
<?php
    }