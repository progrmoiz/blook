<?php
    function echo_filter_heading($title) {
?>
    <div class="px-6 md:px-0 flex items-baseline justify-between border-b-2 border-grey-light mt-6">
        <h4 class="md:inline-block text-grey-dark font-semibold tracking-wide text-sm font-mono uppercase subpixel-antialiased antialiased"><?= $title ?></h4>
    </div>
<?php
    }