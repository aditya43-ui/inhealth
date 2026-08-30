<script type="text/javascript">
function tambahObatNonRacik(obj)
{
    var obatalkes_id = $(obj).parents('fieldset').find('#obatalkes_id').val();
    var obatalkes_kode = $('#obatalkes_kode').val();
    var jumlah = $(obj).parents('fieldset').find('#qtyNonRacik').val();
    var rke = $("#table-obatalkespasien tbody tr:last-child td").find('input[name*="[rke]"]').val();
    var namaObatNonRacik = $('#namaObatNonRacik').val();
    if(rke==undefined){rke=1;}else{rke++;}
    if(obatalkes_id != '')
    {
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('setFormObatAlkesPasien'); ?>',
            data: {obatalkes_id:obatalkes_id,jumlah:jumlah},//
            dataType: "json",
            success:function(data){
                if(data.pesan !== ""){
                    myAlert(data.pesan);
                    var params = [];
                    params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Params::MODUL_ID_GUDANGFARMASI; ?>, judulnotifikasi:'Stok Obat Alkes Habis', isinotifikasi:obatalkes_kode+' '+namaObatNonRacik+'  di <?php echo Yii::app()->user->getState("ruangan_nama"); ?> telah habis'}; // 16 
                    insert_notifikasi(params);
                    return false;
                }
                var tambahkandetail = true;
                var obatalkesyangsama = $("#table-obatalkespasien input[name$='[obatalkes_id]'][value='"+obatalkes_id+"']");
                if(obatalkesyangsama.val()){ //jika ada obat sudah ada di table
                    myConfirm("Apakah Anda akan input ulang obat ini?","Perhatian!",
                    function(r){
                        if(r){
                            $("#table-obatalkespasien input[name$='[obatalkes_id]'][value='"+obatalkes_id+"']").each(function(){
                                $(this).parents('tr').detach();
                            });
                        }else{
                            tambahkandetail = false;
                        }
                    }); 
                }
                if(tambahkandetail){
                    $('#table-obatalkespasien > tbody').append(data.form);
                    $("#table-obatalkespasien").find('input[name*="[ii]"][class*="integer"]').maskMoney(
                        {"symbol":"","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":0}
                    );
                    addDataKeGridObat(obj,'nonracik',rke);
                    renameInputRowObatAlkes($("#table-obatalkespasien"));                    
                    hitungTotal();
                }
                $(obj).parents('fieldset').find('#obatalkes_id').val('');
                $('#namaObatNonRacik').val('');
                $('#qtyNonRacik').val(1);
                formatNumberSemua();
                renameInputRowObatAlkes($("#table-obatalkespasien")); 
            },
            error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        });
    }else{
        myAlert("Silakan pilih obat / alkes terlebih dahulu!");
    }
    $("#namaObatNonRacik").focus();   
}

function tambahObatRacik(obj)
{
    var obatalkes_id = $(obj).parents('fieldset').find('#obatalkes_id').val();
    var obatalkes_kode = $('#obatalkes_kode').val();
    var jumlah = $(obj).parents('fieldset').find('#qtyRacik').val();
    var rke = $(obj).parents('fieldset').find('#racikanKe').val();
    var rkelast = $("#table-obatalkespasien tbody tr:last-child td").find('input[name*="[rke]"]').val();
    var namaObatRacik = $('#namaObatRacik').val();

    var indexrke = 0;
    var jmlrke = 0;
    var marginrke = 0;
    var statusmargin = 0;
    
    if(obatalkes_id != '')
    {
        
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('setFormObatAlkesPasien'); ?>',
            data: {obatalkes_id:obatalkes_id,jumlah:jumlah},//
            dataType: "json",
            success:function(data){
                if(data.pesan !== ""){
                    myAlert(data.pesan);
                    var params = [];
                    params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Params::MODUL_ID_GUDANGFARMASI; ?>, judulnotifikasi:'Stok Obat Alkes Habis', isinotifikasi:obatalkes_kode+' '+namaObatRacik+'  di <?php echo Yii::app()->user->getState("ruangan_nama"); ?> telah habis'}; // 16 
                    insert_notifikasi(params);
                    return false;
                }
                var tambahkandetail = true;
                var obatalkesyangsama = $("#table-obatalkespasien input[name$='[obatalkes_id]'][value='"+obatalkes_id+"']");
                if(obatalkesyangsama.val()){ //jika ada obat sudah ada di table
                    myConfirm("Apakah Anda akan input ulang obat ini?","Perhatian!",
                    function(r){
                        if(r){
                            $("#table-obatalkespasien input[name$='[obatalkes_id]'][value='"+obatalkes_id+"']").each(function(){
                                $(this).parents('tr').detach();
                            });
                        }else{
                            tambahkandetail = false;
                        }
                    });
                }
                $('#table-obatalkespasien > tbody > tr').each(function(){
                    if($(this).find('input[name*="[rke]"]').val()==rke){
                        if (marginrke==0) {
                            if(statusmargin==0){
                                marginrke=jmlrke;
                                statusmargin = 1;
                            }
                        };
                        indexrke++;
                    }
                    jmlrke++;
                });

                if(tambahkandetail){
                    if (indexrke==0) {
                            $('#table-obatalkespasien > tbody').append(data.form);
                    }else{
                        $('#table-obatalkespasien > tbody > tr:nth-child('+(indexrke+marginrke)+')').after(data.form);
                        $("#table-obatalkespasien input[name$='[obatalkes_id]'][value='"+obatalkes_id+"']").parents('tr').find("#isi-r").hide();
                    }
                    $("#table-obatalkespasien").find('input[name*="[ii]"][class*="integer"]').maskMoney(
                        {"symbol":"","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":0}
                    );
                    addDataKeGridObat(obj,'racik',rke);
                    renameInputRowObatAlkes($("#table-obatalkespasien"));                    
                    hitungTotal();
                }
                $(obj).parents('fieldset').find('#obatalkes_id').val('');
                $('#namaObatRacik').val('');
                $('#qtyNonRacik').val(1);
            },
            error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        });
    }else{
        myAlert("Silakan pilih obat / alkes terlebih dahulu!");
    }
    $("#namaObatRacik").focus();   
}

function addDataKeGridObat(obj,tipe,rke){
    if(tipe=='racik'){
        var obatalkes_id = $(obj).parents('fieldset').find('#obatalkes_id').val();
        var signa = $(obj).parents('fieldset').find('#signa_racik').val();
        var permintaan = $(obj).parents('fieldset').find('#permintaan').val();
        var kemasan = $(obj).parents('fieldset').find('#jmlKemasanObat').val();
        var kekuatan = $(obj).parents('fieldset').find('#kekuatanObat').val();
        input_signa = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="'+obatalkes_id+'"]').parents('tr').find('input[name*="[ii][signa_oa]"]');
        input_signa.val(signa);
        input_permintaan = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="'+obatalkes_id+'"]').parents('tr').find('input[name*="[ii][permintaan_oa]"]');
        input_permintaan.val(permintaan);
        input_kemasan = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="'+obatalkes_id+'"]').parents('tr').find('input[name*="[ii][jmlkemasan_oa]"]');
        input_kemasan.val(kemasan);
        input_kekuatan = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="'+obatalkes_id+'"]').parents('tr').find('input[name*="[ii][kekuatan_oa]"]');
        input_kekuatan.val(kekuatan);

        input_rke = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="'+obatalkes_id+'"]').parents('tr').find('input[name*="[ii][rke]"]');
        input_rke.val(rke);
    }else{
        var obatalkes_id = $(obj).parents('fieldset').find('#obatalkes_id').val();
        var signa = $(obj).parents('fieldset').find('#signa').val();
        input_signa = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="'+obatalkes_id+'"]').parents('tr').find('input[name*="[ii][signa_oa]"]');
        input_signa.val(signa);
        
        input_rke = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="'+obatalkes_id+'"]').parents('tr').find('input[name*="[ii][rke]"]');
        input_rke.val(rke);

    }
}
/**
* untuk print penjualan dokter
 */
function print(caraPrint)
{
    var penjualanresep_id = '<?php echo isset($modPenjualan->penjualanresep_id) ? $modPenjualan->penjualanresep_id : null ?>';
    window.open('<?php echo $this->createUrl('print'); ?>&penjualanresep_id='+penjualanresep_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
}

function cekObat(){
    if(requiredCheck($("form"))){
        var jmlObat = $('#table-obatalkespasien tbody tr').length;
        
        if(jmlObat <= 0){
                myAlert('Silakan isikan obat alkes rencana kebutuhan terlebih dahulu!');
            return false;
        }else{
            $('#penjualansosial-form').submit();
        }
        
        $(".animation-loading").removeClass("animation-loading");
        $("form").find('.float').each(function(){
            $(this).val(formatFloat($(this).val()));
        });
        $("form").find('.integer').each(function(){
            $(this).val(formatInteger($(this).val()));
        });
    }
    return false;
}

/**
 * refresh dialog kunjungan
 * @returns {undefined}
 */
function refreshDialogInfoDokter(){
    $.fn.yiiGridView.update('datakunjungan-grid', {
        data: {
        }
    });
}

/**
 * untuk set value jenis kelamin
 * @returns {undefined}
 */
function setJenisKelaminPasien(jeniskelamin)
{
    $('input[name="FAPasienM[jeniskelamin]"]').each(function(){
            if(this.value == jeniskelamin)
                $(this).attr('checked',true);
        }
    );
}

/** control accordion data pasien */
$('#form-pasien > div > .accordion-heading').click(function(){
    var is_pemohon = $("#<?php echo CHtml::activeId($modPenjualan, "is_pemohon"); ?>");
    if(is_pemohon.val() > 0){ //hide
        is_pemohon.val(0);
    }else{//show
        is_pemohon.val(1);
        $("input, select, textarea").attr("disabled",false);
    }
});

function hitungSubTotal(obj){
    unformatNumberSemua();
    harga = parseInt($(obj).parents('tr').find('input[name$="[hargasatuan_oa]"]').val());
    qty = parseInt($(obj).parents('tr').find('input[name$="[qty_oa]"]').val());
    diskon = parseInt($(obj).parents('tr').find('input[name$="[discount]"]').val());
    subsidirs = parseInt($(obj).parents('tr').find('input[name$="[subsidirs]"]').val());
    
    totaliurbiaya = ((harga*qty) - ((harga*qty) * (diskon/100)));
    iurbiaya = $(obj).parents('tr').find('input[name$="[iurbiaya]"]');
        
    subtotal = $(obj).parents('tr').find('input[name$="[subtotal]"]');
    totalsubtotal = ((harga*qty) - ((harga*qty) * (diskon/100)));
    
    if(totaliurbiaya <=0 ){
        totaliurbiaya = 0;
    }
    
    if(totalsubtotal <= 0){
        totalsubtotal = 0;
    }
    
    subtotal.val(totalsubtotal);
    iurbiaya.val(totaliurbiaya);
    
    hitungTotal();
    formatNumberSemua();
}

function hitungIurBiaya(obj){
    unformatNumberSemua();
    harga = parseInt($(obj).parents('tr').find('input[name$="[hargasatuan_oa]"]').val());
    qty = parseInt($(obj).parents('tr').find('input[name$="[qty_oa]"]').val());
    subtotal = parseInt($(obj).parents('tr').find('input[name$="[subtotal]"]').val());
    subsidirs = parseInt($(obj).parents('tr').find('input[name$="[subsidirs]"]').val());
    diskon = parseInt($(obj).parents('tr').find('input[name$="[discount]"]').val());
    
    totalsubtotal = ((harga*qty) - ((harga*qty) * (diskon/100)));
    if(subsidirs > 0 && subsidirs <= totalsubtotal){
        totaliurbiaya = totalsubtotal - subsidirs;
    }
    iurbiaya = $(obj).parents('tr').find('input[name$="[iurbiaya]"]');
    if(totaliurbiaya <=0 ){
        totaliurbiaya = 0;
    }
    iurbiaya.val(totaliurbiaya);
    
    hitungTotal();
    formatNumberSemua();
}

function hitungTotal(){
    unformatNumberSemua();
    obj_totalharganetto =  $('#<?php echo CHtml::activeId($modPenjualan,"totharganetto") ?>');
    obj_totalhargajual =  $('#<?php echo CHtml::activeId($modPenjualan,"totalhargajual") ?>');
    obj_totalsubsidirs =  $('#<?php echo CHtml::activeId($modPenjualan,"subsidirs") ?>');
    totalharganetto = 0;
    totalhargajual = 0;
    totalsubsidirs = 0;
    $('#table-obatalkespasien > tbody > tr').each(function(){
        totalharganetto += parseFloat( $(this).find('input[name*="[harganetto_oa]"]').val() * $(this).find('input[name*="[qty_oa]"]').val() );
        totalhargajual += parseFloat( $(this).find('input[name*="[hargasatuan_oa]"]').val() * $(this).find('input[name*="[qty_oa]"]').val() );
        totalsubsidirs += parseFloat( $(this).find('input[name*="[subsidirs]"]').val());
    });
    
    
    obj_totalharganetto.val(totalharganetto);
    obj_totalhargajual.val(totalhargajual);
    obj_totalsubsidirs.val(totalsubsidirs);
    
    formatNumberSemua();
}

/**
 * function ini harus tetap berada di bawah
 */
$(document).ready(function(){    
    var permohonanoa_id = '<?php echo isset($modPermohonanOa->permohonanoa_id) ? $modPermohonanOa->permohonanoa_id : null; ?>';
    var penjualanresep_id = '<?php echo isset($modPenjualan->penjualanresep_id) ? $modPenjualan->penjualanresep_id : null; ?>';
    if(penjualanresep_id != ""){
        $("#table-obatalkespasien :input").attr("readonly",true);
        $("#table-obatalkespasien .add-on").remove();
        $("#table-obatalkespasien .icon-remove").remove();
        
        $("#penjualansosial-form :input").attr("readonly",true);
        $("#penjualansosial-form .dtPicker3").attr("readonly",true);
        $("#penjualansosial-form .add-on").remove();
        
        $("input, select, textarea").attr("disabled",true);        
    }
    renameInputRowObatAlkes($("#table-obatalkespasien")); 
    hitungTotal();
});
</script>