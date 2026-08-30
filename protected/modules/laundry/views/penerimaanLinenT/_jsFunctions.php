<?php
/**
* - digunakan sebagai url utuk :
* @author : Elham Budianto
* @email : elhambudianto1@gmail.com
* @wiki : ..
**/
?>

<script type="text/javascript">
function tambahLinen()
{
    var pengajuanperawatan_id = $('#LAPenerimaanlinenT_pengperawatanlinen_id').val();
	var linen_id = $('#linen_id').val();
    var kodelinen = $('#kodelinen').val();
    var namalinen = $('#namalinen').val();
    var keterangan = $('#keterangan').val();
    
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('getDataPengajuan'); ?>',
        data: {pengajuanperawatan_id:pengajuanperawatan_id},
        dataType: "json",
        success:function(data){
            if(data.pesan !== ""){
                myAlert(data.pesan);
                return false;
            }
            $('#table-linen > tbody').append(data.form);
            renameInputRow($("#table-linen"));                    
            /*$('#linen_id').val('');
            $('#namalinen').val('');
            $('#kodelinen').val('');
            $('#penyimpananlinen_id').val('');
            $('#keterangan').val('');*/
            $('.numbers-only').keyup(function() {
                setNumbersOnly(this);
            });
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}

function cekPengajuan()
{
    var tabellinen = $('#table-linen tbody tr').length;
    console.log(tabellinen);
	if(tabellinen == 0){
        myAlert("Pilih Dahulu No. Pengajuan Perawatan Linen");
    }else{
        $("#lapenerimaanlinen-t-form").submit();
    }
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
 * menghapus detail mutasi berdasarkan linen_id
 * @param {type} caraPrint
 * @returns {undefined} */
function batalPengirimanLinen(obj){
    myConfirm('Apakah Anda akan membatalkan bahan perawatan ini?', 'Perhatian!', function(r)
    {
        if(r){
            var linen_id = $(obj).parents('tr').find('input[name$="[linen_id]"]').val();
            $(obj).parents('tbody').find('input[name$="[linen_id]"][value="'+linen_id+'"]').each(function(){
                $(this).parents('tr').detach();
            });
			renameInputRow($("#table-detaillinen"));
        }
    });
}

function resetLinen(){
    $('#table-linen tbody tr').remove();
}

function validasiCek(){
    if(requiredCheck($("form"))){
        var jumlah_bahan = $('#table-detaillinen tbody tr').length;
        if(jumlah_bahan <= 0){
                myAlert('Silakan isikan data linen terlebih dahulu!');
            return false;
        }else{
            $('#pengirimanlinen-t-form').submit();
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
});
</script>