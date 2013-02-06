<div class="modal hide fade" id="message-compose">
    <form method="POST" action="/message/compose">
        {formhash hash=$hash}
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3>{translate name="Compose Message"}</h3>
        </div>
        <div class="modal-body">

        </div>
        <div class="modal-footer">
            <a href="#" class="btn" data-dismiss="modal" aria-hidden="true">{translate name="Close"}</a>
            <button class="btn btn-info">{translate name="Compose"}</button>
        </div>
    </form>
</div>