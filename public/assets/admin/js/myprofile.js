var base_url = $("#myBase").attr('href');

$(function() {
    transction_profile._perinfovalidate();
    transction_profile._changepass_validate();
    transction_profile._email_check();
    transction_profile._settabname();
});

transction_profile = {
    _settabname: function(){
        $('.information_id').on('click',function(){
            $('.tab_name').html('My Profile / Personal Information');
        });
        $('.password_id').on('click',function(){
            $('.tab_name').html('My Profile / Change Password');
        });
        $('.settings').on('click',function(){
            $('.tab_name').html('My Profile / Security');
        });
    },
    _perinfovalidate: function () {
        $("#perinfo_form").validate({
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
            },
            errorElement: "em",
            errorPlacement: function ( error, element ) {
                error.addClass( "help-block" );
                error.insertAfter( element );
            },
            submitHandler: function (form) {
                var form_data = $("#perinfo_form").serialize();
                
                transction_front.ajax_req(form_data, '/perinfo_action').done(function (response) {
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
    _changepass_validate: function () {
        $("#changepass_form").validate({
            rules: {
                txtoldpassword: {
                    required: true  
                },
                txtnewpassword: {
                    required: true  
                },
                txtconpassword: {
                    required: true,
                    equalTo: "#txtnewpassword"    
                }
            },
            messages: {
                txtoldpassword: {
                    required: "Please enter Old Password",
                },
                txtnewpassword: {
                    required: "Please enter New Password",  
                },
                txtconpassword: {
                    required: "Please enter Confirm Password",  
                }
            },
            errorElement: "em",
            errorPlacement: function ( error, element ) {
                error.addClass( "help-block1" );
                error.insertAfter(element.parent());
            },
           
            submitHandler: function (form) {
                var old_password = $('#txtoldpassword').val();
                var new_password = $('#txtnewpassword').val();
                if(old_password === new_password){
                    $('.conpass_msg').show();
                    $('.conpass_msg').html("Old Password and New Password does not Same");
                }
                else{
                    $('.conpass_msg').hide();
                    $('.conpass_msg').html("");
                    var form_data = $("#changepass_form").serialize();
                    transction_front.ajax_req(form_data, '/changepassaction').done(function (response) {
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
            }
        });
    },
    _email_check : function (){
        $(".profiletxtemail").change(function() {
            var email = $('#txtemail').val();
            transction_profile.ajax_req({email : email}, '/checkprofileemail').done(function (response) {
                var res = $.parseJSON(response);
                if(res.type == "error"){
                    $('.profiletxtemail_msg').show();
                    $('.profiletxtemail_msg').html(res.msg);
                }
                else{
                    $('.profiletxtemail_msg').hide();
                    $('.profiletxtemail_msg').html('');
                }
            });
            return false;
        });
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