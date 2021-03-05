document.addEventListener('DOMContentLoaded', function(){

    let form_btn = document.querySelector('.add-com');
    let form_comment = document.querySelector('.form-comment');

    function init(){
        display_form_comment();
    }

    function display_form_comment(){
        form_btn.addEventListener('click', function(e){
            e.preventDefault();
            form_comment.style.display = "flex";
        });
    }

    init();
});