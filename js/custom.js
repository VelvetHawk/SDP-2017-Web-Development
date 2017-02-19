// want to highlight which tab on the nav bar we are currently on
// grab url of current page
var url = window.location;

// targetting anchor
// jquery filter
$('ul.nav a').filter(function() {
    return this.href == url;
}).parent().addClass('active');
