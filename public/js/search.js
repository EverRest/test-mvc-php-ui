(function () {
    $(document).on('click', '#search-sbt', function (e) {
        var search = $('#search').val();
        e.preventDefault();
        if (search.length > 3) {
            $('#search').val('');
            $.ajax({
                type: "POST",
                url: "/search",
                data: {
                    'search': search
                },
                success: function(res){
                    data = JSON.parse(res);
                    if (data.error === false) {
                        displaySearchResult(data.books);
                    } else {
                        alert(data.message);
                    }

                }
            });

        } else {
            alert('Plese enter more then 3 symbols to find book!');
        }
    });
})();

function displaySearchResult(books) {
    var book = '',
        url;

    $('.pagination').addClass('hidden');

    if (books.length) {
        var tbody = $('.list-table').find('tbody'),
            content = '';
        tbody.empty();
        $('.list-table').removeClass('hidden');
        $('.no-result').remove();

        for (var i = 0; i < books.length; i++) {
            book = books[i];
            url = $('tbody').data('url');

            content +="<tr id='book-" + book.id + "' data-img=" + url + book.photo +" class='book-row'>";
            content +="<td class='td-title'><span class='book-content'>" + book.title +
                    "</span><a class='edit-book' style='display: none;' href='" + url + "edit/" + book.id + "'>" +
                    "<span class='glyphicon glyphicon-pencil'></span></a></td>";
            content += "<td class='td-author'><span class='book-content'>" + book.author.name + "</span></td>";
            content += "<td class='td-genre'><span class='book-content'>" + book.genre.name + "</span></td>";
            content += "<td class='td-language'><span class='book-content'>" + book.language + "</span></td>";
            content += "<td class='td-year'><span class='book-content'>" + book.year + "</span></td>";
            content += "<td class='td-code'><span class='book-content'>" + book.code + "</span></td></tr>";
            tbody.append(content);
        }
    } else {
        $('.list-table').addClass('hidden').after('<h2 class="no-result">Search result is empty!</h2>');
    }
}