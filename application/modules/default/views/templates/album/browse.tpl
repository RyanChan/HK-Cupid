<div class="container">
    <div class="row-fluid">
        <h1 class="page-title">
            {translate name="Browse Members"}
        </h1>
        <hr />
    </div>

    <div class="row-fluid">
        <ul class="nav nav-tabs">
            <li class="{if $view == ''}active{/if}">
                <a href="{geturl controller="dating"}">{translate name="All"}</a>
            </li>
            <li class="{if $view == 'newest'}active{/if}">
                <a href="{geturl controller="dating" action="browse" parameters=['view' => 'newest']}">{translate name="Newest"}</a>
            </li>
            <li class="{if $view == 'hottest'}active{/if}">
                <a href="{geturl controller="dating" action="browse" parameters=['view' => 'hottest']}">{translate name="Hottest"}</a>
            </li>
            <li class="{if $view == 'male'}active{/if}">
                <a href="{geturl controller="dating" action="online" parameters=['view' => 'male']}">{translate name="Male"}</a>
            </li>
            <li class="{if $view == 'female'}active{/if}">
                <a href="{geturl controller="dating" action="online" parameters=['view' => 'female']}">{translate name="Female"}</a>
            </li>
        </ul>
    </div>

    <div class="{if $albums|count > 0}row{else}row-fluid{/if}">
        <section>
            <style>
                ul.thumbnails {
                    margin-left: 0px;
                }
            </style>
            {if $albums|count > 0}
                <ul class="thumbnails">
                    {foreach from=$albums item=album}
                        {include file="album/album.tpl" user=$album}
                    {/foreach}
                </ul>
            {else}
                <div class="hero-unit">
                    <p>{translate name="No more albums here!"}</p>
                </div>
            {/if}
        </section>
    </div>
</div>