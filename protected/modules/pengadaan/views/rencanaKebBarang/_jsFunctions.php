<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>

<script type="text/javascript">
function tambahBarang()
{
    var idBarang = $('#idBarang').val();
    var jumlah = $('#jumlah').val();
    
        if(idBarang != '')
        {
            $.ajax({
                type:'POST',
                url:'<?php echo $this->createUrl('loadFormRencanaKebutuhan'); ?>',
                data: {idBarang:idBarang,jumlah:jumlah},//
                dataType: "json",
                success:function(data){
                    $('#table-barang > tbody').append(data.form);
                    $("#table-barang").find('input[name$="[ii][barang_id]"]').val(idBarang);
                    $("#table-barang").find('input[name*="[ii]"][class*="integer2"]').maskMoney(
                        {"symbol":"","defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":0}
                    );
                    $("#table-barang").find('input[name*="[ii]"][class*="float2"]').maskMoney({"defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":2,"symbol":null});
                    renameInputRowBarang($("#table-barang"));                    
                    hitungTotal();
                    $("#idBarang, #namaBarang, #satuan").val("");
                    $("#jumlah").val(formatThousandDecimal(1));
                    
                },
                error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
            });
        }else{
            myAlert("Isikan item barang terlebih dahulu");
        }
}

function hitungTotal(){
    unformatNumberSemua();
    var total = 0;
    $('#table-barang tbody tr').each(function(){
        var jmlpermintaan  = parseFloat($(this).find('input[name$="[jmlpermintaanbarangdet]"]').val());
        var harga  = parseFloat($(this).find('input[name$="[harga_barang]"]').val());
        var ppn = parseFloat($(this).find('input[name$="[persen_ppn]"]').val());
        
        var hargajml = (harga * jmlpermintaan);
        if (hargajml > 0){
            hargajml = parseFloat(hargajml.toFixed(2));
        }
        var jmlppn = ((hargajml * ppn)/100);
        if (jmlppn > 0){
            jmlppn = parseFloat(jmlppn.toFixed(2));
        }
        var subtotal = (hargajml + jmlppn);
        if (subtotal > 0){
            subtotal = parseFloat(subtotal.toFixed(2));
        }
        
        total += subtotal;
        $(this).find('input[name$="[ppn]"]').val(jmlppn);
        $(this).find('input[name$="[hpp]"]').val(subtotal);
        $(this).find('input[name$="[subtotal]"]').val(subtotal);
    });
    $('#total').val(total);    
    formatNumberSemua();
}

function cekBarang(){
    if(requiredCheck($("form"))){
        var jmlObat = $('#table-barang tbody tr').length;
        if(jmlObat <= 0){
                myAlert('Isikan barang rencana kebutuhan terlebih dahulu.');
            return false;
        }else{
             $('.integer-decimal').each(function(){
                $(this).val(parseFloat(unformatNumber($(this).val())));
            });
            $('.integer2').each(function(){
                $(this).val(parseInt(unformatNumber($(this).val())));
            });
            
            $('#rencanakebutuhan-form').submit();
        }
        
        $(".animation-loading").removeClass("animation-loading");
    //    $("form").find('.integer-decimal').each(function(){
    //        $(this).val(formatThousandDecimal($(this).val()));
    //    });
    //    $("form").find('.integer2').each(function(){
    //        $(this).val(formatInteger($(this).val()));
    //    });
    }
    return false;
    
}

/**
* rename input grid
*/ 

function renameInputRowBarang(obj_table){
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

function batalBarang(obj){
    myConfirm('Apakah anda akan membatalkan rencana kebutuhan barang ini?','Perhatian!',
    function(r){
        if(r){
            $(obj).parents('tr').detach();
        }
    });
    hitungTotal();
}

/**
* untuk print rencana kebutuhan
 */
function print(caraPrint)
{
    var renkebbarang_id = '<?php echo isset($_GET['renkebbarang_id']) ? $_GET['renkebbarang_id'] : ""; ?>';
    window.open('<?php echo $this->createUrl('print'); ?>&renkebbarang_id='+renkebbarang_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
}

/**
 * class integer2 di unformat 
 * @returns {undefined}
 */
// function unformatNumberSemua(){
//    $('.float2').each(function(){
//         $(this).val(parseFloat(unformatNumber($(this).val())));
//     });
//     $('.integer2').each(function(){
//         $(this).val(parseInt(unformatNumber($(this).val())));
//     });
//     $('.integer-decimal').each(function(){
//         $(this).val(parseFloat(unformatNumber($(this).val())));
//     });
// }
/**
 * class integer2 di format kembali
 * @returns {undefined}
 */
// function formatNumberSemua(){
//    $('.float2').each(function(){
//         $(this).val(formatFloat(parseFloat($(this).val())));
//     });
//     $('.integer2').each(function(){
//         $(this).val(formatInteger($(this).val()));
//     });
//     $('.integer-decimal').each(function(){
//         $(this).val(formatThousandDecimal(parseFloat($(this).val())));
//     });
// }


/**
 * fungsi untuk menghitung recomended order
 * @returns {undefined}
 */
function hitungRO(){
	$('#table-barang').addClass("animation-loading");
	var ro_barang_bulan = $('#<?php echo CHtml::activeId($modRencanaKebBarang,'ro_barang_bulan'); ?>').val();
	if(ro_barang_bulan !== ''){
		$.ajax({
			type:'POST',
			url:'<?php echo $this->createUrl('setHitungRO'); ?>',
			data: {ro_barang_bulan:ro_barang_bulan},
			dataType: "json",
			success:function(data){
				if(data.pesan !== ""){
					myAlert(data.pesan);
					$('#table-barang').removeClass("animation-loading");
					return false;
				}
				$('#table-barang > tbody > tr').detach();
				$('#table-barang > tbody').append(data.form);
				$("#table-barang").find('input[name*="[ii]"][class*="integer"]').maskMoney(
					{"symbol":"","defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":0}
				);
				$('#<?php echo CHtml::activeId($modRencanaKebBarang,'leadtime_lt'); ?>').val(data.lead_time);
				renameInputRowBarang($("#table-barang"));                    
				hitungTotal();
				$('#table-barang').removeClass("animation-loading");
			},
			error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
		});
	}else{
		myAlert('Waktu Pemakaian harus diisi terlebih dahulu!');
		$('#table-barang').removeClass("animation-loading");
	}
}

$(document).ready(function(){
    var satuanobat = $('#ADRencDetailkebT_satuanobat').val();
    $('#satuankecil').hide();
    $('#satuanbesar').hide();
        
    if(satuanobat == 'SATUANKECIL'){
        $('#satuankecil').show();
        $('#satuanbesar').hide();
    }else{
        $('#satuanbesar').show();
        $('#satuankecil').hide();
    }
    
    var renkebbarang_id = '<?php echo $modRencanaKebBarang->renkebbarang_id; ?>';
    if(renkebbarang_id != ""){
//        $("#table-obatalkespasien :input").attr("readonly",true);
//        $("#table-obatalkespasien .add-on").remove();
//        $("#table-obatalkespasien .icon-remove").remove();
//        
//        $("#rencanakebutuhan-form :input").attr("readonly",true);
//        $("#rencanakebutuhan-form .dtPicker3").attr("readonly",true);
//        $("#rencanakebutuhan-form .add-on").remove();
//        
//        $("input, select, textarea").attr("disabled",true);
        
        renameInputRowBarang($("#table-barang"));                    
				hitungTotal();
    }

    <?php 
        if(isset($modRencanaKebBarang->renkebbarang_id)){
    ?>
//        var params = [];
//        params = {instalasi_id:<?php // echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php // echo Params::MODUL_ID_AKUNTANSI ?>, judulnotifikasi:'Rencana Kebutuhan', isinotifikasi:'Telah dilakukan rencana kebutuhan dengan pada <?php // echo $modRencanaKebFarmasi->tglperencanaan ?>'}; // 16 
//        insert_notifikasi(params);
		renameInputRowBarang($("#table-barang"));                    
				hitungTotal();
    <?php
        }
    ?>
});
</script>