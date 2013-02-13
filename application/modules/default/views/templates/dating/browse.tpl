<div class="container">
    <div class="row-fluid">
        <h1 class="page-title">
            {translate name="Browse Members"}
        </h1>
        <hr />
    </div>

    <div class="row-fluid">
        <div class="span9">
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
    </div>

    <div class="row-fluid">
        <div class="span9">
            <style>
                .thumbnail-fixed {
                    width:200px;
                    height:308px;
                }

                .thumbnail-fixed-image {
                    width:133px;
                    height:200px;
                }
            </style>
            <section>
                {if $users|count > 0}
                    <ul class="thumbnails">
                        {foreach from=$users item=user}
                            {include file="dating/member.tpl" user=$user}
                        {/foreach}
                    </ul>
                {else}
                    <div class="hero-unit">
                        <p>{translate name="No more members here!"}</p>
                    </div>
                {/if}
            </section>
        </div>
        <div class="span3">
            <div class="row-fluid">
                <div class="fb-like-box" data-href="http://www.facebook.com/pages/HK-Cupid/115325478649360" data-width="270" data-show-faces="true" data-stream="true" data-header="true"></div>
            </div>
        </div>
    </div>
</div>