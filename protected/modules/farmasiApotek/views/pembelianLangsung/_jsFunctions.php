<script type="text/javascript">

/** control accordion faktur pembelian */
$('#form-fakturpembelian > div > .accordion-heading').click(function(){
    var is_langsungfaktur = $("#<?php echo CHtml::activeId($modPenerimaanBarang, "is_langsungfaktur"); ?>");
    if(is_langsungfaktur.val() > 0){ //hide
        is_langsungfaktur.val(0);
    }else{//show
        is_langsungfaktur.val(1);
    }
    
//    $("input, select, textarea").attr("disabled",false);
//    $("#form-fakturpembelian :input").attr("readonly",false);
    
//    $("#<?php // echo CHtml::activeId($modPenerimaanBarang,'keteranganfaktur'); ?>").attr("readonly",false);
//    $("#<?php echo CHtml::activeId($modFakturPembelian,'totharganetto'); ?>").attr("readonly",true);
//    $("#<?php echo CHtml::activeId($modFakturPembelian,'totalhargabruto'); ?>").attr("readonly",true);
//    $("#<?php echo CHtml::activeId($modFakturPembelian,'totalpajakppn'); ?>").attr("readonly",true);
//    $("#<?php echo CHtml::activeId($modFakturPembelian,'totalpajakppn'); ?>").attr("readonly",true);
//    $("#<?php // echo CHtml::activeId($modFakturPembelian,'persendiscount'); ?>").attr("readonly",true);
//    $("#<?php // echo CHtml::activeId($modFakturPembelian,'jmldiscount'); ?>").attr("readonly",true);
    
});

function tambahObatAlkes()
{
    var obatalkes_id = $('#obatalkes_id').val();
    var jumlah = $('#qty_input').val();
    var tgl_kadaluarsa = $('#<?php echo CHtml::activeId($modPenerimaanBarang,'tglkadaluarsa'); ?>').val()
    
    if(tgl_kadaluarsa != ''){
        if(obatalkes_id != '')
        {
            $.ajax({
                type:'POST',
                url:'<?php echo $this->createUrl('loadFormPenerimaanBarang'); ?>',
                data: {obatalkes_id:obatalkes_id,jumlah:jumlah,tgl_kadaluarsa:tgl_kadaluarsa},//
                dataType: "json",
                success:function(data){
                    $('#table-obatalkespasien > tbody').append(data.form);
                    $("#table-obatalkespasien").find('input[name$="[ii][obatalkes_id]"]').val(obatalkes_id);
                    $("#table-obatalkespasien").find('input[name*="[ii]"][class*="integer"]').maskMoney(
                        {"symbol":"","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":0}
                    );

                    renameInputRowObatAlkes($("#table-obatalkespasien"));
                    jQuery('input[name$="[tglkadaluarsa]"]').datetimepicker(
                            jQuery.extend(
                                {
                                    showMonthAfterYear:false
                                }, 
                                jQuery.datepicker.regional['id'],
                                {
//                                    'dateFormat':'dd M yy',
                                    'minDate':'d',
                                    'timeText':'Waktu',
                                    'hourText':'Jam',
                                    'minuteText':'Menit',
                                    'secondText':'Detik',
                                    'showSecond':true,
                                    'timeOnlyTitle':'Pilih Waktu',
                                    'timeFormat':'hh:mm:ss',
                                    'changeYear':true,
                                    'changeMonth':true,
                                    'showAnim':'fold',
                                    'yearRange':'-80y:+20y'
                                }
                            )
                        ).mask("99/99/9999 99:99:99");
                    hitungTotal();
                },
                error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
            });
        }else{
            myAlert("Isikan item obat terlebih dahulu");
        }
    }else{
        myAlert("Isikan tanggal kadaluarsa terlebih dahulu");
    }
}

function hitungTotal(){
    unformatNumberSemua();
    var total = 0;
    var totalppn = 0;
    var totalpph = 0;	
    var totalharganetto = 0;
	var totalpersendisc = 0;
	var totaldisc = 0;
	var totalhargasatuanper = 0;
    $('#table-obatalkespasien tbody tr').each(function(){
        var jmlppn  = parseInt($('#ppn').val());
        var jmlpph  = parseInt($('#pph').val());
        var jmlpermintaan  = parseInt($(this).find('input[name$="[jmlpermintaan]"]').val());
        var harganetto  = parseInt($(this).find('input[name$="[harganettoper]"]').val());
        var persendis  = parseInt($(this).find('input[name$="[persendiscount]"]').val());
        var jmldis  = parseInt($(this).find('input[name$="[jmldiscount]"]').val());
        var ppn  = parseInt($(this).find('input[name$="[persenppn]"]').val());
        var pph  = parseInt($(this).find('input[name$="[persenpph]"]').val());
        	
		
        subtotal = harganetto * jmlpermintaan;
        totalharganetto += subtotal;
        
        if(subtotal <= 0){
            subtotal = 0;
        }
        
        if(jmlppn > 0){
            ppn = (harganetto * (jmlppn/100));
            subtotal = ((harganetto + ppn) * jmlpermintaan);
        }
        totalppn += (ppn * jmlpermintaan);
        
        if(jmlpph > 0){
            pph = subtotal * (jmlpph/100);
            subtotal = (subtotal + (pph));
        }
        totalpph += pph;
//        jmldisc = (subtotal * (persendis/100));
        
        if(persendis > 0){  
			totalpersendisc += persendis;
			totaldisc += (subtotal * (persendis/100));
			subtotal = subtotal - (subtotal * (persendis/100));			
        }else if(jmldis > 0){    
			if(jmldis > subtotal){
				myAlert('Jumlah Diskon tidak boleh melebihi dari Sub Total');
				return false;
			}
			totalpersendisc += (jmldis / subtotal) * 100;
			totaldisc += jmldis;
			subtotal = subtotal - jmldis;
        }       
        
        total += subtotal;
		if(ppn > 0){
			totalhargasatuanper = totalppn;
		}
		if(pph > 0){
			totalhargasatuanper = totalpph;
		}
				
        $(this).find('input[name$="[subtotal]"]').val(subtotal);
//        $(this).find('input[name$="[jmldiscount]"]').val(totaldisc);
//        $(this).find('input[name$="[persendiscount]"]').val(totalpersendisc);
        $(this).find('input[name$="[persenppn]"]').val(jmlppn);
        $(this).find('input[name$="[persenpph]"]').val(jmlpph);
        $(this).find('input[name$="[hargasatuanper]"]').val(totalhargasatuanper);
		
		if($('#termasukPPN').is(':checked')){
			totalppn = totalppn;
		}else{
			totalppn = 0;
		}
		
		if($('#termasukPPH').is(':checked')){
			totalpph = totalpph;
		}else{
			totalpph = 0;
		}
    });
    $('#total').val(total);    
    $('#<?php echo CHtml::activeId($modFakturPembelian,'totharganetto'); ?>').val(totalharganetto);    
    $('#<?php echo CHtml::activeId($modPenerimaanBarang,'harganetto'); ?>').val(totalharganetto);    
    $('#<?php echo CHtml::activeId($modPenerimaanBarang,'totalharga'); ?>').val(total);    
    $('#<?php echo CHtml::activeId($modPenerimaanBarang,'persendiscount'); ?>').val(totalpersendisc);    
    $('#<?php echo CHtml::activeId($modPenerimaanBarang,'jmldiscount'); ?>').val(totaldisc);    
    $('#<?php echo CHtml::activeId($modFakturPembelian,'totalhargabruto'); ?>').val(total);       
    $('#<?php echo CHtml::activeId($modFakturPembelian,'totalpajakppn'); ?>').val(totalppn);       
    $('#<?php echo CHtml::activeId($modFakturPembelian,'totalpajakpph'); ?>').val(totalpph);       
    formatNumberSemua();
}

/**
* rename input grid
*/ 
function renameInputRowObatAlkes(obj_table){
    var row = 0;
    $(obj_table).find("tbody > tr").each(function(){
        $(this).find("#no_urut").val(row+1);
//        $(this).find('span').each(function(){ //element <input>
//            var old_name = $(this).attr("name").replace(/]/g,"");
//            var old_name_arr = old_name.split("[");
//            if(old_name_arr.length == 3){
//                $(this).attr("name","["+row+"]["+old_name_arr[2]+"]");
//            }
//        });
        $(this).find('input,select,textarea').each(function(){ //element <input>
            var old_name = $(this).attr("name").replace(/]/g,"");
            var old_name_arr = old_name.split("[");
            if(old_name_arr.length == 3){
                $(this).attr("id",old_name_arr[0]+"_"+row+"_"+old_name_arr[2]);
                $(this).attr("name",old_name_arr[0]+"["+row+"]["+old_name_arr[2]+"]");
            }
        });
        $(this).find('input[name$="[tglkadaluarsa]"]').each(function(){ //element <input>
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

function setPersenDiskon(obj){
    $(obj).parents("tr").find('input[name$="[persendiscount]"]').val(0);
}

function setJmlDiskon(obj){
    $(obj).parents("tr").find('input[name$="[jmldiscount]"]').val(0);
}

function setPersenDiskonFaktur(obj){
    var obj_persen = $('#<?php echo CHtml::activeId($modFakturPembelian,'persendiscount'); ?>');
    obj_persen.val(0);
    if($(obj).is(':checked')){
        obj_persen.attr('readonly',false);
    }else{
        obj_persen.attr('readonly',true);
    }
    setPersenDiskonDetail();
        
}

function setPersenDiskonDetail(){
    var persen = $('#<?php echo CHtml::activeId($modFakturPembelian,'persendiscount'); ?>').val();
    
    $('#table-obatalkespasien tr').each(function(){
        $(this).find('input[name$="[persendiscount]"]').val(persen);
        $(this).find('input[name$="[jmldiscount]"]').val(0);
    });
    hitungTotal();
}

function hitungTotalDiskon(obj){
	unformatNumberSemua();
	var totalpersendisc = 0;
	var totaldisc = 0;
	var subtotal = 0;
        var jmlppn  = parseInt($('#ppn').val());
        var jmlpph  = parseInt($('#pph').val());
        var jmlpermintaan  = parseInt($(obj).parents("tr").find('input[name$="[jmlpermintaan]"]').val());
        var harganetto  = parseInt($(obj).parents("tr").find('input[name$="[harganettoper]"]').val());
        var persendis  = parseInt($(obj).parents("tr").find('input[name$="[persendiscount]"]').val());
        var jmldis  = parseInt($(obj).parents("tr").find('input[name$="[jmldiscount]"]').val());
        var ppn  = parseInt($(obj).parents("tr").find('input[name$="[persenppn]"]').val());
        var pph  = parseInt($(obj).parents("tr").find('input[name$="[persenpph]"]').val());
        
		subtotal = harganetto * jmlpermintaan;
		
        if(persendis > 0){  
			totalpersendisc += persendis;
			totaldisc += (subtotal * (persendis/100));
			subtotal = subtotal - (subtotal * (persendis/100));			
        }else if(jmldis > 0){    
			if(jmldis > subtotal){
				myAlert('Jumlah Diskon tidak boleh melebihi dari Sub Total');
				return false;
			}
			totalpersendisc += (jmldis / subtotal) * 100;
			totaldisc += jmldis;
			subtotal = subtotal - jmldis;
        }       
        totaldisc = (totaldisc.toFixed(2));
		totalpersendisc = (totalpersendisc.toFixed(2));
        $(obj).parents("tr").find('input[name$="[jmldiscount]"]').val(totaldisc);
        $(obj).parents("tr").find('input[name$="[persendiscount]"]').val(totalpersendisc);
		hitungTotal();
		formatNumberSemua();
}
/**
 * class integer di unformat 
 * @returns {undefined}
 */
function unformatNumberSemua(){
    $(".integer").each(function(){
        $(this).val(parseInt(unformatNumber($(this).val())));
    });
	$(".float").each(function(){
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
	$(".float").each(function(){
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

function persenPpn(obj){
    if(obj.checked==true){
        var ppn = '<?php echo Yii::app()->user->getState('persenppn'); ?>';
//        $('#<?php //echo CHtml::activeId($modFakturPembelian,'totalpajakppn'); ?>').val(ppn);
        $('#ppn').val(ppn);
        $('#<?php echo CHtml::activeId($modFakturPembelian,'totalpajakppn'); ?>').attr("readonly",false);
    }else{
//        $('#<?php // echo CHtml::activeId($modFakturPembelian,'totalpajakppn'); ?>').val(0);
        $('#ppn').val(ppn);
        $('#<?php echo CHtml::activeId($modFakturPembelian,'totalpajakppn'); ?>').attr("readonly",true);
    }
    hitungTotal();
}

function persenPph(obj){
    if(obj.checked==true){
        var pph = '<?php echo Yii::app()->user->getState('persenpph'); ?>';
//        $('#<?php // echo CHtml::activeId($modFakturPembelian,'totalpajakpph'); ?>').val(pph);
        $('#pph').val(pph);
        $('#<?php echo CHtml::activeId($modFakturPembelian,'totalpajakpph'); ?>').attr("readonly",false);
    }else{
//        $('#<?php // echo CHtml::activeId($modFakturPembelian,'totalpajakpph'); ?>').val(0);
        $('#pph').val(pph);
        $('#<?php echo CHtml::activeId($modFakturPembelian,'totalpajakpph'); ?>').attr("readonly",true);
    }
    hitungTotal();
}

function batalObat(obj){
    myConfirm('Apakah anda akan membatalkan penerimaan barang obat ini?','Perhatian!',
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
    var penerimaanbarang_id = $('#penerimaanbarang_id').val();
    window.open('<?php echo $this->createUrl('print'); ?>&penerimaanbarang_id='+penerimaanbarang_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
}

/**
 * function ini harus tetap berada di bawah
 */
$(document).ready(function(){
    var penerimaanbarang_id = '<?php echo $modPenerimaanBarang->penerimaanbarang_id; ?>';
    var permintaanpembelian_id = '<?php echo isset($modPermintaanPembelian->permintaanpembelian_id) ? $modPermintaanPembelian->permintaanpembelian_id : null; ?>';
    if(penerimaanbarang_id != ""){
        $("#table-obatalkespasien :input").attr("readonly",true);
        $("#table-obatalkespasien .add-on").remove();
        $("#table-obatalkespasien .icon-remove").remove();
        
        $("#penerimaanbarang-form :input").attr("readonly",true);
        $("#penerimaanbarang-form .dtPicker3").attr("readonly",true);
        $("#penerimaanbarang-form .add-on").remove();
        
        $("input, select, textarea").attr("disabled",true);
        
        renameInputRowObatAlkes($("#table-obatalkespasien")); 
        hitungTotal();
    }
    
    if(permintaanpembelian_id != ""){
        renameInputRowObatAlkes($("#table-obatalkespasien")); 
        hitungTotal();
    }

    // Notifikasi supplier 1
    <?php 
        if(isset($_GET['smscp1'])){
            if($_GET['smscp1']==0){
    ?>
        var params = [];
        params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Yii::app()->session['modul_id']; ?>, judulnotifikasi:'GAGAL KIRIM SMS SUPPLIER', isinotifikasi:'<?php echo $modPenerimaanBarang->supplier->supplier_nama; ?> tidak memiliki nomor mobile'}; // 16 
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
        params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Yii::app()->session['modul_id']; ?>, judulnotifikasi:'GAGAL KIRIM SMS SUPPLIER 2', isinotifikasi:'<?php echo $modPenerimaanBarang->supplier->supplier_nama; ?> tidak memiliki nomor mobile'}; // 16 
        insert_notifikasi(params);
    <?php            
            }
        }
    ?>

    <?php 
        if(isset($modPenerimaanBarang->penerimaanbarang_id)){
    ?>
        var params = [];
        params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Params::MODUL_ID_GUDANGFARMASI ?>, judulnotifikasi:'Permintaan Pembelian', isinotifikasi:'Telah dilakukan penerimaan obat alkes dengan <?php echo $modPenerimaanBarang->nosuratjalan ?> pada <?php echo $modPenerimaanBarang->tglterima ?>'}; // 16 
        insert_notifikasi(params);

        var params = [];
        params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Params::MODUL_ID_AKUNTANSI ?>, judulnotifikasi:'Permintaan Pembelian', isinotifikasi:'Telah dilakukan penerimaan obat alkes dengan <?php echo $modPenerimaanBarang->nosuratjalan ?> pada <?php echo $modPenerimaanBarang->tglterima ?>'}; // 16 
        insert_notifikasi(params);
    <?php
        }
    ?>
    
});
</script>