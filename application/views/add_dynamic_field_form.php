<script type="text/javascript">
var sequence_index='<?php echo $sequence_index; ?>';
$(document).ready(function(){
	$('.alldate').datepicker();
	$('.onlypast').datepicker({
		maxDate: new Date()
	});
	$('.onlyfuture').datepicker({
		minDate: 0
	});
	$('select.is_required_field').each(function(){
		var ele=$(this).parent().find(".select2-container").length;
		if(ele){
			$(this).parent().find(".select2-container").addClass("is_required_field_select2");
		}
	});
});
function AddNewField(){
	sequence_index++;
	$('#add_fields_form').fadeIn(0);
	$('#reviewform').fadeOut(0);
	var index=$('.add_dynamic_fields').length;
	$('#dynamic_form_fields').append('<div class="form-group add_dynamic_fields"><div class="row"><div class="col-lg-3 col-md-12"><label>Field Sequence</label><input type="number" id="sequence_no'+index+'" name="sequence_no['+index+']" class="form-control" value="'+sequence_index+'" placeholder="Enter Sequence of this Field" min="0"></div><div class="col-lg-3 col-md-12"><label>Form Input Type <font color="red">*</font></label><select class="form-control" id="field_type'+index+'" name="field_type['+index+']" onchange="changeControlType(this);" required data-msg-required="Please Select Form Input Type"><option value="">Choose Form Input Type</option><option value="text">Text</option><option value="textarea">Textarea</option><option value="number">Number</option><option value="dropdown">Dropdown</option><option value="date">Date</option><option value="checkbox">Checkbox</option><option value="radio">Radio</option><option value="file">File Upload</option></select><label id="field_type'+index+'-error" class="error validationerror" for="field_type'+index+'"></label></div><div class="col-lg-3 col-md-12"><label>Required or Not</label><select class="form-control" name="is_required['+index+']" id ="is_required'+index+'" ><option value="0">Not Required</option><option value="1">Required</option></select></div><div class="col-lg-3 col-md-12"><label>Field Name <font color="red">*</font></label><input type="text" id="field_name'+index+'" name="field_name['+index+']" class="form-control" value="" placeholder="Enter Name for Field" required data-msg-required="Enter Field Name"><label id="field_name'+index+'-error" class="error validationerror" for="field_name'+index+'"></label></div></div><div class="row"><div class="col-lg-4 col-md-4"><label>Add Note</label><textarea class="form-control" id="comments'+index+'" name="comments['+index+']" ></textarea></div></div></div><div id="dynamic_field'+index+'"></div><hr/>');
}
function cancelAddNew(){
	sequence_index='<?php echo $sequence_index; ?>';
	$('#dynamic_form_fields').html('');
	$('#add_fields_form').fadeOut(0);
	$('#reviewform').fadeIn(0);
}
function changeControlType(ele){
	var field_type=$(ele).val();
	var index=$(ele).attr('id');
	index=index.replace('field_type','');
	var file_extension=$('#file_extension').html();
	$("#dynamic_field"+index).html('');
	if(field_type){
		if(field_type=="number"){
			$("#dynamic_field"+index).append("<div class='form-group'><div class='row'><div class='col-lg-4 col-md-4'><label>Minimum Number Requirement</label><input type='number' name='min_number["+index+"][]' id='min_number"+index+"' class='form-control' placeholder='Enter Minimum Number Of Requirement' style='width:90%' min='0' ></div><div class='col-lg-4 col-md-4'><label>Maximum Number Requirement</label><input type='number' name='max_number["+index+"][]' id='max_number"+index+"' class='form-control' placeholder='Enter Maximum Number Of Requirement' style='width:90%' min='1'></div></div></div>");
		}else if(field_type=="dropdown"){
			$("#dynamic_field"+index).append("<div class='form-group'><div class='row'><div class='col-lg-12 col-md-12'><label>How many Option Do You Want In Drodown Box? <font color='red'>*</font></label><input type='number' name='dropdown_val_count["+index+"][]' id='dropdown_val_count"+index+"' class='form-control' placeholder='Enter Number Of Option You Want For Drodown' required data-msg-required='Enter number of options for dropdown' style='width:30%' min='1' onchange='addDdlOption("+index+");'><label id='dropdown_val_count"+index+"-error' class='error validationerror' for='dropdown_val_count"+index+"'></label></div></div></div>");
		}else if(field_type=="checkbox"){
			$("#dynamic_field"+index).append("<div class='form-group'><div class='row'><div class='col-lg-12 col-md-12'><label>How many Values Do You Want For Checkbox? <font color='red'>*</font></label><input type='number' name='checkbox_val_count["+index+"][]' id='checkbox_val_count"+index+"' class='form-control' placeholder='Enter Number Of Option You Want For Checkbox' required data-msg-required='Enter number of options for checkbox' style='width:30%' min='1' onchange='addCbOption("+index+");'><label id='checkbox_val_count"+index+"-error' class='error validationerror' for='checkbox_val_count"+index+"'></label></div></div></div>");
		}else if(field_type=="radio"){
			$("#dynamic_field"+index).append("<div class='form-group'><div class='row'><div class='col-lg-12 col-md-12'><label>How many Values Do You Want For Radio Button? <font color='red'>*</font></label><input type='number' name='radio_val_count["+index+"][]' id='radio_val_count"+index+"' class='form-control' placeholder='Enter Number Of Option You Want For Radio Button' required data-msg-required='Enter number of options' style='width:30%' min='1' onchange='addRdOption("+index+");'><label id='radio_val_count"+index+"-error' class='error validationerror' for='radio_val_count"+index+"'></label></div></div></div>");
		}else if(field_type=="file"){
			$("#dynamic_field"+index).append("<div class='form-group'><div class='row'><div class='col-lg-4 col-md-4'><label>Maximum Upload <font color='red'>*</font></label><input type='number' name='max_upload["+index+"][]' id='max_upload"+index+"' class='form-control' placeholder='Enter Maximum Number Of Upload' style='width:90%' min='1'value='1' required data-msg-required='Enter number of max upload'><label id='max_upload"+index+"-error' class='error validationerror' for='max_upload"+index+"'></label></div><div class='col-lg-4 col-md-4'><label>File Extension <font color='red'>*</font></label><select class='form-control select2' id='file_extension"+index+"' name='file_extension["+index+"][]' multiple required data-msg-required='Please Select File Extension'>"+file_extension+"</select><label id='file_extension"+index+"-error' class='error validationerror' for='file_extension"+index+"'></label></div></div></div>");
		}else if(field_type=="date"){
			$("#dynamic_field"+index).append("<div class='form-group'><div class='row'><div class='col-lg-4 col-md-4'><label>Date Validation <font color='red'>*</font></label><select class='form-control' id='date_validation"+index+"' name='date_validation["+index+"][]'  required data-msg-required='Please Select Date Validation'><option value=''>--Select--</option><option value='alldate'>All</option><option value='onlypast'>Only Past Date</option><option value='onlyfuture'>Only Future Date</option></select><label id='date_validation"+index+"-error' class='error validationerror' for='date_validation"+index+"'></label></div></div></div>");
		}
		$('.select2').select2({
			placeholder: "--Select--",
		});
	}
}
function addDdlOption(index){
	var option_count = $('#dropdown_val_count'+index).val();
	var j=1;
	for(var i=0;i<option_count;i++){
		$("#dynamic_field"+index).append("<div class='form-group'><div class='row'><div class='col-lg-4 col-md-4'><label>Option Value "+j+" <font color='red'>*</font></label><input type='text' name='field_type_option["+index+"]["+i+"]'  id='field_type_option"+j+"' class='form-control' placeholder='Option Value "+j+"' required data-msg-required='Enter option value' style='width:90%'><label id='field_type_option"+j+"-error' class='error validationerror' for='field_type_option"+j+"'></label></div></div></div>");
		j++;
	}
}
function addCbOption(index){
	var option_count = $('#checkbox_val_count'+index).val();
	var j=1;
	for(var i=0;i<option_count;i++){
		$("#dynamic_field"+index).append("<div class='form-group'><div class='row'><div class='col-lg-4 col-md-4'><label>Option Value "+j+" <font color='red'>*</font></label><input type='text' name='field_type_option["+index+"]["+i+"]'  id='field_type_option"+j+"' class='form-control' placeholder='Option Value "+j+"' required data-msg-required='Enter option value' style='width:90%'><label id='field_type_option"+j+"-error' class='error validationerror' for='field_type_option"+j+"'></label></div></div></div>");
		j++;
	}
}
function addRdOption(index){
	var option_count = $('#radio_val_count'+index).val();
	var j=1;
	for(var i=0;i<option_count;i++){
		$("#dynamic_field"+index).append("<div class='form-group'><div class='row'><div class='col-lg-4 col-md-4'><label>Option Value "+j+" <font color='red'>*</font></label><input type='text' name='field_type_option["+index+"]["+i+"]'  id='field_type_option"+j+"' class='form-control' placeholder='Option Value "+j+"' required data-msg-required='Enter option value' style='width:90%'><label id='field_type_option"+j+"-error' class='error validationerror' for='field_type_option"+j+"'></label></div></div></div>");
		j++;
	}
}
</script>