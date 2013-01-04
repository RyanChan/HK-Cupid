{include file="header.tpl" title="Albums"}

<div class="clearfix container">
    <div class="sixteen columns">
        <h1 class="page-title">
            {$identity->nickname|escape} / <span class="gray2">{translate name="Albums"}</span>
            <span class="line"></span>
        </h1>
    </div>

    <div class="sixteen columns">
        <div id="options">
            <ul class="clearfix">
                <li><a href="/{$identity->nickname|escape}/albums/create">{translate name="Create Album"}</a></li>
            </ul>
        </div>
    </div>

    <div class="clearfix"></div>

    <div class="portfolio">
        <div class="gallery" id="contain">
            {foreach from=$albums item=album}
                {include file="album/album.tpl" action="link" album=$album}
            {/foreach}
        </div>
    </div>
</div>

{include file="footer.tpl"}