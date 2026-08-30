<script type="text/javascript">    
function validasi(){
    if(requiredCheck($('#mcpengajuangantikm-t-form'))){
        var jml = $('#gantikacamata-t-grid tbody tr').find("input[name$='[cekList]']").length;
        if(jml < 1){
            myAlert('Silakan pilih pergantian kacamata!');
            return false;
        }
        else{
            $('#mcpengajuangantikm-t-form').submit();
        }
    }
    return false;
}
function setNol(obj){
    if($(obj).is(":checked")){
        obj.value = 1;
    }else{
        obj.value = 0;
    }
}

function print(caraPrint)
{
    var formuliropname_id = '<?php echo isset($_GET['formuliropname_id']) ? $_GET['formuliropname_id'] : null; ?>';
    window.open('<?php echo $this->createUrl('print'); ?>&formuliropname_id='+formuliropname_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
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
 * pilih / tidak semua pergantian kacamata
 * @param {type} obj
 * @returns {undefined}
 */
function pilihSemua(obj){
	if($(obj).is(":checked")){
		$(".cekList").val(1);
		$(".cekList").attr("checked",true);
	}else{
		$(".cekList").val(0);
		$(".cekList").attr("checked",false);
	}
	hitungTotal();
}

function hitungTotal(){
    unformatNumberSemua();
	$('#totalharga').addClass('animation-loading-1');
    var obj_totalharga =  $('#totalharga');
    var totalharga = 0;
	setTimeout(function(){
		$('#gantikacamata-t-grid table tbody tr').each(function(){
			var checked = $(this).find('input[name*="[cekList]"]').val();
			if(checked == 1){
				totalharga += parseFloat($(this).find('input[name*="[jumlahharga_km]"]').val());
			}
		});
		obj_totalharga.val(totalharga);    
		formatNumberSemua();
		$('#totalharga').removeClass('animation-loading-1');
	},500);
}

/**
 * function ini harus tetap berada di bawah
 */
$(document).ready(function(){
	<?php if(isset($_GET['sukses'])){ ?>
		$("input, select, textarea").attr('disabled', true);
	<?php } ?> 
           
	 cekDisabled($('#mcpengajuangantikm-t-form'));
});
</script>