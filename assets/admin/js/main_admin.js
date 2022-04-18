var base_url = $("#myBase").attr('href');
$(function() {
    cubemine_admin.init();
});

cubemine_admin = {
    init:function () {
        cubemine_admin._editversion();
        cubemine_admin._addvariable();
        cubemine_admin._editvariables();
        cubemine_admin._editwithdrawal();
        cubemine_admin._importfrm();
        cubemine_admin._profileaction();
        cubemine_admin._with_trans();
        cubemine_admin._Addcategory();
        cubemine_admin._Addevent();
        cubemine_admin._Addtag();
        cubemine_admin._Addcollection();
        cubemine_admin._Addimgtype();
        cubemine_admin._Addcontract();
        cubemine_admin._Addcurrency();
        cubemine_admin._Adduser();

    },
     showAjaxModal: (url,title) => {
        $('#modal_ajax .modal-body').html('<div class="linear-background"></div><div class="inter-crop"></div><div class="inter-right--bottom"></div></div >');

        $('#modal_ajax').modal('show', { backdrop: 'true' });
        $.ajax({
            url: url,
            success: function(response)
            {
                jQuery('#modal_ajax .modal-title').html("");
                jQuery('#modal_ajax .modal-body').html("");
                jQuery('#modal_ajax .modal-title').html('<strong>' + title + '</strong>');
                jQuery('#modal_ajax .modal-body').html(response);
            }
        });

       /* cubemine_admin.ajax_req1(url).done(function (response) {
            console.log(response);
            return false;
             jQuery('#modal_ajax .modal-title').html("");
             jQuery('#modal_ajax .modal-body').html("");
            $('#modal_ajax .modal-body').html(response);
            $('#modal_ajax .modal-title').html('<strong>' + title + '</strong>');
        });*/
        return false;
    },
    validatewinner:function(){
        jQuery.validator.addMethod("valide_btc", function(value, element){
            var validadd = validatebtc(value);
            if (validadd) {
                return true;
            } else {
                return false;
            };
        });
        $("#winner_form").validate({
                rules : {
                    txtwinname : {
                        required : true
                    },
                    txtaddress : {
                        required : true,
                        valide_btc: true
                    }
                },
                errorElement: "em",
                errorPlacement: function(error, element) {
                   error.addClass( "help-block" );
                  error.insertAfter( element );
                                
                },
                messages : {
                    txtwinname : {
                        required : "Please Enter Name."
                    },
                    txtaddress : {
                        required : "Please Enter Address.",
                        valide_btc : "Please enter valid bitcoin address."
                    }
                },
                submitHandler: function () {
                    
                    var form_data = new FormData(document.getElementById("winner_form"))
                    cubemine_admin.ajax_req(form_data,'/admin/winneraction').then(response=>{
                        cubemine_admin.notifyWithtEle(response.msg , response.type ,'topRight', 3000);
                        setTimeout(function(){ 
                            window.location =  base_url+response.url;
                        }, 3000);
                    })
                }
            });

    },
    _Addcategory:function(){
        $("#category_form").validate({
            rules: {
                txtcat: {
                    required: true,
                },
            },
            messages: {
                txtcat: {
                    required: "Please Enter Category",
                },
            },
            errorElement: "em",
            errorPlacement: function ( error, element ) {
                error.addClass( "help-block" );
                error.insertAfter( element );
            },
            submitHandler: function (form) {
                    form.submit();
                    return false;
            }
        });
    },
    _Addtag:function(){
        $("#tag_form").validate({
            rules: {
                txttag: {
                    required: true,
                },
            },
            messages: {
                txttag: {
                    required: "Please Enter Tag",
                },
            },
            errorElement: "em",
            errorPlacement: function ( error, element ) {
                error.addClass( "help-block" );
                error.insertAfter( element );
            },
            submitHandler: function (form) {
                    form.submit();
                    return false;
            }
        });
    },
    _Addcollection:function(){
        $("#collection_form").validate({
            rules: {
                txtcollect: {
                    required: true,
                },
            },
            messages: {
                txtcollect: {
                    required: "Please Enter collection",
                },
            },
            errorElement: "em",
            errorPlacement: function ( error, element ) {
                error.addClass( "help-block" );
                error.insertAfter( element );
            },
            submitHandler: function (form) {
                    form.submit();
                    return false;
            }
        });
    },
    _Addimgtype:function(){
        $("#imagtype_form").validate({
            rules: {
                txttype: {
                    required: true,
                },
            },
            messages: {
                txttype: {
                    required: "Please Enter Image Type",
                },
            },
            errorElement: "em",
            errorPlacement: function ( error, element ) {
                error.addClass( "help-block" );
                error.insertAfter( element );
            },
            submitHandler: function (form) {
                    form.submit();
                    return false;
            }
        });
    },
    _Addcontract:function(){
        $("#contract_form").validate({
            rules: {
                txtname: {
                    required: true,
                },
            },
            messages: {
                txtname: {
                    required: "Please Enter Contract",
                },
            },
            errorElement: "em",
            errorPlacement: function ( error, element ) {
                error.addClass( "help-block" );
                error.insertAfter( element );
            },
            submitHandler: function (form) {
                    form.submit();
                    return false;
            }
        });
    },
    _Addcurrency:function(){
        $("#currency_form").validate({
            rules: {
                txtname: {
                    required: true,
                },
            },
            messages: {
                txtname: {
                    required: "Please Enter Contract",
                },
            },
            errorElement: "em",
            errorPlacement: function ( error, element ) {
                error.addClass( "help-block" );
                error.insertAfter( element );
            },
            submitHandler: function (form) {
                    form.submit();
                    return false;
            }
        });
    },
    _Addevent:function(){
        $.validator.addMethod("valueNotEquals", function(value, element, arg){
          return arg !== value;
        }, "Value must not equal arg.");

                jQuery.validator.addMethod("greaterThan", 
        function(value, element, params) {

            if (!/Invalid|NaN/.test(new Date(value))) {
                return new Date(value) > new Date($(params).val());
            }

            return isNaN(value) && isNaN($(params).val()) 
                || (Number(value) > Number($(params).val())); 
        },'Must be greater than {0}.');

        $("#event_form").validate({
            rules: {
                title: {
                    required: true,
                },
                description: {
                    required: true,
                },
                /*eimage: {
                    required: true,
                },*/
                event_category: {
                    valueNotEquals:"0"
                },
                timezone: {
                    required: true,
                },
              /*  launch_start_date: {
                    required: true,
                },
                launch_end_date: {
                    required: true,
                    greaterThan: "#launch_start_date"
                },*/
                email: {
                    required: true,
                },
                txteventtwitter: {
                    required: true,
                },
                event_collection:{
                    valueNotEquals:"0"
                },
                event_currency: {
                    valueNotEquals:"0"
                },
                twitter_url: {
                    required: true,
                },
                event_tag: {
                   valueNotEquals:"0"
                },
            },
            messages: {
                title: {
                    required: "Please Enter Title",
                },
                description: {
                    required: "Please Enter Description",
                },
               /* eimage: {
                    required: "Please Select Image",
                },*/
                event_category: {
                    valueNotEquals: "Please Select Category",
                },
                timezone: {
                    required: "Please Select Timezone",
                },
                /*launch_start_date: {
                    required: "Please Select start date",
                },
                launch_end_date: {
                    required: "Please Select end date",
                    greaterThan: "Must be greater than to Start Date"
                },*/
                email: {
                    required: "Please Enter Email",
                },
                twitter_url: {
                    required: "Please Enter Twitter URL",
                },
                event_collection:{
                    valueNotEquals: "Please Select Collection",
                },
                event_currency: {
                    valueNotEquals: "Please select currency",
                }, 
                twitter_url: {
                    required: "Please Enter Twitter URL",
                },
                event_tag: {
                    valueNotEquals: "Please Enter tag",
                },
            },
            errorElement: "em",
            errorPlacement: function ( error, element ) {
                error.addClass( "help-block" );
                 if(element.parent('.input-group').length) {
            error.insertAfter(element.parent());
        } else {
            error.insertAfter(element);
        }
                //error.insertAfter( element );
            },
            onError : function(){
        $('.input-group.error-class').find('.help-block.form-error').each(function() {
          $(this).closest('.form-group').addClass('error-class').append($(this));
        });
    },
            submitHandler: function (form) {
                    form.submit();
                    return false;
            }
        });
    },

    _profileaction:function(){
        $("#profile_frm").validate({
                rules : {
                    firstname : {
                        required : true
                    },
                    lastname : {
                        required : true
                    },
                    email:{
                        required:true,
                        email:true,
                    },
                    username:{
                        required:true,
                    },
                    password : {
                        required : true,
                    }
                },
                errorElement: "em",
                errorPlacement: function(error, element) {
                  error.addClass( "help-block" );
                  error.insertAfter( element );
                                
                },
                messages : {
                    firstname : {
                        required : "Please Enter First Name"
                    }, 
                    lastname : {
                        required : "Please Enter Last Name"
                    },
                    email:{
                        required:"Please Enter Email",
                        email:"Please Enter valid Email",
                    },
                    username:{
                        required:"Please Enter Username",
                    },
                    password : {
                        required : "Please Enter Password."
                    }
                },
                submitHandler: function () {
                    
                    var form_data = new FormData(document.getElementById("profile_frm"))
                    cubemine_admin.ajax_req(form_data,'/admin/profileaction').then(response=>{
                        cubemine_admin.notifyWithtEle(response.msg , response.type ,'topRight', 3000);
                        setTimeout(function(){ 
                            window.location =  base_url+response.url;
                        }, 3000);
                    })
                }
            });
    },

    _importfrm:function(){
        $('#import_submit').on('click',function(){
            //var form_data = new FormData(document.getElementById("import_form"));
            cubemine_admin.ajax_req_get('/admin/importaction').done(response=>{
                var res = $.parseJSON(response);
                     cubemine_admin.notifyWithtEle(res.msg , res.type ,'topRight', 3000);
                    setTimeout(function(){ 
                    window.location =  base_url+res.url;
                    }, 3000);
            })
        })
    },
    delwinner:function(id){
        var delid = '/admin/delwinner/'+$(id).data("id");
        Swal.fire({
            title: '<p style="font-size : 35px; padding:10px;">Are you sure?</p>',
            html: "<p style='font-size : 20px;  padding:10px;'>You won\'t be able to revert this!</p>",
            icon: 'error',
            width: '500px',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#d33',
            confirmButtonText: '<font style="font-size :20px;">Yes, delete it!</font>',
            cancelButtonText: '<font style="font-size :20px;">Cancel</font>',
            showLoaderOnConfirm: true,
            preConfirm: () => {
                $.ajax({
                    url: base_url+delid,
                    type: 'GET',
                    success: function(response){
                        cubemine_admin.notifyWithtEle(response.msg , response.type ,'topRight', 3000);
                        setTimeout(function(){ 
                            window.location =  base_url+response.url;
                        }, 3000);
                    }
                });
            }
        });
       
        
    },
    _editversion:function(){
        $("#edit_version").validate({
            rules : {
                txtversion : {
                    required : true
                },
                txtbtcpermin : {
                    required : true,
                },
                txtbtcperday : {
                    required : true,
                },
                txtbonus : {
                    required : true,
                },
                txtprice : {
                    required : true,
                }
            },
            errorElement: "em",
            errorPlacement: function(error, element) {
                error.addClass( "help-block" );
                error.insertAfter( element );
            },
            messages : {
                txtversion : {
                    required : "Please Enter Version."
                },
                txtbtcpermin : {
                    required : "Please Enter BTC Per Minute."
                },
                txtbtcperday : {
                    required : "Please Enter BTC Per Day."
                },
                txtbonus : {
                    required : "Please Enter Bonus."
                },
                txtprice : {
                    required : "Please Enter Price."
                }
            },
            submitHandler: function () {
                var form_data = new FormData(document.getElementById("edit_version"))
                cubemine_admin.ajax_req(form_data,'/admin/edit_versionaction').then(response=>{
                    cubemine_admin.notifyWithtEle(response.msg , response.type ,'topRight', 3000);
                    setTimeout(function(){ 
                        window.location =  base_url+response.url;
                    }, 3000);
                })
            }
        });
    },
    _addvariable:function(){
        $("#add_variables").validate({
            rules : {
                txtname : {
                    required : true
                },
                txtvalue : {
                    required : true,
                },
            },
            errorElement: "em",
            errorPlacement: function(error, element) {
                error.addClass( "help-block" );
                error.insertAfter( element );
            },
            messages : {
                txtname : {
                    required : "Please Enter Name."
                },
                txtvalue : {
                    required : "Please Enter Value."
                },
            },
            submitHandler: function () {
                var form_data = new FormData(document.getElementById("add_variables"))
                cubemine_admin.ajax_req(form_data,'/admin/add_variablesaction').then(response=>{
                    cubemine_admin.notifyWithtEle(response.msg , response.type ,'topRight', 3000);
                    setTimeout(function(){ 
                        window.location =  base_url+response.url;
                    }, 3000);
                })
            }
        });
    },
    _editvariables:function(){
        $("#edit_variables").validate({
            rules : {
                txtname : {
                    required : true
                },
                txtvalue : {
                    required : true,
                },
            },
            errorElement: "em",
            errorPlacement: function(error, element) {
                error.addClass( "help-block" );
                error.insertAfter( element );
            },
            messages : {
                txtname : {
                    required : "Please Enter Name."
                },
                txtvalue : {
                    required : "Please Enter Value."
                },
            },
            submitHandler: function () {
                var form_data = new FormData(document.getElementById("edit_variables"))
                cubemine_admin.ajax_req(form_data,'/admin/edit_variablesaction').then(response=>{
                    cubemine_admin.notifyWithtEle(response.msg , response.type ,'topRight', 3000);
                    setTimeout(function(){ 
                        window.location =  base_url+response.url;
                    }, 3000);
                })
            }
        });
    },
    _with_trans:function(){
        $("#with_trans").validate({
            rules : {
                trans_id : {
                    required : true
                },
            },
            errorElement: "em",
            errorPlacement: function(error, element) {
                error.addClass( "help-block" );
                error.insertAfter( element );
            },
            messages : {
                trans_id : {
                    required : "Please Enter Transction ID."
                },
            },
            submitHandler: function () {
                var form_data = new FormData(document.getElementById("with_trans"))
                cubemine_admin.ajax_req(form_data,'/admin/with_trans_action').then(response=>{
                    cubemine_admin.notifyWithtEle(response.msg , response.type ,'topRight', 3000);
                    setTimeout(function(){ 
                        window.location =  base_url+response.url;
                    }, 3000);
                })
            }
        });
    },
    _editwithdrawal:function(){
        $("#edit_withdrawal").validate({
            rules : {
                txtstatus : {
                    required : true
                },
                txttranid : {
                    required : true,
                },
            },
            errorElement: "em",
            errorPlacement: function(error, element) {
                error.addClass( "help-block" );
                error.insertAfter( element );
            },
            messages : {
                txtstatus : {
                    required : "Please Select Status."
                },
                txttranid : {
                    required : "Please Enter Transction ID."
                },
            },
            submitHandler: function () {
                var form_data = new FormData(document.getElementById("edit_withdrawal"))
                cubemine_admin.ajax_req(form_data,'/admin/edit_withdrawaction').then(response=>{
                    cubemine_admin.notifyWithtEle(response.msg , response.type ,'topRight', 3000);
                    setTimeout(function(){ 
                        window.location =  base_url+response.url;
                    }, 3000);
                })
            }
        });
    },
    _delvariables:function(id){
        var delid = '/admin/deletevariables/'+$(id).data("id");
        Swal.fire({
            title: '<p style="font-size : 35px; padding:10px;">Are you sure?</p>',
            html: "<p style='font-size : 20px;  padding:10px;'>You won\'t be able to revert this!</p>",
            icon: 'error',
            width: '500px',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#d33',
            confirmButtonText: '<font style="font-size :20px;">Yes, delete it!</font>',
            cancelButtonText: '<font style="font-size :20px;">Cancel</font>',
            showLoaderOnConfirm: true,
            preConfirm: () => {
                $.ajax({
                    url: base_url+delid,
                    type: 'GET',
                    success: function(response){
                        cubemine_admin.notifyWithtEle(response.msg , response.type ,'topRight', 3000);
                        setTimeout(function(){ 
                            window.location =  base_url+response.url;
                        }, 3000);
                    }
                });
            }
        });
    },
    suspend_withuser:function(id){
        var delid = '/admin/suspend_withuser/'+$(id).data("id");
        Swal.fire({
            title: '<p style="font-size : 35px; padding:10px;">Are you sure?</p>',
            html: "<p style='font-size : 20px;  padding:10px;'>You won\'t be able to revert this!</p>",
            icon: 'error',
            width: '500px',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#d33',
            confirmButtonText: '<font style="font-size :20px;">Yes, delete it!</font>',
            cancelButtonText: '<font style="font-size :20px;">Cancel</font>',
            showLoaderOnConfirm: true,
            preConfirm: () => {
                $.ajax({
                    url: base_url+delid,
                    type: 'GET',
                    success: function(response){
                        cubemine_admin.notifyWithtEle(response.msg , response.type ,'topRight', 3000);
                        setTimeout(function(){ 
                            window.location =  base_url+response.url;
                        }, 3000);
                    }
                });
            }
        });
    },
    remove_withuser:function(id){
        var delid = '/admin/remove_withuser/'+$(id).data("id");
        Swal.fire({
            title: '<p style="font-size : 35px; padding:10px;">Are you sure?</p>',
            html: "<p style='font-size : 20px;  padding:10px;'>You won\'t be able to revert this!</p>",
            icon: 'error',
            width: '500px',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#d33',
            confirmButtonText: '<font style="font-size :20px;">Yes, delete it!</font>',
            cancelButtonText: '<font style="font-size :20px;">Cancel</font>',
            showLoaderOnConfirm: true,
            preConfirm: () => {
                $.ajax({
                    url: base_url+delid,
                    type: 'GET',
                    success: function(response){
                        cubemine_admin.notifyWithtEle(response.msg , response.type ,'topRight', 3000);
                        setTimeout(function(){ 
                            window.location =  base_url+response.url;
                        }, 3000);
                    }
                });
            }
        });
    },
    loginvalidate: function(){
            $("#login_frm").validate({
                rules : {
                    txtusername : {
                        required : true
                    },
                    txtpassword : {
                        required : true
                    }
                },
                errorElement: "em",
                errorPlacement: function(error, element) {
                   error.addClass( "help-block" );
                    if ( element.prop( "type" ) === "checkbox" ) {
                        error.insertAfter( element.parent( "label" ) );
                    } else {
                        error.insertAfter( element.parent() );
                    }                
                },
                messages : {
                    txtusername : {
                        required : "Please Enter Username or Email ID."
                    },
                    txtpassword : {
                        required : "Please Enter Password."
                    }
                },
                submitHandler: function () {
                    var form_data = new FormData(document.getElementById("login_frm"))
                    cubemine_admin.ajax_req(form_data,'/admin/loginaction').then(response=>{
                        if(response.txtusername || response.txtpassword){
                            $('.txtusername').html(response.txtusername);
                            $('.txtuserpassword').html(response.txtuserpassword);
                        }
                        else{
                            $('.txtusername').html('');
                            $('.txtuserpassword').html('');
                            cubemine_admin.notifyWithtEle(response.msg , response.type ,'topRight', 3000);
                            setTimeout(function(){ 
                                window.location =  base_url+response.url;
                            }, 4000);
                        }
                    })
                }
            });
      
    },
    redirectvalidate:function(){
        $("#redirect_form").validate({
                rules : {
                    site_enable:{
                        required : true
                    },
                    siteurl : {
                        required : true
                    },
                    sitename : {
                        required : true
                    }
                },
                errorElement: "em",
                errorPlacement: function(error, element) {
                   error.addClass( "help-block" );
                   error.insertAfter(element);
                                   
                },
                messages : {
                    site_enable:{
                        required : "Please select Available."
                    },
                    siteurl : {
                        required : "Please Enter Siteurl"
                    },
                    sitename : {
                        required : "Please Enter Sitename"
                    }
                },
                submitHandler: function () {
                    var form_data = new FormData(document.getElementById("redirect_form"))
                    cubemine_admin.ajax_req(form_data,'/admin/betaaction').then(response=>{
                            cubemine_admin.notifyWithtEle(response.msg , response.type ,'topRight', 3000);
                            setTimeout(function(){ 
                                window.location =  base_url+response.url;
                            }, 3000);
                        
                    })
                }
            });
    },
    
    ajax_req:async function(fields, url) {
        let response = await fetch(base_url+url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            body: fields
        });
        return await response.json();
    },
    notifyWithtEle: function (msg,type,pos,timeout) {
        pos = "";
        timeout = "";
        var noty = new Noty({
            theme:'metroui',
            text: msg,
            type: type,
            layout: (pos != "") ? pos : 'topRight',
            timeout: (timeout != "") ? timeout : 3000,
            closeWith: ['click'],
            animation: {
                open: 'animated slideInRight',
                close: 'animated slideOutRight'
            }
        });
        noty.show();
    },
    ajax_req_get: function(url, type = 'application/json') {
        return $.ajax({
            url:base_url+url,
            type:'GET',
        });
    },

    _fetch_data_category : function(){
        $(document).ready(function () {
            var table = $('.data-table_funddep').DataTable({
                processing: true,
                serverSide: true,
                ajax: base_url+'/admin/fetch_cate_data',
                columns: [
                    {data:'_ID', name: '_ID', orderable: true, searchable: false},
                    {data: '_Address', name: '_Address' , orderable: false, searchable: true},
                    {data: '_Amount', name: '_Amount', orderable: true, searchable: true},
                    {data: 'status', name: 'status', orderable: false, searchable: true},
                    {data: '_Created', name: '_Created', orderable: true, searchable: true},
                ],
                order: [4, 'desc'],
                columnDefs: [
                    { 
                        targets: 4, render:function(data){
                            return moment(data).format('DD-MMM-YYYY hh:mm:ss');
                        }
                    }
                ]
            });
        });
    },
      _Adduser:function(){
 
        $("#user_form").validate({
            rules: {
                name: {
                    required: true,
                },
                email: {
                    required: true,
                },
                address: {
                    required: true,
                },
                user_type: {
                    required: true,
                },
                mobile: {
                    required: true,
                },
            },
            messages: {
                name: {
                    required: "Please Enter Name",
                },
                email: {
                    required: "Please Enter email",
                },
               address: {
                    required: "Please Enter address",
                },
                user_type: {
                    required: "Please Select Type",
                },
                mobile: {
                    required: "Please Enter mobile no",
                },
             
            },
            errorElement: "em",
            errorPlacement: function ( error, element ) {
                error.addClass( "help-block" );
                 if(element.parent('.input-group').length) {
            error.insertAfter(element.parent());
        } else {
            error.insertAfter(element);
        }
                //error.insertAfter( element );
            },
            onError : function(){
        $('.input-group.error-class').find('.help-block.form-error').each(function() {
          $(this).closest('.form-group').addClass('error-class').append($(this));
        });
    },
            submitHandler: function (form) {
                    form.submit();
                    return false;
            }
        });
    },
}
