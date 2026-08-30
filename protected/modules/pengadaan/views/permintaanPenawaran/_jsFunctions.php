<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>

<script type="text/javascript">
function tambahObatAlkes()
{
    $("#table-obatalkespasien").addClass("animation-loading");
    var obatalkes_id = $('#obatalkes_id').val();
    var jumlah = $('#qty_input').val();
    
        if(obatalkes_id != '')
        {
             $.ajax({
                type:'POST',
                url:'<?php echo $this->createUrl('loadFormPermintaanPenawaran'); ?>', 
                data: {obatalkes_id:obatalkes_id,jumlah:jumlah},
                dataType: "json",
                success:function(data)
                {
                    $('#table-obatalkespasien > tbody').append(data.form);
                    $("#table-obatalkespasien").find('input[name$="[ii][obatalkes_id]"]').val(obatalkes_id);
                    $("#table-obatalkespasien").find('input[name*="[ii]"][class*="integer2"]').maskMoney(
                        {"symbol":"","defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":0}
                    );
                    $(".integer-decimal").maskMoney(
                        {"symbol": "", "defaultZero": true, "allowZero": true, "decimal": ",", "thousands": ".", "precision": 2}
                      );
                    renameInputRowObatAlkes($("#table-obatalkespasien"));
                    hitungTotal();
                    $("#table-obatalkespasien").removeClass("animation-loading");
					
					$("#ADPermintaanPenawaranT_supplier_id").change();
                },
                error: function (jqXHR, textStatus, errorThrown) { myAlert("Data Obat tidak ditemukan !"); $("#table-obatalkespasien").removeClass("animation-loading");}
            });
        }else{
            myAlert("Isikan item obat terlebih dahulu");
        }
}

function hitungTotal(){
    unformatNumberSemua();
    var total = 0;
    $('#table-obatalkespasien tbody tr').each(function(){
        var jmlpermintaan  = parseInt($(this).find('input[name$="[qty]"]').val());
        var harganetto  = parseInt($(this).find('input[name$="[harganetto]"]').val());
        subtotal = harganetto * jmlpermintaan;
        
        if(subtotal <= 0){
            subtotal = 0;
        }
        
        total += subtotal;
        $(this).find('input[name$="[subtotal]"]').val(subtotal);
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
    myConfirm('Apakah anda akan membatalkan permintaan penawaran obat ini?','Perhatian!',
    function(r){
        if(r){
            $(obj).parents('tr').detach();
			renameInputRowObatAlkes($("#table-obatalkespasien"));
			hitungTotal();
			$("#ADPermintaanPenawaranT_supplier_id").change();
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

/**
* untuk print permintaan penawaran
 */
function print(caraPrint)
{
    var permintaanpenawaran_id = $('#permintaanpenawaran_id').val();
    window.open('<?php echo $this->createUrl('print'); ?>&permintaanpenawaran_id='+permintaanpenawaran_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=640,height=480');
}

function cekBarang(){
    if(requiredCheck($("form"))){
        var jmlObat = $('#table-obatalkespasien tbody tr').length;
        if(jmlObat <= 0){
                myAlert('Isikan barang penawaran terlebih dahulu.');
            return false;
        }else{
            $('#permintaanpenawaran-form').submit();
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

/**
 * function ini harus tetap berada di bawah
 */
$(document).ready(function(){
    var satuanobat = $('#ADPenawaranDetailT_satuanobat').val();
    $('#satuankecil').hide();
    $('#satuanbesar').hide();
    
    if(satuanobat == 'SATUANKECIL'){
        $('#satuankecil').show();
        $('#satuanbesar').hide();
    }else{
        $('#satuanbesar').show();
        $('#satuankecil').hide();
    }
    
    var permintaanpenawaran_id = '<?php echo (isset($modPermintaanPenawaran->permintaanpenawaran_id)?$modPermintaanPenawaran->permintaanpenawaran_id:""); ?>';
    var rencanakebfarmasi_id = '<?php echo (isset($modRencanaKebFarmasi->rencanakebfarmasi_id)?$modRencanaKebFarmasi->rencanakebfarmasi_id:""); ?>';
    if(permintaanpenawaran_id != ""){
        $("#table-obatalkespasien :input").attr("readonly",true);
        $("#table-obatalkespasien .add-on").remove();
        $("#table-obatalkespasien .icon-remove").remove();
        
        $("#permintaanpenawaran-form :input").attr("readonly",true);
        $("#permintaanpenawaran-form .dtPicker3").attr("readonly",true);
        $("#permintaanpenawaran-form .add-on").remove();
        
        $("input, select, textarea").attr("disabled",true);
        
        renameInputRowObatAlkes($("#table-obatalkespasien")); 
        hitungTotal();
    }
    
    if(rencanakebfarmasi_id != ""){
        renameInputRowObatAlkes($("#table-obatalkespasien")); 
        hitungTotal();
    }

    // Notifikasi supplier 1
    <?php 
        if(isset($_GET['smscp1'])){
            if($_GET['smscp1']==0){
    ?>
        var params = [];
        params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Yii::app()->session['modul_id']; ?>, judulnotifikasi:'GAGAL KIRIM SMS SUPPLIER', isinotifikasi:'<?php echo $modPermintaanPenawaran->supplier->supplier_nama; ?> tidak memiliki nomor mobile'}; // 16 
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
        params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Yii::app()->session['modul_id']; ?>, judulnotifikasi:'GAGAL KIRIM SMS SUPPLIER 2', isinotifikasi:'<?php echo $modPermintaanPenawaran->supplier->supplier_nama; ?> tidak memiliki nomor mobile'}; // 16 
        insert_notifikasi(params);
    <?php            
            }
        }
    ?>

    <?php 
        if(isset($modRencanaKebFarmasi->permintaanpenawaran_id)){
    ?>
        var params = [];
        params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Params::MODUL_ID_AKUNTANSI ?>, judulnotifikasi:'Permintaan Penawaran', isinotifikasi:'Telah dilakukan permintaan penawaran pada <?php echo $modPermintaanPenawaran->tglpenawaran ?>'}; // 16 
        insert_notifikasi(params);
    <?php
        }
    ?>
	<?php if(isset($_GET['ubah'])){ ?>
		renameInputRowObatAlkes($("#table-obatalkespasien"));
		hitungTotal();
	<?php } ?>
		
	<?php if ($modPermintaanPenawaran->isNewRecord): ?>
		
		setValidasiCekDisabled($("#permintaanpenawaran-form"), function() {
			if ($("#table-obatalkespasien tbody tr").length == 0) {
				return false;
			}
			return true;
		});
	<?php endif; ?>	
		
});
</script>