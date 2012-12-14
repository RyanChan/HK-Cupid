{include file="header.tpl" title="Albums"}

<div class="clearfix container">

    <div class="sixteen columns">
        <h1 class="page-title">
            {translate name="Albums"}
            <span class="line"></span>
        </h1>
        <div class="title clearfix" id="options">
            <ul class="option-set clearfix" id="filters" data-option-key="filter">
                <li><a href="#filter" data-option-value="*" class="selected">{translate name="All"}</a></li>
            </ul>
        </div>
    </div>

    {include file="breadcrum.tpl"}

    <div class="clearfix"></div>

    <div class="portfolio">
        <div class="gallery" id="contain">
            {for $i=0 to 12}
            {include file="album/album.tpl" action="link"}
            {/for}
        </div>
    </div>
</div>

{include file="footer.tpl"}