$(function() {
    //初始化input
    inputInt();
});
//是否出现警告信息  false无  true有
var isWarning = false;
//出现警告信息的元素ID
var isWarningId = null;

function showInfor(message) {
    $("#count-msg").html(message);
    $("#count-msg").css("height","50px")
}
function checkInfor(obj,id,message,value) {
    if (isWarning && id != isWarningId)
        return;
    //根据不同ID 规则 提示不同信息
    switch (id){
        case "username":
            if( value.length<4){
                //修改isWarning为true 使不显示focus消息
                isWarning = true;
                //记录出现错误的元素
                isWarningId = id;
            } else{
                //修改isWarning为true 使显示focus消息
                isWarning = false;
                //去除记录的错误元素
                isWarningId == null;
            }
            break;
        case "password":
            if(value.length < 22 && value.length>6){
                isWarning = true;
                isWarningId = id;
            }else{
                isWarning = false;
                isWarningId == null;
            }
            break;
        case "verify":
            if(value.length!=4){
                isWarning = true;
                isWarningId = id;
            }else{
                isWarning = false;
                isWarningId == null;
            }
            break;
        case "email":
            var re = /^[_".0-9a-z-]+@([0-9a-z][0-9a-z-]+".){1,4}[a-z]{2,3}$/i;
            if(re.test(value)){
                isWarning = true;
                isWarningId = id;
            }else{
                isWarning = false;
                isWarningId == null;
            }
            break;
        case "mailVerify":
            if(value.length!=6){
                isWarning = true;
                isWarningId = id;
            }else{
                isWarning = false;
                isWarningId == null;
            }
            break;
        case "repassword":
            if(value.length < 22 && value.length>6 && value == $("#password").val()){
                isWarning = true;
                isWarningId = id;
            }else{
                isWarning = false;
                isWarningId == null;
            }
            break;
        case "nickname":
            var re =/[`~!@#$%^&*()_+<>?:"{},.\/;'[\]]/im
            if(re.test(value) && value.length < 22 && value.length>6){
                isWarning = true;
                isWarningId = id;
            }else{
                isWarning = false;
                isWarningId == null;
            }
            break;
        case "mobile":
            var re = /^[1][3,4,5,7,8][0-9]{9}$/;
            if(re.test(value)){
                isWarning = true;
                isWarningId = id;
            }else{
                isWarning = false;
                isWarningId == null;
            }
            break;
    }
    $("#count-msg").html(message);
    $("#count-msg").css("height","50px");
    obj.css("border","2px solid rgba(227, 60, 60, 1)")

}
function inputInt() {
    var obj = $('input');


    //input_box 下的input框focus状态改变css
    $("input").focus(function(){
        //如果存在警告信息则不显示当前focus样式
        if (isWarning)
            return;

        $(this).css({
            "border":"2px solid rgba(244, 244, 200, 0.9)",
        },1500);

        showInfor($(this).attr('foucs-message'));
    });
    //input_box 下的input框focus状态改变css
    $(".input_box input").focus(function(){
        //如果存在警告信息则不显示当前focus样式
        if (isWarning)
            return;

        $(this).parent().animate({
            "width":"330px",
        },200);
    });

    //所有input框blur状态提示信息
    $("input").blur(function(){
        checkInfor($(this),$(this)[0].id,$(this).attr('lost-message'),$(this).val());
    });
    //input_box 下的input框blur状态还原css
    $("input").blur(function(){
        //如果存在警告信息则不还原input样式
        if (isWarning)
            return;

        $(this).css({
            "border":"1px solid rgba(255, 255, 255, 0.4)",
        },1500)
    });
    $(".input_box input").blur(function(){
        //如果存在警告信息则不显示当前focus样式
        if (isWarning)
            return;

        $(this).parent().animate({
            "width":"280px",
        },200)
    });
    //设置第一个input focus
    obj[0].focus();
}
