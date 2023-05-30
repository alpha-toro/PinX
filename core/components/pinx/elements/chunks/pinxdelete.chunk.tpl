<form action="#" method="POST">
    
    <input type="hidden" name="pinxid" id="pinxid">
    
    <div class="py-2 clearfix">
        <button type="submit" id="pinxDelete" class="btn">Yes, Delete this Image</button>
    </div>    
    
    <div id="pinxError" class="alert alert--danger"></div>
</form>


<script>

$(document).ready(function() {
    
    // this button should open a modal in your website to show form
    $('.pin-del').on('click', function(e){
       e.preventDefault();
       
       $('#pinxError').html('');
       
       var id = $(this).data('pinxid');
       $('#pinxid').val(id);
       
    });
    
    $('#pinxDelete').on('click', function(e){
        var pinxid = $('#pinxid').val();
        
        e.preventDefault();
        $.post("/pinx-delete.json", { 
            pinxid:  pinxid
        },function(response) {})
        .always(function(response) {
    		if(response.status == "200"){
    		    //show success
    		    location.reload();
    		}
    		if(response.status == "400"){
    		 //show error
    		 $('#pinxError').html('Oops, something went wrong trying to delete.');
    		}
    	});
    });
});    
</script>