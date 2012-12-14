{include file="header.tpl" title="Albums - Browse album"}

<div class="clearfix container">
    <div class="sixteen columns">
        <h1 class="page-title">
            {translate name="Browse Album"}
            <span class="line"></span>
        </h1>
    </div>

    <div class="sixteen columns">
        <div class="title clearfix" id="options">
            <ul class="option-set clearfix" id="filters" data-option-key="filter">
                <li><a href="#filter" data-option-value="*" class="selected">{translate name="All"}</a></li>
                <li><a href="#filter" data-option-value="*">{translate name="All"}</a></li>
                <li><a href="#filter" data-option-value="*">{translate name="All"}</a></li>
                <li><a href="#filter" data-option-value="*">{translate name="All"}</a></li>
                <li><a href="#filter" data-option-value="*">{translate name="All"}</a></li>
            </ul>
        </div>
    </div>

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