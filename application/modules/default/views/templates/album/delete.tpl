{include file="header.tpl" title="Albums - Delete album"}

<div class="clearfix container">
    <div class="sixteen columns bottom-2">
        <h2 class="title">
            {translate name="Delete Album"}
            <span class="line"></span>
        </h2>

        <div class="welcome">
            {if $deleted}
                <p>{translate name="Your album have been deleted"}</p>
            {else}
                <p>{translate name="You can't delete this album"}</p>
            {/if}

        </div>
        <a href="/{$nickname|escape}/albums" class="button small color">{translate name="Back to albums"}</a>
    </div>
</div>

{include file="footer.tpl"}