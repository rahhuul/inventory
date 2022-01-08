var base_url = $("#myBase").attr('href');


$(function() {
    transction_withdraw._withdrawvalidate();
   
});
transction_withdraw={
	_withdrawvalidate: function () {
		 jQuery.validator.addMethod("validebtc", function(value, element){
            var validadd = WAValidator.validate(value, 'btc');

                if (validadd) {
                    return true;
                } else {
                    return false;
                };
        }, "This is not valid BTC address");
		 $("#withdraw_form").validate({
            rules: {
                txtaddress: {
                    required: true,
                    validebtc: true
                },
                txtamount: {
                    required: true  
                }
            },
            messages: {
                txtaddress: {
                    required: "Please Enter Address",
                },
                txtamount: {
                    required: "Please Enter Amount",
                }
            },
            errorElement: "em",
            errorPlacement: function ( error, element ) {
                error.addClass( "help-block" );
                error.insertAfter( element );
            },
            submitHandler: function (form) {
              //  alert("heloo");return false;
                var form_data = $("#withdraw_form").serialize();
                
                transction_front.ajax_req(form_data, '/withdrawaction').done(function (response) {
                    var res = $.parseJSON(response);
                     if(res.txtaddress){
                            $('.address').html(res.txtaddress);
                            
                    }
                    else
                    {
                    	$('.address').html('');
                    }
                    if(res.txtamount){
                    	$('.amount').html(res.txtamount);
                            
                    }
                    else
                    {
                    	
                    	$('.amount').html('');
                   
                    if(res.type == "success"){
                        toastr.success(res.msg);
                    }
                    if(res.type == "error"){
                        toastr.error(res.msg);
                    }
                    setTimeout(function(){ 
                        window.location =  base_url+res.url;
                    }, 3000);
                     }
                   
                });
                return false;
            }
        });

	},
    _fetch_withdata:function(){
         $(document).ready(function () {
            var table = $('#example1').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            autoWidth: false,
           ajax: base_url+'/getwithdrawdata',
            columns: [
                {data:'_ID', name: '_ID', orderable: true, searchable: true},
                {data: '_Address', name: '_Address', orderable: false, searchable: true},
                {data: '_Amount', name: '_Amount', orderable: true, searchable: true},
                {data: '_Status', name: '_Status', orderable: false, searchable: true},
                {data: '_Created', name: '_Created', orderable: true, searchable: true},
            ],
            columnDefs: [
                    { 
                        targets: 4, render:function(data){
                            return moment(data).format('DD-MMM-YYYY hh:mm:ss');
                        }
                    }
                ]
        });
         });

    }
};