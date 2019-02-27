<button <?= $page <= 1 ? 'disabled' : '' ?> onclick="location.href='<?= merge_querystring(current_url(), '?page=' . ($page-1)) ?>'" class="px-2 py-1 mx-1 hover:bg-grey-light text-grey-darker hover:text-grey-darkest disabled:text-grey-dark"><</button>
<select onchange="location.href='<?= merge_querystring(current_url(), '?page=page_var') ?>'.replace('page_var', this.value)" class="block bg-white border border-grey-light hover:border-grey pl-3 py-1 rounded-sm shadow leading-normal focus:outline-none focus:shadow-outline">
    <?= $total / $rpp ?>
    <?php for ($i = 1; $i < $total / $rpp; $i++) { ?>
        <option value="<?= $i ?>" <?= $page == $i ? 'selected' : '' ?>><?= $i ?></option>
    <?php } ?>
</select>
<button <?= $page >= $total / $rpp  ? 'disabled' : '' ?> onclick="location.href='<?= merge_querystring(current_url(), '?page=' . ($page+1)) ?>'" class="px-2 py-1 mx-1 hover:bg-grey-light text-grey-darker hover:text-grey-darkest">></button>