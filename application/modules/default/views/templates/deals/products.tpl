<div class="container">
    <div class="row-fluid">
        <h2 class="page-title">
            {$nickname|escape} / Products
        </h2>
    </div>

    <ul class="nav nav-tabs" id="tabs">
        {if $isOwner}
            <li class="active"><a href="#all" data-toggle="tab">{translate name="All"}</a></li>
        {/if}
        <li class="{if !$isOwner}active{/if}"><a href="#on-sale" data-toggle="tab">{translate name="On Sale"}</a></li>
        {if $isOwner}
            <li><a href="#rejected" data-toggle="tab">{translate name="Rejected"}</a>
            <li><a href="#removed-from-sale" data-toggle="tab">{translate name="Removed From Sale"}</a></li>
            <li><a href="#settings" data-toggle="tab">{translate name="Settings"}</a></li>
        {/if}
    </ul>

    <div class="tab-content">
        {if $isOwner}
            <div class="tab-pane active"></div>
        {/if}
        <div class="tab-pane {if !$isOwner}active{/if}" id="on-sale">
            <div class="{if $products|count > 0}row{else}row-fluid{/if}">
                <style>
                    ul.thumbnails {
                        margin-left: 0px;
                    }
                </style>
                {if $products|count > 0}
                    <ul class="thumbnails">
                        {foreach from=$products item=product}
                            {include file="deals/product.tpl" product=$product}
                        {/foreach}
                    </ul>
                {else}
                    <div class="hero-unit">
                        <p>{translate name="No more products here!"}</p>
                    </div>
                {/if}
            </div>
        </div>
        {if $isOwner}
            <div class="tab-pane" id="rejected">
                <div class="{if $products|count > 0}row{else}row-fluid{/if}">
                    <style>
                        ul.thumbnails {
                            margin-left: 0px;
                        }
                    </style>
                    {if $products|count > 0}
                        <ul class="thumbnails">
                            {foreach from=$products item=product}
                                {include file="deals/product.tpl" product=$product}
                            {/foreach}
                        </ul>
                    {else}
                        <div class="hero-unit">
                            <p>{translate name="No more rejected products here!"}</p>
                        </div>
                    {/if}
                </div>
            </div>

            <div class="tab-pane" id="removed-from-sale">
                <div class="{if $products|count > 0}row{else}row-fluid{/if}">
                    <style>
                        ul.thumbnails {
                            margin-left: 0px;
                        }
                    </style>
                    {if $products|count > 0}
                        <ul class="thumbnails">
                            {foreach from=$products item=product}
                                {include file="deals/product.tpl" product=$product}
                            {/foreach}
                        </ul>
                    {else}
                        <div class="hero-unit">
                            <p>{translate name="No more removed from sale products here!"}</p>
                        </div>
                    {/if}
                </div>
            </div>

            <div class="tab-pane" id="settings">
                
            </div>
        {/if}
    </div>
</div>