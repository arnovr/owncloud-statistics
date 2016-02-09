$(document).ready(function() {
    $("#toggle").click(function () {
        $('#chart-settings').slideToggle('', function() {
            $('#toggle').toggleClass('icon-triangle-n', $(this).is(':visible'));
            $('#toggle').toggleClass('icon-triangle-s', !$(this).is(':visible'));
        });
    });
});