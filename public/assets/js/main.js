$(document).ready(function() {
    var url = $(location).attr('pathname');
    current_url = url.substr(url.lastIndexOf('/') + 1,url.length);                  
    $('.nav a[href="' + current_url + '"]').parent().addClass('active');
});