<script type="text/javascript">
function tambahBahanPerawatan()
{
    var bahanperawatan_id = $('#bahanperawatan_id').val();
    var bahanperawatan_jenis = $('#bahanperawatan_jenis').val();
    var bahanperawatan_nama = $('#bahanperawatan_nama').val();
    var satuan = $('#satuan').val();
    var jumlah = $('#jumlah').val();
    
    if(bahanperawatan_id != '')
    {
        
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('setFormDetailBahanPerawatan'); ?>',
            data: {bahanperawatan_id:bahanperawatan_id,satuan:satuan,jumlah:jumlah},//
            dataType: "json",
            success:function(data){
                if(data.pesan !== ""){
                    myAlert(data.pesan);
                    return false;
                }
                var tambahkandetail = true;
                var bahanyangsama = $("#table-detailbahan input[name$='[bahanperawatan_id]'][value='"+bahanperawatan_id+"']");
                if(bahanyangsama.val()){ //jika ada bahan sudah ada di table
                    myConfirm('Apakah Anda akan input ulang bahan ini?', 'Perhatian!', function(r)
                    {
                        if(r){
                            $("#table-detailbahan input[name$='[bahanperawatan_id]'][value='"+bahanperawatan_id+"']").each(function(){
                                $(this).parents('tr').detach();
                            });
				if(tambahkandetail){
					$('#table-detailbahan > tbody').append(data.form);
					renameInputRow($("#table-detailbahan"));                    
				}
                        }else{
                            tambahkandetail = false;
                        }
                    });
                }else{
			if(tambahkandetail){
				$('#table-detailbahan > tbody').append(data.form);
				renameInputRow($("#table-detailbahan"));                    
			}
		}
                $('#bahanperawatan_id').val('');
                $('#bahanperawatan_nama').val('');
            },
            error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        });
    }else{
        myAlert("Silakan pilih bahan perawatan terlebih dahulu!");
    }
    $("#bahanperawatan_nama").focus();   
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
/**
 * menghapus detail mutasi berdasarkan bahanperawatan_id
 * @param {type} caraPrint
 * @returns {undefined} */
function batalBahanPerawatan(obj){
    myConfirm('Apakah Anda akan membatalkan bahan perawatan ini?', 'Perhatian!', function(r)
    {
        if(r){
            var bahanperawatan_id = $(obj).parents('tr').find('input[name$="[bahanperawatan_id]"]').val();
            $(obj).parents('tbody').find('input[name$="[bahanperawatan_id]"][value="'+bahanperawatan_id+'"]').each(function(){
                $(this).parents('tr').detach();
            });
        }
    });
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
        var jumlah_bahan = $('#table-detailbahan tbody tr').length;
        if(jumlah_bahan <= 0){
                myAlert('Silakan isikan bahan perawatan terlebih dahulu!');
				$(".animation-loading").removeClass("animation-loading");
				$(".animation-loading-1").removeClass("animation-loading-1");
            return false;
        }else{
            $('#pencucianlinen-t-form').submit();
        }
        
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
    var pencucianlinen_id = '<?php echo $modPencucianLinen->pencucianlinen_id; ?>';
    window.open('<?php echo $this->createUrl('print'); ?>&pencucianlinen_id='+pencucianlinen_id+'&caraprint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
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
    var pencucianlinen_id = '<?php echo $modPencucianLinen->pencucianlinen_id; ?>';
    if(pencucianlinen_id != ""){
        $("input, textarea, checkbox, select").attr("readonly",true);
        $(".add-on").remove();
        $(".dtPicker3").remove();
        $(".icon-remove").remove();
    }
        cekDisabled($('#pencucianlinen-t-form'));
        $('form').bind('click keyup select change', function(event) {
            cekDisabled(this);
         });
         $(document).on('click keyup select change','.ui-dialog-content',function(){
            cekDisabled('form');
         });
});
</script>