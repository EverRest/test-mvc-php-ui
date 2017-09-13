// Wait for the DOM to be ready
$(function() {
    var today = new Date();
    var year = today.getFullYear();

    //create form
    $("#create-form").validate({
        rules: {
            title: "required",
            author: "required",
            genre: "required",
            lang:"required",
            photo: "required",
            date:  {
                required: true,
                maxlength: 4
            },
            isbn:  {
                required: true,
                maxlength: 25
            }
        },
        messages: {
            title: "Please enter title",
            author: "Please enter author",
            genre: "Please enter genre",
            lang:"Please enter language",
            photo: "Please input photo",
            date: {
                required: "Please provide a password",
                maxlength: "Year must be less then " + year
            },
            isbn: {
                required: "Please enter ISBN code",
                maxlength: "Too long for valid ISBN code"
            },
        },
        submitHandler: function(form) {
            form.submit();
        }
    });

    //edit form
    $("#edit-form").validate({
        rules: {
            title: "required",
            author: "required",
            genre: "required",
            lang:"required",
            date:  {
                required: true,
                maxlength: 4
            },
            isbn:  {
                required: true,
                // maxlength: 13
            }
        },
        messages: {
            title: "Please enter title",
            author: "Please enter author",
            genre: "Please enter genre",
            lang:"Please enter language",
            date: {
                required: "Please provide a password",
                maxlength: "Year must be less then " + year
            },
            isbn: {
                required: "Please enter ISBN code",
                maxlength: "It\'s not a valid ISBN code"
            },
        },
        submitHandler: function(form) {
            form.submit();
        }
    });

});