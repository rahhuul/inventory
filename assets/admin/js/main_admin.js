var base_url = $("#myBase").attr('href');
$(function() {
    cubemine_admin.init();
});

cubemine_admin = {
    init:function () {
        

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
}
