<script type="text/javascript">
function tambahLinen()
{
    var penyimpananlinen_id = $('#penyimpananlinen_id').val();
	var linen_id = $('#linen_id').val();
    var kodelinen = $('#kodelinen').val();
    var namalinen = $('#namalinen').val();
    var keterangan = $('#keterangan').val();
    
    if(penyimpananlinen_id != '')
    {
        
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('setFormDetailLinenView'); ?>',
//            data: {linen_id:linen_id,keterangan:keterangan},
			data: {penyimpananlinen_id:penyimpananlinen_id,keterangan:keterangan},
            dataType: "json",
            success:function(data){
                if(data.pesan !== ""){
                    myAlert(data.pesan);
                    return false;
                }
                var tambahkandetail = true;
                var linenyangsama = $("#table-detaillinen input[name$='[penyimpananlinen_id]'][value='"+penyimpananlinen_id+"']");
                if(linenyangsama.val()){ //jika ada bahan sudah ada di table
                    myConfirm('Apakah Anda akan input ulang bahan ini?', 'Perhatian!', function(r)
                    {
                        if(r){
                            $("#table-detaillinen input[name$='[penyimpananlinen_id]'][value='"+penyimpananlinen_id+"']").each(function(){
                                $(this).parents('tr').detach();
                            });
				if(tambahkandetail){
					$('#table-detaillinen > tbody').append(data.form);
					renameInputRow($("#table-detaillinen"));                    
				}
                        }else{
                            tambahkandetail = false;
                        }
                    });
                }else{
			if(tambahkandetail){
				$('#table-detaillinen > tbody').append(data.form);
				renameInputRow($("#table-detaillinen"));                    
			}
		}
                $('#linen_id').val('');
                $('#namalinen').val('');
                $('#kodelinen').val('');
				$('#penyimpananlinen_id').val('');
				$('#keterangan').val('');
            },
            error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        });
    }else{
        myAlert("Silakan pilih bahan perawatan terlebih dahulu!");
    }
    $("#namalinen").focus();   
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
* untuk print perawatan linen
 */
function print(caraPrint)
{
    var pengirimanlinen_id = '<?php echo $modPengirimanLinen->pengirimanlinen_id; ?>';
    window.open('<?php echo $this->createUrl('print'); ?>&pengirimanlinen_id='+pengirimanlinen_id+'&caraprint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
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
 * refresh dialog kunjungan
 * @returns {undefined}
 */
function refreshDialog(){
    var ruangan_id = $("#LAPengirimanlinenT_ruangantujuan_id").val();
//    var ruangan_id = $("#instalasi_id option:selected").text();
    $.fn.yiiGridView.update('dialogPenyimpananLinen-m-grid', {
        data: {
            "LAPenyimpananlinenV[ruangan_id]":ruangan_id,
        }
    });
}
//
//function setDialog(obj){
//       var bariske = $(obj).parents('tr').find('input[name$="row"]').val();
//        $("#bariske").val(bariske);
//        $("#dialogPenyimpananLinen").dialog("open");
//    }   

/**
 * function ini harus tetap berada di bawah
 */
$(document).ready(function(){
    var pengirimanlinen_id = '<?php echo $modPengirimanLinen->pengirimanlinen_id; ?>';
    <?php if(isset($_GET['penyimpananlinen_id'])){ 
            if(!isset($_GET['sukses'])){
        ?>
        $('#penyimpananlinen_id').val('<?php echo $_GET['penyimpananlinen_id']; ?>');
        tambahLinen();
    <?php }
        } ?>
    if(pengirimanlinen_id != ""){
        $("input, textarea, checkbox, select").attr("readonly",true);
        $(".add-on").remove();
        $(".dtPicker3").remove();
        $(".icon-remove").remove();
        renameInputRow($("#table-detailinen"));
    }
        setValidasiCekDisabled($('#pengirimanlinen-t-form'));
        
});
</script>