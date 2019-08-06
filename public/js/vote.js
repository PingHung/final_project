$('.vote').on('click', function (event) {
    event.preventDefault();
    answerId = event.target.parentNode.parentNode.dataset['answerid'];
    var isVote = event.target.previousElementSibling == null;
    $.ajax({
        method: 'POST',
        url: urlVote,
        data: {isVote: isVote, answerId: answerId, _token: token},
    })
        .done(function() {

        });
});