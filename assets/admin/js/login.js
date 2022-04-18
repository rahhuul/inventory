var base_url = $("#myBase").attr('href');

$(function() {
    transction_front._loginvalidate();
    transction_front._registervalidate();
    transction_front._resetpass_validate();
    transction_front._password_functionality();
    transction_front._old_password_check();
    transction_front._email_check();
    transction_front._forgot_check();
    transction_front._validate_qr_img();
});

transction_front = {
    _password_functionality: function () {
        $(".password_hide").hide();
        $(".password_hide_old").hide();
        $(".password_hide_new").hide();
        $(".password_hide_con").hide();
        /*login password functionality */
        $(".password_show").click(function() {
            $("#txtpassword").attr("type", "text");
            $(".password_show").hide();
            $(".password_hide").show();
        });
        $(".password_hide").click(function() {
            $("#txtpassword").attr("type", "password");
            $(".password_hide").hide();
            $(".password_show").show();
        });
        /*old password functionality */
        $(".password_show_old").click(function() {
            $("#txtoldpassword").attr("type", "text");
            $(".password_show_old").hide();
            $(".password_hide_old").show();
        });
        $(".password_hide_old").click(function() {
            $("#txtoldpassword").attr("type", "password");
            $(".password_hide_old").hide();
            $(".password_show_old").show();
        });
        /*new password functionality */
        $(".password_show_new").click(function() {
            $("#txtnewpassword").attr("type", "text");
            $(".password_show_new").hide();
            $(".password_hide_new").show();
        });
        $(".password_hide_new").click(function() {
            $("#txtnewpassword").attr("type", "password");
            $(".password_hide_new").hide();
            $(".password_show_new").show();
        });
        /*confirm password functionality */
        $(".password_show_con").click(function() {
            $("#txtconpassword").attr("type", "text");
            $(".password_show_con").hide();
            $(".password_hide_con").show();
        });
        $(".password_hide_con").click(function() {
            $("#txtconpassword").attr("type", "password");
            $(".password_hide_con").hide();
            $(".password_show_con").show();
        });
    },
    _validate_qr_img: function (){
        $('#txtqr_img').on('keypress',function(){
            $('.validate_qr_error').html("");
        });
        $('.validate_qr_img').on('click',function(){
            $('.2fa_qr_show').hide();
            $('.2fa_qr_validate').show();
        });
        $('.validate_qr_submit').on('click',function(){
            txtqr_img = $('#txtqr_img').val();
            if(txtqr_img == ''){
                $('.validate_qr_error').html("Enter One Time Password.");
            }
            else{
                transction_front.ajax_req({txtqr_img : txtqr_img}, '/qr_img_action').done(function (response) {
                    var res = $.parseJSON(response);
                    if(res.type == "success"){
                        toastr.success(res.msg);
                        setTimeout(function(){ 
                            window.location =  base_url+res.url;
                        }, 3000);
                    }
                    else{
                        toastr.error(res.msg);
                    }
                });
                return false;
            }
        });
    },
    _loginvalidate: function () {
        $("#login_form").validate({
            rules: {
                txtemail: {
                    required: true,
                    email: true
                },
                txtpassword: {
                    required: true  
                }
            },
            messages: {
                txtemail: {
                    required: "Please enter Email Address",
                },
                txtpassword: {
                    required: "Please enter Password",
                }
            },
            errorElement: "em",
            errorPlacement: function ( error, element ) {
                error.addClass( "help-block" );

                if(element.parent().hasClass('input-group')){
                  error.insertAfter( element.parent() );
                }else{
                    error.insertAfter( element );
                }
            },
            submitHandler: function (form) {
                var form_data = $("#login_form").serialize();
                
                transction_front.ajax_req(form_data, '/loginaction').done(function (response) {
                    var res = $.parseJSON(response);
                    if(res.type == "success"){
                        if(res.QR_Image == ''){
                            $('.login_main_show').hide();
                            $('.2fa_qr_show').hide();
                            $('.2fa_qr_validate').show();
                        }
                        else{
                            $('.login_main_show').hide();
                            $('.2fa_qr_show').show();
                            $('.2fa_qr_img').html(res.QR_Image);
                            $('.2fa_qr_secret').html(res.secret);
                        }
                    }
                    else{
                        toastr.error(res.msg);
                        setTimeout(function(){ 
                            window.location =  base_url+res.url;
                        }, 3000);
                    }
                });
                return false;
            }
        });
    },
    _resetpass_validate: function () {
        $("#reset_pass_form").validate({
            rules: {
                txtnewpassword: {
                    required: true  
                },
                txtconpassword: {
                    required: true,
                    equalTo: "#txtnewpassword"    
                }
            },
            messages: {
                txtnewpassword: {
                    required: "Please enter New Password",  
                },
                txtconpassword: {
                    required: "Please enter Confirm Password",  
                }
            },
            errorElement: "em",
            errorPlacement: function ( error, element ) {
                error.addClass( "help-block" );
                 if(element.parent().hasClass('input-group')){
                  error.insertAfter( element.parent() );
                }else{
                    error.insertAfter( element );
                }
            },
            submitHandler: function (form) {
                var form_data = $("#reset_pass_form").serialize();
                    
                transction_front.ajax_req(form_data, '/resetpassaction').done(function (response) {
                    var res = $.parseJSON(response);
                   if(res.type == "success"){
                        toastr.success(res.msg);
                    }
                    if(res.type == "error"){
                        toastr.error(res.msg);
                    }
                    setTimeout(function(){ 
                        window.location =  base_url+res.url;
                    }, 3000);
                    
                });
                    return false;
            }
        });
    },
    _registervalidate: function () {
        $("#register_form").validate({
            rules: {
                txtfname: {
                    required: true,
                },
                txtlname: {
                    required: true,
                },
                txtemail: {
                    required: true,
                    email: true
                },
                txtpassword: {
                    required: true  
                },
                txtconpassword: {
                    required: true,
                    equalTo: "#txtpassword"    
                }
            },
            messages: {
                txtfname: {
                    required: "Please enter First Name",
                },
                txtlname: {
                    required: "Please enter Last Name",
                },
                txtemail: {
                    required: "Please enter Email Address",
                },
                txtpassword: {
                    required: "Please enter Password",
                },
                txtconpassword: {
                    required: "Please enter Confirm Password",  
                }
            },
            errorElement: "em",
            errorPlacement: function ( error, element ) {
                error.addClass( "help-block" );
                error.insertAfter( element.parent() );
            },
            submitHandler: function (form) {
                var form_data = $("#register_form").serialize();
                
                transction_front.ajax_req(form_data, '/registeraction').done(function (response) {
                    var res = $.parseJSON(response);
                    if(res.type == "success"){
                        toastr.success(res.msg);
                    }
                    if(res.type == "error"){
                        toastr.error(res.msg);
                    }
                    setTimeout(function(){ 
                        window.location =  base_url+res.url;
                    }, 3000);
                });
                return false;
            }
        });
    },
    _old_password_check : function (){
        $(".txtoldpassword").change(function() {
            var password = $('#txtoldpassword').val();
            var email = $('#txtemail').val();
            transction_front.ajax_req({password : password , email : email}, '/checkpassword').done(function (response) {
                var res = $.parseJSON(response);
                if(res.type == "error"){
                    $('.oldpass_msg').show();
                    $('.oldpass_msg').html(res.msg);
                }
                else{
                    $('.oldpass_msg').hide();
                    $('.oldpass_msg').html('');
                }
            });
            return false;
        });
    },
    _email_check : function (){
        $(".txtemail").change(function() {
            var email = $('#txtemail').val();
            transction_front.ajax_req({email : email}, '/checkemail').done(function (response) {
                var res = $.parseJSON(response);
                if(res.type == "error"){
                    $('.email_msg').show();
                    $('.email_msg').html(res.msg);
                }
                else{
                    $('.email_msg').hide();
                    $('.email_msg').html('');
                }
            });
            return false;
        });
        $(".regtxtemail").change(function() {
            var email = $('#txtemail').val();
            transction_front.ajax_req({email : email}, '/checkemail').done(function (response) {
                var res = $.parseJSON(response);
                if(res.type == "success"){
                    $('.email_msg').show();
                    $('.email_msg').html('Email Address already exist.');
                }
                else{
                    $('.email_msg').hide();
                    $('.email_msg').html('');
                }
            });
            return false;
        });
    },
    _forgot_check:function ()
    {
        $("#forgot_form").validate({
            rules: {
                txtemail: {
                    required: true,
                    email: true
                },
            },
            messages: {
                txtemail: {
                    required: "Please enter Email Address",
                },
            },
            errorElement: "em",
           errorPlacement: function ( error, element ) {
                if(element.parent().hasClass('input-group')){
                  error.insertAfter( element.parent() );
                }else{
                    error.insertAfter( element );
                }
            },
            submitHandler: function (form) {
                var form_data = $("#forgot_form").serialize();
                transction_front.ajax_req(form_data, '/forgotaction').done(function (response) {
                  //  console.log(response);return false;
                    var res = $.parseJSON(response);
                      if(res.type == "success"){
                        toastr.success(res.msg);
                    }
                    if(res.type == "error"){
                        toastr.error(res.msg);
                    }
                    setTimeout(function(){ 
                        window.location =  base_url+res.url;
                    }, 3000);
                });
                return false;
            }
        });
    },
    notifyWithtEle: function (msg,type,pos,timeout) {
        pos = "";
        timeout = "";
        var noty = new Noty({
            theme:'metroui',
            text: msg,
            type: type,
            layout: (pos != "") ? pos : 'topRight',
            timeout: (timeout != "") ? timeout : 2000,
            closeWith: ['click'],
            animation: {
                open: 'animated slideInRight',
                close: 'animated slideOutRight'
            }
        });
        noty.show();
    },
    ajax_req: function(fields, url) {
        return $.ajax({
            url:base_url+url,
            type:'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },      
            data: fields,
            datatype : "application/json"
        });
    },
};