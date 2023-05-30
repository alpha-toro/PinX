<form action="#" method="POST">
    <div class="py-6">
        <img src="" id="pinxholder" style="width:300px;margin: 0 auto;">
    </div>    
    <div class="mb-3">
        <label for="pinxnote" class="form-label">Notes about image:</label>
        <input type="text" name="pinxnote" id="pinxnote" class="form-control">
    </div>    
    
    [[!PinXOptions]]
    
    <div class="mb-3">
        <label for="pinxnewlist" class="form-label">New List:</label>
        <input type="text" name="pinxnewlist" id="pinxnewlist" class="form-control">
    </div>
    
    <input type="hidden" name="pinximage" id="pinximage">
    <input type="hidden" name="pinxidx" id="pinxidx">
    
    <div class="pb-2 clearfix">
        <button type="submit" id="pinxProcess" class="btn flex--end">SAVE</button>
    </div>    
    
    <div id="pinxSuccess" class="alert alert--success"></div>
    <div id="pinxError" class="alert alert--danger"></div>
</form>


<script>

$(document).ready(function() {
    
    // this button should open a modal in your website to show form
    $('.pin').on('click', function(e){
       e.preventDefault();
       $('#pinxnote').html(''); $('#pinxnewlist').html('');
       $('#pinxSuccess').html(''); $('#pinxError').html('');
       
       var image = $(this).data('pinximage');
       var idx = $(this).data('pinid');
       $('#pinxholder').attr('src',image);
       $('#pinximage').val(image);
       $('#pinxidx').val(idx);
       
    });
    
    $('#pinxProcess').on('click', function(e){
        var pinxidx = $('#pinxidx').val();
        var listidval = ''; 
        if ($('#pinxlistid').val() != ''){
            var listidval = $('#pinxlistid').val();
        }
        e.preventDefault();
        $.post("/pinx-process.json", { 
            pinxlistid:  listidval,
            pinximage:   $('#pinximage').val(),
            pinxnote:    $('#pinxnote').val(),
            pinxnewlist: $('#pinxnewlist').val() 
        },function(response) {})
        .always(function(response) {
    		if(response.status == "200"){
    		    //show success
    		    $('#pinxSuccess').html('Pinned!');
    		    $('[data-pinid="'+pinxidx+'"]').addClass('pinned');
    		}
    		if(response.status == "400"){
    		 //show error
    		 $('#pinxError').html('Oops, something went wrong trying to save.');
    		}
    	});
    });
});    
</script>