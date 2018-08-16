jQuery(document).ready(function ($) {

    $.ajax({
        url: "https://testando.tri",
        success: function (data) {
            alert('Your home page has ' + $(data).find('div').length + ' div elements.');
        }
    })

})