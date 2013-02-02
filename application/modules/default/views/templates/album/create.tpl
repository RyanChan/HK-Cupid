<style>
    .form-create-album {
        max-width: 700px;
        padding: 19px 29px 29px;
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
    .form-create-album .form-create-album-heading,
    .form-create-album .checkbox {
        margin-bottom: 10px;
    }
    .form-create-album input[type="text"],
    .form-create-album input[type="password"] {
        font-size: 16px;
        height: auto;
        width:310px;
        margin-bottom: 15px;
        padding: 7px 9px;
    }
</style>

<div class="container">
    <form class="form-create-album" action="{geturl action="create"}" method="POST">
        {formhash hash=$hash}
        <fieldset>
            <legend>{translate name="Create Album"}</legend>

            <label for="album_name">{translate name="Album Name"}</label>
            <input type="text" name="album_name" id="album_name" value="{$form->album_name|escape}" />

            <label for="album_status">{translate name="Privacy"}</label>
            {status default=$form->album_status}

            <label for="album_description">{translate name="Description"}</label>
            <textarea class="ckeditor editor-html" name="album_description">{$form->album_description|escape}</textarea>
        </fieldset>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary pull-right">{translate name="Create Album"}</button>
            <a href="javascript:history.back(1)" class="btn">{translate name="Cancel"}</a>
        </div>
    </form>
</div>
