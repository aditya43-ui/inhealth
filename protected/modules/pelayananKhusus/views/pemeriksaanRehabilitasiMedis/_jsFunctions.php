<script type="text/javascript">
/**
 * set form kunjungan
 * @param {type} pasien_id
 * @returns {undefined}
 */
function setKunjungan(pasienmasukpenunjang_id){
    $("#form-datakunjungan > div").addClass("animation-loading");
    var ruangan_id = $("#ruangan_id").val();
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('GetDataKunjungan'); ?>',
        data: {ruangan_id:ruangan_id, pasienmasukpenunjang_id:pasienmasukpenunjang_id},
        dataType: "json",
        success:function(data){
            $("#ruangan_id").val(ruangan_id);
            $("#pendaftaran_id").val(data.pendaftaran_id);
            $("#pasienmasukpenunjang_id").val(data.pasienmasukpenunjang_id);
            $("#pasien_id").val(data.pasien_id);
            $("#jeniskasuspenyakit_id").val(data.jeniskasuspenyakit_id);
            $("#carabayar_id").val(data.carabayar_id);
            $("#penjamin_id").val(data.penjamin_id);
            $("#penanggungjawab_id").val(data.penanggungjawab_id);
            $("#instalasiasal_id").val(data.instalasiasal_id);
            $("#ruanganasal_id").val(data.ruanganasal_id);
            $("#kelaspelayanan_id").val(data.kelaspelayanan_id);
            $("#no_masukpenunjang").val(data.no_masukpenunjang);
            $("#no_pendaftaran").val(data.no_pendaftaran);
            $("#tglmasukpenunjang").val(data.tglmasukpenunjang);
            $("#tgl_pendaftaran").val(data.tgl_pendaftaran);
            $("#instalasiasal_nama").val(data.instalasiasal_nama);
            $("#ruanganasal_nama").val(data.ruanganasal_nama);
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
            
            setTindakanPelayanan();
            
            $("#form-datakunjungan > legend > .judul").html('Data Kunjungan '+data.no_masukpenunjang);
            $("#form-datakunjungan > legend > .tombol").attr('style','display:true;');
            $("#form-datakunjungan > .box").addClass("well").removeClass("box");
            cekDisabled('form'); 
            $("#form-datakunjungan > div").removeClass("animation-loading");
            $("#no_pendaftaran").focus();
        },
        error: function (jqXHR, textStatus, errorThrown) { 
            myAlert("Data kunjungan tidak ditemukan !"); 
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
        
    $('#form-tindakanpemeriksaan table > tbody').html("");
    $('#content-pemeriksaan-lab .checklists').html("");
    $('#content-pemeriksaan-lab input').each(function(){
        $(this).val("");
    });
}


/**
 * update (refresh) checklist pemeriksaan lab
 * harus include /js/jquery.tiler.js
 * @param {obj} form_checklist
 */
function updateChecklistPemeriksaanRehab(){
    $('#content-pemeriksaan-lab .checklists').addClass("animation-loading");
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('SetChecklistPemeriksaanRehab'); ?>',
        data: {data:$("#form-caripemeriksaan :input").serialize()},
        dataType: "json",
        success:function(data){
            $('#content-pemeriksaan-lab .checklists').html(data.content);
            $('.checkboxlist-tile').tile({widths : [ 256 ]});
            $('#content-pemeriksaan-lab .checklists').removeClass("animation-loading");
            setCheckedPemeriksaan($("#form-tindakanpemeriksaan"));
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}

/**
 * Set checklist pemeriksaan lab
 */
function setChecklistPemeriksaanRehab(){
    var penjamin_id = $("#penjamin_id").val();
    var ruangan_id = $("#ruangan_id").val();
    var kelaspelayanan_id = $("#kelaspelayanan_id").val();
    if(penjamin_id == "" && kelaspelayanan_id==""){
        myAlert("Silakan pilih data kunjungan!");
    }else{
        $("#form-caripemeriksaan").find("input[name$='[ruangan_id]']").val(ruangan_id);
        $("#form-caripemeriksaan").find("input[name$='[penjamin_id]']").val(penjamin_id);
        $("#form-caripemeriksaan").find("input[name$='[kelaspelayanan_id]']").val(kelaspelayanan_id);
        updateChecklistPemeriksaanRehab();
    }
}
/**
 * reset pencarian & checklist pemeriksaan lab
 */
function setChecklistPemeriksaanRehabReset(){
    $("#form-caripemeriksaan").find("input:not(:disabled):not([readonly])").each(function(){
        $(this).val("");
    });
    updateChecklistPemeriksaanRehab();
}

/**
 * Centang pemeriksaan lab dari checkboxlist
 */
function pilihPemeriksaanIni(obj){
    var tindakanrm_id = $(obj).val();
    var jenistindakanrm_id = $(obj).parent().find('input[name$="[jenistindakanrm_id]"]').val();
    var tindakanrm_nama = $(obj).parent().find('input[name$="[tindakanrm_nama]"]').val();
    var daftartindakan_id = $(obj).parent().find('input[name$="[daftartindakan_id]"]').val();
    var jenistarif_id = $(obj).parent().find('input[name$="[jenistarif_id]"]').val();
    var harga_tariftindakan = $(obj).parent().find('input[name$="[harga_tariftindakan]"]').val();
    var rowtindakan = [];
    rowtindakan = '<?php echo CJSON::encode($this->renderPartial($this->path_view_pendaftaran.'_rowTindakanPemeriksaan',array('i'=>0,'modTindakan'=>$modTindakan),true));?>';
    if($(obj).is(':checked')){
        $("#form-tindakanpemeriksaan").find('tbody').append(rowtindakan);
        $("#form-tindakanpemeriksaan").find('input[name$="[ii][tindakanpelayanan_id]"]').val("");
        $("#form-tindakanpemeriksaan").find('input[name$="[ii][tindakanrm_id]"]').val(tindakanrm_id);
        $("#form-tindakanpemeriksaan").find('input[name$="[ii][jenistindakanrm_id]"]').val(jenistindakanrm_id);
        $("#form-tindakanpemeriksaan").find('input[name$="[ii][daftartindakan_id]"]').val(daftartindakan_id);
        $("#form-tindakanpemeriksaan").find('input[name$="[ii][jenistarif_id]"]').val(jenistarif_id);$("#form-tindakanpemeriksaan").find('span[name$="[ii][tindakanrm_nama]"]').html(tindakanrm_nama);
        $("#form-tindakanpemeriksaan").find('input[name$="[ii][satuantindakan]"]').val("<?php echo Params::SATUAN_TINDAKAN_REHAB_MEDIS; ?>");
        $("#form-tindakanpemeriksaan").find('input[name$="[ii][tarif_satuan]"]').val(harga_tariftindakan);
        $("#form-tindakanpemeriksaan").find('input[name$="[ii][tarif_tindakan]"]').val(formatInteger(harga_tariftindakan));
        $("#form-tindakanpemeriksaan").find('a').tooltip({"placement":"<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
    }else{
        var tindakanpelayanan_id =  $("#form-tindakanpemeriksaan").find('input[name$="[tindakanpelayanan_id]"][value=""]').val();
        if(tindakanpelayanan_id == ""){
            var delete_row = $("#form-tindakanpemeriksaan").find('input[name$="[tindakanrm_id]"][value="'+tindakanrm_id+'"]').parents('tr');
            delete_row.detach();
        }else{ //jika undefined = tindakanpelayanan_id terisi

            myConfirm("Apakah anda yakin akan menghapus pemeriksaan yang sudah di database?","Perhatian!",
            function(r){
                if(r){
                    hapusTindakanPelayanan(daftartindakan_id);
                }else{
                    $(obj).attr("checked",true);
                }
            }); 
        }
    }
    renameInputRow($("#form-tindakanpemeriksaan"));
}


function hapusPemeriksaanDariTabel(daftartindakan_id) {
    myConfirm("Apakah anda yakin akan menghapus pemeriksaan yang sudah di database?","Perhatian!",
    function(r){
        if(r){
            hapusTindakanPelayanan(daftartindakan_id);
        }else{
            $(obj).attr("checked",true);
        }
    }); 
}

/**
 * rename input row yang terakhir di tambahkan
 * @param {type} obj_table
 */
function renameInputRow(obj_table){
    var row = 0;
    $(obj_table).find("tbody > tr").each(function(){
        $(this).find("#no_urut").val(row+1);
        $(this).find('span[name*="[ii]"]').each(function(){ //element <span>
            var new_name = $(this).attr("name").replace("ii",(row));
            $(this).attr("name",new_name);
        });
        $(this).find('span[name$="[tindakanrm_nama]"]').each(function(){ //element <input>
            var old_name = $(this).attr("name").replace(/]/g,"");
            var old_name_arr = old_name.split("[");
            if(old_name_arr.length == 2){
                $(this).attr("name","["+row+"]["+old_name_arr[1]+"]");
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
 * set checked pemeriksaan yang sudah ada di daftar
 */
function setCheckedPemeriksaan(obj_table){
    $("div.checklists").find('input[name$="[is_pilih]"]').removeAttr('checked');
    $(obj_table).find('input[name$="[tindakanrm_id]"]').each(function(){
        var tindakanrm_id = $(this).val();
        $("div.checklists").find('input[name$="[is_pilih]"][value='+tindakanrm_id+']').attr('checked',true);
    });
    
}
/**
* load pemeriksaan yang sudah tersimpan berdasarkan:
* - pasienmasukpenunjang_id
*/ 
function setTindakanPelayanan(){
    $('#form-tindakanpemeriksaan').addClass("animation-loading");
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('SetTindakanPelayanan'); ?>',
        data: {pasienmasukpenunjang_id:$("#pasienmasukpenunjang_id").val()},
        dataType: "json",
        success:function(data){
            $('#form-tindakanpemeriksaan table > tbody').html(data.rows);
            $('#form-tindakanpemeriksaan').removeClass("animation-loading");
            renameInputRow($("#form-tindakanpemeriksaan"));
            setChecklistPemeriksaanRehab();

        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}
/**
* hapus tindakanpelayanan_t berdasarkan daftartindakan_id
*/ 
function hapusTindakanPelayanan(daftartindakan_id){
    var pasienmasukpenunjang_id = $("#pasienmasukpenunjang_id").val();
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('HapusTindakanPelayanan'); ?>',
        data: {pasienmasukpenunjang_id:pasienmasukpenunjang_id, daftartindakan_id:daftartindakan_id},
        dataType: "json",
        success:function(data){
            myAlert(data.pesan);
            if(data.sukses){
                var delete_row = $("#form-tindakanpemeriksaan").find('input[name$="[daftartindakan_id]"][value="'+daftartindakan_id+'"]').parents('tr');
                delete_row.detach();
                renameInputRow($("#form-tindakanpemeriksaan"));
            }
            setChecklistPemeriksaanRehab();
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);return false;}
    });
}
/**
 * print status 
 */
function printStatus()
{
    var pendaftaran_id = $("#pendaftaran_id").val();
    if(pendaftaran_id != ""){
        window.open('<?php echo $this->createUrl('printStatusRehabMedis'); ?>&pendaftaran_id='+pendaftaran_id,'printwin','left=100,top=100,width=480,height=640');
    }else{
        myAlert("Silakan pilih data kunjungan pasien!");
    }
}

/**
 * javascript yang di running setelah halaman ready / load sempurna
 * posisi script ini harus tetap dibawah
 */
$( document ).ready(function(){
<?php if(!empty($modKunjungan->pasienmasukpenunjang_id)){ ?>
    $("#form-datakunjungan > legend > .judul").html('Data Kunjungan <?php echo $modKunjungan->no_masukpenunjang ?>');
    $("#form-datakunjungan > legend > .tombol").attr('style','display:true;');
    $("#form-datakunjungan > .box").addClass("well").removeClass("box");
    setTindakanPelayanan();
    setChecklistPemeriksaanRehab();
<?php } ?>
});
</script>