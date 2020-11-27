$(document).ready(function(){
    //console.log('Hello World');

    function init() {
        scroll_to_div();
    }

    function scroll_to_div() {
        // var body = $(window);
        var html = $('html, body');
        var section = $('section');
        var section_id = section.val('id').slice(1);
        var next = section.closest(section_id);
        var section_scroll = section.closest(section_id).next().offset().top;

        var array = [];
        array.push(section_id);
        console.log(array);

        //console.log('Hello World');
        //body.scroll(function(){
            //console.log('Hello World');
            //for (var i = 0; i < section.length; i++) {
            //section.each(function(index){
                console.log(section_id.length);
                //var current_id = section_id[i];
        html.animate({
                    scrollTop: section_scroll
                }, 1000);
            //}
            /*$('html, body').animate({
                scrollTop: $('section').val('id').offset().top
            }, 1000);*/
            /*$('#services').animate({
                scrollTop: 0
            }, 1000);
            $('#social-networks').animate({
                scrollTop: 0
            }, 1000);
            $('#contact').animate({
                scrollTop: 0
            }, 1000);*/
        //});
    }

    //init();
    var body = $(window);
    body.scroll(function() {
        scroll_to_div();
    });

});