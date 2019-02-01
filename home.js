$.ajax({
    url: "home_template.html",
    success: function (data) { $('body').append(data); },
    dataType: 'html'
});


