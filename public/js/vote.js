    $('.vote').on('click', function (event) {
        event.preventDefault();
        answerId = event.target.parentNode.parentNode.dataset['answerid'];
        var isVote = event.target.previousElementSibling == null;
        $.ajax({
            method: 'POST',
            url: urlVote,
            data: {isVote: isVote, answerId: answerId, _token: token},
        })
            .done(function () {
                event.target.innerText = isVote ? event.target.innerText == 'Vote Up' ? 'You vote up this answer' : 'Vote Up' : event.target.innerText == 'Vote Down' ? 'You vote down this answer' : 'Vote Down';
                if (isVote) {
                    event.target.nextElementSibling.innerText = 'Vote Down';
                } else {
                    event.target.previousElementSibling.innerText = 'Vote Up';
                }
            });
    });