$(function () {
    var message_success = $('<div class="alert alert-success fade in"><button type="button" class="close" data-dismiss="alert">&times;</button>更新成功！</div>');
    var message_error = $('<div class="alert alert-error fade in"><button type="button" class="close" data-dismiss="alert">&times;</button>更新失敗！</div>');
    var current_message;
    $(".form").submit(function (){
        var triggerForm = $(this);

        $.ajax({
            url: triggerForm.attr('action') + "/?format=json",
            type: triggerForm.attr('method'),
            data: triggerForm.serialize()
        }).done(function (data){
            if (current_message)
                current_message.hide("fast");

            var success = data['error'] === true ? true : false;

            if (success) {
                current_message = message_success;
                triggerForm.prepend(current_message.fadeIn("fast"));
            } else {
                current_message = message_error;
                triggerForm.prepend(current_message.fadeIn("fast"));
            }

        }).fail(function (){
            triggerForm.prepend(message_error);
        });

        return false;
    });
});