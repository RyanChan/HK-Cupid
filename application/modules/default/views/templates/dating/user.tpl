<style>

</style>

<div class="container">
    <div class="row-fluid">
        <div class="span3">
            <div class="thumbnail">
                <img data-src="holder.js/270x310" />
            </div>
        </div>

        <div class="span9">
            <h3>{$user->getProfile('nickname')|capitalize:false} {if $user->getAge() != null}({$user->getAge()}){/if}</h3>
            <hr />
            <dl>
                {if $user->getProfile('first_name') !== null && $user->getProfile('last_name') !== null}
                    <dt>{translate name="Real Name"}</dt>
                    <dd>{$user->getProfile('first_name')|escape}, {$user->getProfile('last_name')|escape}</dd>
                {/if}
                {if $user->getProfile('birthday') != null}
                    <dt>{translate name="Birthday"}</dt>
                    <dd>{$user->getProfile('birthday')|date_format:"%B %e, %Y"}</dd>
                {/if}
                {if $user->getProfile('email') !== null}
                    <dt>{translate name="Email Address"}</dt>
                    <dd><a href="mailto:{$user->getProfile('email')|escape}">{$user->getProfile('email')|escape}&nbsp;<i class="icon-envelope"></i></a></dd>
                {/if}
                {if $user->getProfile('gender') !== null}
                    <dt>{translate name="Gender"}</dt>
                    <dd>{$user->getGender()|escape}</dd>
                {/if}
            </dl>

            <a href="#" class="btn"><i class="iconic-heart"></i>&nbsp;{translate name="Like"}</a>
            <a href="#" class="btn btn-info"><i class="iconic-star"></i>&nbsp;{translate name="Follow"}</a>
            <a href="#" class="btn btn-primary"><i class="iconic-mail"></i>&nbsp;{translate name="Send Message"}</a>
        </div>
    </div>
    <hr />
    <div class="row-fluid">
        <ul id="descriptionTabs" class="nav nav-tabs">
            <li class="active"><a href="#intro" data-toggle="tab">{translate name="Intro"}</a></li>
            <li><a href="#activity" data-toggle="tab">{translate name="Activity"}</a></li>
            <li><a href="#recent-albums" data-toggle="tab">{translate name="Recent Photo"}</a></li>
        </ul>
        <div id="descriptionTabsContent" class="tab-content">
            <div class="tab-pane fade in active" id="intro">
                {$user->getProfile('intro')}
            </div>
            <div class="tab-pane fade" id="activity">
                <div class="well">
                    {translate name="No Activity"}
                </div>
            </div>
            <div class="tab-pane fade" id="recent-albums">
                {foreach from=$user->albums item=album}
                    {include file="album/album.tpl" album=$album}
                {foreachelse}
                    <div class="well">
                        {translate name="No Albums"}
                    </div>
                {/foreach}
            </div>
        </div>
    </div>
</div>