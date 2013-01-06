{include file="header.tpl" title=$title}

<div class="clearfix container">
    <div class="sixteen columns">
        <h1 class="page-title">
            {translate name="Browse Members"}
            <span class="line"></span>
        </h1>
    </div>

    <div class="sixteen columns">
        <div class="title clearfix">
            <a href="{geturl controller="dating"}" class="{if $view == ''}color{else}black{/if} button small">{translate name="All"}</a>
            <a href="{geturl controller="dating" action="browse" parameters=['view' => 'newest']}" class="{if $view == 'newest'}color{else}black{/if} button small">{translate name="Newest"}</a>
            <a href="{geturl controller="dating" action="browse" parameters=['view' => 'hottest']}" class="{if $view == 'hottest'}color{else}black{/if} button small">{translate name="Hottest"}</a>
            <a href="{geturl controller="dating" action="online" parameters=['view' => 'male']}" class="{if $view == 'male'}color{else}black{/if} button small">{translate name="Male"}</a>
            <a href="{geturl controller="dating" action="online" parameters=['view' => 'female']}" class="{if $view == 'female'}color{else}black{/if} button small">{translate name="Female"}</a>
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