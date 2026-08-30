<?php
/**
* - digunakan untuk menampung semua script javascript, agar mudah di tracing
* 
* @author       M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @website      <piindonesia.co.id>
 *@wiki         <https://piiproject.atlassian.net/wiki/display/MDO>
*/

?>
<script type="text/javascript">
/**
 * print status
 */
function printTimeOut()
{
    window.open('<?php echo $this->createUrl('printTimeOut',array('pasienpenunjang_id'=>$model->pasienmasukpenunjang_id)); ?>','printwin','left=100,top=100,width=793,height=1122,scrollbars=yes');
}

/**
 * - digunakan untuk memilih data form dan checklist timeout
 * @param {type} obj
 * @returns {generate data ke hidden field}
 */
function pilihTimeOutIni(obj){   
	
    var form_id = $(obj).attr('form_id');
	var check_id = $(obj).attr('check_id');
	var status = $(obj).attr('status');
    
	if (status == true){				
		$(obj).parents("tr").find('input[name$="[isdipilih]"][value="'+form_id+check_id+'false"]').prop("checked",false);
	}else if(status == false){
		$(obj).parents("tr").find('input[name$="[isdipilih]"][value="'+form_id+check_id+'true"]').prop("checked",false);
	}
	
	if ($(obj).prop("checked") == false){
		$("#tampung-timeout > tbody > tr ").each(function(){
			if ($(this).find(".identifier").val() == form_id+'_'+check_id){
				var delete_row = $("#tampung-timeout").find('input[name$="[identifier]"][value="'+form_id+'_'+check_id+'"]').parents('tr');
				delete_row.detach();
			}
		});
		renameInputRow($("#tampung-timeout"),'timeout');
		return false;
	}
	
	$.ajax({				
		type: "POST", 
		url: "<?php echo $this->createUrl('AddTambahDetailTimeout')?>", 
		data: {form_id:form_id,check_id:check_id,status:status},
		dataType: "json",
		success: function(data){
			if(data.sukses == 0){
				myAlert(data.pesan);
			}else{		
				$("#tampung-timeout > tbody > tr ").each(function(){
					if ($(this).find(".identifier").val() == data.identifier){
						var delete_row = $("#tampung-timeout").find('input[name$="[identifier]"][value="'+data.identifier+'"]').parents('tr');
						delete_row.detach();
					}
				});
				$("#tampung-timeout > tbody ").append(data.tr);																
				renameInputRow($("#tampung-timeout"),'timeout');
			}

		},
		error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
	});	    
}

/**
 * - digunakan untuk memilih data triase
 * @param {type} obj
 * @returns {generate data ke hidden field}
 */
function pilihTimeOutTextIni(obj){   
	
    var form_id = $(obj).attr('form_id');
	var check_id = $(obj).attr('check_id');	
	var text = $(obj).val();
    		
	if (text == ''){
		$("#tampung-timeout > tbody > tr ").each(function(){
			if ($(this).find(".identifier").val() == form_id+'_'+check_id){
				var delete_row = $("#tampung-timeout").find('input[name$="[identifier]"][value="'+form_id+'_'+check_id+'"]').parents('tr');
				delete_row.detach();
			}
		});
		renameInputRow($("#tampung-timeout"),'timeout');
		return false;
	}
	
	
	
	$.ajax({				
		type: "POST", 
		url: "<?php echo $this->createUrl('AddTambahDetailTimeout')?>", 
		data: {form_id:form_id,check_id:check_id,isian:text},
		dataType: "json",
		success: function(data){
			if(data.sukses == 0){
				myAlert(data.pesan);
			}else{		
				$("#tampung-timeout > tbody > tr ").each(function(){
					if ($(this).find(".identifier").val() == data.identifier){
						var delete_row = $("#tampung-timeout").find('input[name$="[identifier]"][value="'+data.identifier+'"]').parents('tr');
						delete_row.detach();
					}
				});
				$("#tampung-timeout > tbody ").append(data.tr);																
				renameInputRow($("#tampung-timeout"),'timeout');
			}

		},
		error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
	});	    
}

/**
 * rename input row yang terakhir di tambahkan
 * @param {type} obj_table
 */
function renameInputRow(obj_table, get){
    var row = 0;
    $(obj_table).find("tbody > tr").each(function(){                
        $(this).find('input,select,textarea').each(function(){ //element <input>
            var old_name = $(this).attr("name").replace(/]/g,"");
            var old_name_arr = old_name.split("[");
            
            if(old_name_arr.length == 4){
                $(this).attr("id",old_name_arr[0]+"_"+get+"_"+row+"_"+old_name_arr[3]);
                $(this).attr("name",old_name_arr[0]+"["+get+"]["+row+"]["+old_name_arr[3]+"]");
            }
        });
        row++;
    });
    
}
$(document).ready(function(){
	
});
</script>