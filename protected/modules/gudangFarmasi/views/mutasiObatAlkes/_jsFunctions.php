<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>

<script type="text/javascript">
    
function cekValidasi() {
    
    if (requiredCheck($('#gfmutasioaruangan-t-form'))) {
        var is_cukup = true;
    
        $("#table-mutasidetail tbody tr").each(function() {
            $(this).removeClass("yellow");
            
            var qty = parseFloat(($(this).find(".qty").val()));
            var stok = parseFloat(($(this).find(".stok").val()));

            // console.log(qty, stok);

            if (qty > stok) {
                $(this).addClass("yellow");
                is_cukup = false;
            }

        });

        if (!is_cukup) {
            // $(".animation-loading-1").removeClass("animation-loading-1");
            myAlert("Stok tidak mencukupi.");
            $("form").find('.float2').each(function(){
                $(this).val(formatFloat(parseFloat($(this).val())));
            });
            $("form").find('.integer2').each(function(){
                $(this).val(formatNumber($(this).val()));
            });
            $("form").find('.integer-decimal-global').each(function(){
                $(this).val(formatThousandDecimal(parseFloat($(this).val())));
            });
            return false;
        }
        
        // return false;
        unformatNumberSemua();
        // return false;
        $('#gfmutasioaruangan-t-form').submit();
        $("form").find('.float2').each(function(){
            $(this).val(formatFloat(parseFloat($(this).val())));
        });
        $("form").find('.integer2').each(function(){
            $(this).val(formatNumber($(this).val()));
        });
        $("form").find('.integer-decimal').each(function(){
            $(this).val(formatThousandDecimal(parseFloat($(this).val())));
        });
    }
    
    return false;
}    
    
    
function tambahObatAlkes()
{
	var pesanobatalkes_id = '<?php echo isset($_GET['pesanobatalkes_id'])?$_GET['pesanobatalkes_id']:''; ?>';
    var obatalkes_id = $('#obatalkes_id').val();
    var jumlah = $('#qty_input').val();
    
    if(obatalkes_id != '')
    {
        
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('setFormMutasiDetail'); ?>',
            data: {obatalkes_id:obatalkes_id,jumlah:jumlah,pesanobatalkes_id:pesanobatalkes_id},//
            dataType: "json",
            success:function(data){
                if(data.pesan !== ""){
                    myAlert(data.pesan);
                    return false;
                }
                var tambahkandetail = true;
                var obatalkesyangsama = $("#table-mutasidetail input[name$='[obatalkes_id]'][value='"+obatalkes_id+"']");
                if(obatalkesyangsama.val()){ //jika ada obat sudah ada di table
                    myConfirm('Apakah Anda akan input ulang obat ini?','Perhatian!',
                    function(r){
                        if(r){
                            $("#table-mutasidetail input[name$='[obatalkes_id]'][value='"+obatalkes_id+"']").each(function(){
                                $(this).parents('tr').detach();
                            });
				if(tambahkandetail){
					$('#table-mutasidetail > tbody').append(data.form);
					$("#table-mutasidetail").find('input[name*="[ii]"][class*="integer2"]').maskMoney(
						{"symbol":"","defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":0}
					);
                    $("#table-mutasidetail").find('input[name*="[ii]"][class*="integer-decimal-global"]').maskMoney(
                        {"symbol": "", "defaultZero": true, "allowZero": true, "decimal": ",", "thousands": ".", "precision": 2}
                    );
					renameInputRowObatAlkes($("#table-mutasidetail"));                    
					hitungTotal();
				}
                        }else{
                            tambahkandetail = false;
                        }
                    }); 
                }else{
			if(tambahkandetail){
				$('#table-mutasidetail > tbody').append(data.form);
				$("#table-mutasidetail").find('input[name*="[ii]"][class*="integer2"]').maskMoney(
					{"symbol":"","defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":0}
				);
                $("#table-mutasidetail").find('input[name*="[ii]"][class*="integer-decimal-global"]').maskMoney(
                        {"symbol": "", "defaultZero": true, "allowZero": true, "decimal": ",", "thousands": ".", "precision": 2}
                    );
				renameInputRowObatAlkes($("#table-mutasidetail"));                    
				hitungTotal();
			}
		}
                $('#obatalkes_id').val('');
                $('#obatalkes_nama').val('');
                $('#qty_input').val(1);
            },
            error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        });
    }else{
        myAlert("Silakan pilih obat / alkes terlebih dahulu!");
    }
    $("#obatalkes_nama").focus();   
}

function hitungTotal(){
    unformatNumberSemua();
    var total = 0;
    var totaljual = 0;
    $('#table-mutasidetail tbody > tr').each(function(){
        var jmlmutasi  = parseFloat($(this).find('input[name$="[jmlmutasi]"]').val());
        var harganetto  = parseFloat($(this).find('input[name$="[harganetto]"]').val());
        var hargajualsatuan  = parseFloat($(this).find('input[name$="[hargajualsatuan]"]').val());
        var subtotal = harganetto * jmlmutasi;
        if(subtotal > 0){
            subtotal = parseFloat(subtotal.toFixed(2));
        }
        var subtotaljual = hargajualsatuan * jmlmutasi;
        if(subtotaljual > 0){
            subtotaljual = parseFloat(subtotaljual.toFixed(2));
        }

        total += subtotal;
        totaljual += subtotaljual;
        $(this).find('input[name$="[totalharga]"]').val(subtotal);
    });    
    $('#total').val(total);    
    $('#<?php echo CHtml::activeId($model, 'totalharganettomutasi') ?>').val(total);    
    $('#<?php echo CHtml::activeId($model, 'totalhargajual') ?>').val(totaljual);    
    formatNumberSemua();
}

/**
* rename input grid
*/ 
function renameInputRowObatAlkes(obj_table){
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
 * menghapus detail mutasi berdasarkan obatalkes_id
 * @param {type} caraPrint
 * @returns {undefined} */
function batalMutasiDetail(obj){
    myConfirm('Apakah Anda akan membatalkan mutasi obat alkes ini??','Perhatian!',
    function(r){
        if(r){
            var obatalkes_id = $(obj).parents('tr').find('input[name$="[obatalkes_id]"]').val();
            $(obj).parents('tbody').find('input[name$="[obatalkes_id]"][value="'+obatalkes_id+'"]').each(function(){
                $(this).parents('tr').detach();
            });
            hitungTotal();
        }
    }); 

}

/**
 * refresh dialog obat
 * @returns {undefined}
 */
function refreshDialogObat(){
    var is_nobatch_tglkadaluarsa = $("#<?php echo CHtml::activeId($model,'is_nobatch_tglkadaluarsa'); ?>").val();
	if($("#<?php echo CHtml::activeId($model,'is_nobatch_tglkadaluarsa'); ?>").is(":checked")){
		$.fn.yiiGridView.update('obatalkes-m-grid', {
			data: {
				"GFObatalkesM[is_nobatch_tglkadaluarsa]":is_nobatch_tglkadaluarsa,
			}
		});
	}else{
		$.fn.yiiGridView.update('obatalkes-m-grid', {
			data: {
				"GFObatalkesM[is_nobatch_tglkadaluarsa]":0,
			}
		});
	}	
    
}

/**
* untuk print rencana kebutuhan
 */
function print(caraprint)
{
    var mutasioaruangan_id = '<?php echo $model->mutasioaruangan_id; ?>';
    window.open('<?php echo $this->createUrl('print'); ?>&mutasioaruangan_id='+mutasioaruangan_id+'&caraprint='+caraprint,'printwin','left=100,top=100,width=1000,height=640');
}

/**
 * class integer2 di unformat 
 * @returns {undefined}
 */
// function unformatNumberSemua(){
//     $(".integer2").each(function(){
//         $(this).val(parseInt(unformatNumber($(this).val())));
//     });
// }
/**
 * class integer2 di format kembali
 * @returns {undefined}
 */
// function formatNumberSemua(){
//     $(".integer2").each(function(){
//         $(this).val(formatInteger($(this).val()));
//     });
// }

/**
 * function ini harus tetap berada di bawah
 */
$(document).ready(function(){
    var mutasioaruangan_id = '<?php echo $model->mutasioaruangan_id; ?>';
    if(mutasioaruangan_id !== ""){
        $("input, textarea, checkbox, select").attr("readonly",true);
        $(".add-on").remove();
        $(".dtPicker3").remove();
        $(".icon-remove").remove();        
    }
    renameInputRowObatAlkes($("#table-mutasidetail"));     
    hitungTotal();    

    <?php 
        if(isset($model->mutasioaruangan_id)){
    ?>
        $("#GFMutasioaruanganT_totalharganettomutasi").val("<?php echo number_format($model->totalharganettomutasi,0,'','.'); ?>");     
        $("#GFMutasioaruanganT_totalhargajual").val("<?php echo number_format($model->totalhargajual,0,'','.'); ?>");
        var params = [];
        params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo $model->instalasitujuan_id ?>, judulnotifikasi:'Mutasi Obat Alkes', isinotifikasi:'Mutasi obat alkes dari <?php echo $model->ruanganasal->ruangan_nama ?> ke <?php echo $model->ruangantujuan->ruangan_nama ?>'}; // 16 
        insert_notifikasi(params);
    <?php
        }
    ?>
});
</script>