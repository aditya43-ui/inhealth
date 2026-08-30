<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>


<script type="text/javascript">
var row_produksi_first = new String(<?php echo CJSON::encode($this->renderPartial('_rowDetailProduksi',array('form'=>$form,'modProduksiDetail'=>$modProduksiDetail,'model'=>$model, 'is_adatombolhapus'=>false),true));?>);
var row_produksi = new String(<?php echo CJSON::encode($this->renderPartial('_rowDetailProduksi',array('form'=>$form,'modProduksiDetail'=>$modProduksiDetail, 'model'=>$model, 'is_adatombolhapus'=>true),true));?>);
function submitObat_old(obatalkes_id)
{
//    $(dialog).dialog("close");
    
//    var table = $('#tblDetailProduksi');
//    if(first == true){
//        $(table).children('tbody').append(row_tindakan_first.replace());
//    }else{
//        $(table).children('tbody').append(row_tindakan.replace());
//    }

    
    var obatProduksiId = $('#obatProduksiId').val();
    var obatProduksiKode = $('#obatProduksiKode').val();
    var obatProduksi = $('#obatProduksi').val();
    var pegawai_id = $('#FAProduksiobatT_pegawai_id').val();
    var dokter_id = $('#dokter_id').val();
    var obatalkes_id = obatalkes_id;
    var jumlah = 1;
    
        
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('setFormProduksiDetail'); ?>',
            data: {obatalkes_id:obatalkes_id,jumlah:jumlah},//
            dataType: "json",
            success:function(data){
                if(data.pesan !== ""){
                    myAlert(data.pesan);
                    var params = [];
                    params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Params::MODUL_ID_GUDANGFARMASI; ?>, judulnotifikasi:'Stok Obat Alkes Habis', isinotifikasi:obatProduksiKode+' '+obatProduksi+'  di <?php echo Yii::app()->user->getState("ruangan_nama"); ?> telah habis'}; // 16 
                    insert_notifikasi(params);
                    return false;
                }
                var tambahkandetail = true;
                var obatalkesyangsama = $("#tblDetailProduksi input[name$='[obatalkes_id]'][value='"+obatalkes_id+"']");
                if(obatalkesyangsama.val()){ //jika ada obat sudah ada di table
//                    if(confirm("Apakah Anda akan input ulang obat ini?")){
                        $("#tblDetailProduksi input[name$='[obatalkes_id]'][value='"+obatalkes_id+"']").each(function(){
                            $(this).parents('tr').detach();
                        });
////                        $("#tblDetailProduksi input[name$='[obatalkes_id]'][value='"+obatalkes_id+"']").each(function());
////                        $(this).parents('tr').find('input[name$="[obatalkes_nama]"]').val(ui.item.kategoritindakan_nama);
//                    }else{
//                        tambahkandetail = false;
//                    }
                }
                if(tambahkandetail){
                    $('#tblDetailProduksi > tbody').append(data.form);
                    $("#tblDetailProduksi > tbody tr:last").find('.integer2').maskMoney(
                        {"symbol":"","defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":0}
                    );
//                    renameInputRowObatAlkes($("#tblDetailProduksi"));                    
//                    hitungTotal();
                }
            },
            error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        });
    
    
    
//    if(pegawai_id =='')
//    {
//        myAlert('Silakan pilih dokter terlebih dahulu!');
//    }else{
//            $.post("${urlGetObatProduksi}", { obatProduksiId: obatProduksiId, obatProduksi: obatProduksi, pegawai_id:pegawai_id, dokter_id:dokter_id},
//            function(data){
//                $('#tblDetailProduksi tbody').append(data.tr);
//                renameInput('FAProduksiobatdetT','obatalkes_kode');
//                renameInput('FAProduksiobatdetT','obatalkes_nama');
//                renameInput('FAProduksiobatdetT','dosis');
//                renameInput('FAProduksiobatdetT','kemasan');
//                renameInput('FAProduksiobatdetT','kekuatan');
//                renameInput('FAProduksiobatdetT','qtyproduksi');
//                renameInput('FAProduksiobatdetT','satuankecil_nama');
//                renameInput('FAProduksiobatdetT','stokobatalkes_id');
//                $("#tblDetailProduksi tbody").find('.integer2').maskMoney({"defaultZero":true, "allowZero":true, "decimal":",", "thousands":".", "symbol":null, "precision":0});
//                $("#tblDetailProduksi tbody").find('.float2').maskMoney({"symbol":"","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":2});
//                clear();
//                
//            }, "json");
//    }   
}

/**
* rename input grid
*/ 
function renameInputRowObatAlkes(obj_table){
    var row = 0;
    $(obj_table).find("tbody > tr").each(function(){
        $(this).find("#noUrut").val(row+1);
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

function cekObat(){
    if(requiredCheck($("form"))){
        var jumlah_obat = $('#tblDetailProduksi tbody tr').length;
		var indexobat = jumlah_obat-1;
        var kodeoa = $('#tblDetailProduksi tbody tr td #FAProduksiobatdetT_'+indexobat+'_obatalkes_kode').val();
			if(kodeoa == ''){
				myAlert('Lengkapi data Detail Bahan terlebih dahulu!');
				return false;
			}else{
				$('#faproduksiobat-t-form').submit();
			}
		
        $(".animation-loading").removeClass("animation-loading");
        $("form").find('.float2').each(function(){
            $(this).val(formatFloat($(this).val()));
        });
        $("form").find('.integer2').each(function(){
            $(this).val(formatInteger($(this).val()));
        });
    }
    return false;
    
}

</script>
