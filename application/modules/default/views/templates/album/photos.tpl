<div class="container">
    <div class="row-fluid">
        <h1 class="page-title">
            {$album->title|escape}
        </h1>
    </div>

    <ul class="nav nav-tabs" id="tabs">
        <li class="active"><a href="#photos" data-toggle="tab">{translate name="Photos"}</a></li>
        <li><a href="#info" data-toggle="tab">{translate name="Info"}</a></li>
        {if $isOwner}
            <li><a href="#upload" data-toggle="tab">{translate name="Upload"}</a>
            <li><a href="#settings" data-toggle="tab">{translate name="Settings"}</a></li>
        {/if}
    </ul>

    <div class="tab-content">
        <div class="tab-pane active" id="photos">
            <div class="{if $photos|count > 0}row{else}row-fluid{/if}">
                <style>
                    ul.thumbnails {
                        margin-left: 0px;
                    }
                </style>
                {if $photos|count > 0}
                    <ul class="thumbnails">
                        {foreach from=$photos item=photo}
                            {include file="album/photo.tpl" action="zoom" photo=$photo}
                        {/foreach}
                    </ul>
                {else}
                    <div class="hero-unit">
                        <p>{translate name="No more albums here!"}</p>
                    </div>
                {/if}
            </div>
        </div>

        <div class="tab-pane" id="info">
            <h3>{translate name="Description"}</h3>
            <hr />
            {$album->getProfile('description')}
        </div>

        {if $isOwner}
            <div class="tab-pane" id="upload">
                <form action="{geturl action="upload" controller="album"}/id/{$album_id|escape}" method="POST" enctype="multipart/form-data">
                    {formhash hash=$hash}
                    <fieldset>
                        <legend>{translate name="Upload your image"}</legend>
                        <div class="fileupload fileupload-new" data-provides="fileupload">
                            <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                                <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&text=no+image" />
                            </div>
                            <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                            <div>
                                <span class="btn btn-file">
                                    <span class="fileupload-new">Select image</span>
                                    <span class="fileupload-exists">Change</span>
                                    <input type="file" name="image" />
                                </span>
                                <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                            </div>
                        </div>
                        <input type="submit" class="btn" value="{translate name="Upload"}" />
                    </fieldset>
                </form>
            </div>

            <div class="tab-pane" id="settings">

            </div>
        {/if}
    </div>
</div>