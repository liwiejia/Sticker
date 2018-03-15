$(function() {
    inputInt();
});
function inputInt() {
    var obj = $('input');
    $(".input_box input").focus(function(){
        $(this).css({
            "border":"2px solid rgba(244, 244, 200, 0.9)",
        },1500)
        $(this).parent().animate({
            "width":"330px",
        },200)
    });
    $(".input_box input").blur(function(){
        $(this).css({
            "border":"1px solid rgba(255, 255, 255, 0.4)",
        },1500)
        $(this).parent().animate({
            "width":"280px",
        },200)
    });
    obj[0].focus();
}


//parent()