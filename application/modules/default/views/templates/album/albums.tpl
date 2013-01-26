<div class="container">
    <div class="row-fluid">
        <h2 class="page-title">
            {$nickname|escape} / Albums
        </h2>
    </div>

    <ul class="nav nav-tabs" id="tabs">
        <li class="active"><a href="#all" data-toggle="tab">{translate name="All"}</a></li>
        {if $authenticated}
            <li class="pull-right">
                <a href="/{$identity->nickname|escape}/albums/create">{translate name="Create Album"}</a>
            </li>
        {/if}
    </ul>

    <div class="tab-content">
        <div class="tab-pane active" id="on-sale">
            <div class="{if $albums|count > 0}row{else}row-fluid{/if}">
                <style>
                    ul.thumbnails {
                        margin-left: 0px;
                    }
                </style>
                {if $albums|count > 0}
                    <ul class="thumbnails">
                        {foreach from=$albums item=album}
                            {include file="album/album.tpl" product=$album isOwner=$isOwner}
                        {/foreach}
                    </ul>
                {else}
                    <div class="hero-unit">
                        <p>{translate name="No more albums here!"}</p>
                    </div>
                {/if}
            </div>
        </div>
    </div>
</div>
            