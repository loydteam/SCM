$(document).ready(function () {

//
//    $(".menu_user").click(function () {
//        $(".sub_menu_user").slideToggle();
//    });



    $(document).ready(function () {
        $(".menu_user ul").hide();
        $(".menu_user li a").click(function () {
            $(this).next().slideToggle("hight");
        });
    });


});