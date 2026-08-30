<script type="text/javascript">
/**
 * set form kunjungan
 * @param {type} pasien_id
 * @returns {undefined}
 */
function setKunjungan(pendaftaran_id){
    $("#form-datakunjungan > div").addClass("animation-loading");
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('GetDataKunjungan'); ?>',
        data: {pendaftaran_id:pendaftaran_id},
        dataType: "json",
        success:function(data){
            if(data.pesan != ""){
                myAlert(data.pesan);
                setKunjunganReset();
            }else{
                $("#pendaftaran_id").val(data.pendaftaran_id);
                $("#pasien_id").val(data.pasien_id);
                $("#jeniskasuspenyakit_id").val(data.jeniskasuspenyakit_id);
                $("#carabayar_id").val(data.carabayar_id);
                $("#penjamin_id").val(data.penjamin_id);
                $("#penanggungjawab_id").val(data.penanggungjawab_id);
                $("#instalasi_id").val(data.instalasi_id);
                $("#ruangan_id").val(data.ruangan_id);
                $("#kelaspelayanan_id").val(data.kelaspelayanan_id);
                $("#no_pendaftaran").val(data.no_pendaftaran);
                $("#no_pendaftaran").val(data.no_pendaftaran);
                $("#tgl_pendaftaran").val(data.tgl_pendaftaran);
                $("#instalasi_nama").val(data.instalasi_nama);
                $("#ruangan_nama").val(data.ruangan_nama);
                $("#jeniskasuspenyakit_nama").val(data.jeniskasuspenyakit_nama);
                $("#carabayar_nama").val(data.carabayar_nama);
                $("#penjamin_nama").val(data.penjamin_nama);
                $("#no_rekam_medik").val(data.no_rekam_medik);
                $("#namadepan").val(data.namadepan);
                $("#nama_pasien").val(data.nama_pasien);
                $("#nama_bin").val(data.nama_bin);
                $("#tanggal_lahir").val(data.tanggal_lahir);
                $("#umur").val(data.umur);
                $("#jeniskelamin").val(data.jeniskelamin);
                $("#nama_pj").val(data.nama_pj);
                $("#pengantar").val(data.pengantar);
                $("#kelaspelayanan_nama").val(data.kelaspelayanan_nama);
                $("#alamat_pasien").val(data.alamat_pasien);
                if(data.photopasien === null || data.photopasien === ""){ //set photo
                    $('#photo-preview').attr('src','<?php echo Params::urlPhotoPasienDirectory()."no_photo.jpeg"?>');
                }else{
                    $('#photo-preview').attr('src','<?php echo Params::urlPasienTumbsDirectory()."kecil_"?>'+data.photopasien);
                }
                
                setRiwayatObatAlkesPasien();

                $("#form-datakunjungan > legend > .judul").html('Data Kunjungan '+data.no_pendaftaran);
                $("#form-datakunjungan > legend > .tombol").attr('style','display:true;');
                $("#form-datakunjungan > .box").addClass("well").removeClass("box");
            }
            $("#form-datakunjungan > div").removeClass("animation-loading");
            $("#no_pendaftaran").focus();
        },
        error: function (jqXHR, textStatus, errorThrown) { 
            myAlert("Data kunjungan tidak ditemukan!"); 
            console.log(errorThrown);
            setKunjunganReset();
            $("#form-datakunjungan > div").removeClass("animation-loading");
            $("#no_pendaftaran").focus();
        }
    });

}

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
function tambahObatAlkesPasien(obj)
{
    var obatalkes_id = $(obj).parents('.fieldset').find('#obatalkes_id').val();
    var obatalkes_kode = $(obj).parents('.fieldset').find('#obatalkes_kode').val();
    var obatalkes_nama = $(obj).parents('.fieldset').find('#obatalkes_nama').val();
    var jumlah = $(obj).parents('.fieldset').find('#qty_input').val();
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
                    params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Params::MODUL_ID_GUDANGFARMASI; ?>, judulnotifikasi:'Stok Obat Alkes Habis', isinotifikasi:obatalkes_kode+' '+obatalkes_nama+'  di <?php echo Yii::app()->user->getState("ruangan_nama"); ?> telah habis'}; // 16 
                    insert_notifikasi(params);
                    return false;
                }
                var tambahkandetail = true;
                var obatalkesyangsama = $("#table-obatalkespasien input[name$='[obatalkes_id]'][value='"+obatalkes_id+"']");
                if(obatalkesyangsama.val()){ //jika ada obat sudah ada di table
                    myConfirm("Apakah Anda akan input ulang obat ini?","Perhatian!",function(r) {
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
                    renameInputRowObatAlkes($("#table-obatalkespasien"));  
                }
                $(obj).parents('.fieldset').find('#obatalkes_id').val('');
                $('#obatalkes_nama').val('');
                $('#qty_input').val(1);
                formatNumberSemua();
                renameInputRowObatAlkes($("#table-obatalkespasien")); 
            },
            error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        });
    }else{
        myAlert("Silakan pilih obat / alkes terlebih dahulu!");
    }
    // setObatAlkesPasienReset();
    $("#obatalkes_nama").focus();   
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
 * membatalkan form input obat alkes pasien 
 */ 
function batalOaPasien(obj)
{
    myConfirm("Apakah Anda akan membatalkan obat / alat kesehatan ini?","Perhatian!",function(r) {
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
    myConfirm("Apakah Anda akan menghapus obat / alat kesehatan ini?","Perhatian!",function(r) {
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
                        setRiwayatObatAlkesPasien();
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
    // var qty_stok = parseInt($(obj).parents('tr').find('input[name$="[qty_stok]"]').val());
    var harganetto_oa = parseInt($(obj).parents('tr').find('input[name$="[harganetto_oa]"]').val());
    subtotal = qty * harganetto_oa;
    $(obj).parents('tr').find('input[name$="[iurbiaya]"]').val(formatInteger(subtotal));
    // if(qty > qty_stok){
    //     $(obj).val(qty_stok);
    //    myAlert("Jumlah tidak boleh lebih besar dari stok!");
    //}
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