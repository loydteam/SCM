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


//$('.dialog-message').find('.E').html('User successfully Edit !');
//$('.dialog-message').find('[name="message"]').html('User successfully Edit !');
//$("#dialog-message").dialog("open");
//E
//

     $('.files-files-delete').click(function (){
         
        EroreCleaner();
         
        var id = $(this).val();

        var obj = new FormData();
        obj.append('id', id);
         
        $.ajax({
            url: '/Files/FileDelete/',
            type: 'POST',
            data: obj,
            enctype: 'multipart/form-data',
            async: false,
            contentType: false,
            processData: false,
            cache: false,
            success: function (resp) {

                var resp = eval('(' + resp + ')');

                if (resp.e != undefined) {
                                        
                    $('.dialog-message').find('.E').html(resp.e.e);
                    $("#dialog-message").dialog("open");
                    
                } else {

                    $('.dialog-message').find('[name="message"]').html('File successful delete !');
                    $("#dialog-message").dialog("open");
                }
            }
        });
         
     });

     $('.revision-file-delete').click(function (){
         
        EroreCleaner();
         
        var id = $(this).val();

        var obj = new FormData();
        obj.append('id', id);
         
        $.ajax({
            url: '/revision/FileDelete/',
            type: 'POST',
            data: obj,
            enctype: 'multipart/form-data',
            async: false,
            contentType: false,
            processData: false,
            cache: false,
            success: function (resp) {

                var resp = eval('(' + resp + ')');

                if (resp.e != undefined) {
                                        
                    $('.dialog-message').find('.E').html(resp.e.e);
                    $("#dialog-message").dialog("open");
                    
                } else {

                    $('.dialog-message').find('[name="message"]').html('File successful delete !');
                    $("#dialog-message").dialog("open");
                }
            }
        });
         
     });

    $('.revision-file-edit-button').click(function () {

        EroreCleaner();

        var SEL = $('.revision-file-edit-data');

        var $arr = ['file', 'id', 'comments'];
        var obj = FormGetDataFile($arr, SEL);

        $.ajax({
            url: '/revision/FileEditSet/',
            type: 'POST',
            data: obj,
            enctype: 'multipart/form-data',
            async: false,
            contentType: false,
            processData: false,
            cache: false,
            success: function (resp) {

                var resp = eval('(' + resp + ')');

                if (resp.e != undefined) {
                    EroreAlert(resp, SEL);
                } else {

                    var file_id = SEL.find('[name=file_id]').val();

                    location.assign("/revision/Index/" + file_id + "/?i=" + file_id);
                }
            }
        });

    });

    $('.new-version-file-button').click(function () {

        EroreCleaner();

        var SEL = $('.new-version-file-data');

        var $arr = ['comments', 'id'];
        var obj = FormGetDataFile($arr, SEL);
        obj.append('File', SEL.find('[name=File]').prop('files')[0]);

        $.ajax({
            url: '/revision/NewFileSet/',
            type: 'POST',
            data: obj,
            enctype: 'multipart/form-data',
            async: false,
            contentType: false,
            processData: false,
            cache: false,
            success: function (resp) {

                var resp = eval('(' + resp + ')');

                if (resp.e != undefined) {
                    EroreAlert(resp, SEL);
                } else {

                    var id = SEL.find('[name=id]').val();

                    location.assign("/revision/Index/" + id + "/?i=" + id);
                }
            }
        });

    });

//    $('.new-file-data').find('[name=File]').change(function () {
//        //.button()
//
//        var SEL = $('.new-file-data');
//        var name = SEL.find('[name=File]').val();
//        SEL.find('[name=file_name]').val(name);
//
//    });

    $('.new-file-button').click(function () {

        EroreCleaner();

        var SEL = $('.new-file-data');

        var $arr = ['file_name', 'description', 'comments'];
        var obj = FormGetDataFile($arr, SEL);
        obj.append('File', SEL.find('[name=File]').prop('files')[0]);

        $.ajax({
            url: '/Files/NewFileSet/',
            type: 'POST',
            data: obj,
            enctype: 'multipart/form-data',
            async: false,
            contentType: false,
            processData: false,
            cache: false,
            success: function (resp) {

                var resp = eval('(' + resp + ')');

                if (resp.e != undefined) {
                    EroreAlert(resp, SEL);
                } else {

                    location.assign("/Files/Index/");
                }
            }
        });

    });

    $('.edit-file-button').click(function () {

        EroreCleaner();

        var SEL = $('.edit-file-data');

        var $arr = ['file_name', 'description', 'id'];
        var obj = FormGetDataFile($arr, SEL);

        $.ajax({
            url: '/Files/FileEditSet/',
            type: 'POST',
            data: obj,
            enctype: 'multipart/form-data',
            async: false,
            contentType: false,
            processData: false,
            cache: false,
            success: function (resp) {

                var resp = eval('(' + resp + ')');

                if (resp.e != undefined) {
                    EroreAlert(resp, SEL);
                } else {

                    location.assign("/Files/Index/");
                }
            }
        });

    });

    $('.my-files-list').change(function () {

        if ($('.my-files-list').val() <= 0) {
            retutn;
        }

        var id_file = $('.my-files-list').val();

        location.assign("/revision/Index/" + id_file + "/?i=" + id_file);

    });

    $("img").error(function () {
        $(this).unbind("error").attr("src", "/images/no_image.gif");
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
