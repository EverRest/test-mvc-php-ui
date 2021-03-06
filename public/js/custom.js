$(document).ready(function (){

    // js events

    $(document).mousemove(function(e){

        var X = e.pageX;
        var Y = e.pageY;

        $('.book-row').on('mouseover', function (e) {
            $(this).find('a.edit-book').show('fast');

            var tip = $('.tool-tip');
            var img = $(this).data('img');

            tip.css({'visibility': 'visible', 'margin-top': e.pageY - 380, 'margin-left': e.pageX + 20});
            tip.find('img').attr('src', img);

            $('.book-row').on('mouseleave', function () {
                tip.css({'visibility': 'hidden'});
                tip.find('img').attr('src', '');
                $(this).find('a.edit-book').hide('fast');
                $('.book-row').off('mouseleave');
            });

        });

    });

    // sorting buttons toggle
    $(document).on('click', '#down-btn', function () {
        $(this).hide('fast');
        $('#up-btn').show('slow');
    });

    $(document).on('click', '#up-btn', function () {
        $(this).hide('fast');
        $('#down-btn').show('slow');
    });

    // redirect to detail

    $(document).on('click', '.book-content', function () {
        var href = window.location.href,
            tmp = false;
        tmp = $(this).next('.edit-book').attr('href').split('/');
        window.location = href + 'detail/' + tmp[tmp.length - 1];

    });


    // display error messages and change url string
    var errors = $('.valid-errors'),
        url = false;

    if (errors.length) {
        errors.css({'color': 'red','font-weight' : 'bold'});
        url = window.location.href;
        var book_id = $('#book_id').length ? $('#book_id').val() : false;
        url = url.split('/');

        // check is edit or create form
        if (book_id) {
            url.length -=2;
            url = url.join('/');
            url += '/edit/' + book_id;
        } else {
            url.length -=1;
            url = url.join('/');
            url += '/create';
        }
        window.history.pushState("", "", url);
    }
});
