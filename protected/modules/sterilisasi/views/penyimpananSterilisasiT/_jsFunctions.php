<script type="text/javascript">
function setNol(obj){
    if($(obj).is(":checked")){
        obj.value = 1;
    }else{
        obj.value = 0;
    }
	$("#STPenyimpanansterilT_penyimpanansteril_no").blur();
}

function checkAll(){
    $("#tabel-sterilisasi > tbody > tr").find('input[type="checkbox"]').each(
    function(){
        if($("#check_semua").is(":checked")){
            $(this).attr('checked','checked');
        }else{
            $(this).removeAttr('checked');
        }
		$("#STPenyimpanansterilT_penyimpanansteril_no").blur();
    });
}

function validasiCek(){
    if(requiredCheck($("form"))){
        var jumlah_bahan = $('#tabel-sterilisasi tbody tr').length;
        if(jumlah_bahan <= 0){
                myAlert('Silakan isikan data sterilisasi terlebih dahulu!');
            return false;
        }else{
            $('#penyimpanansteril-t-form').submit();
        }
        
        $(".animation-loading").removeClass("animation-loading");
        $("form").find('.float').each(function(){
            $(this).val(formatFloat($(this).val()));
        });
        $("form").find('.integer').each(function(){
            $(this).val(formatInteger($(this).val()));
        });
    }
    return false;    
}

/**
* untuk print perawatan linen
 */
function print(caraPrint)
{
    var penyimpanansteril_id = '<?php echo $modPenyimpananSterilisasi->penyimpanansteril_id; ?>';
    window.open('<?php echo $this->createUrl('print'); ?>&penyimpanansteril_id='+penyimpanansteril_id+'&caraprint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
}

function searchPenerimaan(){
	$('#form-penerimaan').addClass('animation-loading');	
	$.ajax({
		type:'POST',
		url:'<?php echo $this->createUrl('pencarianPenerimaan'); ?>',
		data: {data:$('#pencarian-form').serialize()},//
		dataType: "json",
		success:function(data){
			if(data.pesan !== ""){
				myAlert(data.pesan);
				$('#form-penerimaan').removeClass('animation-loading');
				return false;
			}
			$('#tabel-sterilisasi > tbody').html(data.form);
			renameInputRow($("#tabel-sterilisasi"));
			$('#form-penerimaan').removeClass('animation-loading');
			$("#STPenyimpanansterilT_penyimpanansteril_no").blur();
		},
		error: function (jqXHR, textStatus, errorThrown) { 
			console.log(errorThrown);
			$("#STPenyimpanansterilT_penyimpanansteril_no").blur();
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
/**
 * class integer di unformat 
 * @returns {undefined}
 */
function unformatNumberSemua(){
    $(".integer").each(function(){
        $(this).val(parseInt(unformatNumber($(this).val())));
    });
}
/**
 * class integer di format kembali
 * @returns {undefined}
 */
function formatNumberSemua(){
    $(".integer").each(function(){
        $(this).val(formatInteger($(this).val()));
    });
}

/**
 * function ini harus tetap berada di bawah
 */
$(document).ready(function(){
    var penyimpanansteril_id = '<?php echo $modPenyimpananSterilisasi->penyimpanansteril_id; ?>';
    if(penyimpanansteril_id != ""){
        $("input, textarea, checkbox, select").attr("readonly",true);
        $(".add-on").remove();
        $(".dtPicker3").remove();
        $(".icon-remove").remove();
        renameInputRow($("#tabel-sterilisasi"));
    } 
    
    <?php if (isset($_GET['sterilisasi_id'])) { ?>
        renameInputRow($("#tabel-sterilisasi"));
    <?php } ?>
    /* else {
		setValidasiCekDisabled($("#penyimpanansteril-t-form"), function() {
			if ($("#tabel-sterilisasi .ceklis:checked").length == 0) {
				return false;
			}
			return true;
		});
	} */
	
	
    // cekDisabled($('#penyimpanansteril-t-form'));
});
</script>