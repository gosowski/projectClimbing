$(function () {

    var prevBtn = $('#previous');
    var nextBtn = $('#next');

    var form = $("#answer");
    if(questionId === 1) {
        prevBtn.addClass("disabled");
        prevBtn.attr('disabled', true);
    } else if (questionId === 30) {
        nextBtn.removeClass("btn-outline-primary").addClass("btn-outline-success");
        nextBtn.text("Wynik");
    }

    //event for next button
    $(nextBtn).on('click', function () {

        //if clicked - increment questionId and assign to href attr
        var updateId = questionId+1;
        var newHref = "/question/"+updateId+"/";
       form.attr('action', newHref);
        
    });

    //event for previous button
    $(prevBtn).on('click', function () {

        //if clicked - decrement questionId and assign to href attr
        var updatedId = questionId-1;
        var newHref = "/question/"+updatedId+"/";

        form.attr('action', newHref);
    });

});