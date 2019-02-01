$.ajax({
    url: "home.html",
    success: function (data) { $('body').append(data); },
    dataType: 'html'
});


