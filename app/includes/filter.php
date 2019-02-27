<div class="navigation text-xs mt-5 flex p-2 flex-row justify-end">
<div class="flex items-center px-2 border-r border-grey-light">
    <span class="font-mono mr-2 text-grey-darker">Sort by: </span>
    <select onchange="location.href='<?= merge_querystring(current_url(), '?sort=sort_var&order=order_var') ?>'.replace('sort_var', this.value.split('-')[0]).replace('order_var', this.value.split('-')[1])" name="sort" class="block bg-white border border-grey-light hover:border-grey pl-3 py-1 rounded-sm shadow leading-normal focus:outline-none focus:shadow-outline">
    <option value="" disabled selected>Sort by</option>
    <?php foreach($sorts as $s) { ?>
        <?php foreach ($orders as $o) {
        if ($o == 'a') {
            $oo = 'ASC';
        } else if ($o == 'd') {
            $oo = 'DESC';
        }
        ?>
        <option <?= $s == $sort && $o == $order ? 'selected' : '' ?> value="<?= $s . '-' . $o ?>"><?= $s . ' (' . $oo . ')' ?></option>
        <?php } ?>
    <?php } ?>
    </select>
</div>
<div class="flex items-center px-2 border-r border-grey-light">
<select onchange="location.href='<?= merge_querystring(current_url(), '?result=result_var') ?>'.replace('result_var', this.value)" name="result" class="block bg-white border border-grey-light hover:border-grey pl-3 py-1 rounded-sm shadow leading-normal focus:outline-none focus:shadow-outline">
    <option value="" disabled selected>No. of Books</option>
    <option value='25' <?= $rpp == 25 ? 'selected' : '' ?>>25 Books</option>
    <option value='50' <?= $rpp == 50 ? 'selected' : '' ?>>50 Books</option>
    <option value='75' <?= $rpp == 75 ? 'selected' : '' ?>>75 Books</option>
    <option value='100' <?= $rpp == 100 ? 'selected' : '' ?>>100 Books</option>
</select>
</div>
<div class="flex items-center px-2 border-r border-grey-light">
<select onchange="location.href='<?= merge_querystring(current_url(), '?year=year_var') ?>'.replace('year_var', this.value)" name="year" class="block bg-white border border-grey-light hover:border-grey pl-3 py-1 rounded-sm shadow leading-normal focus:outline-none focus:shadow-outline">
    <option value="" disabled selected>Year</option>
    <?php
    $sql = 'SELECT year(MIN(published)) AS min_year, year(MAX(published)) AS max_year FROM book';
    $handle = $db->prepare($sql);
    $handle->execute();
    $result = $handle->fetchAll(\PDO::FETCH_OBJ)[0];
    $max_year = $result->max_year;
    $min_year = $result->min_year;
    for ($y = $min_year; $y <= $max_year; $y++) {
        echo "<option value=$y " . ($year == $y ? 'selected' : '') .">$y</option>";
    }
    ?>
</select>
</div>
<div class="flex items-center px-2">
<select onchange="location.href='<?= merge_querystring(current_url(), '?month=month_var') ?>'.replace('month_var', this.value)" name="month" class="block bg-white border border-grey-light hover:border-grey pl-3 py-1 rounded-sm shadow leading-normal focus:outline-none focus:shadow-outline">
    <option value="" disabled selected>Month</option>
    <?php
    $months = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
    foreach ($months as $i => $m) {
        $i++;
        echo "<option value=$i " . ($month == $i ? 'selected' : '') . ">$m</option>";
    }
    ?>
</select>
</div>


</div>