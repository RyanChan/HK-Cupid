<div class="container">

    <div class="row-fluid">
        <div class="span9">
            <div class="row-fluid">
                <div class="navbar">
                    <div class="navbar-inner">
                        <a class="brand">{$album->title|escape}</a>
                        <ul class="nav">
                            <li><button id="description-modal" class="btn" data-modal="modal" role="button">{translate name="Description"}</button></li>
                            <li class="divider-vertical"></li>
                            <li><button class="btn btn-info">{translate name="Like"}</button></li>
                            <li class="divider-vertical"></li>
                            <li><button class="btn btn-success">{translate name="Comments"}</button></li>

                        </ul>
                        {if $isOwner}
                            <ul class="nav pull-right">
                                <li>
                                    <div class="btn-group">
                                        <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                            {translate name="Manage"}
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a id="album-form-modal" data-modal="modal" role="button">{translate name="Edit Album"}</a></li>
                                            <li><a id="album-upload-images-modal" data-modal="modal" role="button">{translate name="Upload Images"}</a></li>
                                            <li><a id="delete-image">{translate name="Delete Images"}</a></li>
                                        </ul>
                                    </div>

                                </li>
                                <li class="divider-vertical"></li>
                                <li><button class="btn btn-danger">{translate name="Delete"}</button></li>
                            </ul>
                        {/if}
                    </div>
                </div>
            </div>
            <div class="row-fluid">
                <div id="gallery" data-toggle="modal-gallery" data-target="#modal-gallery" class="container-fluid">
                    <style>
                        a.photo {
                            margin:5px;
                        }

                        a.photo img {
                            height:81px;
                            width:81px;
                        }
                    </style>
                    {foreach from=$photos item=photo}
                        {include file="album/photo.tpl" photo=$photo}
                    {/foreach}
                </div>
                {gallery}
            </div>
        </div>
        <div class="span3">

        </div>
    </div>
    {*
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
    <li class="pull-right">
    <a href="/{$album->user->getProfile('nickname')|escape}/albums">{translate name="Back to Albums"}</a>
    </li>
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
    <div id="gallery" data-toggle="modal-gallery" data-target="#modal-gallery">
    <ul class="thumbnails">
    {foreach from=$photos item=photo}
    {include file="album/photo.tpl" photo=$photo}
    {/foreach}
    </ul>
    </div>
    {else}
    <div class="hero-unit">
    <p>{translate name="No more photos here!"}</p>
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

    <form id="fileupload" class="form" action="{geturl action="upload" controller="album"}/id/{$album_id|escape}" method="POST" enctype="multipart/form-data">
    <!-- Redirect browsers with JavaScript disabled to the origin page -->
    <noscript><input type="hidden" name="redirect" value="{geturl action="upload" controller="album"}/id/{$album_id|escape}"></noscript>
    <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
    <div class="row fileupload-buttonbar">
    <div class="span7">
    <!-- The fileinput-button span is used to style the file input field as button -->
    <span class="btn btn-success fileinput-button">
    <i class="icon-plus icon-white"></i>
    <span>Add files...</span>
    <input type="file" name="files[]" multiple>
    </span>
    <button type="submit" class="btn btn-primary start">
    <i class="icon-upload icon-white"></i>
    <span>Start upload</span>
    </button>
    <button type="reset" class="btn btn-warning cancel">
    <i class="icon-ban-circle icon-white"></i>
    <span>Cancel upload</span>
    </button>
    <button type="button" class="btn btn-danger delete">
    <i class="icon-trash icon-white"></i>
    <span>Delete</span>
    </button>
    <input type="checkbox" class="toggle">
    </div>
    <!-- The global progress information -->
    <div class="span5 fileupload-progress fade">
    <!-- The global progress bar -->
    <div class="progress progress-success progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
    <div class="bar" style="width:0%;"></div>
    </div>
    <!-- The extended global progress information -->
    <div class="progress-extended">&nbsp;</div>
    </div>
    </div>
    <!-- The loading indicator is shown during file processing -->
    <div class="fileupload-loading"></div>
    <br>
    <!-- The table listing the files available for upload/download -->
    <table role="presentation" class="table table-striped"><tbody class="files" data-toggle="modal-gallery" data-target="#modal-gallery"></tbody></table>
    </form>

    <!--                <form action="{geturl action="upload" controller="album"}/id/{$album_id|escape}" method="POST" enctype="multipart/form-data">
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

    <div id="fileupload">
    <div class="fileupload-buttonbar">
    <label class="fileupload-button">
    <span>Add files...</span>
    <input type="file" name="files[]" multiple />
    </label>
    </div>
    </div>
    <input type="submit" class="btn" value="{translate name="Upload"}" />
    </fieldset>
    </form>-->
    </div>

    <div class="tab-pane" id="settings">
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
    <form class="form-create-album" action="/{$album->user->username|escape}/albums/edit/{$album->id|escape}" method="POST">
    {formhash hash=$hash}
    <fieldset>
    <legend>{translate name="Edit Album"}</legend>

    <label for="album_name">{translate name="Album Name"}</label>
    <input type="text" name="album_name" id="album_name" value="{$album->title|escape}" />

    <label for="album_status">{translate name="Privacy"}</label>
    {status default=$album->getProfile('privacy')}

    <label for="album_description">{translate name="Description"}</label>
    <textarea class="ckeditor editor-html" name="album_description">{$album->getProfile('description')}</textarea>
    </fieldset>
    <div class="form-actions">
    <button type="submit" class="btn btn-primary pull-right">{translate name="Update Album"}</button>
    </div>
    </form>
    </div>
    </div>
    {/if}
    </div>
    *}
</div>

<div id="description" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="descriptionLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="descriptionLabel">{translate name="Description"}</h3>
    </div>
    <div class="modal-body" style="">
        {$album->getProfile('description')}
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">{translate name="Close"}</button>
    </div>
</div>
<div id="album-upload-images" class="modal hide fade" style="width:750px; margin-left: -375px;" tabindex="-1" role="dialog" aria-labelledby="album-upload-imagesLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="album-upload-imagesLabel">{translate name="Upload Images"}</h3>
    </div>
    <div class="modal-body">
        <form id="fileupload" class="form" action="{geturl action="upload" controller="album"}/id/{$album_id|escape}" method="POST" enctype="multipart/form-data">
            <!-- Redirect browsers with JavaScript disabled to the origin page -->
            <noscript><input type="hidden" name="redirect" value="{geturl action="upload" controller="album"}/id/{$album_id|escape}"></noscript>
            <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
            <div class="row fileupload-buttonbar">
                <div class="span7">
                    <!-- The fileinput-button span is used to style the file input field as button -->
                    <span class="btn btn-success fileinput-button">
                        <i class="icon-plus icon-white"></i>
                        <span>Add files...</span>
                        <input type="file" name="files[]" multiple>
                    </span>
                    <button type="submit" class="btn btn-primary start">
                        <i class="icon-upload icon-white"></i>
                        <span>Start upload</span>
                    </button>
                    <button type="reset" class="btn btn-warning cancel">
                        <i class="icon-ban-circle icon-white"></i>
                        <span>Cancel upload</span>
                    </button>
                    <button type="button" class="btn btn-danger delete">
                        <i class="icon-trash icon-white"></i>
                        <span>Delete</span>
                    </button>
                    <input type="checkbox" class="toggle">
                </div>
                <!-- The global progress information -->
                <div class="span5 fileupload-progress fade">
                    <!-- The global progress bar -->
                    <div class="progress progress-success progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                        <div class="bar" style="width:0%;"></div>
                    </div>
                    <!-- The extended global progress information -->
                    <div class="progress-extended">&nbsp;</div>
                </div>
            </div>
            <!-- The loading indicator is shown during file processing -->
            <div class="fileupload-loading"></div>
            <br>
            <!-- The table listing the files available for upload/download -->
            <table role="presentation" class="table table-striped"><tbody class="files" data-toggle="modal-gallery" data-target="#modal-gallery"></tbody></table>
        </form>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">{translate name="Close"}</button>
    </div>
</div>
<div id="album-form" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="album-formLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="album-formLabel">{translate name="Album Form"}</h3>
    </div>
    <div class="modal-body">
        <style>
            .form-create-album {
                max-width: 500px;
                padding: 19px 29px 29px;
                /*margin: 0 auto 20px;*/
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

        <form class="form-create-album" action="/{$album->user->username|escape}/albums/edit/{$album->id|escape}" method="POST">
            {formhash hash=$hash}
            <fieldset>
                <legend>{translate name="Edit Album"}</legend>

                <label for="album_name">{translate name="Album Name"}</label>
                <input type="text" name="album_name" id="album_name" value="{$album->title|escape}" />

                <label for="album_status">{translate name="Privacy"}</label>
                {status default=$album->getProfile('privacy')}

                <label for="album_description">{translate name="Description"}</label>
                <textarea class="ckeditor editor-html" name="album_description">{$album->getProfile('description')}</textarea>
            </fieldset>
            <div class="form-actions">
                <button type="submit" class="btn btn-primary pull-right">{translate name="Update Album"}</button>
            </div>
        </form>

    </div>
    <div class="modal-footer">
        <button class="btn btn-primary" id="album-update">{translate name="Update"}</button>
        <button class="btn" data-dismiss="modal" aria-hidden="true">{translate name="Close"}</button>
    </div>
</div>
<!-- The template to display files available for upload -->
<script id="template-upload" type="text/x-tmpl">
    {literal}
        {% for (var i=0, file; file=o.files[i]; i++) { %}
        <tr class="template-upload fade">
            <td class="preview"><span class="fade"></span></td>
            <td class="name"><span>{%=file.name%}</span></td>
            <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
            {% if (file.error) { %}
            <td class="error" colspan="2"><span class="label label-important">Error</span> {%=file.error%}</td>
            {% } else if (o.files.valid && !i) { %}
            <td>
                <div class="progress progress-success progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="bar" style="width:0%;"></div></div>
            </td>
            <td class="start">{% if (!o.options.autoUpload) { %}
                <button class="btn btn-primary">
                    <i class="icon-upload icon-white"></i>
                    <span>Start</span>
                </button>
                {% } %}</td>
            {% } else { %}
            <td colspan="2"></td>
            {% } %}
            <td class="cancel">{% if (!i) { %}
                <button class="btn btn-warning">
                    <i class="icon-ban-circle icon-white"></i>
                    <span>Cancel</span>
                </button>
                {% } %}</td>
        </tr>
        {% } %}
    {/literal}
</script>
<!-- The template to display files available for download -->
<script id="template-download" type="text/x-tmpl">
    {literal}
        {% for (var i=0, file; file=o.files[i]; i++) { %}
        <tr class="template-download fade">
            {% if (file.error) { %}
            <td></td>
            <td class="name"><span>{%=file.name%}</span></td>
            <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
            <td class="error" colspan="2"><span class="label label-important">Error</span> {%=file.error%}</td>
            {% } else { %}
            <td class="preview">{% if (file.thumbnail_url) { %}
                <a href="{%=file.url%}" title="{%=file.name%}" data-gallery="gallery" download="{%=file.name%}"><img src="{%=file.thumbnail_url%}"></a>
                {% } %}</td>
            <td class="name">
                <a href="{%=file.url%}" title="{%=file.name%}" data-gallery="{%=file.thumbnail_url&&'gallery'%}" download="{%=file.name%}">{%=file.name%}</a>
            </td>
            <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
            <td colspan="2"></td>
            {% } %}
            <td class="delete">
                <button class="btn btn-danger" data-type="{%=file.delete_type%}" data-url="{%=file.delete_url%}"{% if (file.delete_with_credentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
                        <i class="icon-trash icon-white"></i>
                    <span>Delete</span>
                </button>
                <input type="checkbox" name="delete" value="1">
            </td>
        </tr>
        {% } %}
    {/literal}
</script>
<script src="/js/photo-main.js"></script>
<script>
    {literal}
        $(function (){
            $("#description-modal").click(function (){
                $("#description").modal('show');
            });

            $("button#album-update").click(function (){
                $(".form-create-album").submit();
            });

            $("#album-form-modal").click(function (){
                $("#album-form").modal('show');
            });

            $("#album-upload-images-modal").click(function (){
                $("#album-upload-images").modal('show');
            });
        });
    {/literal}
</script>
