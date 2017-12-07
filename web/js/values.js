$(function () {

    $('.values').each(function () {
        if($(this).text() <= 3) {
            $(this).parent().addClass('alert alert-danger');
        };
    });

});