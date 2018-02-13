<!--Switches-->
<script type="text/javascript">
$(document).ready(function() {

    
    $('#opt1').change(function() {
        if($(this).is(":checked")) {
            $(this).attr("checked", true);
        }
        var status = $(this).is(':checked');
		if(status == true) {
			$('.status').text("True");
		}
		else {
			$('.status').text("False");
		}
    });
});
</script>
<style>
.onoffswitch {
    position: relative; width: 46px;
    -webkit-user-select:none; -moz-user-select:none; -ms-user-select: none;
}
.onoffswitch-checkbox {
    display: none;
}
.onoffswitch-label {
    display: block; overflow: hidden; cursor: pointer;
    height: 20px; padding: 0; line-height: 20px;
    border: 2px solid #CCCCCC; border-radius: 20px;
    background-color: #DBDBDB;
    transition: background-color 0.3s ease-in;
}
.onoffswitch-label:before {
    content: "";
    display: block; width: 20px; margin: 0px;
    background: #FFFFFF;
    position: absolute; top: 0; bottom: 0;
    right: 24px;
    border: 2px solid #CCCCCC; border-radius: 20px;
    transition: all 0.3s ease-in 0s; 
}
.onoffswitch-checkbox:checked + .onoffswitch-label {
    background-color: #46EBE0;
}
.onoffswitch-checkbox:checked + .onoffswitch-label, .onoffswitch-checkbox:checked + .onoffswitch-label:before {
   border-color: #46EBE0;
}
.onoffswitch-checkbox:checked + .onoffswitch-label:before {
    right: 0px; 
}
</style>
<div class="onoffswitch">
    <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="opt1">
    <label class="onoffswitch-label" for="opt1"></label>
</div>
<!--end-->