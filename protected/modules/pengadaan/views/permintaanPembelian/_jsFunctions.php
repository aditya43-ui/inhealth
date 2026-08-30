<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>


<script type="text/javascript">
function tambahObatAlkes()
{
    var obatalkes_id = $('#obatalkes_id').val();
    var jumlah = $('#qty_input').val();
    
        if(obatalkes_id != '')
        {
            $.ajax({
                type:'POST',
                url:'<?php echo $this->createUrl('loadFormPermintaanPembelian'); ?>',
                data: {obatalkes_id:obatalkes_id,jumlah:jumlah},//
                dataType: "json",
                success:function(data){
                    $('#table-obatalkespasien > tbody').append(data.form);
                    $("#table-obatalkespasien").find('input[name$="[ii][obatalkes_id]"]').val(obatalkes_id);
                    $("#table-obatalkespasien").find('input[name*="[ii]"][class*="integer2"]').maskMoney(
                        {"symbol":"","defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":0}
                    );
                    renameInputRowObatAlkes($("#table-obatalkespasien"));                    
                    hitungTotal();
					$("#ADPermintaanpembelianT_pegawaimengetahui_nama").blur();
                },
                error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
            });
        }else{
            myAlert("Isikan item obat terlebih dahulu");
        }
}

function hitungTotal(){
    unformatNumberSemua();
    var total = 0;
    $('#table-obatalkespasien tbody tr').each(function(){
        var jmlpermintaan  = parseInt($(this).find('input[name$="[jmlpermintaan]"]').val());
        var harganetto  = parseInt($(this).find('input[name$="[harganettoper]"]').val());
        var persendis  = parseInt($(this).find('input[name$="[persendiscount]"]').val());
        var jmldis  = parseInt($(this).find('input[name$="[jmldiscount]"]').val());
        subtotal = harganetto * jmlpermintaan;
        jmldisc = (harganetto * (persendis/100));
        
        if(jmldisc > 0){
            subtotal = subtotal - jmldisc;
        }else{
            subtotal = subtotal - jmldis;
            jmldisc = jmldis;
        }
        
        if(subtotal <= 0){
            subtotal = 0;
        }
        
        total += subtotal;
        $(this).find('input[name$="[subtotal]"]').val(subtotal);
        $(this).find('input[name$="[jmldiscount]"]').val(jmldisc);
    });
    $('#total').val(total);    
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
    $('#obatalkes_id').val('');
    $('#obatalkes_nama').val('');
    $('#qty_input').val(1);
}

function batalObat(obj){
    myConfirm('Apakah anda akan membatalkan permintaan pembelian obat ini?','Perhatian!',
    function(r){
        if(r){
			$(obj).parents('tr').detach();
			$("#ADPermintaanpembelianT_pegawaimengetahui_nama").blur();
			hitungTotal();
        }
    }); 
}

function pilihSatuan(obj){
    var satuanobat = $(obj).val();
    
    if(satuanobat == '<?php echo PARAMS::SATUAN_KECIL; ?>'){
        $(obj).parents('tr').find('.satuankecil').show();
        $(obj).parents('tr').find('.satuanbesar').hide();
    }else{
        $(obj).parents('tr').find('.satuanbesar').show();
        $(obj).parents('tr').find('.satuankecil').hide();
    }
}
function cekObat(){
    if(requiredCheck($("form"))){
        var jmlObat = $('#table-obatalkespasien tbody tr').length;
        if(jmlObat <= 0){
                myAlert('Isikan obat alkes rencana kebutuhan terlebih dahulu.');
            return false;
        }else{
            $('#permintaanpembelian-form').submit();
        }
        
        $(".animation-loading").removeClass("animation-loading");
        $("form").find('.float').each(function(){
            $(this).val(formatFloat($(this).val()));
        });
        $("form").find('.integer2').each(function(){
            $(this).val(formatInteger($(this).val()));
        });
    }
    return false;
    
}
/**
* load rencdetailkeb_t yang sudah tersimpan berdasarkan:
* - permintaanpembelian_id
*/ 
function setRiwayatRencanaKebutuhan(){
    $('#table-obatalkespasien').addClass("animation-loading");
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('setRiwayatRencanaKebutuhan'); ?>',
        data: {permintaanpembelian_id:$("#permintaanpembelian_id").val()},
        dataType: "json",
        success:function(data){
            $('#table-obatalkespasien > tbody').html(data.rows);
            $('#table-obatalkespasien > tbody').find('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip({"placement":"<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
            $('#table-obatalkespasien').removeClass("animation-loading");
            renameInputRowObatAlkes($("#table-obatalkespasien"));
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}

/**
* untuk print rencana kebutuhan
 */
function print(caraPrint)
{
    var permintaanpembelian_id = $('#permintaanpembelian_id').val();
    window.open('<?php echo $this->createUrl('print'); ?>&permintaanpembelian_id='+permintaanpembelian_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
}

/**
 * class integer2 di unformat 
 * @returns {undefined}
 */
function unformatNumberSemua(){
    $(".integer2").each(function(){
        $(this).val(parseInt(unformatNumber($(this).val())));
    });
}
/**
 * class integer2 di format kembali
 * @returns {undefined}
 */
function formatNumberSemua(){
    $(".integer2").each(function(){
        $(this).val(formatInteger($(this).val()));
    });
}

function pilihSatuan(obj){
    var satuanobat = $(obj).val();
    
    if(satuanobat == '<?php echo PARAMS::SATUAN_KECIL; ?>'){
        $(obj).parents('tr').find('.satuankecil').show();
        $(obj).parents('tr').find('.satuanbesar').hide();
    }else{
        $(obj).parents('tr').find('.satuanbesar').show();
        $(obj).parents('tr').find('.satuankecil').hide();
    }
}
/**
 * function ini harus tetap berada di bawah
 */
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
    
    var permintaanpembelian_id = '<?php echo $modPermintaanPembelian->permintaanpembelian_id; ?>';
    var rencanakebfarmasi_id = '<?php echo isset($_GET['rencana_id']) ? $_GET['rencana_id'] : null; ?>';
    var permintaanpenawaran_id = '<?php echo isset($modPermintaanPenawaran->permintaanpenawaran_id) ? $modPermintaanPenawaran->permintaanpenawaran_id : null; ?>';
    
    if(permintaanpembelian_id != ""){
        $("#table-obatalkespasien :input").attr("readonly",true);
        $("#table-obatalkespasien .add-on").remove();
        $("#table-obatalkespasien .icon-remove").remove();
        
        $("#permintaanpembelian-form :input").attr("readonly",true);
        $("#permintaanpembelian-form .dtPicker3").attr("readonly",true);
        $("#permintaanpembelian-form .add-on").remove();
        
        $("input, select, textarea").attr("disabled",true);
        
        renameInputRowObatAlkes($("#table-obatalkespasien")); 
        hitungTotal();
    }
    
    if(rencanakebfarmasi_id != ""){
        renameInputRowObatAlkes($("#table-obatalkespasien")); 
        hitungTotal();
    }
    
    if(permintaanpenawaran_id != ""){
        renameInputRowObatAlkes($("#table-obatalkespasien")); 
        hitungTotal();
    }

    // Notifikasi supplier 1
    <?php 
        if(isset($_GET['smscp1'])){
            if($_GET['smscp1']==0){
    ?>
        var params = [];
        params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Yii::app()->session['modul_id']; ?>, judulnotifikasi:'GAGAL KIRIM SMS SUPPLIER', isinotifikasi:'<?php echo $modPermintaanPembelian->supplier->supplier_nama; ?> tidak memiliki nomor mobile'}; // 16 
        insert_notifikasi(params);
    <?php            
            }
        }
    ?>
    // Notifikasi supplier 2
    <?php 
        if(isset($_GET['smscp2'])){
            if($_GET['smscp2']==0){
    ?>
        var params = [];
        params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Yii::app()->session['modul_id']; ?>, judulnotifikasi:'GAGAL KIRIM SMS SUPPLIER 2', isinotifikasi:'<?php echo $modPermintaanPembelian->supplier->supplier_nama; ?> tidak memiliki nomor mobile'}; // 16 
        insert_notifikasi(params);
    <?php            
            }
        }
    ?>

    <?php 
        if(isset($modPermintaanPembelian->permintaanpembelian_id)){
    ?>
        var params = [];
        params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Params::MODUL_ID_AKUNTANSI ?>, judulnotifikasi:'Permintaan Pembelian', isinotifikasi:'Telah dilakukan permintaan penawaran pada <?php echo $modPermintaanPembelian->tglpermintaanpembelian ?>'}; // 16 
        insert_notifikasi(params);
    <?php
        }
    ?>
	<?php if(isset($_GET['ubah'])){ ?>
		renameInputRowObatAlkes($("#table-obatalkespasien"));
		hitungTotal();
	<?php } ?>
		
	<?php if ($modPermintaanPembelian->isNewRecord): ?>
		
		setValidasiCekDisabled($("#permintaanpembelian-form"), function() {
			if ($("#table-obatalkespasien tbody tr").length == 0) {
				return false;
			}
			return true;
		});
		
	<?php endif; ?>	
		
});
</script>