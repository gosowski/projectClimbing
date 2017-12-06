$(function () {
    var prevBtn = $('#previous');
    var nextBtn = $('#next');

    if(questionId == 1) {
        prevBtn.addClass("disabled");
    } else if (questionId == 30) {
        nextBtn.addClass("disabled");
    }

    //event for next button
    $(nextBtn).on('click', function () {

        //if clicked - increment questionId and assign to href attr
        var updateId = questionId+1;
        var newHref = "/question/"+updateId+"/";

        nextBtn.attr("href", newHref);

    });

    //event for previous button
    $(prevBtn).on('click', function () {

        //if clicked - decrement questionId and assign to href attr
        var updatedId = questionId-1;
        var newHref = "/question/"+updatedId+"/";

        prevBtn.attr('href', newHref);
    });

});