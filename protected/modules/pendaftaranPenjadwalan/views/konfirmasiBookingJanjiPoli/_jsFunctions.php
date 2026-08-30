<script>

function setPasienJanjiPoli(no_buatjanji) {
    
    if (no_buatjanji.trim() == "") {
        return false;
    }
    
    $("#form-pasien > div").addClass("animation-loading");
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('GetDataPasienJanjiPoli'); ?>',
        data: {no_buatjanji:no_buatjanji},
        dataType: "json",
        success:function(data){
            
            if (data.data_janjipoli == null) {
                myAlert("Data Janji Poliklinik tidak ditemukan atau sudah dilakukan.");
                $("#no_buatjanji").val("");
                $("#form-pasien > div").removeClass("animation-loading");
                return false;
            }
            
            // $("#no_buatjanji").val(data.data_janjipoli.no_buatjanji);
            $("#PPBuatJanjiPoliT_buatjanjipoli_id").val(data.data_janjipoli.buatjanjipoli_id);

            $("#<?php echo CHtml::activeId($model,"ruangan_id");?>").val(data.data_janjipoli.ruangan_id);
            $("#<?php echo CHtml::activeId($model,"pegawai_id");?>").val(data.data_janjipoli.pegawai_id);
            $("#<?php echo CHtml::activeId($model,"carabayar_id");?>").val(data.data_janjipoli.carabayar_id).change();
            $("#<?php echo CHtml::activeId($model,"penjamin_id");?>").val(data.data_janjipoli.penjamin_id);
            
            if(data.statusrekammedis.trim() == "<?php echo Params::STATUSREKAMMEDIS_AKTIF?>"){
				$("#cari_nomorindukpegawai").val(data.nomorindukpegawai); // untuk load filed NIP
                $("#no_rekam_medik").val(data.no_rekam_medik);
                $("#<?php echo CHtml::activeId($modPasien,'pasien_id');?>").val(data.pasien_id);
                $("#<?php echo CHtml::activeId($modPasien,'no_rekam_medik');?>").val(data.no_rekam_medik);
                $("#<?php echo CHtml::activeId($modPasien,"jenisidentitas");?>").val(data.jenisidentitas);
                $("#<?php echo CHtml::activeId($modPasien,"no_jamkespa");?>").val(data.no_jamkespa);
                $("#<?php echo CHtml::activeId($modPasien,"no_identitas_pasien");?>").val(data.no_identitas_pasien);
                $("#<?php echo CHtml::activeId($modPasien,"namadepan");?>").val(data.namadepan);
                $("#<?php echo CHtml::activeId($modPasien,"nama_pasien");?>").val(data.nama_pasien);
                $("#<?php echo CHtml::activeId($modPasien,"nama_bin");?>").val(data.nama_bin);
                $("#<?php echo CHtml::activeId($modPasien,"tempat_lahir");?>").val(data.tempat_lahir);
                $("#<?php echo CHtml::activeId($modPasien,"nama_ayah");?>").val(data.nama_ayah);
                $("#<?php echo CHtml::activeId($modPasien,"nama_ibu");?>").val(data.nama_ibu);
                $("#<?php echo CHtml::activeId($modPasien,"tanggal_lahir");?>").val(data.tanggal_lahir);
                $("#<?php echo CHtml::activeId($modPasien,"kelompokumur_id");?>").val(data.kelompokumur_id);
                $("#<?php echo CHtml::activeId($modPasien,"statusperkawinan");?>").val(data.statusperkawinan);
                $("#<?php echo CHtml::activeId($modPasien,"golongandarah");?>").val(data.golongandarah);
                $("#<?php echo CHtml::activeId($modPasien,"rhesus");?>").val(data.rhesus);
                $("#<?php echo CHtml::activeId($modPasien,"alamat_pasien");?>").val(data.alamat_pasien);
                $("#<?php echo CHtml::activeId($modPasien,"rt");?>").val(data.rt);
                $("#<?php echo CHtml::activeId($modPasien,"rw");?>").val(data.rw);
                $("#<?php echo CHtml::activeId($modPasien,"no_telepon_pasien");?>").val(data.no_telepon_pasien);
                $("#<?php echo CHtml::activeId($modPasien,"no_mobile_pasien");?>").val(data.no_mobile_pasien);
                $("#<?php echo CHtml::activeId($modPasien,"suku_id");?>").val(data.suku_id);
                $("#<?php echo CHtml::activeId($modPasien,"alamatemail");?>").val(data.alamatemail);
                $("#<?php echo CHtml::activeId($modPasien,"anakke");?>").val(data.anakke);
                $("#<?php echo CHtml::activeId($modPasien,"jumlah_bersaudara");?>").val(data.jumlah_bersaudara);
                $("#<?php echo CHtml::activeId($modPasien,"pendidikan_id");?>").val(data.pendidikan_id);
                $("#<?php echo CHtml::activeId($modPasien,"pekerjaan_id");?>").val(data.pekerjaan_id);
                $("#<?php echo CHtml::activeId($modPasien,"agama");?>").val(data.agama);
                $("#<?php echo CHtml::activeId($modPasien,"warga_negara");?>").val(data.warga_negara);
                $("#<?php echo CHtml::activeId($modPasien,"jeniskelamin");?>").val(data.jeniskelamin);
                
                
                
                
				
                $('#photo-preview').attr('src','<?php echo Params::urlPhotoPasienDirectory()."no_photo.jpeg"?>');
                if(data.photopasien != null && data.photopasien != ""){ //set photo
                    $("#<?php echo CHtml::activeId($modPasien,"photopasien");?>").val(data.photopasien);
                    $('#photo-preview').attr('src','<?php echo Params::urlPasienTumbsDirectory()."kecil_"?>'+data.photopasien);
                }
				
                setJenisKelaminPasien(data.jeniskelamin);
                setRhesusPasien(data.rhesus);
                setDaerahPasien(data.propinsi_id, data.kabupaten_id, data.kecamatan_id, data.kelurahan_id);
                setUmur(data.tanggal_lahir);
                setKarcis();
                setRiwayatKunjunganPasien(data.pasien_id);
                setAsuransiPasienLama(data.pasien_id);
                getRuanganPoliklinikPasien();
                                
                $(".rb_rm").eq(0).click();
                $(".rmlama").prop("checked",true);
                
                
                $("#form-pasien > legend > .judul").html('Data Pasien Lama ');
                $("#form-pasien > legend > .tombol").attr('style','display:true;');
                $("#form-pasien > .box").addClass("well").removeClass("box");
            }else{
                if(confirm("Apakah Anda akan menggunakan No. Rekam Medik Non-Aktif ?")){
                    $("#cari_no_rekam_medik").val(data.no_rekam_medik);
                    $("#<?php echo CHtml::activeId($modPasien,'pasien_id');?>").val(data.pasien_id);
                    
                    $("#form-pasien > legend > .judul").html('Data Pasien No. Rekam Medik Lama ');
                    $("#form-pasien > legend > .tombol").attr('style','display:true;');
                    $("#form-pasien > .box").addClass("well").removeClass("box");
                    $("#<?php echo CHtml::activeId($modPasien,'jenisidentitas'); ?>").focus();
                }
            }
            $("#<?php echo CHtml::activeId($model, 'ruangan_id'); ?>").focus(); //<<RND-820 (custom)
            window.scrollBy(0,380); //<<RND-820 (custom)
            $("#form-pasien > div").removeClass("animation-loading");
            isSetLama = false;
            hideHitunganRM();
        },
        error: function (jqXHR, textStatus, errorThrown) { 
            if (!is_manual) {
                myAlert("Data Janji Poliklinik tidak ditemukan atau sudah dilakukan."); 
                $("#no_buatjanji").val("");
            }
            else $("#no_rekam_medik_baru").val(no_rekam_medik);
            
            isSetLama = false;
            $("#form-pasien > div").removeClass("animation-loading");
        }
    });
}

/**
* @author Deni Hamdani <denihamdani@piindonesia.co.id>
* 
 * Menampilkan form verifikasi
 * sebelum menampilkan verifikasi, terlebih dahulu dilakukan validasi Input Keseluruhan
 * terlebih dahulu. Kemudian, divalidasi lagi Nomor Identitas beserta Input Nama Ibu-nya.
 * Dan yang terahir, validasi apakah Nomot KTP atau Tgl. Lahir+Nama Ibu sudah dipakai oleh
 * Pasien lain.
 * 
 * @returns {undefined}
 */
function setVerifikasiJanjiPoli(){
    
    
    
    
    if(requiredCheck($("form"))){        
        disableOnSubmit(this); $("#pppendaftaran-t-form").submit();
    }
    
    return false;
}

</script>
