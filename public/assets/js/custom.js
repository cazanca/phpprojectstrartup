$(document).ready(function () {
    $(".form-signin").unbind('submit').bind('submit', function (event) {
        event.preventDefault();

        var form = $(this);

        $.ajax({
            url: form.attr('action'),
            type: form.attr('method'),
            data: form.serialize(),
            dataType: 'json',
            beforeSend: function () {
                $(".response").html('<div class="loading">Loading...</div>');
                $(".alert").delay(500).show(10, function(){
                    $(this).delay(3000).hide(10, function(){
                        $(this).remove();
                    })
                })
            },
            success: function (response) {
                
                if (response.success == true) {
                    $(".form-signin")[0].reset();
                }

                if (response.redirect) {
                    window.location.href = response.redirect;
                }

                $(".response").html(response.message);
                $(".alert").delay(500).show(10, function(){
                    $(this).delay(3000).hide(10, function(){
                        $(this).remove();
                    })
                })
            }
        })
    })
})
