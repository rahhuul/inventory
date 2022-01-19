<!-- SIMPLE AJAX MODAL -->
<script type="text/javascript">
    function showAjaxModal(url,title)
    {
        // SHOWING AJAX PRELOADER IMAGE
        jQuery('#modal_ajax .modal-body').html('Please wait ... ');

        // LOADING THE AJAX MODAL
        jQuery('#modal_ajax').modal('show', {backdrop: 'true'});
        
        // SHOW AJAX RESPONSE ON REQUEST SUCCESS
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
    }
</script>
<div class="modal fade" id="modal_ajax" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" style="width:55%;">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
        <button type="button" class="btn btn-default" id="btnclose" data-dismiss="modal">Close</button>
      </div>
        </div>
    </div>
</div>