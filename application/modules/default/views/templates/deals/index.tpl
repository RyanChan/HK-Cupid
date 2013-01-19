<div class="clearfix container">
    <div class="sixteen columns">
        <h1 class="page-title">
            {translate name="Browse Products"}
            <span class="line"></span>
        </h1>
    </div>

    <div class="sixteen columns">
        <div class="title clearfix">
            <a href="{geturl controller="deals"}" class="{if $view == ''}color{else}black{/if} button small">{translate name="All"}</a>
            <a href="{geturl controller="deals" parameters=['view' => 'newest']}" class="{if $view == 'newest'}color{else}black{/if} button small">{translate name="Newest"}</a>
            <a href="{geturl controller="deals" parameters=['view' => 'hottest']}" class="{if $view == 'hottest'}color{else}black{/if} button small">{translate name="Hottest"}</a>
            <a href="{geturl controller="deals" parameters=['view' => 'featured']}" class="{if $view == 'featured'}color{else}black{/if} button small">{translate name="Featured"}</a>
        </div>
    </div>

    <div class="clearfix"></div>

    <div class="portfolio">
        <div class="gallery" id="contain">
            {foreach from=$products item=product}
                {include file="deals/product.tpl" action="zoom" user=$product}
            {foreachelse}

            {/foreach}
        </div>
    </div>
</div>