<script type="text/javascript">
//==================================================Validasi===============================================
//*Jangan Lupa untuk menambahkan hiddenField dengan id "berubah" di setiap form
//* hidden field dengan id "url"
//*Copas Saja hiddenfield di Line 36 dan 35
//* ubah juga id button simpannya jadi "btn_simpan"
function palidasiForm(obj)
{
    var berubah = $('#berubah').val();
    if(berubah=='Ya'){
        myConfirm("Apakah Anda Akan menyimpan Perubahan Yang Sudah Dilakukan?","Perhatian!",function(r) {
            if(r){
                $('#url').val(obj);
                $('#btn_simpan').click();
            }
        });
    }      
}

function viewDetailKonsul(idKonsulAntarPoli)
{
    $.post('<?php echo $this->createUrl('ajaxDetailKonsul') ?>', {idKonsulAntarPoli: idKonsulAntarPoli}, function(data){
        $('#contentDetailKonsul').html(data.result);
    }, 'json');
    $('#dialogDetailKonsul').dialog('open');
}
function batalKonsul(idKonsulAntarPoli,pendaftaran_id)
{
    myConfirm("Apakah Anda akan membatalkan konsul ini?","Perhatian!",function(r) {
        if(r){
            $.post('<?php echo $this->createUrl('ajaxBatalKonsul') ?>', {idKonsulAntarPoli: idKonsulAntarPoli, pendaftaran_id:pendaftaran_id}, function(data){
                $('#tblListKonsul').html(data.result);
            }, 'json');
        }
    });
}
/**
 * menampilkan karcis
 */
function setKarcis()
{
	var kelaspelayanan_id = '<?php echo isset($modPendaftaran->kelaspelayanan_id) ? $modPendaftaran->kelaspelayanan_id : null; ?>';
	var ruangan_id = $("#<?php echo CHtml::activeId($modKonsul,"ruangan_id");?>").val();
	var penjamin_id = '<?php echo isset($modPendaftaran->penjamin_id) ? $modPendaftaran->penjamin_id : null; ?>';
	var pasien_id = '<?php echo isset($modPendaftaran->pasien_id) ? $modPendaftaran->pasien_id : null; ?>';
    
    if(kelaspelayanan_id !== "" && ruangan_id !== "" && penjamin_id !== "") {
        $("#form-karcis").addClass("animation-loading");
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('SetKarcis'); ?>',
            data: {kelaspelayanan_id:kelaspelayanan_id, ruangan_id : ruangan_id, penjamin_id:penjamin_id, pasien_id:pasien_id},//
            dataType: "json",
            success:function(data){
                $("#content-karcis-html").html(data.listKarcis);
                $("#form-karcis").removeClass("animation-loading");
            },
             error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        });
    }else{
        $("#content-karcis-html").html("");
    }
	updateChecklistTindakanMcuDiluarPaket();
}
/** control accordion rujukan */
$('#form-karcis > div > .accordion-heading').click(function(){
//    console.log("Karcis Di Klik!");
    var is_adakarcis = $("#<?php echo CHtml::activeId($modPendaftaran, "is_adakarcis"); ?>");
    if(is_adakarcis.val() > 0){ //hide
        is_adakarcis.val(0);
    }else{//show
        is_adakarcis.val(1);
    }
});
/**
 * pilih karcis (check - uncheck)
 * harus pilih salah satu
 * @param {type} obj
 * @returns {undefined} */
function pilihKarcis(obj){
//    console.log("Karcis Dipilih!");
    var is_pilihtindakan = $(obj).parents('tr').find('input[name$="[is_pilihtindakan]"]');
    $(obj).parents('table').find('tr').each(function(){
        $(this).find('input[name$="[is_pilihtindakan]"]').val(0);
        $(this).removeClass('checked');
    });
    if(is_pilihtindakan.val() > 0){
        is_pilihtindakan.val(0);
        $(obj).parents('tr').removeClass('checked');
    }else{
        is_pilihtindakan.val(1);
        $(obj).parents('tr').addClass('checked');
    }
}
/**
 * print karcis
 */
function printKarcis()
{
    window.open('<?php echo $this->createUrl('printKarcis',array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id)); ?>','printwin','left=100,top=100,width=480,height=640');
}

/**
 * Function Pemeriksaan MCU
*/
/**
 * Centang pemeriksaan lab dari checkboxlist
 */
function pilihPemeriksaanIni(obj){
    var paketpelayanan_id = $(obj).val();
    var namatindakan = $(obj).parent().find('input[name$="[namatindakan]"]').val();
    var daftartindakan_id = $(obj).parent().find('input[name$="[daftartindakan_id]"]').val();
    var tipepaket_id = $(obj).parent().find('input[name$="[tipepaket_id]"]').val();
    var ruangan_id = $(obj).parent().find('input[name$="[ruangan_id]"]').val();
    var tarifpaketpel = $(obj).parent().find('input[name$="[tarifpaketpel]"]').val();
    var rowtindakan = [];
    rowtindakan = '<?php echo CJSON::encode($this->renderPartial($this->path_view.'_rowTindakanPemeriksaanMcu',array('i'=>0,'modPermintaanMcu'=>$modPermintaanMcu),true));?>';
    if($(obj).is(':checked')){
        $("#form-tindakanpemeriksaan").find('tbody').append(rowtindakan);
        $("#form-tindakanpemeriksaan").find('input[name$="[ii][tindakanpelayanan_id]"]').val("");
        $("#form-tindakanpemeriksaan").find('input[name$="[ii][paketpelayanan_id]"]').val(paketpelayanan_id);
        $("#form-tindakanpemeriksaan").find('input[name$="[ii][daftartindakan_id]"]').val(daftartindakan_id);
        $("#form-tindakanpemeriksaan").find('input[name$="[ii][tipepaket_id]"]').val(tipepaket_id);$("#form-tindakanpemeriksaan").find('span[name$="[ii][namatindakan]"]').html(namatindakan);
        $("#form-tindakanpemeriksaan").find('input[name$="[ii][satuantindakan]"]').val("<?php echo Params::SATUAN_TINDAKAN_LABORATORIUM; ?>");
        $("#form-tindakanpemeriksaan").find('input[name$="[ii][ruangantujuan_id]"]').val(ruangan_id);
        $("#form-tindakanpemeriksaan").find('input[name$="[ii][qty_tindakan]"]').val(1);
        $("#form-tindakanpemeriksaan").find('input[name$="[ii][tarif_satuan]"]').val(tarifpaketpel);
        $("#form-tindakanpemeriksaan").find('input[name$="[ii][tarif_tindakan]"]').val(formatInteger(tarifpaketpel));
        $("#form-tindakanpemeriksaan").find('a').tooltip({"placement":"<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
		$("#form-tindakanpemeriksaan input[name*='[i]']").each(function(){ //element <input>
            var old_name = $(this).attr("name").replace(/]/g,"");
            var old_name_arr = old_name.split("[");
            if(old_name_arr.length == 4){
                $(this).attr("id",old_name_arr[0]+"_"+ruangan_id+"_"+old_name_arr[2]+"_"+old_name_arr[3]);
                $(this).attr("name",old_name_arr[0]+"["+ruangan_id+"]["+old_name_arr[2]+"]["+old_name_arr[3]+"]");
            }
        });
    }else{
        var delete_row = $("#form-tindakanpemeriksaan").find('input[name$="[paketpelayanan_id]"][value="'+paketpelayanan_id+'"]').parents('tr');
        delete_row.detach();
    }
    renameInputRow($("#form-tindakanpemeriksaan"));
}

/**
 * Centang pemeriksaan tindakan diluar paket checkboxlist
 */
function pilihPemeriksaanDiluarPaket(obj){
    var daftartindakan_id = $(obj).val();
    var daftartindakan_nama = $(obj).parent().find('input[name$="[daftartindakan_nama]"]').val();
    var daftartindakan_id = $(obj).parent().find('input[name$="[daftartindakan_id]"]').val();
    var tipepaket_id = $(obj).parent().find('input[name$="[tipepaket_id]"]').val();
    var ruangan_id = $(obj).parent().find('input[name$="[ruangan_id]"]').val();
    var tarifpaketpel = $(obj).parent().find('input[name$="[harga_tariftindakan]"]').val();
    var rowtindakan = [];
    rowtindakan = '<?php echo CJSON::encode($this->renderPartial($this->path_view.'_rowTindakanPemeriksaanMcuDiluarPaket',array('i'=>0,'modTindakan'=>$modTindakan),true));?>';
    if($(obj).is(':checked')){
        $("#form-tindakanpemeriksaan-diluar-paket").find('tbody').append(rowtindakan);
        $("#form-tindakanpemeriksaan-diluar-paket").find('input[name$="[ii][tindakanpelayanan_id]"]').val("");
        $("#form-tindakanpemeriksaan-diluar-paket").find('input[name$="[ii][daftartindakan_id]"]').val(daftartindakan_id);
        $("#form-tindakanpemeriksaan-diluar-paket").find('input[name$="[ii][tipepaket_id]"]').val(tipepaket_id);$("#form-tindakanpemeriksaan-diluar-paket").find('span[name$="[ii][namatindakan]"]').html(daftartindakan_nama);
        $("#form-tindakanpemeriksaan-diluar-paket").find('input[name$="[ii][ruangan_id]"]').val(ruangan_id);
        $("#form-tindakanpemeriksaan-diluar-paket").find('input[name$="[ii][satuantindakan]"]').val("<?php echo Params::SATUAN_TINDAKAN_LABORATORIUM; ?>");
        $("#form-tindakanpemeriksaan-diluar-paket").find('input[name$="[ii][ruangantujuan_id]"]').val(ruangan_id);
        $("#form-tindakanpemeriksaan-diluar-paket").find('input[name$="[ii][qty_tindakan]"]').val(1);
        $("#form-tindakanpemeriksaan-diluar-paket").find('input[name$="[ii][tarif_satuan]"]').val(tarifpaketpel);
        $("#form-tindakanpemeriksaan-diluar-paket").find('input[name$="[ii][tarif_tindakan]"]').val(formatInteger(tarifpaketpel));
        $("#form-tindakanpemeriksaan-diluar-paket").find('a').tooltip({"placement":"<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
    }else{
        var delete_row = $("#form-tindakanpemeriksaan-diluar-paket").find('input[name$="[daftartindakan_id]"][value="'+daftartindakan_id+'"]').parents('tr');
        delete_row.detach();
    }
    renameInputRowTindakan($("#form-tindakanpemeriksaan-diluar-paket"),ruangan_id);
}

/**
 * update (refresh) checklist tindakan mcu
 * harus include /js/jquery.tiler.js
 * @param {obj} form_checklist
 */
function updateChecklistTindakanMcu(){
    $('#content-pemeriksaan-mcu .checklists').addClass("animation-loading");
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('SetChecklistTindakanMcu'); ?>',
        data: {data:$("#form-caripemeriksaan :input").serialize()},
        dataType: "json",
        success:function(data){
            $('#content-pemeriksaan-mcu-paket .checklists').html(data.content);
            $('.checkboxlist-tile').tile({widths : [ 256 ]});
            $('#content-pemeriksaan-mcu-paket .checklists').removeClass("animation-loading");
            setCheckedPemeriksaan($("#form-tindakanpemeriksaan"));
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}

/**
 * update (refresh) checklist tindakan mcu diluar paket
 * harus include /js/jquery.tiler.js
 * @param {obj} form_checklist
 */
function updateChecklistTindakanMcuDiluarPaket(){
    $('#content-pemeriksaan-mcu-diluar-paket .checklists-mcu-diluar-paket').addClass("animation-loading");
	var ruangan_id = $('#<?php echo CHtml::activeId($modPendaftaran,'ruangan_id'); ?>').val();
	var kelaspelayanan_id = $('#<?php echo CHtml::activeId($modPendaftaran,'kelaspelayanan_id'); ?>').val();
	var tipepaket_id = '<?php echo Params::TIPEPAKET_ID_NONPAKET; ?>';
	var penjamin_id = $('#<?php echo CHtml::activeId($modPendaftaran,'penjamin_id'); ?>').val();
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('SetChecklistTindakanMcuDiluarPaket'); ?>',
        data: {data:$("#form-caripemeriksaan-diluar-paket :input").serialize(),ruangan_id:ruangan_id,kelaspelayanan_id:kelaspelayanan_id,penjamin_id:penjamin_id,tipepaket_id:tipepaket_id},
        dataType: "json",
        success:function(data){
            $('#content-pemeriksaan-mcu-diluar-paket .checklists-mcu-diluar-paket').html(data.content);
            $('.checkboxlist-tile-diluar-paket').tile({widths : [ 256 ]});
            $('#content-pemeriksaan-mcu-diluar-paket .checklists-mcu-diluar-paket').removeClass("animation-loading");
            setCheckedPemeriksaanDiluarPaket($("#form-tindakanpemeriksaan-diluar-paket"));
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}
/**
 * set checked pemeriksaan yang sudah ada di daftar
 */
function setCheckedPemeriksaan(obj_table){
    $("div.checklists").find('input[name$="[is_pilih]"]').removeAttr('checked');
    $(obj_table).find('input[name$="[paketpelayanan_id]"]').each(function(){
        var paketpelayanan_id = $(this).val();
        $("div.checklists").find('input[name$="[is_pilih]"][value='+paketpelayanan_id+']').attr('checked',true);
    });
    
}
/**
 * set checked pemeriksaan yang sudah ada di daftar
 */
function setCheckedPemeriksaanDiluarPaket(obj_table){
    $("div.checklists-mcu-diluar-paket").find('input[name$="[is_pilih]"]').removeAttr('checked');
    $(obj_table).find('input[name$="[daftartindakan_id]"]').each(function(){
        var daftartindakan_id = $(this).val();
        $("div.checklists-mcu-diluar-paket").find('input[name$="[is_pilih]"][value='+daftartindakan_id+']').attr('checked',true);
    });
    
}
/**
 * Set checklist tindakan mcu
 */
function setChecklistTindakanMcu(){
    var penjamin_id = $("#penjamin_id").val();
    var ruangan_id = $("#<?php echo CHtml::activeId($modPasienMasukPenunjang,'ruangan_id') ?>").val();
    var kelaspelayanan_id = $("#<?php echo CHtml::activeId($modPasienMasukPenunjang,'kelaspelayanan_id') ?>").val();
    if(penjamin_id == "" && kelaspelayanan_id==""){
        myAlert("Silakan pilih data rujukan!");
        setChecklistPemeriksaanLabReset();
    }else{
        $("#form-caripemeriksaan").find("input[name$='[ruangan_id]']").val(ruangan_id);
        $("#form-caripemeriksaan").find("input[name$='[penjamin_id]']").val(penjamin_id);
        $("#form-caripemeriksaan").find("input[name$='[kelaspelayanan_id]']").val(kelaspelayanan_id);
        updateChecklistTindakanMcu();
    }
}
function setChecklistTindakanMcuDiluarPaket(){
    var penjamin_id = $("#penjamin_id").val();
    var ruangan_id = $("#<?php echo CHtml::activeId($modPasienMasukPenunjang,'ruangan_id') ?>").val();
    var kelaspelayanan_id = $("#<?php echo CHtml::activeId($modPasienMasukPenunjang,'kelaspelayanan_id') ?>").val();
    if(penjamin_id == "" && kelaspelayanan_id==""){
        myAlert("Silakan pilih data rujukan!");
        setChecklistPemeriksaanLabReset();
    }else{
        $("#form-caripemeriksaan-diluar-paket").find("input[name$='[ruangan_id]']").val(ruangan_id);
        $("#form-caripemeriksaan-diluar-paket").find("input[name$='[penjamin_id]']").val(penjamin_id);
        $("#form-caripemeriksaan-diluar-paket").find("input[name$='[kelaspelayanan_id]']").val(kelaspelayanan_id);
        updateChecklistTindakanMcuDiluarPaket();
    }
}
/**
 * reset pencarian & checklist tindakan mcu
 */
function setChecklistTindakanMcuReset(){
    $("#form-caripemeriksaan").find("input:not(:disabled):not([readonly])").each(function(){
        $(this).val("");
    });
    updateChecklistTindakanMcu();
}
/**
 * reset pencarian & checklist tindakan mcu diluar paket
 */
function setChecklistTindakanMcuDiluarPaketReset(){
    $("#form-caripemeriksaan-diluar-paket").find("input:not(:disabled):not([readonly])").each(function(){
        $(this).val("");
    });
    updateChecklistTindakanMcuDiluarPaket();
}

/**
 * rename input row yang terakhir di tambahkan
 * @param {type} obj_table
 */
function renameInputRow(obj_table,ruangan_id){
    var row = 0;
    $(obj_table).find("tbody > tr").each(function(){
        $(this).find("#no_urut").val(row+1);
        $(this).find('span').each(function(){ //element <span>
            var old_name = $(this).attr("name").replace(/]/g,"");
            var old_name_arr = old_name.split("[");
            if(old_name_arr.length == 3){
                $(this).attr("name","["+row+"]["+old_name_arr[2]+"]");
            }
        });
        $(this).find('input,select,textarea').each(function(){ //element <input>
            var old_name = $(this).attr("name").replace(/]/g,"");
            var old_name_arr = old_name.split("[");
            if(old_name_arr.length == 4){
                $(this).attr("id",old_name_arr[0]+"_"+old_name_arr[1]+"_"+row+"_"+old_name_arr[3]);
                $(this).attr("name",old_name_arr[0]+"["+old_name_arr[1]+"]["+row+"]["+old_name_arr[3]+"]");
            }
        });
        row++;
    });    
}

function renameInputRowTindakan(obj_table,ruangan_id){
    var row = 0;
    $(obj_table).find("tbody > tr").each(function(){
        $(this).find("#no_urut").val(row+1);
        $(this).find('span').each(function(){ //element <span>
            var old_name = $(this).attr("name").replace(/]/g,"");
            var old_name_arr = old_name.split("[");
            if(old_name_arr.length == 3){
                $(this).attr("name","["+ruangan_id+"]["+row+"]["+old_name_arr[2]+"]");
            }
        });
        $(this).find('input,select,textarea').each(function(){ //element <input>
            var old_name = $(this).attr("name").replace(/]/g,"");
            var old_name_arr = old_name.split("[");
            if(old_name_arr.length == 4){
                $(this).attr("id",old_name_arr[0]+"_"+ruangan_id+"_"+row+"_"+old_name_arr[3]);
                $(this).attr("name",old_name_arr[0]+"["+ruangan_id+"]["+row+"]["+old_name_arr[3]+"]");
            }
        });
        row++;
    });    
}
/**
 * 
 * @param {int} tipepaket_id
*/
function pilihPemeriksaanSemua(obj){
	if($(obj).is(':checked')){
		$(obj).parents('.boxtindakan').find("input[name*='is_pilih']").each(function(){
			$(this).attr('checked',true);
			pilihPemeriksaanIni(this);
		});
    }else{
		$(obj).parents('.boxtindakan').find("input[name*='is_pilih']").each(function(){
			$(this).attr('checked',false);
			pilihPemeriksaanIni(this);
		});
    }
}

function hitungTotal(obj)
{   
    unformatNumberSemua();
    var qty = $(obj).val();
    var harga = parseFloat($(obj).parents('tr').find('input[name$="[tarif_satuan]"]').val());
    var subTotal=0;
    
    subTotal = parseFloat(harga*qty);
    if ($.isNumeric(subTotal)){
        $(obj).parents('tr').find('input[name$="[tarif_tindakan]"]').val(subTotal);
    }

    formatNumberSemua();
}

function print(caraPrint)
{
	var idKonsul = '<?php echo isset($_GET['idKonsulPoli'])?$_GET['idKonsulPoli']:null; ?>';
    window.open("<?php echo $this->createUrl('print'); ?>&id="+<?php echo $modPendaftaran->pendaftaran_id; ?>+"&idKonsulPoli="+idKonsul+"&caraPrint="+caraPrint,"",'location=_new, width=460px');
}
function printRiwayat(caraPrint)
{
	window.open("<?php echo $this->createUrl('printRiwayat'); ?>&id="+<?php echo $modPendaftaran->pendaftaran_id; ?>+"&caraPrint="+caraPrint,"",'location=_new, width=460px');
}
function printPermintaan(idKonsulPoli)
{
	var caraPrint = 'PRINT';
    window.open("<?php echo $this->createUrl('print'); ?>&id="+<?php echo $modPendaftaran->pendaftaran_id; ?>+"&idKonsulPoli="+idKonsulPoli+"&caraPrint="+caraPrint,"",'location=_new, width=460px');
}

/**
* javascript yang di running setelah halaman ready / load sempurna
* posisi script ini harus tetap dibawah
*/
$(document).ready(function(){	
	var ruanganMCU = '<?php echo $modKonsul->ruangan_id; ?>';
	updateChecklistTindakanMcu();
	updateChecklistTindakanMcuDiluarPaket();
	setKarcis();
    // Notifikasi Pasien
    <?php 
        if(isset($_GET['smspasien'])){
            if($_GET['smspasien']==0){
    ?>
        var params = [];
        params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Yii::app()->session['modul_id']; ?>, judulnotifikasi:'GAGAL KIRIM SMS PASIEN', isinotifikasi:'Pasien <?php echo $modPasien->nama_pasien; ?> tidak memiliki nomor mobile'}; // 16 
        insert_notifikasi(params);
    <?php            
            }
        }
    ?>

    <?php 
        if(isset($modKirimKeUnitLain->pasienkirimkeunitlain_id)){
    ?>
        var params = [];
        params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Params::MODUL_ID_RJ ?>, judulnotifikasi:'Pasien Rujukan', isinotifikasi:'<?php echo $modPasien->nama_pasien ?> dengan <?php echo $modPasien->no_rekam_medik ?> telah dirujuk pada <?php echo $modKirimKeUnitLain->tgl_kirimpasien ?> dari <?php echo $modKirimKeUnitLain->ruangan->ruangan_nama ?>'}; // 16 
        insert_notifikasi(params);
    <?php
        }
    ?>
});
</script>