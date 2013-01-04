{include file="header.tpl" title=$title}

<div class="clearfix container">
    <div class="sixteen columns">
        <h1 class="page-title">
            {translate name="Browse Members"}
            <span class="line"></span>
        </h1>
    </div>

    <div class="sixteen columns">
        <div class="title clearfix" id="options">
            <ul class="option-set clearfix" id="filters" data-option-key="filter">
                <li><a href="#filter" data-option-value="*" class="selected">{translate name="All"}</a></li>
            </ul>
        </div>
    </div>

    <div class="clearfix"></div>

    <div class="portfolio">
        <div class="gallery" id="contain">
            {foreach from=$users item=user}
                {include file="dating/member.tpl" action="link" user=$user}
            {foreachelse}

            {/foreach}
        </div>
    </div>
</div>

{include file="footer.tpl"}