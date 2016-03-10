/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/*
 var imgError = function imgError(image) {
 image.onerror = "";
 image.src = "/images/no_image.gif";
 return true;
 }*/

var FormGetDataFile = function FormGetDataFile($arr, SEL) {

    var obj = new FormData();

    $.each($arr, function (key, value) {
        obj.append(value, SEL.find('[name=' + value + ']').val());
    });

    return obj;
};

var IsValidImg = function IsValidImg(maxFileSize, SEL) {

    EroreCleaner();

    var file = SEL.find('[name=Image]').prop('files')[0];

    if (file == undefined) {
        return;
    }

    maxFileSize = maxFileSize * 1024 * 1024;

    if (file.size > maxFileSize) {
        SEL.find('[for=Image]').find('.E').html('<br/>Available max file size is ' + (maxFileSize / 1024 / 1024) + "mb");
        return;
    }

    if (!(file.type == 'image/jpeg' || file.type == 'image/gif' || file.type == 'image/png')) {
        SEL.find('[for=Image]').find('.E').html('<br/>Invalid file type. Available type is jpeg, gif, png');
        return;
    }
    
    return file;
    
};

var FormGetData = function FormGetData($arr, SEL) {

    var obj = new Object();

    $.each($arr, function (key, value) {
        obj[value] = SEL.find('[name=' + value + ']').val();
    });

    return obj;

    /*
     var obj = new Object();                             
     obj['Email'] = SEL.find('[name=Email]').val();
     obj['Pass'] = SEL.find('[name=Pass]').val();
     obj['g-recaptcha-response'] = SEL.find('[name=g-recaptcha-response]').val();
     */
};

var EroreCleaner = function EroreCleaner() {

    $('.E').each(function (index) {
        $(this).html('');
    });
};

var EroreAlert = function EroreAlert(resp, SEL) {

    $.each(resp.e, function (key, value) {
        SEL.find('[for=' + key + ']').find('.E').html('<br/>' + value);
    });
};

$(document).ready(function () {

//products-searchr
//
//search
//E

    $('.orders-searchr').find('[name=button]').click(function () {

        var SEL = $('.orders-searchr');

        var obj = new Object();
        var s = SEL.find('[name=search]').val();
        var so = SEL.find('[name=option]:checked').val();

        location.assign("/Orders/MyOrders/?s=" + s + "&so=" + so);

    });

    $('.products-searchr').find('[name=button]').click(function () {

        var SEL = $('.products-searchr');

        var obj = new Object();
        var s = SEL.find('[name=search]').val();
        var so = SEL.find('[name=option]:checked').val();

        location.assign("/Searchr/ProductsGet/?s=" + s + "&so=" + so);

    });


    $("img").error(function () {
        $(this).unbind("error").attr("src", "/images/no_image.gif");
    });

    $('.get-free-test-money-bytton').click(function () {

        EroreCleaner();

        var SEL = $('.get-free-test-money');

        var $arr = ['g-recaptcha-response'];
        var obj = FormGetData($arr, SEL);

        $.ajax({
            url: '/User/MyAddBalance',
            type: 'POST',
            data: obj,
            success: function (resp) {

                var resp = eval('(' + resp + ')');

                if (resp.e != undefined) {
                    grecaptcha.reset(0);
                    EroreAlert(resp, SEL);
                } else {

                    $('.dialog-message').find('[name="message"]').html('Free money successfully added to your account !');
                    $("#dialog-message").dialog("open");
                }
            }
        });

    });

    $('.BuyProduct-button').click(function () {

        var SEL = $('.dialog-message');

        var obj = new Object();
        obj['Id'] = $(this).attr("ProductId");

        $.ajax({
            url: '/Orders/BayOrder/',
            type: 'POST',
            data: obj,
            success: function (resp) {

                var resp = eval('(' + resp + ')');

                if (resp.e != undefined) {
                    EroreAlert(resp, SEL);
                    $("#dialog-message").dialog("open");
                } else {
                    SEL.find('[name="message"]').html('You have successfully purchased the product !');
                    $("#dialog-message").dialog("open");
                }
            }
        });


    });

    $("#dialog-message").dialog({
        autoOpen: false,
        resizable: true,
        modal: true,
        width: 330,
        show: {
            effect: "blind",
            duration: 1000
        },
        hide: {
            effect: "blind",
            duration: 1000
        },
        close: function (event, ui) {
            EroreCleaner();
            $('.dialog-message').find('[name="message"]').html('');
            location.reload();
        }
    });

    // 
    $('.my-profile-edit-bytton').click(function () {

        EroreCleaner();

        var SEL = $('.my-profile-edit');

        var $arr = ['Email', 'Pass', 'Pass2', 'FirstName', 'LastName', 'g-recaptcha-response'];
        var obj = FormGetData($arr, SEL);

        $.ajax({
            url: '/User/MyProfileEdit',
            type: 'POST',
            data: obj,
            success: function (resp) {

                var resp = eval('(' + resp + ')');

                if (resp.e != undefined) {
                    grecaptcha.reset(0);
                    EroreAlert(resp, SEL);
                } else {

                    location.reload();
                    //$(this).dialog("close");
                }
            }
        });

    });

    $(".login-button").click(function () {

        EroreCleaner();

        if (20 > $('#Recaptcha').html().length) {
            var widgetId = grecaptcha.render('Recaptcha', {'sitekey': '6LejaxkTAAAAAKL1SZUnrd9I5TL__3cj61E5vKUR'});
        }

        $("#dialog-login").dialog({
            resizable: true,
            modal: true,
            width: 330,
            show: {
                effect: "blind",
                duration: 1000
            },
            hide: {
                effect: "blind",
                duration: 1000
            },
            buttons: {
                "Login": function () {
                    EroreCleaner();

                    var SEL = $('.loginform');

                    var $arr = ['Email', 'Pass', 'g-recaptcha-response'];
                    var obj = FormGetData($arr, SEL);

                    $.ajax({
                        url: '/User/Login',
                        type: 'POST',
                        data: obj,
                        success: function (resp) {

                            var resp = eval('(' + resp + ')');

                            if (resp.e != undefined) {
                                grecaptcha.reset(0);
                                EroreAlert(resp, SEL);
                            } else {

                                location.reload();
                                $(this).dialog("close");
                            }

                        }
                    });

                },
                Cancel: function () {
                    $(this).dialog("close");
                }
            }
        });

    });

    $("#register-button").click(function () {

        $("#dialog-login").dialog("close");
        EroreCleaner();

        if (20 > $('#Recaptcha2').html().length) {
            grecaptcha.render('Recaptcha2', {'sitekey': '6LejaxkTAAAAAKL1SZUnrd9I5TL__3cj61E5vKUR'});
        }

        $("#dialog-register").dialog({
            resizable: true,
            modal: true,
            width: 330,
            show: {
                effect: "blind",
                duration: 1000
            },
            hide: {
                effect: "blind",
                duration: 1000
            },
            buttons: {
                "Register": function () {

                    EroreCleaner();

                    var SEL = $('.registerform');

                    var $arr = ['Email', 'Pass', 'Pass2', 'FirstName', 'LastName', 'g-recaptcha-response'];
                    var obj = FormGetData($arr, SEL);

                    $.ajax({
                        url: '/User/Register',
                        type: 'POST',
                        data: obj,
                        success: function (resp) {

                            var resp = eval('(' + resp + ')');

                            if (resp.e != undefined) {
                                grecaptcha.reset(1);
                                EroreAlert(resp, SEL);
                            } else {

                                location.reload();
                                $(this).dialog("close");
                            }

                        }
                    });

                },
                Cancel: function () {
                    $(this).dialog("close");
                }
            }
        });


    });

    $("#logout-button").click(function () {

        $.ajax({
            url: '/User/Logout',
            type: 'GET',
            data: '',
            success: function (resp) {
                location.reload();
            }
        });
    });

});
