{include file="header.tpl" title="Upload Photo"}

<div class="clearfix container">
    <div class="sixteen columns">
        <h1 class="page-title">
            {$identity->nickname|escape} / {translate name="Albums"} / <span class="gray2">{translate name="Upload Photo"}</span>
            <span class="line"></span>
        </h1>
    </div>

    <div class="sixteen columns">
        <form action="{geturl action="upload"}" id="form-album-upload" enctype="multipart/form-data" method="POST" class="form-elements">
            <fieldset>
                <label for="image">{translate name="Upload photo"}</label>
                <input type="file" name="image" id="image" />
            </fieldset>
            <fieldset>
                <input type="submit" value="{translate name="Create Album"}" class="button small color" />
                <input type="submit" value="{translate name="Reset"}" class="button small gray" />
            </fieldset>
        </form>
    </div>
</div>

{include file="footer.tpl"}