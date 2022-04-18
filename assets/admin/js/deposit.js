var base_url = $("#myBase").attr('href');

$(function() {
    transction_deposit._fundsdep_validate();
});

transction_deposit = {
    call_scoket_deposit: function(dep_addr) {
        //alert(dep_addr);
        //let socket = new WebSocket("wss://javascript.info/article/websocket/demo/hello");
        let socket = new WebSocket("wss://ws.blockchain.info/inv");

        socket.onopen = function(e) {
            //alert("[open] Connection established");
            //alert("Sending to server");
            //socket.send("My name is John");
            socket.send({"op":"addr_sub", "addr":dep_addr});
            transction_deposit._update_balance_deposit(dep_addr,'1000');
        };

        socket.onmessage = function(event) {
           // alert(`[message] Data received from server: ${event.data}`);
        };

        /*socket.onclose = function(event) {
          if (event.wasClean) {
            alert(`[close] Connection closed cleanly, code=${event.code} reason=${event.reason}`);
          } else {
            // e.g. server process killed or network down
            // event.code is usually 1006 in this case
            alert('[close] Connection died');
          }
        };*/

        socket.onerror = function(error) {
          alert(`[error] ${error.message}`);
        };
    },
    _fundsdep_pending: function(id){
        transction_deposit.ajax_req_get('/fundspending_action/'+id).done(function (response) {
            var res = $.parseJSON(response);
            transction_deposit.call_scoket_deposit(res.address);
            jQuery('#modal_ajax .modal-body').html('<div style="text-align:center;"></div>');
            jQuery('#modal_ajax').modal('show', {backdrop: 'true'});
            jQuery('#modal_ajax .modal-title').html("");
            jQuery('#modal_ajax .modal-body').html("");
            jQuery('#modal_ajax .modal-title').html('<strong> Deposit Balance</strong>');
            jQuery('#modal_ajax .modal-body').html(res.data);
        });
    },
    _update_balance_deposit: function(dep_address,dep_balance){
        transction_deposit.ajax_req({dep_address:dep_address , dep_balance:dep_balance }, '/update_bal_action').done(function (response) {
            var res = $.parseJSON(response);
            console.log(res);
        });
        return false;
    },
    _fundsdep_validate: function () {
        $('#modal_ajax').on('hidden.bs.modal', function (e) {
            location.reload();
        })
        $("#fundsdep_form").validate({
            rules: {
                txtamt: {
                    required: true,
                    number:true
                },
            },
            messages: {
                txtamt: {
                    required: "Please enter Amount",
                },
            },
            errorElement: "em",
            errorPlacement: function ( error, element ) {
                error.addClass( "help-block" );
                error.insertAfter( element );
            },
            submitHandler: function (form) {
                var form_data = $("#fundsdep_form").serialize();

                transction_deposit.ajax_req(form_data, '/fundsdep_action').done(function (response) {
                    var res = $.parseJSON(response);
                    if(res.type == "success"){
                        transction_deposit.call_scoket_deposit(res.address);
                        jQuery('#modal_ajax .modal-body').html('<div style="text-align:center;"></div>');
                        jQuery('#modal_ajax').modal('show', {backdrop: 'true'});
                        jQuery('#modal_ajax .modal-title').html("");
                        jQuery('#modal_ajax .modal-body').html("");
                        jQuery('#modal_ajax .modal-title').html('<strong> Deposit Balance</strong>');
                        jQuery('#modal_ajax .modal-body').html(res.data);
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
    _fetch_data_dep : function(){
        $(document).ready(function () {
            var table = $('.data-table_funddep').DataTable({
                processing: true,
                serverSide: true,
                ajax: base_url+'/fetch_dep_data',
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
    ajax_req_get: function(url) {
        return $.ajax({
            url:base_url+url,
            type:'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },      
            datatype : "application/json"
        });
    },
};