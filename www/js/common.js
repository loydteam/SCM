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

    tinymce.init({
        selector: "textarea",
        plugins: [
            "advlist autolink lists link image charmap print preview anchor",
            "searchreplace visualblocks code fullscreen",
            "insertdatetime media table contextmenu paste"
        ],
        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
    });
});