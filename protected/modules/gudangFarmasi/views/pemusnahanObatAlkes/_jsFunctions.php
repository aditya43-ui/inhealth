<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>
<script type="text/javascript">
function tambahObatAlkes()
{
    var stokobatalkes_id = $('#stokobatalkes_id').val();
    var jumlah = $('#qty_input').val();
    var ruanganasal_id = $('#<?php echo CHtml::activeId($model, 'ruanganasal_id') ?>').val();
    
    if((ruanganasal_id == '')||(ruanganasal_id ==0)){
        myAlert('Silakan isi ruangan asal terlebih dahulu!');
        $('#stokobatalkes_id').val("");
        $('#obatalkes_id').val("");
        $('#qty_input').val(1);
        $('#obatalkes_nama').val("");
        return false;
    }
    if(stokobatalkes_id != '')
    {
        
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('setFormPemusnahanDetail'); ?>',
            data: {stokobatalkes_id:stokobatalkes_id,jumlah:jumlah,ruanganasal_id:ruanganasal_id},//
            dataType: "json",
            success:function(data){
                if(data.pesan !== ""){
                    myAlert(data.pesan);
                    return false;
                }
                var tambahkandetail = true;
                var obatalkesyangsama = $("#table-pemusnahandetail input[name$='[obatalkes_id]'][value='"+obatalkes_id+"']");
                if(obatalkesyangsama.val()){ //jika ada obat sudah ada di table
                    myConfirm('Apakah Anda akan input ulang obat ini?','Perhatian!',
                        function(r){
                            if(r){
                                $("#table-pemusnahandetail input[name$='[obatalkes_id]'][value='"+obatalkes_id+"']").each(function(){
                                    $(this).parents('tr').detach();
                                });
                            }else{
                                tambahkandetail = false;
                            }
                        }); 
                }else{
		    if(tambahkandetail){
			$('#table-pemusnahandetail > tbody').append(data.form);
			$("#table-pemusnahandetail").find('input[name*="[ii]"][class*="integer2"]').maskMoney(
			    {"symbol":"","defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":0}
			);
			renameInputRowObatAlkes($("#table-pemusnahandetail"));                    
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
    $('#table-pemusnahandetail tbody > tr').each(function(){
        var jmlbarang  = parseInt($(this).find('input[name$="[jmlbarang]"]').val());
        var harganetto  = parseFloat($(this).find('input[name$="[harganetto]"]').val());
        var hargajualsatuan  = parseFloat($(this).find('input[name$="[hargajualsatuan]"]').val());
        var subtotal = harganetto * jmlbarang;
        var subtotaljual = hargajualsatuan * jmlbarang;
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
 * menghapus detail mutasi berdasarkan stokobatalkes_id
 * @param {type} caraPrint
 * @returns {undefined} */
function batalPemusnahanDetail(obj){
    myConfirm('Apakah Anda akan membatalkan pemusnahan obat alkes ini?','Perhatian!',
    function(r){
        if(r){
			$(obj).parent().parent().remove();
            hitungTotal();
        }
    }); 

}

/**
* untuk print rencana kebutuhan
 */
function print(caraprint)
{
    var pemusnahanobatalkes_id = '<?php echo $model->pemusnahanobatalkes_id; ?>';
    window.open('<?php echo $this->createUrl('print'); ?>&pemusnahanobatalkes_id='+pemusnahanobatalkes_id+'&caraprint='+caraprint,'printwin','left=100,top=100,width=1000,height=640');
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
function refreshDialogObatAlkes(){
	$("#obatalkes_nama").addClass("animation-loading-1");
    var instalasi_id = $('#<?php echo CHtml::activeId($model, 'instalasiasal_id') ?>').val();
    var instalasi_nama = $("#<?php echo CHtml::activeId($model, 'instalasiasal_id') ?> option:selected").text();
    var ruangan_id = $('#<?php echo CHtml::activeId($model, 'ruanganasal_id') ?>').val();
    var ruangan_nama = $("#<?php echo CHtml::activeId($model, 'ruanganasal_id') ?> option:selected").text();
	
	if (ruangan_nama == '-- Pilih --'){
		ruangan_nama = "(Ruangan Belum Dipilih)";
	}else{
		ruangan_nama = "(Stok "+ruangan_nama+")";
	}
	
	if (instalasi_id == ""){
		instalasi_id = 999999;
		ruangan_id = 999999;
	}
	
	if (ruangan_id == ""){
		ruangan_id = 999999;
	}
	
	setTimeout(function(){
		$("#ruangannama-asal").html(ruangan_nama);
		$("#obatalkes_nama").removeClass("animation-loading-1");
		$.fn.yiiGridView.update('obatalkes-m-grid', {
			data: {
				"GFInformasikartustokobatalkesV[instalasi_id]":instalasi_id,
				"GFInformasikartustokobatalkesV[instalasi_nama]":instalasi_nama,
				"GFInformasikartustokobatalkesV[ruangan_id]":ruangan_id,
				"GFInformasikartustokobatalkesV[ruangan_nama]":ruangan_nama,
			}
		});
	},500);
    
}

/**
 * function ini harus tetap berada di bawah
 */
$(document).ready(function(){
    var pemusnahanobatalkes_id = '<?php echo $model->pemusnahanobatalkes_id; ?>';
    if(pemusnahanobatalkes_id !== ""){
        $("input, textarea, checkbox, select").attr("readonly",true);
        $(".add-on").remove();
        $(".dtPicker3").remove();
        $(".icon-remove").remove();
    }
    renameInputRowObatAlkes($("#table-pemusnahandetail")); 
    hitungTotal();
	
	refreshDialogObatAlkes();
});
</script>