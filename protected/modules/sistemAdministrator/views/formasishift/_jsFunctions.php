<script type="text/javascript">

function tambahFormasi()
{
	unformatNumberSemua();
	var ruangan_id = $('#ruangan_id').val();
	var shift_id = $('#shift_id').val();
	var jmlformasi = $('#jmlformasi').val();
			
	if (ruangan_id == ''){
		myAlert('Ruangan belum dipilih!');
	}else if(shift_id == ''){
		myAlert('Shift belum ditentukan!');
	}else if(jmlformasi == ''){
		myAlert('Jumlah Formasi belum ditentukan!');
	}else{
		$.ajax({
			type:'POST',
			url:'<?php echo $this->createUrl('SetFormFormasiShift'); ?>',
			data: {ruangan_id:ruangan_id,shift_id:shift_id,jmlformasi:jmlformasi},
			dataType: "json",
			success:function(data){
				if(data.pesan !== ""){
					myAlert(data.pesan);
					return false;
				}
				$('#table-formasiShift > tbody').append(data.form);
				$("#table-formasiShift").find('input[name*="[ii]"][class*="integer"]').maskMoney(
					{"symbol":"","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":0}
				);	
				renameInputRow($("#table-formasiShift"));       

				$('#ruangan_id').val('');
				$('#shift_id').val('');
				$('#jmlformasi').val('');
				formatNumberSemua();
			},
			error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
		});
	}
	formatNumberSemua();
}

/**
* rename input grid
*/ 
function renameInputRow(obj_table){
    var row = 0;
    $(obj_table).find("tbody > tr").each(function(){
        $(this).find("#no_urut").val(row+1);
        $(this).find('span').each(function(){ //element <input>
            var old_name = $(this).attr("name").replace(/]/g,"");
            var old_name_arr = old_name.split("[");
            if(old_name_arr.length == 3){
                $(this).attr("name","["+row+"]["+old_name_arr[2]+"]");
            }
        });
        $(this).find('input,select,textarea').each(function(){ //element <input>
            var old_name = $(this).attr("name").replace(/]/g,"");
            var old_name_arr = old_name.split("[");
            if(old_name_arr.length == 3){
                $(this).attr("id",old_name_arr[0]+"_"+row+"_"+old_name_arr[2]);
                $(this).attr("name",old_name_arr[0]+"["+row+"]["+old_name_arr[2]+"]");
            }
        });
        row++;
    });
    
}

function formatNumberSemua(){
    $(".integer").each(function(){
        $(this).val(formatInteger($(this).val()));
    });
}

</script>