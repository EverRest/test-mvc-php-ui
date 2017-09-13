(function () {
    // get 3 books desc
    $(document).on('click', '#up-btn', function () {
        sort('desc');
    });

    // get 3 books asc
    $(document).on('click', '#down-btn', function () {
        sort('asc');
    });

})();

function sort(type) {

    $.ajax({
        type: "POST",
        url: "sort",
        data: {
            'type': type
        },
        success: function(res){
            data = JSON.parse(res);
            if (data.error === false) {
                displayBooks(data.books);
            } else {
                alert(data.message);
            }

        }
    });
}

function displayBooks(books) {
    var book = false,
        row = false,
        rows = $('.book-row'),
        url = '';

    $('.book-content').empty();

    for (i = 0; i < books.length; i++) {
        book = books[i];
        row = $('#book-' + i);
        url = $('tbody').data('url');

        row.data('img', url + book.photo);
        row.find('.td-title .book-content').html(book.title);
        row.find('.td-author .book-content').html(book.author.name);
        row.find('.td-genre .book-content').html(book.genre.name);
        row.find('.td-year .book-content').html(book.year);
        row.find('.td-language .book-content').html(book.language);
        row.find('.td-code .book-content').html(book.code);

    }
}
