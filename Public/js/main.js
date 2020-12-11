$(document).ready(function(){
    //console.log('Hello World');

    function init() {
        scroll_to_div();
    }

    function scroll_to_div() {
        // var body = $(window);
        var html = $('html, body');
        var section = $('.page-section');
        //var sec_class = $('.page-section');
        var section_id = section.val('id');
        //var next = section.closest(section_id);
        //var section_scroll = sec_class.closest(section_id).next().offset().top;
        var hash = this.hash;

        //var nextSection = 0;

        var array = [];
        array.push(section_id);
        //console.log(array);

        for (var i =0; i < section.length; i++) {
            //if(section[i] < section) {
                html.animate({
                    //scrollTop: $(section[i]).parent().next().offset().top
                    scrollTop: $(section[i]).offset().top
                }, 1000);
            //}
        }

        // $(window).scroll(function() {
        //     scroll_to_div();
        // });
    }

    //init();
    //var body = $(window);
    /*$(window).scroll(function() {
        scroll_to_div();
        /!*if($('html, body').is(':animated')) {
            e.preventDefault();
            e.stopPropagation();
        }*!/
    });*/
});