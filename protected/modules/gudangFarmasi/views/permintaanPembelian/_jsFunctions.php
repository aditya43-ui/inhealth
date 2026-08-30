<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>


<script type="text/javascript">
function refreshDialogOA(){        
	$("#obatalkes_nama").addClass("animation-loading-1");
	var su = $("#<?php echo CHtml::activeId($modPermintaanPembelian, 'supplier_nama') ?> ").val();
	if (su == "-- Pilih --"){
		su = "(Supplier Belum Dipilih)";
	}
	setTimeout(function(){
                $("#suppliernama").html(su);
				$("#obatalkes_nama").removeClass("animation-loading-1");
				var supplier_id = $('#<?php echo CHtml::activeId($modPermintaanPembelian,"supplier_id") ?>').val();        
				
				$(".dialog_supplier_id").val(supplier_id);        
				$.fn.yiiGridView.update('obatalkessupplier-m-grid', {
					data: {
						"GFObatSupplierM[supplier_id]":supplier_id,			
					}
				});
	},500);
}
	
/**
 * - digunakan untuk berpindah dialog box sesuai checkbox berdasarkan master oa
 * @param {type} obj
 * @returns {change dialog box show}
 */
function setValue(obj){								
	if($(obj).is(":checked")){
		//alert('chek');
		$("#obatalkes_nama").parent().find("a").removeAttr("onclick");
		$("#obatalkes_nama").parent().find("a").attr("onclick",'$("#dialogObatAlkes").dialog("open");return false;');
	}else{
		//alert('unchek');
		$("#obatalkes_nama").parent().find("a").removeAttr("onclick");
		$("#obatalkes_nama").parent().find("a").attr("onclick",'$("#dialogObatAlkesSupplier").dialog("open");return false;');
	}
}

function cekTipeSatuan(obj){
	var tipesatuan = $(obj).val();
	
	if (tipesatuan == '<?php echo Params::SATUANOBAT_KECIL ?>'){
		$("#ceksatuankecil").attr("style","display:block;");
		$("#ceksatuanbesar").attr("style","display:none;");
	}else if (tipesatuan == '<?php echo Params::SATUANOBAT_BESAR ?>'){
		$("#ceksatuankecil").attr("style","display:none;");
		$("#ceksatuanbesar").attr("style","display:block;");
	}
}
	
    
function viewStokOA(id) {
    $.post('<?php echo $this->createUrl('viewStokOA'); ?>', {id: id}, function(data) {
        $("#info_stok_min").html(data.stok_min);
        $("#info_stok_max").html(data.stok_max);
        $(".tab_info .details").remove();
        $(data.detail).appendTo(".tab_info");
        $(".tab_info").show();
    },'json');
}    
    
    
function tambahObatAlkes()
{
    var obatalkes_id = $('#obatalkes_id').val();
    var jumlah = $('#qty_input').val();
	var statusobat = $("#statusobat").val();
	var tipesatuan = $("#tipesatuan").val();
	var supplier_id = $("#<?php echo CHtml::activeId($modPermintaanPembelian, 'supplier_id') ?>").val();
    
    if(obatalkes_id != '')
    {
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('loadFormPermintaanPembelian'); ?>',
            data: {obatalkes_id:obatalkes_id,jumlah:jumlah,tipesatuan:tipesatuan, statusobat:statusobat,supplier_id:supplier_id},//
            dataType: "json",
            success:function(data){
                $('#table-obatalkespasien > tbody').append(data.form);
                $("#table-obatalkespasien").find('input[name$="[ii][obatalkes_id]"]').val(obatalkes_id);
                $("#table-obatalkespasien").find('input[name*="[ii]"][class*="integer2"]').maskMoney(
				//$("#table-obatalkespasien").find('input[class*="integer2"]').maskMoney(
                    {"symbol":"","defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":0}
                );				
				$("#table-obatalkespasien").find('[class*="integerFloat"]').maskMoney(
                  //  {"symbol":"","defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":2}
                );
                $(".tab_info").hide();
                renameInputRowObatAlkes($("#table-obatalkespasien"));                   
                hitungTotal();				
				$("#table-obatalkespasien").find(".satuanobat").change();
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
        var jmlpermintaan  = parseFloat($(this).find('input[name$="[jmlpermintaan]"]').val());
        var harganetto  = parseFloat($(this).find('input[name$="[harganettoper]"]').val());
        var persendis  = parseFloat($(this).find('input[name$="[persendiscount]"]').val());
        var persenppn = parseInt($(this).find('input[name$="[persenppn]"]').val());
        var persenpph = parseInt($(this).find('input[name$="[persenpph]"]').val());
        var kemasanbesar = parseInt($(this).find('input[name$="[kemasanbesar]"]').val());
       
        if((typeof kemasanbesar === "undefined") || isNaN(kemasanbesar)){
            kemasanbesar = 0;
        }
        
        if(kemasanbesar >0){
            jmlpermintaan = (jmlpermintaan * kemasanbesar);
        }
        
        var totaljml = harganetto * jmlpermintaan;
         if (totaljml > 0){
            totaljml = parseFloat(totaljml.toFixed(2));
        }
        
        var jmldiskon = ((totaljml * persendis)/100);
        if (jmldiskon > 0){
            jmldiskon = parseFloat(jmldiskon.toFixed(2));
        }
        
        var jmlppn = (((totaljml - jmldiskon) * persenppn)/100);
        if (jmlppn > 0){
            jmlppn = parseFloat(jmlppn.toFixed(2));
        }
        
        var jmlpph = (((totaljml - jmldiskon) * persenpph)/100);
        if (jmlpph > 0){
            jmlpph = parseFloat(jmlpph.toFixed(2));
        }
        
        var subtotal = (totaljml - jmldiskon + jmlppn - jmlpph);
        
        if(subtotal <= 0){
            subtotal = 0;
        }
        
        total += subtotal;
        $(this).find('input[name$="[hargasatuanper]"]').val(subtotal);
        $(this).find('input[name$="[ppn]"]').val(jmlppn);
        $(this).find('input[name$="[hpp]"]').val(subtotal);
//        $(this).find('input[name$="[subtotal]"]').val(subtotal);
        $(this).find('input[name$="[jmldiscount]"]').val(jmldiskon);
        $(this).find('input[name$="[jmlpph]"]').val(jmlpph);
    });
    $('#total').val(total);    
    formatNumberSemua();
    checkuangmuka();
}

function checkuangmuka(){
    unformatNumberSemua();
    var totalpermintaan = parseFloat($('#total').val());
    var jmluangmuka  = parseFloat($('#<?php echo CHtml::activeId($modPermintaanPembelian, 'jmlpermintaanuangmuka'); ?>').val());
    
    if(jmluangmuka > totalpermintaan){
        myAlert("Jumlah Uang Muka Tidak Boleh Lebih Besar dari Total Permintaan Pembelian Obat Alkes");
        $('#<?php echo CHtml::activeId($modPermintaanPembelian, 'jmlpermintaanuangmuka'); ?>').val(0);
    }
    formatNumberSemua();
}

function setPersenPPN(obj){	
    //$(obj).parents("tr").find('input[name$="[persendiscount]"]').val(0);
	var ppnpersen = parseInt($(obj).parents("tr").find('input[name$="[persenppn]"]').val());	
	
	if (ppnpersen > 0){
		ppnpersen = <?php echo Params::DEFAULT_PPN; ?>;
	}
	
	$(obj).parents("tr").find('input[name$="[persenppn]"]').val(ppnpersen);		
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

        // $(this).find('.integer-decimal').unmaskMoney({ "symbol": "", "defaultZero": true, "allowZero": true, "decimal": ",", "thousands": ".", "precision": 2 }); 
        // $(this).find('.integer-decimal').maskMoney(
        //     {"symbol": "", "defaultZero": true, "allowZero": true, "decimal": ",", "thousands": ".", "precision": 2}
        // );
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
        }
    }); 
    hitungTotal();
}

function cekObat(){
    if(requiredCheck($("form"))){
        var jmlObat = $('#table-obatalkespasien tbody tr').length;
        if(jmlObat <= 0){
                myAlert('Isikan obat alkes Permintaan Pembelian terlebih dahulu.');
            return false;
        }else{
            var cekpph = 0;
            $("#table-obatalkespasien tbody tr").each(function() {
                unformatNumberSemua();
                var persenpph  = parseFloat($(this).find('input[name$="[persenpph]"]').val());
                if(persenpph > 0){
                    cekpph += 1;
                }else{
                    if(cekpph > 1){
                        cekpph -= 1;
                    }
                }
                formatNumberSemua();
            });

            if(cekpph > 0){
                if($('#<?php echo CHtml::activeId($modPermintaanPembelian, 'pajak_id'); ?>').val() == ''){
                     myAlert("Jenis PPh harus diisi ");
                    return false;
                }
            }
            
            $(".integer2, .float2, .integer-decimal").each(function(){
                $(this).val(unformatNumber($(this).val()));
            });
            $('#permintaanpembelian-form').submit();
        }
        
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

function printObatTertentu(caraPrint)
{
    var permintaanpembelian_id = $('#permintaanpembelian_id').val();
    window.open('<?php echo $this->createUrl('printObatTertentu'); ?>&permintaanpembelian_id='+permintaanpembelian_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=900,height=640');
}

function printObatPrekursor(caraPrint)
{
    var permintaanpembelian_id = $('#permintaanpembelian_id').val();
    window.open('<?php echo $this->createUrl('printObatPrekursor'); ?>&permintaanpembelian_id='+permintaanpembelian_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=900,height=640');
}

function printObatPsikotropika(caraPrint)
{
    var permintaanpembelian_id = $('#permintaanpembelian_id').val();
    window.open('<?php echo $this->createUrl('printObatPsikotropika'); ?>&permintaanpembelian_id='+permintaanpembelian_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=900,height=640');
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

function pilihSatuan(obj){
    var satuanobat = $(obj).val();
    
    if(satuanobat == '<?php echo PARAMS::SATUANOBAT_KECIL; ?>'){
        $(obj).parents('tr').find('.satuankecil').show();
        $(obj).parents('tr').find('.satuanbesar').hide();
    }else{
        $(obj).parents('tr').find('.satuanbesar').show();
        $(obj).parents('tr').find('.satuankecil').hide();
    }
}

function setKategoriObat() {
    $("#table-obatalkespasien tbody").empty();
    $("#GFObatSupplierM_obatalkes_golongan").val($("#oa_kategori_obat").val());
    $.fn.yiiGridView.update("obatalkessupplier-m-grid", {data: $("#obatalkessupplier-m-grid :input").serialize()});
}

/**
 * function ini harus tetap berada di bawah
 */
$(document).ready(function(){
    var satuanobat = $('#ADRencDetailkebT_satuanobat').val();
    $('#satuankecil').hide();
    $('#satuanbesar').hide();
    
    if(satuanobat == '<?php echo PARAMS::SATUANOBAT_KECIL; ?>'){
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
            
    $('#form-uangmukapembelian > div > .accordion-heading').click(function () {
        var is_uangmukapembelian = $("#<?php echo CHtml::activeId($modPermintaanPembelian, 'is_uangmukapembelian'); ?>");
        if (is_uangmukapembelian.val() > 0) { //hide
            is_uangmukapembelian.val(0);
        } else {//show
            is_uangmukapembelian.val(1);
        }
    });
});
</script>