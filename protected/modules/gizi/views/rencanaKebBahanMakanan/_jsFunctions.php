<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>

<script type="text/javascript">
function tambahBarang()
{
    var idBarang = $('#idBarang').val();
    var jumlah = $('#jumlah').val();
    var satuan = $('#satuan').val();
    
        if(idBarang != '')
        {
            $.ajax({
                type:'POST',
                url:'<?php echo $this->createUrl('loadFormRencanaKebutuhan'); ?>',
                data: {idBarang:idBarang,jumlah:jumlah,satuan:satuan},//
                dataType: "json",
                success:function(data){
                    $('#table-barang > tbody').append(data.form);
                    $("#table-barang").find('input[name$="[ii][barang_id]"]').val(idBarang);
                    $("#table-barang").find('input[name*="[ii]"][class*="integer2"]').maskMoney(
                        {"symbol":"","defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":0}
                    );
                    renameInputRowBarang($("#table-barang"));                    
                    hitungTotal();
                    $("#idBarang, #namaBarang, #satuan").val("");
                    $("#jumlah").val(1);
                    
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
        var jmlpermintaan  = parseFloat($(this).find('input[name$="[jmlpermintaandet]"]').val());
        var harga  = parseFloat($(this).find('input[name$="[harga_barangdet]"]').val());
        var persenppn  = parseInt($(this).find('input[name$="[persen_ppn]"]').val());
        
        var totalJml = (harga * jmlpermintaan);
        
        var jmlppn = ((totalJml * persenppn)/100);
        
       var subtotal = (totalJml + jmlppn);
        
        if(subtotal <= 0){
            subtotal = 0;
        }
        
        total += subtotal;
        $(this).find('input[name$="[jml_ppn]"]').val(jmlppn);
        $(this).find('input[name$="[subtotal]"]').val(subtotal);
    });
    $('#total').val(total);    
    formatNumberSemua();
}

function cekBarang(){
    if(requiredCheck($("form"))){
        var jmlObat = $('#table-barang tbody tr').length;
        if(jmlObat <= 0){
                myAlert('Silakan isikan barang rencana kebutuhan terlebih dahulu!');
            return false;
        }else{
            $('.integer-decimal, .integer2, float2').each(function(){
                $(this).val(unformatNumber($(this).val()));
            });
            $('#rencanakebutuhan-form').submit();
        }
        
        $(".animation-loading").removeClass("animation-loading");
//        $("form").find('.float2').each(function(){
//            $(this).val(formatFloat($(this).val()));
//        });
//        $("form").find('.integer2').each(function(){
//            $(this).val(formatInteger($(this).val()));
//        });
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
    myConfirm('Apakah Anda akan membatalkan rencana kebutuhan barang ini?','Perhatian!',
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
    var renkebbahanmakanan_id = '<?php echo isset($_GET['renkebbahanmakanan_id']) ? $_GET['renkebbahanmakanan_id'] : ""; ?>';
    window.open('<?php echo $this->createUrl('print'); ?>&renkebbahanmakanan_id='+renkebbahanmakanan_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
}

/**
 * class integer2 di unformat 
 * @returns {undefined}
 */
//function unformatNumberSemua(){
//    $(".integer2").each(function(){
//        $(this).val(parseInt(unformatNumber($(this).val())));
//    });
//}
/**
 * class integer2 di format kembali
 * @returns {undefined}
 */
//function formatNumberSemua(){
//    $(".integer2").each(function(){
//        $(this).val(formatInteger($(this).val()));
//    });
//}

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
var renkebbarang_id = '<?php echo $modRencanaKebBarang->renkebbahanmakanan_id; ?>';
    if(renkebbarang_id != ""){
        renameInputRowBarang($("#table-barang"));                    
				hitungTotal();
    }
<?php 
        if(isset($modRencanaKebBarang->renkebbahanmakanan_id)){
    ?>
		renameInputRowBarang($("#table-barang"));                    
				hitungTotal();
    <?php
        }
    ?>
});

</script>