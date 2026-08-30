<script>
      function printLabelGelangBayiLahir(tipe) {
        window.open('<?php echo $this->createUrl('printLabelGelang', array('pendaftaran_id' => $model->pendaftaran_id)); ?>&tipe=' + tipe, 'printwin', 'left=100,top=100,width=793,height=1122');
    }


function setPasienBayi(pasien_id, pendaftaran_id, kelahiranbayi_id){    
    $("#form-pasien > div").addClass("animation-loading");
    
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('GetDataPasienIbu'); ?>',
        data: {pasien_id:pasien_id, pendaftaran_id:pendaftaran_id, kelahiranbayi_id},
        dataType: "json",
        success:function(data){
            if(data.statusrekammedis.trim() == "<?php echo Params::STATUSREKAMMEDIS_AKTIF?>"){
                $("#<?php echo CHtml::activeId($modPasienAdmisi,"carabayar_id");?>").val(data.listDaftar.carabayar_id).change();
                $("#<?php echo CHtml::activeId($modPasienAdmisi, "penjamin_id");?>").val(data.listDaftar.penjamin_id).change();

				$("#cari_nomorindukpegawai").val(data.nomorindukpegawai); // untuk load filed NIP
                $("#no_rekam_medik_bayi").val(data.no_rekam_medik);
                $("#<?php echo CHtml::activeId($modPasien,"jenisidentitas");?>").val(data.jenisidentitas);
                $("#<?php echo CHtml::activeId($modPasien,"nama_pasien");?>").val(data.persalinan.nama_bayi);
                $("#<?php echo CHtml::activeId($modPasien,"no_identitas_pasien");?>").val(data.no_identitas_pasien);
                $("#<?php echo CHtml::activeId($modPasien,"nama_ibu");?>").val(data.nama_pasien);
                $("#<?php echo CHtml::activeId($modPasien,"alamat_pasien");?>").val(data.alamat_pasien);
                $("#<?php echo CHtml::activeId($modPasien,"tanggal_lahir");?>").val(data.persalinan.tgl_lahir);
                $("#<?php echo CHtml::activeId($modPasien,"rt");?>").val(data.rt);
                $("#<?php echo CHtml::activeId($modPasien,"rw");?>").val(data.rw);
                $("#<?php echo CHtml::activeId($modPasien,"no_telepon_pasien");?>").val(data.no_telepon_pasien);
                $("#<?php echo CHtml::activeId($modPasien,"no_mobile_pasien");?>").val(data.no_mobile_pasien);
                $("#<?php echo CHtml::activeId($modPasien,"suku_id");?>").val(data.suku_id);
                $("#<?php echo CHtml::activeId($modPasien,"alamatemail");?>").val(data.alamatemail);
                $("#<?php echo CHtml::activeId($modPasien,"anakke");?>").val(data.anakke);
                $("#<?php echo CHtml::activeId($modPasien,"jumlah_bersaudara");?>").val(data.jumlah_bersaudara);
                $("#<?php echo CHtml::activeId($modPasien,"pekerjaan_id");?>").val(data.pekerjaan_id);
                $("#<?php echo CHtml::activeId($modPasien,"agama");?>").val(data.agama);
                $("#<?php echo CHtml::activeId($modPasien,"warga_negara");?>").val(data.warga_negara);
                $("#<?php echo CHtml::activeId($modPasien,"is_ambilfoto");?>").val(0);
                $("#<?php echo CHtml::activeId($modPasien,"photopasien");?>").val("");
                $("#<?php echo CHtml::activeId($modPasien,"kelahiranbayi_id");?>").val(kelahiranbayi_id);
                $('#PPPasienAdmisiT_kelaspelayanan_id').val(data.persalinan.kelaspelayanan_id);
                /*
				if(data.pegawai_id !== "" && data.pegawai_id !== null){
					$("#<?php echo CHtml::activeId($modPasien,'pegawai_id');?>").val(data.pegawai_id);
					$("#<?php echo CHtml::activeId($modPegawai,'nomorindukpegawai');?>").val(data.nomorindukpegawai);
					$("#<?php echo CHtml::activeId($modPegawai,'nama_pegawai');?>").val(data.nama_pegawai);
					$("#<?php echo CHtml::activeId($modPegawai,'gelardepan');?>").val(data.gelardepan);
					$("#<?php echo CHtml::activeId($modPegawai,'gelarbelakang_nama');?>").val(data.gelarbelakang_nama);
					$("#<?php echo CHtml::activeId($modPegawai,'unit_perusahaan');?>").val(data.unit_perusahaan);
					$("#<?php echo CHtml::activeId($modPegawai,'jabatan_nama');?>").val(data.jabatan_nama);
					tampilFormPegawai();
				}else{ */
					sembunyiFormPegawai();
				// }
				
                // $('#photo-preview').attr('src','<?php echo Params::urlPhotoPasienDirectory()."no_photo.jpeg"?>');
                // if(data.photopasien != null && data.photopasien != ""){ //set photo
                //    $("#<?php echo CHtml::activeId($modPasien,"photopasien");?>").val(data.photopasien);
                //    $('#photo-preview').attr('src','<?php echo Params::urlPasienTumbsDirectory()."kecil_"?>'+data.photopasien);
                // }
				
                setJenisKelaminPasien(data.persalinan.jeniskelamin);
                setUmur(data.persalinan.tgl_lahir);
                setDaerahPasien(data.propinsi_id, data.kabupaten_id, data.kecamatan_id, data.kelurahan_id);
                // setRhesusPasien(data.rhesus);
                // setKarcis();
                // setRiwayatKunjunganPasien(data.pasien_id);
                // setAsuransiPasienLama(data.pasien_id);
                // getRuanganPoliklinikPasien();
                
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
            if (!is_manual) myAlert("Data Pasien tidak ditemukan!"); 
            else $("#no_rekam_medik_baru").val(no_rekam_medik);
            
            isSetLama = false;
            $("#form-pasien > div").removeClass("animation-loading");
        }
    });    
}



// function cekPilihSatu(obj) {
//         // console.log($(obj).find('option').length);
//         if ($(obj).find('option').length == 2) {
//             $(obj).val($(obj).find('option').eq(1).val());
//             $(obj).change();
//         }
//         if ($(obj).find('option').length == 1) {
//             $(obj).change();
//         }
//     }

    
// $(document).ready(function() {
//     cekPilihSatu($("#PPPendaftaranT_carabayar_id"));
//     cekPilihSatu($("#PPPendaftaranT_penjamin_id"));
// });

/**
 * set nama depan berdasarkan umur, jenis kelamin dan status perkawinan
 *
 * @returns {undefined} */
function setNamaDepan(){

var statusperkawinan = $('#PPPasienM_statusperkawinan').val();
var namadepan = $('#PPPasienM_namadepan');
var umur = $("#<?php echo CHtml::activeId($model,'umur');?>").val().substr(0,2);
umur = parseInt(umur);

console.log(umur);

if(umur <= 5){
    var namadepan = $('#PPPasienM_namadepan').val('By. ');
}
}

$(document).ready(function() {
    <?php
    if (isset($_GET['pendaftaranibu_id']) && $model->isNewRecord) {
        $pendaftaran = PendaftaranT::model()->findByPk($_GET['pendaftaranibu_id']);
        
        if (!empty($pendaftaran)) {
            echo 'setPasienBayi('.$pendaftaran->pasien_id.', '.$pendaftaran->pendaftaran_id.')';
        }
    }
    ?>


  $("#<?php echo CHtml::activeId($modPasienAdmisi,"penjamin_id");?>").change(function() {
        console.log("PJ", $(this).val(), $("#<?php echo CHtml::activeId($model,"is_pasienrujukan");?>").val());
        if ($(this).val() == <?php echo Params::PENJAMIN_ID_UMUM; ?>) {
            if ($("#<?php echo CHtml::activeId($model,"is_pasienrujukan");?>").val() == 1) {
                $("#form-rujukan .accordion-heading a").click();
            }   
        }
    });
});

</script>