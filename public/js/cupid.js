$(function () {
    $("[rel='tooltip']").tooltip();
    $("#notice").modal();

    $("#message-compose-send").click(function (){
        $("#message-compose").modal();
    });

    $("#message-reply").click(function () {
        $("#message-compose").modal();
    });
});