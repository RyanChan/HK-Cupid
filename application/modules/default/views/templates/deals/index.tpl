<div class="container">
    <div class="row-fluid">
        <h1 class="page-title">
            {translate name="Browse Products"}
        </h1>
        <hr />
    </div>

    <div class="row-fluid">
        <ul class="nav nav-tabs">
            <li class="{if $view == ''}active{/if}">
                <a href="{geturl controller="deals"}">{translate name="All"}</a>
            </li>
            <li class="{if $view == 'newest'}active{/if}">
                <a href="{geturl controller="deals" action="browse" parameters=['view' => 'newest']}">{translate name="Newest"}</a>
            </li>
            <li class="{if $view == 'hottest'}active{/if}">
                <a href="{geturl controller="deals" action="browse" parameters=['view' => 'hottest']}">{translate name="Hottest"}</a>
            </li>
            <li class="{if $view == 'featured'}active{/if}">
                <a href="{geturl controller="deals" action="browse" parameters=['view' => 'featured']}">{translate name="Featured"}</a>
            </li>
            <li class="pull-right">
                <a href="{geturl controller="deals" action="create"}">{translate name="Create Product"}</a>
            </li>
        </ul>
    </div>

    <div class="{if $products|count > 0}row{else}row-fluid{/if}">
        <section>
            <style>
                ul.thumbnails {
                    margin-left: 0px;
                }
            </style>
            {if $products|count > 0}
                <ul class="thumbnails">
                    {foreach from=$products item=product}
                        {include file="deals/product.tpl" user=$product}
                    {/foreach}
                </ul>
            {else}
                <div class="hero-unit">
                    <p>{translate name="No more products here!"}</p>
                </div>
            {/if}
        </section>
    </div>
</div>