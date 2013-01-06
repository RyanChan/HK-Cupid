{include file="header.tpl" title="Albums - Browse album"}

<div class="clearfix container">
    <div class="sixteen columns">
        <h1 class="page-title">
            {translate name="Browse Album"}
            <span class="line"></span>
        </h1>
    </div>

    <div class="sixteen columns">
        <div class="title clearfix">
            <a href="{geturl controller="album"}" class="{if $view == ''}color{else}black{/if} button small">{translate name="All"}</a>
            <a href="{geturl controller="album" action="browse" parameters=['view' => 'newest']}" class="{if $view == 'newest'}color{else}black{/if} button small">{translate name="Newest"}</a>
            <a href="{geturl controller="album" action="browse" parameters=['view' => 'hottest']}" class="{if $view == 'hottest'}color{else}black{/if} button small">{translate name="Hottest"}</a>
            <a href="{geturl controller="album" action="browse" parameters=['view' => 'male']}" class="{if $view == 'male'}color{else}black{/if} button small">{translate name="Male"}</a>
            <a href="{geturl controller="album" action="browse" parameters=['view' => 'female']}" class="{if $view == 'female'}color{else}black{/if} button small">{translate name="Female"}</a>
        </div>
    </div>

    <div class="clearfix"></div>

    <div class="portfolio">
        <div class="gallery" id="contain">
            {foreach from=$albums item=album}
                {include file="album/album.tpl" action="zoom" album=$album}
            {/foreach}
        </div>
    </div>
</div>

{include file="footer.tpl"}