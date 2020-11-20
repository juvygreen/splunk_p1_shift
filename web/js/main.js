

function doShift(id, flag){
  
  hasError = false;
  var postUrl = "update";
  var elem_status_id = "#shift_status"+id;
  var elem_engr_id = "#shift_engr"+id;
  var elem_phone_id = "#shift_phone"+id;
  var elem_msg_id = "#shift_msg"+id;
  var elem_msg_input_id = "#shift_msg_input"+id;
  var elem_action_id = "#shift_action"+id;
  var elem_answered = "#shift_answered"+id;
  var elem_missed = "#shift_missed"+id;
  var elem_day_abr = "#shift_day_abr"+id;
  
  var comment = "";
  
  if($(elem_status_id).prop('checked')){
    var mode = "on"; // on/4
    $(elem_engr_id).css('color', 'black');
    $(elem_phone_id).css('color', 'blue');
    $(elem_answered).css('color', 'black');
    $(elem_missed).css('color', 'black');
    $(elem_day_abr).css('color', 'black');
    $(elem_action_id).prop('disabled', false);
    $(elem_msg_id).html("");
  } else {
    var mode = "off"; // off/5
    var msg_input_id = "shift_msg_input"+id;
    $(elem_engr_id).css('color', 'red');
    $(elem_phone_id).css('color', 'red');
    $(elem_answered).css('color', 'red');
    $(elem_missed).css('color', 'red');
    $(elem_day_abr).css('color', 'red');
    $(elem_action_id).prop('disabled', true);
    
    if(flag == 0)
      $(elem_msg_id).html('<input onBlur="doShift('+id+', 1);" type="text" class="form-control" id="'+msg_input_id+'" placeholder="If marking yourself unavailable, fill this field.">');
    else
      var comment = $(elem_msg_input_id).val();
  }
  
  
  
  if(!hasError){
    $.ajax({
				url: postUrl,
				method: 'POST',
				data: {
          engr: id,
					mode: mode,
          comment: comment,
          flag: flag
				},
				complete: function (data) {
					//alert(data['responseText']);
					
          data = JSON.parse(data['responseText']);
          
          var idxw = "spanckcc"+id;
					var jidx = "#spanckcc"+id;
          
          if(mode == "off"){
            if(flag == 1){
              if ('error' in data && data['error'] !== null) {
                // display error
                $(elem_msg_input_id).after("<span id=\""+idxw+"\" style='color:red;'>&nbsp;&nbsp;<i class=\"fa fa-times\"></i></span>");
              } else {
                          
                //$(elem_msg_input_id).after("<span id=\""+idxw+"\" style='color:blue;'>&nbsp;&nbsp;<i class=\"fa fa-check\"></i></span>");
              }
              
              //$(jidx).finish().show().delay(2500).fadeOut("slow");
              //$(elem_msg_input_id).css('color', 'red');
              $(elem_msg_input_id)
              .delay(2000)
              .queue(function (next) { 
                $(this).css('color', 'red');
                $(this).css('font-weight', 'bold');
                $(this).css('margin-bottom', '-5px');
                $(this).css('margin-top', '-5px');
                $(this).css('background', 'transparent');
                $(this).css('border', 'none');
                $(this).css('padding', '0px');
                next(); 
              });
            }
          }
				}
		});
  }

  
}


function rotateAssign(id, table){
  
  hasError = false;
  var elem_status_id = "#shift_status"+id;
  var elem_engr_id = "#shift_engr"+id;
  var elem_action_id = "#shift_action"+id;
  var elem_answered = "#shift_answered"+id;
  var elem_missed = "#shift_missed"+id;
  var elem_day_abr = "#shift_day_abr"+id;
  var elem_table = "#"+table;
  
  var postUrl = "rotate-assign";
  var status = $(elem_status_id).val();
  //var engr = $(elem_engr_id).val();
  var action = $(elem_action_id).val();
  
  
  if(!hasError){
    $.ajax({
				url: postUrl,
				method: 'POST',
				data: {
          engr: id,
					action: action
				},
				complete: function (data) {
					//alert(data['responseText']);
					
          data = JSON.parse(data['responseText']);
          var sum_answered = data["sum_answered"];
          var sum_missed = data["sum_missed"];
          var day_abr = data["day_abr"];
          
          if(sum_missed["sum_missed"] == null)
            sum_missed["sum_missed"] = "";
          
          var idxw = "spanck"+id;
					var jidx = "#spanck"+id;
          
					if ('error' in data && data['error'] !== null) {
						// display error
						$(elem_action_id).after("<span id=\""+idxw+"\" style='color:red;'>&nbsp;&nbsp;<i class=\"fa fa-times\"></i></span>");
					} else {
            
            if(action == 1){
              if(sum_answered["sum_answered"] != null)
                $(elem_answered).html("<strong>"+sum_answered["sum_answered"]+"</strong>");
            
                $(elem_day_abr).html("<strong>"+day_abr+"</strong>");
            }
            
            if(action == 2){
              if(sum_missed["sum_missed"] != null)
                $(elem_missed).html("<strong>"+day_abr+"</strong>");
            }
            //$(elem_missed).html("<strong>"+sum_missed["sum_missed"]+"</strong>");
            //$(elem_day_abr).html("<strong>"+day_abr+"</strong>");
            
            
            $(elem_action_id).after("<span id=\""+idxw+"\" style='color:blue;'>&nbsp;&nbsp;<i class=\"fa fa-check\"></i></span>");
          }
          
         
					$(jidx).finish().show().delay(2500).fadeOut("slow");
          $(elem_table).DataTable().destroy();
           var table = $(elem_table).DataTable( {
              "paging":   false,
              "searching": false,
              "info":     false,
              "order": [[ 4, "asc" ]],
              "columnDefs": [
                            { "orderable": false, "targets": [0,1,2,3,5,6,7] }
                            ]
          } );
				}
		});
  }
}

function changeRole(){
  
  var roles = $("#p1_roles").val();
  
  if(roles == 2){
    $('#div_sg_engr').hide();
    $('#div_sg_mngr').show();
    $('#div_shift').hide();
  } else {
    $('#div_sg_engr').show();
    $('#div_sg_mngr').hide();
    $('#div_shift').show();
  }
}

function retrieveShift(){
  hasError = false;
  var postUrl = "retrieve-shift";
  var roles = $("#p1_roles").val();
  var region = $("#p1_region").val();
  if(roles == 2){
    var support_group = $("#p1_support_group_mngr").val();
  } else {
    var support_group = $("#p1_support_group_engr").val();
  }
  
  if(region == "")
    hasError = true;
  
  if(support_group == "")
    hasError = true;
  
  if(!hasError){
    $.ajax({
				url: postUrl,
				method: 'POST',
				data: {
          roles: roles,
					region: region,
					support_group: support_group
				},
				complete: function (data) {
					//alert(data['responseText']);
					data = JSON.parse(data['responseText']);
					var shifts = data["model"];
					if ('error' in data && data['error'] !== null) {
						// display error
						$("#msg-message").html("<p id='profileresult' style='color:red;'>"+data['error']+"</p>");
					} else {
						
						var id = "#p1_support_group_shift";
						$(id).empty();
						var options = "";
						
						for (i = 0; i < shifts.length; i++) {
							options += "<option value=\""+shifts[i]["id"]+"\">"+shifts[i]["name"]+"</option>";
						}
            //alert(options);
						$(id).append(options);
						$(id).prop('selectedIndex', 0);
          }
				}
		});
  }
}

function addP1Shift(){
  hasError = false;
  var msg = "";
  var postUrl = "add-p1-shift";
  $("#div_p1_msg").hide();
  $("#p1_msg").html(msg);
  var postUrl = "add-p1-shift";
  var email = $("#p1_email").val();
  var name = $("#p1_name").val();
  var phone = $("#p1_phone").val();
  var slack_url = $("#p1_slack_url").val();
  var roles = $("#p1_roles").val();
  var timezone = $("#p1_timezone").val();
  var region = $("#p1_region").val();
  var support_group_shift = "";
  var support_group = "";
  if(roles == 2)
    var support_group = $("#p1_support_group_mngr").val();
  else
    var support_group = $("#p1_support_group_engr").val();
  
  
  if(!validateEmail(email)){
			hasError = true;
			if(msg != "")
				msg += "<br>";
			
			msg += "<font color=red> Invalid Email</font>";
			$("#p1_email").focus();
  }
  
  if (name.length <= 0) {
			hasError = true;
			if(msg != "")
				msg += "<br>";
			
			msg += "<font color=red> Please Enter Your Name</font>";
			$("#p1_name").focus();
	}
  
  if (phone.length <= 0) {
			hasError = true;
			if(msg != "")
				msg += "<br>";
			
			msg += "<font color=red> Please Enter Your Phone</font>";
			$("#p1_phone").focus();
	}
    
  if (roles.length <= 0) {
			hasError = true;
			if(msg != "")
				msg += "<br>";
			
			msg += "<font color=red> Please Select Role</font>";
			$("#p1_roles").focus();
	}
  
  if (timezone.length <= 0) {
			hasError = true;
			if(msg != "")
				msg += "<br>";
			
			msg += "<font color=red> Please Select Timezone</font>";
			$("#p1_timezone").focus();
	}
    
  if (region.length <= 0) {
			hasError = true;
			if(msg != "")
				msg += "<br>";
			
			msg += "<font color=red> Please Select Region</font>";
			$("#p1_region").focus();
	}
  
  var ifSelected = true;
  if(roles == 2){
    if (support_group == null) {
        var ifSelected = false;
        hasError = true;
        if(msg != "")
          msg += "<br>";
        
        msg += "<font color=red> Please Select Support Group</font>";
        $("#p1_support_group_mngr").focus();
    }
  } else {
    if (support_group.length <= 0) {
      var ifSelected = false;
        hasError = true;
        if(msg != "")
          msg += "<br>";
        
        msg += "<font color=red> Please Select Support Group</font>";
        $("#p1_support_group_engr").focus();
    }
  }
  
  
  if(ifSelected){
    var support_group_shift = $("#p1_support_group_shift").val();
    if (support_group_shift.length <= 0) {
      hasError = true;
      if(msg != "")
        msg += "<br>";
      
      msg += "<font color=red> Please Select Shift</font>";
      $("#p1_support_group_shift").focus();
    }
  }
  
  
  
  if(!hasError){
    $.ajax({
				url: postUrl,
				method: 'POST',
				data: {
          email: email,
          name: name,
          phone: phone,
          slack_url: slack_url,
          roles: roles,
          timezone: timezone,
					region: region,
					support_group: support_group,
          support_group_shift: support_group_shift
				},
				complete: function (data) {
					//alert(data['responseText']);
					var str = data['responseText'].split("|");
           $("#div_p1_msg").show();
          
					if(data['responseText'].substr(0,2) == "ok"){
            $("#p1_msg").html("<p style='color:blue;'>Success!</p>");
					} else {
						$("#p1_msg").html("<p style='color:red;'>"+data['responseText']+"</p>");
					}
				}
		});
  } else {
    $("#div_p1_msg").show();
		$("#p1_msg").html("<p style='color:red;'>"+msg+"</p>");
    return false;
	}
}


function validateEmail(email) {
    var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
    if (!pattern.test(email)) {
        return false;
    }
    return true;
}


$(document).ready(function() {
  
  hasError = false;
  var postUrl = "retrieve-tables";
  var status = 1;
  
  if(!hasError){
    $.ajax({
				url: postUrl,
				method: 'POST',
				data: {
          status: status
				},
				complete: function (data) {
					//alert(data['responseText']);
					data = JSON.parse(data['responseText']);
					var tables = data["tables"];
					if ('error' in data && data['error'] !== null) {
						// display error
						$("#msg-message").html("<p id='profileresult' style='color:red;'>"+data['error']+"</p>");
					} else {
						
						var str = "";
						
            for (i = 0; i < tables.length; i++) {
						    str += tables[i]["shift_table"]+", ";
                
                var elem_table = "#table-"+tables[i]["shift_table"];
                
                $(elem_table).DataTable( {
                    "paging":   false,
                    "searching": false,
                    "info":     false,
                    "order": [[ 4, "asc" ]],
                    "columnDefs": [
                                  { "orderable": false, "targets": [0,1,2,3,5,6,7] }
                                  ]
                } );
                
            }
            //alert(str);
						
          }
				}
		});
  
  
  } else {
  
  
  
  
    $('#table-tab-cloudamer1').DataTable( {
        "paging":   false,
        "searching": false,
        "info":     false,
        "order": [[ 4, "asc" ]],
        "columnDefs": [
                      { "orderable": false, "targets": [0,1,2,3,5,6,7] }
                      ]
    } );
    
    $('#table-tab-cloudamer2').DataTable( {
        "paging":   false,
        "searching": false,
        "info":     false,
        "order": [[ 4, "asc" ]],
        "columnDefs": [
                      { "orderable": false, "targets": [0,1,2,3,5,6,7] }
                      ]
    } );
    
    $('#table-tab-cloudamer3').DataTable( {
        "paging":   false,
        "searching": false,
        "info":     false,
        "order": [[ 4, "asc" ]],
        "columnDefs": [
                      { "orderable": false, "targets": [0,1,2,3,5,6,7] }
                      ]
    } );
    
    $('#table-tab-cloudamer4').DataTable( {
        "paging":   false,
        "searching": false,
        "info":     false,
        "order": [[ 4, "asc" ]],
        "columnDefs": [
                      { "orderable": false, "targets": [0,1,2,3,5,6,7] }
                      ]
    } );
    
  }
  
} );








