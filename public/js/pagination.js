(function () {
    // display start pagination
    init();

    var items = $('.pagination .pgnt-item'),
        item = false,
        books = false,
        count = 0,
        page = false,
        current = false;
    
    $(document).on('click', '.pgnt-item', function (e) {
        e.preventDefault();
        page = +$(this).data('val');

        if ($('.pagination .active').length > 0) current = $('.pagination .active');
        if ($('.pagination-active').length > 0) current = $('.pagination-active');

        current = +current.text();
        books = getBooks(page, current);
        count = +$('.pagination').data('pages');

        $('.pagination-active').removeClass('pagination-active');
        item = $(this);
        item.addClass('pagination-active').text(page);

        if(item.parent('.item').hasClass('next')) {
            $('.pagination').find('.item.next').removeClass('next');
            $('.pagination').find('.item.prev').removeClass('prev');
            // item.parent('.item').removeClass('next');
            var prevLi = $('.pagination').find('li.item').first();
            prevLi.find('.pgnt-item').text('<');
            prevLi.addClass('prev');
            if (count > page) {
                var next = page + 1;
                $('.pagination').append('<li class="item next"><a data-val="'+ next +'" href="#" class="pgnt-item">></a></li>');
                if ($('.pagination li').length > 5)  {
                    $('.pagination').find('.prev').remove();
                    var first = $('.pagination li').first();
                    first.addClass('prev');
                    first.find('a').text('<');
                }
            } else {
                $('.pagination').find('li.item').first().next('li.item').remove();
                $('.pagination').find('li.next').remove();
                var li = $('.pagination').find('li.item').first();
                li.find('.pgnt-item').data('val', page - 3);
            }
        }

        if(item.parent('.item').hasClass('prev')) {
            $('.pagination').find('.item.next').removeClass('next');
            $('.pagination').find('.item.prev').removeClass('prev');
            var nextLi = $('.pagination').find('li.item').last();
            nextLi.find('.pgnt-item').text('>');
            nextLi.addClass('next');
            prevLi = $('.pagination .prev');
            if (page > 3) {
                nextLi.find('.pgnt-item').text('>');
                nextLi.addClass('next');
            }
            if ( page > 1 ) {
                var prev = page - 1;
                $('.pagination li').first().before('<li class="item prev"><a data-val="'+ prev +'" href="#" class="pgnt-item"><</a></li>');

                if ($('.pagination li').length > 5)  {
                    $('.pagination').find('.next').remove();
                    var last = $('.pagination li').last();
                    last.addClass('next');
                    last.find('a').text('>');
                }

                if ($('.pagination li').length > 5)  {
                    $('.pagination').find('.next').remove();
                    var first = $('.pagination li').first();
                    first.addClass('prev');
                    first.find('a').text('<');
                }
            } else {
                $('.pagination').find('li.item').last().remove();
                $('.pagination').find('li.prev').remove();
                var li = $('.pagination').find('li.item').first();
                li.find('.pgnt-item').data('val', 1);
                if (count > 3) {
                    nextLi = $('.pagination').find('li.item').last();
                    nextLi.find('.pgnt-item').text('>');
                    nextLi.addClass('next');
                }
            }
        }
    });
    
})();


function init() {

    $.get(
        "/count",
        initSuccess
    );

}

function getBooks(page, current) {

    $.ajax({
        type: "GET",
        url: "/paginate",
        data: {
            'page': page,
            'current': current
        },
        success: function(res){
            data = JSON.parse(res);
            if (data.error === false) {
                displayPaginationResult(data);
            } else {
                alert(data.message);
            }

        }
    });
}

// init pagination

function initSuccess(res)
{
    var pgntn = $('.pagination'),
        n = 3, // pagination items default value
        content = '';
    data = JSON.parse(res);

    if (!data.count){ data.count = 1; } else {
        data.count = Math.ceil(data.count/3);
    }

    pgntn.attr('data-pages',data.count);
    if (data.count < 3)  n = data.count;

    for (var i = 1; i <= n; i++) {
        if (i === 1) {
            content += "<li class='active item'><a data-val=" + i + " href='#' class='pgnt-item'>" + i +"</a></li>";
        } else {
            content += "<li class='item'><a data-val=" + i + " href='#' class='pgnt-item'>" + i +"</a></li>";
        }
    }

    if (data.count > 3) content += "<li class='item next'><a data-val='" + 4 + "' href='#' class='pgnt-item'>></a></li>";

    pgntn.append(content);
}

// show table rows with result

function displayPaginationResult(data) {
    var book = '',
        books = data.books,
        count = 0,
        page = data.page,
        url;

    if (books.length) {
        var tbody = $('.list-table').find('tbody'),
            content = '';
        tbody.empty();
        $('.list-table').removeClass('hidden');
        $('.no-result').remove();
        $('.pagination').find('li.active').removeClass('active');

        for (var i = 0; i < books.length; i++) {
            book = books[i];
            url = $('tbody').data('url');

            content +="<tr id='book-" + i + "' data-img=" + url + book.photo +" class='book-row'>";
            content +="<td class='td-title'><span class='book-content'>" + book.title +
                "</span><a class='edit-book' style='display: none;' href='" + url + "edit/" + book.id + "'>" +
                "<span class='glyphicon glyphicon-pencil'></span></a></td>";
            content += "<td class='td-author'><span class='book-content'>" + book.author.name + "</span></td>";
            content += "<td class='td-genre'><span class='book-content'>" + book.genre.name + "</span></td>";
            content += "<td class='td-language'><span class='book-content'>" + book.language + "</span></td>";
            content += "<td class='td-year'><span class='book-content'>" + book.year + "</span></td>";
            content += "<td class='td-code'><span class='book-content'>" + book.code + "</span></td></tr>";
        }
            tbody.append(content);


    } else {
        $('.list-table').addClass('hidden').after('<h2 class="no-result">Bookshelf is empty!</h2>');
    }
}