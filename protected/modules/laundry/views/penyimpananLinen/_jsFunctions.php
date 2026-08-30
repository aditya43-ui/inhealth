<script type="text/javascript">

function updateListRakPenyimpanan(obj) {
	var id = $(obj).val();
	
	$.post('<?php echo $this->createUrl('ajaxGetRakDariLokasi'); ?>', {id: id}, function(data) {
		$(obj).parents("tr").find(".rak").html(data.list);
	}, 'json');
}	
	
function setNol(obj){
    if($(obj).is(":checked")){
        obj.value = 1;
    }else{
        obj.value = 0;
    }
}

/**
 * pilih / tidak semua obat
 * @param {type} obj
 * @returns {undefined}
 */
function pilihSemua(obj){
	if($(obj).is(":checked")){
		$(".checklist").val(1);
		$(".checklist").attr("checked",true);
	}else{
		$(".checklist").val(0);
		$(".checklist").attr("checked",false);
	}
}

function validasiCek(){
//    if(requiredCheck($("form"))){
        //var jumlah_bahan = $('#pencucianlinen-grid > table > tbody > tr > th').length;
        //if(jumlah_bahan < 1){
          //      myAlert('Silakan isikan linen terlebih dahulu!');
            //return false;
        //}else{
            $('#penyimpananlinen-t-form').submit();
        //}
        
//        $(".animation-loading").removeClass("animation-loading");
//        $("form").find('.float').each(function(){
//            $(this).val(formatFloat($(this).val()));
//        });
//        $("form").find('.integer').each(function(){
//            $(this).val(formatInteger($(this).val()));
//        });
//    }
    return false;    
}

/**
* untuk print perawatan linen
 */
function print(caraPrint)
{
    var penyimpananlinen_id = '<?php echo $modPenyimpananLinen->penyimpananlinen_id; ?>';
    window.open('<?php echo $this->createUrl('print'); ?>&penyimpananlinen_id='+penyimpananlinen_id+'&caraprint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
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
    var penyimpananlinen_id = '<?php echo $modPenyimpananLinen->penyimpananlinen_id; ?>';
    if(penyimpananlinen_id != ""){
        $("input, textarea, checkbox, select").attr("readonly",true);
        $(".add-on").remove();
        $(".dtPicker3").remove();
        $(".icon-remove").remove();
    }
        cekDisabled($('#penyimpananlinen-t-form'));
});
</script>