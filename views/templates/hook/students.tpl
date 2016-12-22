<div id="testmodule_block" class="block">
    <h3>Students</h3>
    <ul>
        {foreach from=$students item=foo}
            <li>{$foo}</li>
        {/foreach}
    </ul>
    <p>Лучший ученик: {$students2}</p>
    <p>Максимальный средний балл: {$students3|string_format:"%.2f"}</p>
</div>