<script type="text/javascript">
function setSaldoBank(obj){
	var bank_id = $(obj).val();
	$.post('<?php echo $this->createUrl('setSaldoBank'); ?>',{
		bank_id:bank_id
	},
		function(data){
			if(data != null){
				$('#<?php echo CHtml::activeId($model,'rekonsiliasibank_saldobank'); ?>').val(data.saldobank);
				formatNumberSemua();
			}
	}, "json");
}

function setRekonsiliasiBank(){
	var jenisrekonsiliasibank_id = $('#jenisrekonsiliasibank_id').val();
	
	$("#tabel-detailrekonsiliasi > tbody").empty();
	$.post('<?php echo $this->createUrl('setRekonsiliasiBank'); ?>',{
		jenisrekonsiliasibank_id:jenisrekonsiliasibank_id
	},
		function(data){
			if(data.pesan == ''){
				$("#tabel-detailrekonsiliasi > tbody").append(data.form);
				$("#tabel-detailrekonsiliasi").find('input[name*="[ii]"][class*="integer2"]').maskMoney(
					{"symbol":"","defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":0}
				);
				renameInputRow($('#tabel-detailrekonsiliasi'));
				clearInputan();
			}else{
				myAlert(data.pesan);
				clearInputan();
			}
	}, "json");
}

function setRekonsiliasiBankRekening(){
	var jenisrekonsiliasibank_id = $('#jenisrekonsiliasibank_id').val();
	var rekening1_id= $('#rekening1_id').val();
	var rekening2_id= $('#rekening2_id').val();
	var rekening3_id= $('#rekening3_id').val();
	var rekening4_id= $('#rekening4_id').val();
	var rekening5_id= $('#rekening5_id').val();
	var rekening5_nb	= $('#rekening5_nb').val();
	
	if(jenisrekonsiliasibank_id != ''){
		$.post('<?php echo $this->createUrl('setRekonsiliasiBankRekening'); ?>',{
			jenisrekonsiliasibank_id:jenisrekonsiliasibank_id, rekening1_id:rekening1_id, rekening2_id:rekening2_id, rekening3_id:rekening3_id, rekening4_id:rekening4_id, rekening5_id:rekening5_id, rekening5_nb:rekening5_nb
		},
			function(data){
				if(data.pesan == ''){
					$("#tabel-detailrekonsiliasi > tbody").append(data.form);
					$("#tabel-detailrekonsiliasi").find('input[name*="[ii]"][class*="integer2"]').maskMoney(
						{"symbol":"","defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":0}
					);
					renameInputRow($('#tabel-detailrekonsiliasi'));
					clearInputan();
				}else{
					myAlert(data.pesan);
					clearInputan();
				}
		}, "json");
	}else{
		myAlert('Silakan pilih jenis rekonsiliasi bank terlebih dahulu!');
	}
}

function clearInputan(){
	$('#rekening1_id').val('');
	$('#rekening2_id').val('');
	$('#rekening3_id').val('');
	$('#rekening4_id').val('');
	$('#rekening5_id').val('');
	$('#rekening5_nb').val('');
}

/**
 * menghapus detail rekonsiliasi bank
 * @returns {undefined} */
function batalRekening(obj){
    myConfirm("Apakah Anda akan membatalkan rekening ini?","Perhatian!",
    function(r){
        if(r){
           $(obj).parents('tr').detach();
        }
    }); 
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

function verifikasi(){
    if(requiredCheck($("#akrekonsiliasibank-t-form"))){
        var jml_rekonsiliasi = $('#tabel-detailrekonsiliasi tbody tr').length;
		if(jml_rekonsiliasi <= 0){
			myAlert('Silakan isikan rekonsiliasi bank terlebih dahulu!');
            return false;
        }else{
            $('#akrekonsiliasibank-t-form').submit();
        }
        
        $(".animation-loading").removeClass("animation-loading");
        $("form").find('.float').each(function(){
            $(this).val(formatFloat($(this).val()));
        });
        $("form").find('.integer2').each(function(){
            $(this).val(formatInteger($(this).val()));
        });
    }
    return false;    
}

/**
* untuk print hasil treadmill
 */
function print(caraPrint)
{
    var rekonsiliasibank_id = '<?php echo isset($model->rekonsiliasibank_id) ? $model->rekonsiliasibank_id : null ?>';
    window.open('<?php echo $this->createUrl('print'); ?>&rekonsiliasibank_id='+rekonsiliasibank_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
}

/**
 * class integer di unformat 
 * @returns {undefined}
 */
function unformatNumberSemua(){
    $(".integer2").each(function(){
        $(this).val(parseInt(unformatNumber($(this).val())));
    });
}
/**
 * class integer di format kembali
 * @returns {undefined}
 */
function formatNumberSemua(){
    $(".integer2").each(function(){
        $(this).val(formatInteger($(this).val()));
    });
}	

$(document).ready(function(){
	<?php if(isset($_GET['rekonsiliasibank_id']) && isset($_GET['sukses'])){ ?>
        var rekonsiliasibank_id = <?php echo isset($_GET['rekonsiliasibank_id']) ? $_GET['rekonsiliasibank_id']:'' ?>;
        $("#tabel-detailrekonsiliasi :input").removeAttr("readonly",true);
        $("#tabel-detailrekonsiliasi .add-on").remove();
        $("#tabel-detailrekonsiliasi .icon-remove").remove();        
        
        $("#akrekonsiliasibank-t-form :input").attr("readonly",true);
        $("#akrekonsiliasibank-t-form .dtPicker3").attr("readonly",true);
        $("#akrekonsiliasibank-t-form .add-on").remove();
        $("#akrekonsiliasibank-t-form .btn-mini").remove();
        
        $("input, select, textarea").attr("disabled",true);  
    <?php } ?>
});
</script>