{include file="header.tpl" title="Albums - Edit album"}

<div class="clearfix container">
    <div class="sixteen columns">
        <h1 class="page-title">
            {translate name="Edit Album"} - {$nickname}
            <span class="line"></span>
        </h1>
    </div>
    <div class="sixteen columns">
        <form action="/{$nickname|escape}/albums/edit/{$form->album->id|escape}" enctype="multipart/form-data" method="POST" id="form-album-create" class="form-elements">
            {formhash hash=$hash}
            <fieldset>
                <h3>
                    <label for="album_name">{translate name="Album Name"}</label>
                </h3>
                <input type="text" name="album_name" id="album_name" value="{$form->album_name|escape}" />
            </fieldset>
            <fieldset>
                <h3>
                    <label for="album_status">{translate name="Privacy"}</label>
                </h3>
                {status default=$form->album_status}
            </fieldset>
            <fieldset>
                <h3>
                    <label for="album_description">{translate name="description"}</label>
                </h3>
                <textarea class="ckeditor" name="album_description">{$form->album_description}</textarea>
            </fieldset>
            <fieldset>
                <input type="submit" value="{translate name="Update Album"}" class="button small color" />
                <input type="submit" value="{translate name="Reset"}" class="button small gray" />
            </fieldset>
        </form>
    </div>
    {if $form->hasError()}
        {include file="error.tpl" error=$form->getErrors()}
    {/if}
</div>

{include file="footer.tpl"}