{if $error|is_array && $error|count > 0 || !$error|is_array && $error|strlen > 0}
    {assign var=hasError value=true}
{else}
    {assign var=hasError value=false}
{/if}

<div class="eight columns bottom-2" {if !$hasError} style="display:none"{/if}>
    <div class="alert error hideit">
        {if $error|is_array}
            {foreach from=$error item=str}
                <p>{$str|escape}</p>
            {/foreach}
        {else}
            <p>{$error|escape}</p>
        {/if}
        <span class="close"></span>
    </div>
</div>