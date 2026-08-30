<script type="text/javascript">
/**
 * untuk mereset form kunjungan
 * @returns {undefined} */
function setKunjunganReset(){
    $("#form-datakunjungan input,textarea").each(function(){
        $(this).val("");
    });
    $("#ruangan_id").val(<?php echo $modKunjungan->ruangan_id; ?>);
    $('#photo-preview').attr('src','<?php echo Params::urlPhotoPasienDirectory()."no_photo.jpeg"?>');
    $("#form-datakunjungan > legend > .judul").html('Data Kunjungan');
    $("#form-datakunjungan > legend > .tombol").attr('style','display:none;');
    $("#form-datakunjungan > .well").addClass("box").removeClass("well");
        
    $('#riwayat-obatalkespasien-t table > tbody').html("");
    $('#table-obatalkespasien > tbody').html(""); 
}
/**
 * menambahkan form obatalkespasien ke tabel
 * @type Arguments
 */
function tambahObatAlkesPasien()
{
    // unformatNumberSemua();
    // console.log(obj);
    var pendaftaran_id = $('#pendaftaran_id').val();
    var obatalkes_id = $('#obatalkes_id').val();//$(obj).parents('fieldset').find('#obatalkes_id').val();
    var jumlah = $('#qty_input').val();//$(obj).parents('fieldset').find('#qty_input').val();
    var instalasi_id = $('#instalasi').val();//$(obj).parents('fieldset').find('#instalasi').val();
    var ruangan_id = $('#ruangan_id2').val();//$(obj).parents('fieldset').find('#ruangan_id2').val();
    console.log(pendaftaran_id,obatalkes_id,jumlah,instalasi_id,ruangan_id);
    
    if((obatalkes_id!='') && (pendaftaran_id!='') && (jumlah > 0) && (instalasi_id !='') && (ruangan_id != '')){  
        console.log("<?php echo $this->createUrl('setFormObatAlkesPasien'); ?>");      
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('setFormObatAlkesPasien'); ?>',
            data: {obatalkes_id:obatalkes_id,jumlah:jumlah,ruangan_id:ruangan_id},//
            dataType: "json",
            success:function(data){
                if(data.pesan !== ""){
                    myAlert(data.pesan);
                    return false;
                }
                var tambahkandetail = true;
                var obatalkesyangsama = $("#table-obatalkespasien input[name$='[obatalkes_id]'][value='"+obatalkes_id+"']");
                if(obatalkesyangsama.val()){ //jika ada obat sudah ada di table
                    myConfirm("Apakah Anda akan input ulang obat ini?",
                    "Perhatian!",
                    function(r){
                        if(r){
                            $("#table-obatalkespasien input[name$='[obatalkes_id]'][value='"+obatalkes_id+"']").each(function(){
                                var row = $(this).data('obatalkes_id');
                               
                                var jumlah_semula =  $("#table-obatalkespasien input[name$='["+row+"][qty_oa]']").val();
                                var harga =  $("#table-obatalkespasien input[name$='["+row+"][hargajual_oa]']").val();
                                var jumlah_sekarang = parseInt(jumlah_semula) + parseInt(jumlah);
                                var subtotal = parseInt(jumlah_sekarang) * parseInt(harga);

                                $("#table-obatalkespasien input[name$='["+row+"][qty_oa]']").val(jumlah_sekarang);
                                $("#table-obatalkespasien input[name$='["+row+"][iurbiaya]']").val(subtotal)
                            });
                        }else{
                            tambahkandetail = false;
                        }
                    }); 
                } else {
                    if(tambahkandetail){
                        $('#table-obatalkespasien > tbody').append(data.form);
                        $("#table-obatalkespasien").find('input[name*="[ii]"][class*="integer"]').maskMoney(
                            {"symbol":"","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":0}
                        );
                        renameInputRowObatAlkes($("#table-obatalkespasien"));  
                    }
                    $(obj).parents('fieldset').find('#obatalkes_id').val('');
                    $('#obatalkes_nama').val('');
                    $('#qty_input').val(1);
                    formatNumberSemua();
                    renameInputRowObatAlkes($("#table-obatalkespasien")); 
                }
            },
            error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        });
    }else{
        if(pendaftaran_id == ''){
            myAlert("Silakan isi data kunjungan terlebih dahulu!");
        }else if(obatalkes_id == ''){
            myAlert("Silakan pilih obat alkes terlebih dahulu!");
        }else if(jumlah == 0){
            myAlert("Stok obat kosong!");
        }else if(instalasi_id == ''){
            myAlert("Silakan pilih instalasi terlebih dahulu!");
        }else if(ruangan_id == ''){
            myAlert("Silakan pilih ruangan terlebih dahulu!");
        }
    }
    setObatAlkesPasienReset();  
}
//function tambahObatAlkesPasien(){
//    unformatNumberSemua();
//    var pendaftaran_id = $('#pendaftaran_id').val();
//    var obatalkes_id = $('#obatalkes_id').val();
//    var obatalkes_nama = $('#obatalkes_nama').val();
//    var satuankecil_id = $('#satuankecil_id').val();
//    var satuankecil_nama = $('#satuankecil_nama').val();
//    var sumberdana_id = $('#sumberdana_id').val();
//    var qty = parseInt($('#qty_input').val());
//    var qty_stok = parseInt($('#qty_stok').val());
//    var hargajual = parseInt($('#hargajual').val());
//    var harganetto = parseInt($('#harganetto').val());
//
//    var rowtindakan = "";
//    rowtindakan = '<?php echo CJSON::encode($this->renderPartial($this->path_view.'_rowObatAlkesPasien',array('modObatAlkesPasien'=>$modObatAlkesPasien),true));?>';
//    if((obatalkes_id!='') && (pendaftaran_id!='') && (qty_stok > 0) && (qty <= qty_stok)){
//        $("#table-obatalkespasien").find('tbody').append(rowtindakan);
//        $("#table-obatalkespasien").find('input[name$="[ii][obatalkes_id]"]').val(obatalkes_id);
//        $("#table-obatalkespasien").find('span[name$="[ii][obatalkes_nama]"]').html(obatalkes_nama);
//        $("#table-obatalkespasien").find('span[name$="[ii][satuankecil_nama]"]').html(satuankecil_nama);
//        $("#table-obatalkespasien").find('input[name$="[ii][qty_stok]"]').val(qty_stok);
//        $("#table-obatalkespasien").find('input[name$="[ii][qty_oa]"]').val(qty);
//        $("#table-obatalkespasien").find('input[name$="[ii][hargajual_oa]"]').val(hargajual);
//        $("#table-obatalkespasien").find('input[name$="[ii][harganetto_oa]"]').val(harganetto);
//        $("#table-obatalkespasien").find('input[name$="[ii][sumberdana_id]"]').val(sumberdana_id);
//        $("#table-obatalkespasien").find('input[name$="[ii][satuankecil_id]"]').val(satuankecil_id);
//        $("#table-obatalkespasien").find('input[name$="[ii][iurbiaya]"]').val(qty*hargajual);
//        $("#table-obatalkespasien").find('input[name*="[ii]"][class*="integer"]').maskMoney(
//            {"symbol":"","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":0}
//        );
//        $('#table-obatalkespasien').find('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip({"placement":"<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
//        renameInputRowObatAlkes($("#table-obatalkespasien"));
//        formatNumberSemua();
//    }else{
//        if(pendaftaran_id == ''){
//            myAlert("Silakan isi data kunjungan terlebih dahulu!");
//        }else if(obatalkes_id == ''){
//            myAlert("Silakan pilih obat alkes terlebih dahulu!");
//        }else if(qty_stok == 0){
//            myAlert("Stok obat kosong!");
//        }else if(qty > qty_stok){
//            myAlert("Jumlah tidak boleh lebih besar dari stok tersedia "+qty_stok+".");
//        }
//    }
//    setObatAlkesPasienReset();
//}

function refreshDialogObatAlkes(){
    
    var ruangan_id2 = $("#ruangan_id2").val();
    $.fn.yiiGridView.update('obatalkes-m-grid', {
        data: {
            "BKInfostokobatalkesruanganV[ruangan_id]":ruangan_id2,
        }
    });
}

/**
 * reset form obat
 */
function setObatAlkesPasienReset(){
    $('#form-tambahobatalkes :input').val("");
    $('#qty_input').val("1");
    $('#obatalkes_nama').focus();
}
/**
* load obatalkespasien_t yang sudah tersimpan berdasarkan:
* - pendaftaran_id
*/ 
function setRiwayatObatAlkesPasien(){
    $('#riwayat-obatalkespasien-t').addClass("animation-loading");
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('setRiwayatObatAlkesPasien'); ?>',
        data: {pendaftaran_id:$("#pendaftaran_id").val()},
        dataType: "json",
        success:function(data){
            $('#riwayat-obatalkespasien-t table > tbody').html(data.rows);
            $('#riwayat-obatalkespasien-t table > tbody').find('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip({"placement":"<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
            $('#riwayat-obatalkespasien-t').removeClass("animation-loading");
            renameInputRowObatAlkes($("#riwayat-obatalkespasien-t"));
            formatNumberSemua();
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
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
                    $(this).attr('data-'+old_name_arr[2], row);
                }
            });
            $(this).find('input,select,textarea').each(function(){ //element <input>
                var old_name = $(this).attr("name").replace(/]/g,"");
                var old_name_arr = old_name.split("[");
                if(old_name_arr.length == 3){
                    $(this).attr("id",old_name_arr[0]+"_"+row+"_"+old_name_arr[2]);
                    $(this).attr("name",old_name_arr[0]+"["+row+"]["+old_name_arr[2]+"]");
                    $(this).attr('data-'+old_name_arr[2], row);
                }
            });
            row++;
        });
}
/**
 * membatalkan form input obat alkes pasien 
 */ 
function batalOaPasien(obj)
{
    myConfirm("Apakah Anda akan membatalkan obat / alat kesehatan ini?",
    "Perhatian!",
    function(r){
        if(r){
            $(obj).parents('tr').remove();
            renameInputRowObatAlkes($("#table-obatalkespasien"));
        }
    }); 
}
/**
 * menghapus obat alkes pasien yang sudah tersimpan di ObatalkespasienT
 * berdasarkan obatalkespasien_id
 */ 
function hapusOaPasien(obatalkespasien_id)
{
    myConfirm("Apakah Anda akan menghapus obat / alat kesehatan ini?",
    "Perhatian!",
    function(r){
        if(r){
            $.ajax({
                type:'POST',
                url:'<?php echo $this->createUrl('hapusObatAlkesPasien'); ?>',
                data: {obatalkespasien_id:obatalkespasien_id},
                dataType: "json",
                success:function(data){
                    if(data.sukses){
                        var delete_row = $("#riwayat-obatalkespasien-t").find('input[name$="[obatalkespasien_id]"][value="'+obatalkespasien_id+'"]').parents('tr');
                        delete_row.detach();
                        renameInputRowObatAlkes($("#riwayat-obatalkespasien-t"));
                    }
                    myAlert(data.pesan);
                },
                error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
            });
            renameInputRowObatAlkes($("#riwayat-obatalkespasien-t"));
        }
    }); 
}
/**
 * menghitung subtotal per baris
 */ 
function hitungSubTotal(obj)
{
    unformatNumberSemua();
    var subtotal = 0;
    var qty = parseInt($(obj).val());
    var qty_stok = parseInt($(obj).parents('tr').find('input[name$="[qty_stok]"]').val());
    var hargajual_oa = parseInt($(obj).parents('tr').find('input[name$="[hargajual_oa]"]').val());
    subtotal = qty * hargajual_oa;
    $(obj).parents('tr').find('input[name$="[iurbiaya]"]').val(formatInteger(subtotal));
    if(qty > qty_stok){
        $(obj).val(qty_stok);
        myAlert("Jumlah tidak boleh lebih besar dari stok!");
    }
    formatNumberSemua();
}

function refreshHalaman(){
    myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;});
}

function print(pendaftaran_id)
{
    window.open('<?php echo $this->createUrl('print'); ?>&pendaftaran_id='+pendaftaran_id,'printwin','left=100,top=100,width=480,height=640');
}

/**
 * function ini harus tetap berada di bawah
 */
$(document).ready(function(){
    var pendaftaran_id = $('#pendaftaran_id').val();
    if(pendaftaran_id != ""){
        setRiwayatObatAlkesPasien();
    }
});
</script>