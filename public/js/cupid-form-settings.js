$(function () {
    var message_success = $('<div class="alert alert-success fade in"><button type="button" class="close" data-dismiss="alert">&times;</button>更新成功！</div>');
    var message_error = $('<div class="alert alert-error fade in"><button type="button" class="close" data-dismiss="alert">&times;</button>更新失敗！</div>');
    var current_message;
    $("form#form-general").submit(function () {
        var form_general = $(this);
        $.ajax({
            url: "/account/general/?format=json",
            type: "POST",
            data: form_general.serialize()
        }).done(function (data){
            if (current_message)
                current_message.hide("fast");

            var success = data['error'] == true ? true : false;

            if (success) {
                current_message = message_success;
                form_general.prepend(current_message.fadeIn("fast"));
            } else {
                current_message = message_error;
                form_general.prepend(current_message.fadeIn("fast"));
            }

        }).fail(function (){
            form_general.prepend(message_error);
        });
        return false;
    });

    $("form#form-profile").submit(function (){
        var form_profile = $(this);
        $.ajax({
            url: '/account/profile/?format=json',
            type: "POST",
            data: form_general.serialize()
        }).done(function (data) {
            if (current_message)
                current_message.hide();

            var success = $data['error'] == true ? true : false;

            if (success) {
                current_message = message_success;
                form_profile.prepend(current_message.fadeIn("fast"));
            } else {
                current_message = message_error;
                form_profile.prepend(current_message.fadeIn("fast"));
            }
        }).fail(function (){
            form_general.prepend(message_error);
        });;
    });
});