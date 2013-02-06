<style>
    .message-box {
        padding: 15px 15px 15px;
        margin: 0 auto 20px;
        background-color: #fff;
        border: 1px solid #e5e5e5;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        border-radius: 5px;
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
        -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
        box-shadow: 0 1px 2px rgba(0,0,0,.05);
    }
</style>
<div class="container">
    <div class="row-fluid">
        <div class="span8">
            {foreach from=$messages item=message}
                <div class="message-box">
                    <a rel="tooltip" title="{$message->sender->username|escape}" href="{geturl controller="dating" action="user"}/{$message->sender->username|escape}" class="pull-right">
                        <img data-src="holder.js/55x55" src="{imagefile id=$message->sender->getProfileAlbum()->photos->last()->id w=55 h=55}">
                    </a>
                    <h3>{$message->title|escape}</h3>
                    <hr />
                    <div class="message-content">
                        {$message->content}
                    </div>
                    <hr />
                    <div class="message-controls">
                        <a id="message-reply" class="btn"><i class="iconic-arrow-left"></i>&nbsp;{translate name="Reply"}</a>
                        <a id="message-forward" rel="tooltip" title="{translate name="Not Available"}" class="btn"><i class="iconic-arrow-right"></i>&nbsp;{translate name="Forward"}</a>
                        <a href="/message/delete/{$message->id|escape}" class="btn btn-danger pull-right"><i class="iconic-o-x"></i>&nbsp;{translate name="Delete"}</a>
                    </div>
                    {include file="message_compose.tpl" controller=$controller action=$action receiver=$message->sender}
                </div>
            {foreachelse}
                <div class="hero-unit">
                    {translate name="No more messages."}
                </div>
            {/foreach}
            {include file="message_box.tpl" hash=$hash}
        </div>
        <div class="span4">
            <form class="message-box form-search" method="POST" action="/message/search">
                {formhash hash=$hash}
                <fieldset>
                    <legend>{translate name="Search Message"}</legend>
                    <div class="input-append">
                        <input type="text" class="span9 search-query" placeholder="Search content" />
                        <button type="submit" class="btn">{translate name="Search"}</button>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
</div>