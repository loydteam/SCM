$(document).ready(function () {


    //$(".button_my_profile").click(function () {
    //    $(".my-profile-edit").slideToggle();
    //});



    $(document).ready(function () {
        $(".menu_user ul").hide();
        $(".menu_user li a").click(function () {
            $(this).next().slideToggle("hight");
        });
    });


});