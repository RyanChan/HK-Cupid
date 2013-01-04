{include file="header.tpl" title="Photos"}

<div class="clearfix container">

    <div class="sixteen columns">
        <h1 class="page-title">
            {$album->user->getProfile('nickname')|escape} / {translate name="Albums"} / <span class="gray2">{translate name="Photos"}</span>
            <span class="line"></span>
        </h1>
    </div>

    {if $isOwner}
        <div class="sixteen columns">
            <h2 class="title">
                {translate name="Upload your photo"}
                <span class="line"></span>
            </h2>
            <form action="{geturl action="upload" controller="album"}/id/{$album_id|escape}" id="form-album-upload" enctype="multipart/form-data" method="POST" class="form-elements">
                <fieldset>
                    <input type="file" name="image" id="image" />
                    <input type="submit" value="{translate name="Upload Photo"}" class="button small color" />
                </fieldset>
            </form>
        </div>


    {/if}
    <div class="sixteen columns">
        <h2 class="title">
            {$album->title|escape}
            <span class="line"></span>
        </h2>
    </div>

    <div class="clearfix"></div>

    <div class="portfolio">
        <div class="gallery" id="contain">
            {foreach from=$photos item=photo}
                {include file="album/photo.tpl" action="zoom" photo=$photo}
            {/foreach}
        </div>
    </div>

    <div class="clearfix"></div>
</div>

{include file="footer.tpl"}