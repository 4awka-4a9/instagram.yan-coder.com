$(function () {

    $(".follow-btn").click(function () {

        let followID = $(this).data('follow');
        $buttom = $(this);

        if ($(this).hasClass('follow')) {

            $.post(

                BASE_URL + "follow.php",
                {
                    followID: followID,
                },
                function (data) {

                    $buttom.removeClass('follow').addClass('unfollow')
                    $buttom.text('Following');

                }

            )

        } else {

            $.post(

                BASE_URL + "follow.php",
                {
                    unfollowID: followID
                },
                function (data) {

                    $buttom.removeClass('unfollow').addClass('follow');
                    $buttom.text('Follow'); 

                }
            )

        }

    })

})