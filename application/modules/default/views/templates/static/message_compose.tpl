<div class="modal hide fade" id="message-compose">
    <form method="POST" action="{geturl controller="message" action="compose"}">
        {formhash hash=$hash}
        <input type="hidden" name="redirect" value="{geturl controller=$controller action=$action}/{$username|escape}" />
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3>{translate name="Compose Message"}</h3>
        </div>
        <div class="modal-body">
            <fieldset>
                <input type="text" class="" name="message_title" placeholder="{translate name="Title"}" />
                <input type="text" class="pull-right" name="message_receiver" placeholder="{translate name="@Receiver"}" value="@{$receiver->username|escape}" disabled/>
                <input type="hidden" name="message_receiver" value="{$receiver->id}" />
                <hr />
                <textarea class="ckeditor editor-html" name="message_content" id="content" placeholder="Message"></textarea>
            </fieldset>
        </div>
        <div class="modal-footer">
            <a class="btn" data-dismiss="modal" aria-hidden="true">{translate name="Close"}</a>
            <button class="btn btn-info">{translate name="Compose"}</button>
        </div>
    </form>
</div>