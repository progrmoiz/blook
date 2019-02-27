<?php if (!isMobile()) { ?>
<div class="hidden p-4" id="popup">
    <h3 class="font-medium">{{ title }}</h3>
    <div class="relative text-xl p-0 text-grey inline-block">
        <div class="text-indigo p-0 absolute z-10 block pin-l overflow-hidden " style="width: {{ perc }}%"><span>★</span><span>★</span><span>★</span><span>★</span><span>★</span></div>
        <div class="z-0"><span>☆</span><span>☆</span><span>☆</span><span>☆</span><span>☆</span></div>
    </div>
    <p class="text-sm mt-2 mb-3">{{ desc }}</p>
    <div class="relative">
        <select <?= isUserLoggedIn() ? '' :'onclick="location.href = \'' . ROOT . '/login\'"' ?> value="2" onchange="popupChangeStatusHandler(this, &quot;{{ title }}&quot;)" data-book_id="{{ id }}" class="js-change-status block appearance-none w-full text-sm bg-white border border-grey-light hover:border-grey pl-3 py-1 pr-8 rounded shadow leading-normal focus:outline-none focus:shadow-outline" id="tippy-select">
            <option selected value='' disabled>Add to</option>
            <?php foreach($read_status_codes as $s) {
                echo "<option value='$s->id'>$s->status_alt</option>";
            } ?>
        </select>
        <div class="pointer-events-none absolute pin-y pin-r flex items-center px-2 text-grey-darker">
        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
            <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
        </svg>
        </div>
    </div>
</div>
<?php } ?>