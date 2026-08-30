<style>
    .checked td {
        background-color: yellow;
    }
</style>

<?php $konfig = KonfigsystemK::model()->find(); ?>

<script type="text/javascript">
    
var kk_id = "";   
var pemilik_bpjs = "";
    
/**
 * set pasien lama
 * @param {type} pasien_id
 * @returns {undefined}
 */
var otoval = 1; // untuk hitung rekam medik
var isSetLama = false;



function setPegawai(pegawai_id, nip) {
    $.post('<?php echo $this->createUrl('getDataPegawaiUntukPasienBaru'); ?>', {
        pegawai_id: pegawai_id, nip: nip
    }, function(data) {
        if (data.ok == 0) {
            myAlert(data.msg);
            $("#PPPasienM_nomorindukpegawai").val("").focus();
        } else {
            $("#<?php echo CHtml::activeId($modPasien,"pegawai_id");?>").val(data.res.pegawai_id);
            $("#<?php echo CHtml::activeId($modPasien,"jenisidentitas");?>").val(data.res.jenisidentitas.trim());
            $("#<?php echo CHtml::activeId($modPasien,"no_identitas_pasien");?>").val(data.res.noidentitas);
            $("#<?php echo CHtml::activeId($modPasien,"nama_pasien");?>").val(data.res.nama_pegawai.toUpperCase());
            $("#<?php echo CHtml::activeId($modPasien,"tempat_lahir");?>").val(data.res.tempatlahir_pegawai);
            $("#<?php echo CHtml::activeId($modPasien,"tanggal_lahir");?>").val(data.res.tgl_lahirpegawai);
            $("#<?php echo CHtml::activeId($modPasien,"statusperkawinan");?>").val(data.res.statusperkawinan);
            $("#<?php echo CHtml::activeId($modPasien,"golongandarah");?>").val(data.res.golongandarah);
            $("#<?php echo CHtml::activeId($modPasien,"rhesus");?>").val(data.res.rhesus);
            $("#<?php echo CHtml::activeId($modPasien,"alamat_pasien");?>").val(data.res.alamat_pegawai);
            $("#<?php echo CHtml::activeId($modPasien,"no_telepon_pasien");?>").val(data.res.notelp_pegawai);
            $("#<?php echo CHtml::activeId($modPasien,"no_mobile_pasien");?>").val(data.res.nomobile_pegawai);
            $("#<?php echo CHtml::activeId($modPasien,"suku_id");?>").val(data.res.suku_id);
            $("#<?php echo CHtml::activeId($modPasien,"alamatemail");?>").val(data.res.alamatemail);
            $("#<?php echo CHtml::activeId($modPasien,"pendidikan_id");?>").val(data.res.pendidikan_id);
            $("#<?php echo CHtml::activeId($modPasien,"warga_negara");?>").val(data.res.warganegara_pegawai);
            $("#<?php echo CHtml::activeId($modPasien,"agama");?>").val(data.res.agama);
            setJenisKelaminPasien(data.res.jeniskelamin);
            setRhesusPasien(data.res.rhesus);
            setDaerahPasien(data.res.propinsi_id, data.res.kabupaten_id, data.res.kecamatan_id, data.res.kelurahan_id);
            setUmur(data.res.tgl_lahirpegawai);
            setKarcis();
        }
    }, 'json');
}

function setPasienLama(pasien_id, no_rekam_medik, is_manual){    
    if (isSetLama) return false;
    
    $("#form-pasien > div").addClass("animation-loading");
    setPasienBaru(); 
    isSetLama = true;
    
    var beforeOto = otoval;
    $("#kunjungan_ke").text('');
    
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('GetDataPasien'); ?>',
        data: {pasien_id:pasien_id, no_rekam_medik:no_rekam_medik, is_manual:is_manual},
        dataType: "json",
        success:function(data){

            if (data.kosong) {
                    myAlert("Data Pasien tidak ditemukan!");
                    $("#form-pasien > div").removeClass("animation-loading");
                    $("#no_rekam_medik_baru").val("");
                    return false;
                }

            if (data.lebih) {
                myAlert("No. RM digunakan untuk hitungan otomatis. Pilih antara 000001 - 347499");
                $("#form-pasien > div").removeClass("animation-loading");
                $("#<?php echo CHtml::activeId($modPasien, 'no_rekam_medik') ?>").val("");
                return false;
            }
            
            <?php // if ($this->id == "pendaftaranRawatInap"): ?>
            
            if (data.adaInap) {
                myAlert("Pasien " + data.listDaftar.pasien.namadepan + data.listDaftar.pasien.nama_pasien + " (" + data.listDaftar.no_pendaftaran + ")\n\
                Hari ini sedang dirawat inap di " + data.listDaftar.ruangan.ruangan_nama + ".");
                $("#form-pasien > div").removeClass("animation-loading");
                $("#<?php echo CHtml::activeId($modPasien,'nama_pasien');?>").val("");
                setPasienBaru();
                isSetLama = false;
                return false;
            }
            if (data.tindakLanjut) {
                    myAlert("Pasien " + data.listDaftar.pasien.namadepan + data.listDaftar.pasien.nama_pasien + " (" + data.listDaftar.no_pendaftaran + ")\n\
                    Hari ini menunggu tindak lanjut ke rawat inap di " + data.listDaftar.instalasi.instalasi_nama + " -> " + data.listDaftar.ruangan.ruangan_nama + ".");
                    $("#form-pasien > div").removeClass("animation-loading");
                    $("#<?php echo CHtml::activeId($modPasien,'nama_pasien');?>").val("");
                    setPasienBaru(); 
                    isSetLama = false;
                    return false;
                }
            if (data.adaDaftar) {
                myAlert("Pasien " + data.listDaftar.pasien.namadepan + data.listDaftar.pasien.nama_pasien + " (" + data.listDaftar.no_pendaftaran + ")\n\
                Hari ini sedang di instalasi " + data.listDaftar.instalasi.instalasi_nama + " -> " + data.listDaftar.ruangan.ruangan_nama + " dengan status pemeriksan '"
                + data.listDaftar.statusperiksa + "'.");
                $("#form-pasien > div").removeClass("animation-loading");
                $("#<?php echo CHtml::activeId($modPasien,'nama_pasien');?>").val("");
                setPasienBaru();
                isSetLama = false;
                return false;
            }
            
            <?php //    endif; ?>
            
            if(data.statusrekammedis.trim() == "<?php echo Params::STATUSREKAMMEDIS_AKTIF?>"){
                $("#cari_nomorindukpegawai").val(data.nomorindukpegawai); // untuk load filed NIP
                $("#cari_no_rekam_medik").val(data.no_rekam_medik);
                $("#<?php echo CHtml::activeId($modPasien,'no_rekam_medik');?>").val(data.no_rekam_medik);
                $("#<?php echo CHtml::activeId($modPasien,'pasien_id');?>").val(data.pasien_id);
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
                $("#<?php echo CHtml::activeId($modPasien,"norm_lama");?>").val(data.norm_lama);
                $("#<?php echo CHtml::activeId($modPasien,"norm_lama_temp");?>").val(data.norm_lama);
                $("#<?php echo CHtml::activeId($modPasien,"is_ambilfoto");?>").val(0);
                
                if (data.nofingerprint != null){
                    $("#pesanVerifikasi").html("Pasien Sudah Melakukan Pendaftaran Sidik Jari "+data.nofingerprint);
                }else{
                    $("#pesanVerifikasi").html("Pasien Belum Melakukan Pendaftaran Sidik jari ");
                }
                
				if(data.pegawai_id !== "" && data.pegawai_id !== null){
					$("#<?php echo CHtml::activeId($modPasien,'pegawai_id');?>").val(data.pegawai_id);
					$("#<?php echo CHtml::activeId($modPegawai,'nomorindukpegawai');?>").val(data.nomorindukpegawai);
					$("#<?php echo CHtml::activeId($modPegawai,'nama_pegawai');?>").val(data.nama_pegawai);
					$("#<?php echo CHtml::activeId($modPegawai,'gelardepan');?>").val(data.gelardepan);
					$("#<?php echo CHtml::activeId($modPegawai,'gelarbelakang_nama');?>").val(data.gelarbelakang_nama);
					$("#<?php echo CHtml::activeId($modPegawai,'unit_perusahaan');?>").val(data.unit_perusahaan);
					$("#<?php echo CHtml::activeId($modPegawai,'jabatan_nama');?>").val(data.jabatan_nama);
					tampilFormPegawai();
				}else{
					sembunyiFormPegawai();
				}
				
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
                
                $("#kunjungan_ke").text("Kunjungan Ke - "+data.kunjungan_ke);
                
                $("#form-pasien > legend > .judul").html('Data Pasien Lama ');
                $("#form-pasien > legend > .tombol").attr('style','display:true;');
                $('.tombol').show();
                $("#form-pasien > .box").addClass("well").removeClass("box");
                
                <?php if(isset($jnspelayanan) && $jnspelayanan=='RJ'){ ?>
                    $("#skdp").show();
                <?php } ?>
                
            }else{
                if(confirm("Apakah Anda akan menggunakan No. Rekam Medik Non-Aktif ?")){
                    $("#cari_no_rekam_medik").val(data.no_rekam_medik);
                    $("#<?php echo CHtml::activeId($modPasien,'no_rekam_medik');?>").val(data.no_rekam_medik);
                    $("#<?php echo CHtml::activeId($modPasien,'pasien_id');?>").val(data.pasien_id);
                    
                    $("#form-pasien > legend > .judul").html('Data Pasien No. Rekam Medik Lama ');
                    $("#form-pasien > legend > .tombol").attr('style','display:true;');
                    $('.tombol').show();
                    $("#form-pasien > .box").addClass("well").removeClass("box");
                    $("#<?php echo CHtml::activeId($modPasien,'jenisidentitas'); ?>").focus();
                    
                    $("#kunjungan_ke").text("Kunjungan Ke - "+data.kunjungan_ke);
                }
            }
            $("#<?php echo CHtml::activeId($model, 'ruangan_id'); ?>").focus(); //<<RND-820 (custom)
            window.scrollBy(0,380); //<<RND-820 (custom)
            $("#form-pasien > div").removeClass("animation-loading");
            isSetLama = false;
            hideHitunganRM();
            $("#PPPasienM_alamat_pasien").blur();
        
        },
        error: function (jqXHR, textStatus, errorThrown) { 
            if (!is_manual) myAlert("Data Pasien tidak ditemukan!"); 
            else $("#<?php echo CHtml::activeId($modPasien, 'no_rekam_medik') ?>").val('');
            
            isSetLama = false;
            $("#form-pasien > div").removeClass("animation-loading");
        }
    });    
}



function setPasienLamaNomor() {
    var nik = $(".nik").val();
    
    if (nik == "") return false;
    
    $("#form-pasien > div").addClass("animation-loading");
    
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('getDataPasienNIK'); ?>',
        data: {nik:nik},
        dataType: "json",
        success:function(data) {
            $("#form-pasien > div").removeClass("animation-loading");
            
            if (data.id != 0) {
                setPasienLama(data.id);
            }
        }
    });
    
}

/**
 * set form pasien ke pasien baru 
 * @returns {undefined} */
function setPasienBaru(){    
//    if (setPasienLama) return false;
    
    <?php if(isset($_GET['pendaftaranbayi_id']) && !empty($_GET['pendaftaranbayi_id'])){ ?>
            return false;
    <?php }?>
    
    $("#<?php echo CHtml::activeId($model,'umur');?>").val("");
    $("#<?php echo CHtml::activeId($modPasien,'pasien_id');?>").val("");
    $("#<?php echo CHtml::activeId($modPasien,"jenisidentitas");?>").val("");
    $("#<?php echo CHtml::activeId($modPasien,"no_identitas_pasien");?>").val("");
    $("#<?php echo CHtml::activeId($modPasien,"namadepan");?>").val("");
    $("#<?php echo CHtml::activeId($modPasien,"nama_pasien");?>").val("");
    $("#<?php echo CHtml::activeId($modPasien,"nama_bin");?>").val("");
    $("#<?php echo CHtml::activeId($modPasien,"tempat_lahir");?>").val("");
    $("#<?php echo CHtml::activeId($modPasien,"nama_ayah");?>").val("");
    $("#<?php echo CHtml::activeId($modPasien,"nama_ibu");?>").val("");
    $("#<?php echo CHtml::activeId($modPasien,"tanggal_lahir");?>").val("");
    $("#<?php echo CHtml::activeId($modPasien,"kelompokumur_id");?>").val("");
    $("#<?php echo CHtml::activeId($modPasien,"jeniskelamin");?>").val("");
    $("#<?php echo CHtml::activeId($modPasien,"statusperkawinan");?>").val("");
    $("#<?php echo CHtml::activeId($modPasien,"golongandarah");?>").val("");
    $("#<?php echo CHtml::activeId($modPasien,"rhesus");?>").val("");
    $("#<?php echo CHtml::activeId($modPasien,"alamat_pasien");?>").val("");
    $("#<?php echo CHtml::activeId($modPasien,"rt");?>").val("");
    $("#<?php echo CHtml::activeId($modPasien,"rw");?>").val("");
    $("#<?php echo CHtml::activeId($modPasien,"propinsi_id");?>").val(<?php echo $modPasien->propinsi_id; ?>);
    $("#<?php echo CHtml::activeId($modPasien,"kabupaten_id");?>").val(<?php echo $modPasien->kabupaten_id; ?>);
    $("#<?php echo CHtml::activeId($modPasien,"kecamatan_id");?>").val(<?php echo $modPasien->kecamatan_id; ?>);
    $("#<?php echo CHtml::activeId($modPasien,"kelurahan_id");?>").val("<?php echo $modPasien->kelurahan_id; ?>");
    $("#<?php echo CHtml::activeId($modPasien,"no_telepon_pasien");?>").val("");
    $("#<?php echo CHtml::activeId($modPasien,"no_mobile_pasien");?>").val("");
    $("#<?php echo CHtml::activeId($modPasien,"suku_id");?>").val(<?php echo $modPasien->suku_id; ?>);
    $("#<?php echo CHtml::activeId($modPasien,"alamatemail");?>").val("");
    $("#<?php echo CHtml::activeId($modPasien,"anakke");?>").val("");
    $("#<?php echo CHtml::activeId($modPasien,"jumlah_bersaudara");?>").val("");
    $("#<?php echo CHtml::activeId($modPasien,"pendidikan_id");?>").val("");
    $("#<?php echo CHtml::activeId($modPasien,"pekerjaan_id");?>").val("");
    $("#<?php echo CHtml::activeId($modPasien,"agama");?>").val("");
    $("#<?php echo CHtml::activeId($modPasien,"warga_negara");?>").val("<?php echo $modPasien->warga_negara; ?>");
    $("#<?php echo CHtml::activeId($modPasien,"norm_lama");?>").val("");
    $("#<?php echo CHtml::activeId($modPasien,"norm_lama_temp");?>").val("");
    
	$("#<?php echo CHtml::activeId($model,"carabayar_id");?>").val("");
	$("#<?php echo CHtml::activeId($model,"penjamin_id");?>").val("");
	setAsuransiBadakReset();
	
    $("#<?php echo CHtml::activeId($modPasien,"photopasien");?>").val("");
    $('#photo-preview').attr('src','<?php echo Params::urlPhotoPasienDirectory()."no_photo.jpeg"?>');

    setJenisKelaminPasien("");
    setKarcis();
	setPegawaiReset();
    showHitunganRM();

    $("#form-pasien > legend > .judul").html('Data Pasien Baru ');
    $("#form-pasien > legend > .tombol").attr('style','display:none;');
    $('.tombol').hide();
    $("#form-pasien > .well").addClass("box").removeClass("well");
    $("#<?php echo CHtml::activeId($modPasien, 'no_rekam_medik') ?>").val("");
    $("#cari_nomorindukpegawai").val("");   
    $("#PPPasienM_alamat_pasien").blur();
        
}

/**
 * untuk refresh / reset form pegawai
 * @returns {undefined}
 */
function setPegawaiReset(){
	$("#<?php echo CHtml::activeId($modPasien,'pegawai_penanggungjawab_id')?>").val("");
	$("#<?php echo CHtml::activeId($modPegawai,'nomorindukpegawai')?>").val("");
	$("#<?php echo CHtml::activeId($modPegawai,'nama_pegawai')?>").val("");
	$("#<?php echo CHtml::activeId($modPegawai,'gelardepan')?>").val("");
	$("#<?php echo CHtml::activeId($modPegawai,'gelarbelakang_nama')?>").val("");
	$("#<?php echo CHtml::activeId($modPegawai,'unit_perusahaan')?>").val("");
	$("#<?php echo CHtml::activeId($modPegawai,'jabatan_nama')?>").val("");
    $("#PPPasienM_alamat_pasien").blur();
        
}
function setAsuransiLama(){
	$(".judulasuransi").html("Asuransi Lama");
	$(".refreshasuransi").attr("style","display:true;");
    $("#PPPasienM_alamat_pasien").blur();
        
}

function setAsuransiBadak(){
	var pasien_id = $("#<?php echo CHtml::activeId($modPasien,'pasien_id') ?>").val();
	var penjamin_id = $("#<?php echo CHtml::activeId($model,'penjamin_id') ?>").val();
	var pegawai_id = $("#PPPasienM_pegawai_id").val();
//	if(pasien_id!=''){
		$("#form-asubadak").addClass("animation-loading");
		$("#form-asudepartemen").addClass("animation-loading");
		$("#form-asupekerja").addClass("animation-loading");
		$.ajax({
			type:'POST',
			url:'<?php echo $this->createUrl('SetAsuransiBadak'); ?>',
			data: {pasien_id: pasien_id, penjamin_id: penjamin_id,pegawai_id:pegawai_id},
			dataType: "json",
			success:function(data){
				setAsuransiBadakReset();
				if(data != null){
					$("#<?php echo CHtml::activeId($modAsuransiPasienBadak,'nopeserta') ?>").val(data.nopeserta);
					$("#<?php echo CHtml::activeId($modAsuransiPasienBadak,'asuransipasien_id') ?>").val(data.asuransipasien_id);
					$("#<?php echo CHtml::activeId($modAsuransiPasienBadak,'namapemilikasuransi') ?>").val(data.namapemilikasuransi);
					$("#<?php echo CHtml::activeId($modAsuransiPasienBadak,'kelastanggunganasuransi_id') ?>").val(data.kelastanggunganasuransi_id);
					$("#<?php echo CHtml::activeId($modAsuransiPasienBadak,'namaperusahaan') ?>").val(data.namaperusahaan);
					$("#<?php echo CHtml::activeId($modAsuransiPasienBadak,'hubkeluarga') ?>").val(data.hubkeluarga);
					
					$("#<?php echo CHtml::activeId($modAsuransiPasienDepartemen,'asuransipasien_id') ?>").val(data.asuransipasien_id);
					$("#<?php echo CHtml::activeId($modAsuransiPasienDepartemen,'namaperusahaan') ?>").val(data.namaperusahaan);
					$("#<?php echo CHtml::activeId($modAsuransiPasienDepartemen,'nomorpokokperusahaan') ?>").val(data.nomorpokokperusahaan);
					$("#<?php echo CHtml::activeId($modAsuransiPasienDepartemen,'nopeserta') ?>").val(data.nopeserta);
					$("#<?php echo CHtml::activeId($modAsuransiPasienDepartemen,'namapemilikasuransi') ?>").val(data.namapemilikasuransi);
					$("#<?php echo CHtml::activeId($modAsuransiPasienDepartemen,'kelastanggunganasuransi_id') ?>").val(data.kelastanggunganasuransi_id);
					
					$("#<?php echo CHtml::activeId($modAsuransiPasienPekerja,'asuransipasien_id') ?>").val(data.asuransipasien_id);
					$("#<?php echo CHtml::activeId($modAsuransiPasienPekerja,'nopeserta') ?>").val(data.nopeserta);
					$("#<?php echo CHtml::activeId($modAsuransiPasienPekerja,'namapemilikasuransi') ?>").val(data.namapemilikasuransi);
					$("#<?php echo CHtml::activeId($modPegawai,'alamat_pegawai') ?>").val(data.alamat_pegawai);
					$("#<?php echo CHtml::activeId($modPegawai,'notelp_pegawai') ?>").val(data.notelp_pegawai);
					$("#<?php echo CHtml::activeId($modAsuransiPasienPekerja,'kelastanggunganasuransi_id') ?>").val(data.kelastanggunganasuransi_id);
				}
				
				$("#form-asubadak").removeClass("animation-loading");
				$("#form-asudepartemen").removeClass("animation-loading");
				$("#form-asupekerja").removeClass("animation-loading");
                $("#PPPasienM_alamat_pasien").blur();
        
			},
			error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown); }
		});
//	}
}

function setAsuransiBadakReset(){
	$("#<?php echo CHtml::activeId($modAsuransiPasienBadak,'nopeserta') ?>").val("");
    $("#<?php echo CHtml::activeId($modAsuransiPasienBadak,'asuransipasien_id') ?>").val("");
    $("#<?php echo CHtml::activeId($modAsuransiPasienBadak,'nokartuasuransi') ?>").val("");
    $("#<?php echo CHtml::activeId($modAsuransiPasienBadak,'namapemilikasuransi') ?>").val("");
    $("#<?php echo CHtml::activeId($modAsuransiPasienBadak,'nomorpokokperusahaan') ?>").val("");
    $("#<?php echo CHtml::activeId($modAsuransiPasienBadak,'kelastanggunganasuransi_id') ?>").val("");
    $("#<?php echo CHtml::activeId($modAsuransiPasienBadak,'status_konfirmasi') ?>").val("");
    $("#<?php echo CHtml::activeId($modAsuransiPasienBadak,'tgl_konfirmasi') ?>").val("");
    $("#<?php echo CHtml::activeId($modAsuransiPasienBadak,'hubkeluarga') ?>").val("");
	
	$("#<?php echo CHtml::activeId($modAsuransiPasienDepartemen,'nopeserta') ?>").val("");
    $("#<?php echo CHtml::activeId($modAsuransiPasienDepartemen,'asuransipasien_id') ?>").val("");
    $("#<?php echo CHtml::activeId($modAsuransiPasienDepartemen,'nokartuasuransi') ?>").val("");
    $("#<?php echo CHtml::activeId($modAsuransiPasienDepartemen,'namapemilikasuransi') ?>").val("");
    $("#<?php echo CHtml::activeId($modAsuransiPasienDepartemen,'nomorpokokperusahaan') ?>").val("");
    $("#<?php echo CHtml::activeId($modAsuransiPasienDepartemen,'kelastanggunganasuransi_id') ?>").val("");
    $("#<?php echo CHtml::activeId($modAsuransiPasienDepartemen,'status_konfirmasi') ?>").val("");
    $("#<?php echo CHtml::activeId($modAsuransiPasienDepartemen,'tgl_konfirmasi') ?>").val("");
    $("#<?php echo CHtml::activeId($modAsuransiPasienDepartemen,'hubkeluarga') ?>").val("");
	
	$("#<?php echo CHtml::activeId($modAsuransiPasienPekerja,'nopeserta') ?>").val("");
    $("#<?php echo CHtml::activeId($modAsuransiPasienPekerja,'asuransipasien_id') ?>").val("");
    $("#<?php echo CHtml::activeId($modAsuransiPasienPekerja,'nokartuasuransi') ?>").val("");
    $("#<?php echo CHtml::activeId($modAsuransiPasienPekerja,'namapemilikasuransi') ?>").val("");
    $("#<?php echo CHtml::activeId($modAsuransiPasienPekerja,'nomorpokokperusahaan') ?>").val("");
    $("#<?php echo CHtml::activeId($modAsuransiPasienPekerja,'kelastanggunganasuransi_id') ?>").val("");
    $("#<?php echo CHtml::activeId($modAsuransiPasienPekerja,'status_konfirmasi') ?>").val("");
    $("#<?php echo CHtml::activeId($modAsuransiPasienPekerja,'tgl_konfirmasi') ?>").val("");
    $("#<?php echo CHtml::activeId($modAsuransiPasienPekerja,'hubkeluarga') ?>").val("");
    $("#<?php echo CHtml::activeId($modPegawai,'alamat_pegawai') ?>").val("");
    $("#<?php echo CHtml::activeId($modPegawai,'notelp_pegawai') ?>").val("");
    $("#PPPasienM_alamat_pasien").blur();
        
}

function setAsuransiBaru(){
    $("#<?php echo CHtml::activeId($modAsuransiPasien,'nopeserta') ?>").val("");
    $("#<?php echo CHtml::activeId($modAsuransiPasien,'asuransipasien_id') ?>").val("");
    $("#<?php echo CHtml::activeId($modAsuransiPasien,'nokartuasuransi') ?>").val("");
    $("#<?php echo CHtml::activeId($modAsuransiPasien,'namapemilikasuransi') ?>").val("");
    $("#<?php echo CHtml::activeId($modAsuransiPasien,'nomorpokokperusahaan') ?>").val("");
    $("#<?php echo CHtml::activeId($modAsuransiPasien,'kelastanggunganasuransi_id') ?>").val("");
    $("#<?php echo CHtml::activeId($modAsuransiPasien,'namaperusahaan') ?>").val("");
    $("#<?php echo CHtml::activeId($modAsuransiPasien,'status_konfirmasi') ?>").val("");
    $("#<?php echo CHtml::activeId($modAsuransiPasien,'tgl_konfirmasi') ?>").val("");
	
    $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs,'nopeserta') ?>").val("");
    $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs,'asuransipasien_id') ?>").val("");
    $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs,'nokartuasuransi') ?>").val("");
    $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs,'namapemilikasuransi') ?>").val("");
    $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs,'nomorpokokperusahaan') ?>").val("");
    $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs,'kelastanggunganasuransi_id') ?>").val("");
    $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs,'namaperusahaan') ?>").val("");
    $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs,'status_konfirmasi') ?>").val("");
    $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs,'tgl_konfirmasi') ?>").val("");
	
	setAsuransiBadakReset();
	
	$(".judulasuransi").html("Asuransi Baru");
	$(".refreshasuransi").attr("style","display:none;");
    $("#PPPasienM_alamat_pasien").blur();
        
}
/**
 * load otomatis asuransi pasien terakhir
 * @returns {undefined}
 */
function setAsuransiPasienLama(pasien_id){
	var pegawai_id = $("#PPPasienM_pegawai_id").val();
	$.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('SetAsuransiPasienLama'); ?>',
        data: { pasien_id: pasien_id},
        dataType: "json",
        success:function(data){
			if(data != null){
                                if(confirm("Apakah pasien ini akan menggunakan penjamin "+data.penjamin_nama+"?")){
//				}
//				confirm("Apakah pasien ini akan menggunakan penjamin "+data.penjamin_nama+"?","Konfirmasi!",function(r) {
//					if(r){
						
						var datacarabayar_id = data.carabayar_id;
						var datalistPenjamin = data.listPenjamin;
						var datapenjamin_id = data.penjamin_id;
						var datanopeserta = data.nopeserta;
						var dataasuransipasien_id = data.asuransipasien_id;
						var datanokartuasuransi = data.nokartuasuransi;
						var datanamapemilikasuransi = data.namapemilikasuransi;
						var datanomorpokokperusahaan = data.nomorpokokperusahaan;
						var datakelastanggunganasuransi_id = data.kelastanggunganasuransi_id;
						var datanamaperusahaan = data.namaperusahaan;
						var datastatus_konfirmasi = data.status_konfirmasi;
						var datatgl_konfirmasi = data.tgl_konfirmasi;
						
						$("#<?php echo CHtml::activeId($model,"carabayar_id");?>").val(datacarabayar_id);
						$("#<?php echo CHtml::activeId($model,"penjamin_id");?>").html(datalistPenjamin);
                                                
                                                
						// $.ajax({
						//	type:'POST',
						//	url:'<?php echo $this->createUrl('CekCaraBayarBadak'); ?>',
						//	data: {pasien_id: pasien_id,pegawai_id:pegawai_id},
						//	dataType: "json",
						//	success:function(data){
						//		if(data.status === true){
									
									setFormAsuransi(datacarabayar_id);
									$("#<?php echo CHtml::activeId($model,"carabayar_id");?>").val(datacarabayar_id);
									$("#<?php echo CHtml::activeId($model,"penjamin_id");?>").html(datalistPenjamin).change();
									setTimeout('$("#<?php echo CHtml::activeId($model,"penjamin_id");?>").val('+datapenjamin_id+');',1000);
									
									
									setKelasTanggunganDrop();
									if(datacarabayar_id == <?php echo Params::CARABAYAR_ID_BPJS ?>){
										//alert('asdasd');
										<?php if (Yii::app()->user->getState('isbridging') == true){ ?>											
//											getAsuransiNoKartu(datanopeserta, data); //komen karena jangan langsung briging																					
											//alert('asdad');
											//alert("asd");
										<?php }else{ ?>
													
											
													$("#<?php echo CHtml::activeId($modAsuransiPasien,'nopeserta') ?>").val(datanopeserta);
													$("#<?php echo CHtml::activeId($modAsuransiPasien,'asuransipasien_id') ?>").val(dataasuransipasien_id);
													$("#<?php echo CHtml::activeId($modAsuransiPasien,'nokartuasuransi') ?>").val(datanokartuasuransi);
													$("#<?php echo CHtml::activeId($modAsuransiPasien,'namapemilikasuransi') ?>").val(datanamapemilikasuransi);
													$("#<?php echo CHtml::activeId($modAsuransiPasien,'nomorpokokperusahaan') ?>").val(datanomorpokokperusahaan);
													$("#<?php echo CHtml::activeId($modAsuransiPasien,'kelastanggunganasuransi_id') ?>").val(datakelastanggunganasuransi_id);
													$("#<?php echo CHtml::activeId($modAsuransiPasien,'namaperusahaan') ?>").val(datanamaperusahaan);
													$("#<?php echo CHtml::activeId($modAsuransiPasien,'status_konfirmasi') ?>").val(datastatus_konfirmasi);
													$("#<?php echo CHtml::activeId($modAsuransiPasien,'tgl_konfirmasi') ?>").val(datatgl_konfirmasi);
													$("#<?php echo CHtml::activeId($modAsuransiPasien,'nominal_tanggungan') ?>").val(formatNumber(data.nominal_tanggungan));
										<?php } ?>
									//}else if((datacarabayar_id == <?php echo Params::CARABAYAR_ID_BADAK; ?>) || (datacarabayar_id == <?php echo Params::CARABAYAR_ID_DEP_BADAK; ?>) || (datacarabayar_id == <?php echo Params::CARABAYAR_ID_PEKERJA; ?>)){
									//	setAsuransiBadak(data);
									}else{
										$("#<?php echo CHtml::activeId($modAsuransiPasien,'nopeserta') ?>").val(datanopeserta);
										$("#<?php echo CHtml::activeId($modAsuransiPasien,'asuransipasien_id') ?>").val(dataasuransipasien_id);
										$("#<?php echo CHtml::activeId($modAsuransiPasien,'nokartuasuransi') ?>").val(datanokartuasuransi);
										$("#<?php echo CHtml::activeId($modAsuransiPasien,'namapemilikasuransi') ?>").val(datanamapemilikasuransi);
										$("#<?php echo CHtml::activeId($modAsuransiPasien,'nomorpokokperusahaan') ?>").val(datanomorpokokperusahaan);
										$("#<?php echo CHtml::activeId($modAsuransiPasien,'kelastanggunganasuransi_id') ?>").val(datakelastanggunganasuransi_id);
										$("#<?php echo CHtml::activeId($modAsuransiPasien,'namaperusahaan') ?>").val(datanamaperusahaan);
										$("#<?php echo CHtml::activeId($modAsuransiPasien,'status_konfirmasi') ?>").val(datastatus_konfirmasi);
										$("#<?php echo CHtml::activeId($modAsuransiPasien,'tgl_konfirmasi') ?>").val(datatgl_konfirmasi);
                                                                                $("#<?php echo CHtml::activeId($modAsuransiPasien,'nominal_tanggungan') ?>").val(formatNumber(data.nominal_tanggungan));
									}
									
								//}else{
								//	myAlert(data.pesan);
								//	$("#<?php echo CHtml::activeId($model,"penjamin_id");?>").val("");
								//	$("#<?php echo CHtml::activeId($model,"carabayar_id");?>").val("");
								//}
							//},
						//	error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
						//});
												
						setKarcis();
                        $("#PPPasienM_alamat_pasien").blur();
        
					} 
//				}); 
			}
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}
/**
 * set input radio button jenis kelamin 
 * @param {type} jk
 * @returns {undefined}
 */
function setJenisKelaminPasien(jk){
    $('input[name$="[jeniskelamin]"][type="radio"]').each(function(){
        if($(this).val() == $.trim(jk)){
            $(this).attr('checked',true);
        }
    });
}
/**
 * set input radio button rhesus
 * @param {type} rh
 * @returns {undefined}
 */
function setRhesusPasien(rh){
    $('input[name*="[rhesus]"]').each(function(){
        if(this.value == $.trim(rh))
            $(this).attr('checked',true);
    });
}
/**
 * set propinsi, kabupaten, kecamatan, dan kelurahan
 * @param {type} propinsi_id
 * @param {type} kabupaten_id
 * @param {type} kecamatan_id
 * @param {type} kalurahan_id
 * @returns {undefined}
 */
function setDaerahPasien(propinsi_id,kabupaten_id,kecamatan_id,kelurahan_id){
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('SetDropdownDaerahPasien'); ?>',
        data: { propinsi_id: propinsi_id, kabupaten_id: kabupaten_id, kecamatan_id: kecamatan_id, kelurahan_id: kelurahan_id },
        dataType: "json",
        success:function(data){
            $("#<?php echo CHtml::activeId($modPasien,"propinsi_id");?>").html(data.listPropinsi);
            $("#<?php echo CHtml::activeId($modPasien,"kabupaten_id");?>").html(data.listKabupaten);
            $("#<?php echo CHtml::activeId($modPasien,"kecamatan_id");?>").html(data.listKecamatan);
            $("#<?php echo CHtml::activeId($modPasien,"kelurahan_id");?>").html(data.listKelurahan);
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}
/**
 * set nama depan berdasarkan umur, jenis kelamin dan status perkawinan
 *
 * @returns {undefined} */
function setNamaDepan(){
    
    var statusperkawinan = $('#PPPasienM_statusperkawinan').val();
    var namadepan = $('#PPPasienM_namadepan');
    var umur = $("#<?php echo CHtml::activeId($model,'umur');?>").val().substr(0,2);
    umur = parseInt(umur);
    
    //alert(umur);
    console.log(umur);

    if(umur <= 5){
        var namadepan = $('#PPPasienM_namadepan').val('By. ');
        if(statusperkawinan.length > 0 && statusperkawinan != "DIBAWAH UMUR"){
            $('#PPPasienM_statusperkawinan').val('');
            alert('Maaf status perkawinan belum cukup usia');
        }
    }else if(umur <= 14){ //
        var namadepan = $('#PPPasienM_namadepan').val('An. ');
        if(statusperkawinan.length > 0 && statusperkawinan != "DIBAWAH UMUR"){
            $('#PPPasienM_statusperkawinan').val('');
            alert('Maaf status perkawinan belum cukup usia');
        }
    }else{;
        if($('#PPPasienM_jeniskelamin_0').is(':checked')){
            if(statusperkawinan !== 'JANDA'){
                var namadepan = $('#PPPasienM_namadepan').val('Tn. ');
            }else{
                alert('Pilih status pernikahan yang sesuai!');
                $('#PPPasienM_statusperkawinan').val('KAWIN');
                var namadepan = $('#PPPasienM_namadepan').val('Tn. ')
            }

        }

        if($('#PPPasienM_jeniskelamin_1').is(':checked')) {
            $('#PPPasienM_namadepan').val('Nn. ');
            if(statusperkawinan !== 'DUDA') {
                var namadepan = $('#PPPasienM_namadepan').val('Nn. ');
                if(statusperkawinan === 'KAWIN' || statusperkawinan == 'JANDA' || statusperkawinan == 'NIKAH SIRIH' || statusperkawinan == 'POLIGAMI'){
                    var namadepan = $('#PPPasienM_namadepan').val('Ny. ');
                } else {
                    var namadepan = $('#PPPasienM_namadepan').val('Nn. ');
                }
            } else {
                alert('Pilih status pernikahan yang sesuai!');
                $('#PPPasienM_statusperkawinan').val('KAWIN');
                var namadepan = $('#PPPasienM_namadepan').val('Ny. ');
            }
        }

        if (statusperkawinan == "DIBAWAH UMUR"){
            alert('Pilih status pernikahan yang sesuai!');
            $('#PPPasienM_statusperkawinan').val('BELUM KAWIN');
        }
    }
}
/**
 * set nilai tanggal_lahir dari umur 
 * @param {type} obj
 * @returns {undefined} */
function setTglLahir(obj)
{
    var str = obj.value;
    obj.value = str.replace(/_/gi, "0");
    $.ajax({
       type:'POST',
       url:'<?php echo $this->createUrl('SetTanggalLahir'); ?>',
       data: {umur : obj.value},
       dataType: "json",
       success:function(data){
           $("#<?php echo CHtml::activeId($modPasien,"tanggal_lahir");?>").val(data.tanggal_lahir);
           $("#PPPasienM_alamat_pasien").blur();
        
       },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}
/**
 * set nilai umur dari tanggal_lahir 
 * @param {type} tanggal_lahir
 * @returns {undefined} */
function setUmur(tanggal_lahir)
{
    $.ajax({
       type:'POST',
       url:'<?php echo $this->createUrl('SetUmur'); ?>',
       data: {tanggal_lahir : tanggal_lahir},//
       dataType: "json",
       success:function(data){
           $("#<?php echo CHtml::activeId($model,"umur");?>").val(data.umur);
            <?php if(!isset($_GET['pendaftaranbayi_id']) || empty($_GET['pendaftaranbayi_id'])){ ?>
                setNamaDepan();
            <?php }?>
            $("#PPPasienM_alamat_pasien").blur();
        
//           setNamaDepan();
       },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}
/**
 * set nilai tanggal_lahir dari umur 
 * @param {type} obj
 * @returns {undefined} */
function setTglLahirPjp(obj)
{
    var str = obj.value;
    obj.value = str.replace(/_/gi, "0");
    $.ajax({
       type:'POST',
       url:'<?php echo $this->createUrl('SetTanggalLahir'); ?>',
       data: {umur : obj.value},
       dataType: "json",
       success:function(data){
           $("#<?php echo CHtml::activeId($modPenanggungJawab,"tgllahir_pj");?>").val(data.tanggal_lahir);
           $("#PPPasienM_alamat_pasien").blur();
        
       },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}
/**
 * set nilai umur dari tanggal_lahir 
 * @param {type} tanggal_lahir
 * @returns {undefined} */
function setUmurPjp(tanggal_lahir)
{
    $.ajax({
       type:'POST',
       url:'<?php echo $this->createUrl('SetUmur'); ?>',
       data: {tanggal_lahir : tanggal_lahir},//
       dataType: "json",
       success:function(data){
           $("#<?php echo CHtml::activeId($modPenanggungJawab,"umur");?>").val(data.umur);
           $("#PPPasienM_alamat_pasien").blur();
        
       },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}
/** bersihkan dropdown kecamatan */
function setClearDropdownKecamatan()
{
    $("#<?php echo CHtml::activeId($modPasien,"kecamatan_id");?>").find('option').remove().end().append('<option value="">-- Pilih --</option>').val('');
    $("#PPPasienM_alamat_pasien").blur();
        
}
/** bersihkan dropdown kelurahan */
function setClearDropdownKelurahan()
{
    $("#<?php echo CHtml::activeId($modPasien,"kelurahan_id");?>").find('option').remove().end().append('<option value="">-- Pilih --</option>').val('');
    $("#PPPasienM_alamat_pasien").blur();
        
}
/**
 * set dropdown dokter ruangan
 * @param {type} ruangan_id
 * @param {type} pegawai_id
 * @returns {undefined}
 */
function setDropdownDokter(ruangan_id)
{
    $.ajax({
       type:'POST',
       url:'<?php echo $this->createUrl('SetDropdownDokter'); ?>',
       data: {ruangan_id : ruangan_id},//
       dataType: "json",
       success:function(data){
            $("#<?php echo CHtml::activeId($model,"pegawai_id");?>").html(data.listDokter);
            $("#<?php echo CHtml::activeId($model,"ppjp_id");?>").html(data.listPPJP);
            cekPilihSatu($("#<?php echo CHtml::activeId($model,"pegawai_id");?>"));
            
            //untuk kebutuhanset load dpjp skdp bpjs
            $("#kode_spesialis").val(data.kode_bpjs);
            $("#dpjs_is_load").val('');
       },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
    $("#PPPasienM_alamat_pasien").blur();
        
}
/**
 * set dropdown jeniskasuspenyakit_id
 * @param {type} ruangan_id
 * @returns {undefined} */
function setDropdownJeniskasuspenyakit(ruangan_id)
{
    $.ajax({
       type:'POST',
       url:'<?php echo $this->createUrl('SetDropdownJeniskasuspenyakit'); ?>',
       data: {ruangan_id : ruangan_id},//
       dataType: "json",
       success:function(data){
           $("#<?php echo CHtml::activeId($model,"jeniskasuspenyakit_id");?>").html(data.listKasuspenyakit);
           cekPilihSatu($("#<?php echo CHtml::activeId($model,"jeniskasuspenyakit_id");?>"));
       },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
    $("#PPPasienM_alamat_pasien").blur();
        
}
/**
 * set dropdown status hubungan keluarga pada form asuransi pt badak
 * @param {type} ruangan_id
 * @returns {undefined} */
function setDropdownStatushubungankeluarga(penjamin_id)
{
	$.ajax({
		type:'POST',
		url:'<?php echo $this->createUrl('setDropdownStatushubungankeluarga'); ?>',
		data: {penjamin_id : penjamin_id},//
		dataType: "json",
		success:function(data){
			$("#<?php echo CHtml::activeId($modAsuransiPasienBadak,"hubkeluarga");?>").html(data.statushubungankeluarga);
		},
		 error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
	});
    $("#PPPasienM_alamat_pasien").blur();
        
}
/**
 * menampilkan karcis
 */
function setKarcis()
{
    var kelaspelayanan_id=$("#<?php echo CHtml::activeId($model,"kelaspelayanan_id");?>").val();
    var ruangan_id=$("#<?php echo CHtml::activeId($model,"ruangan_id");?>").val();
    var carabayar_id=$("#<?php echo CHtml::activeId($model,"carabayar_id");?>").val();
    var penjamin_id=$("#<?php echo CHtml::activeId($model,"penjamin_id");?>").val();
    var pasien_id=$("#<?php echo CHtml::activeId($modPasien,"pasien_id");?>").val();
    var no_rekam_medik=$("#no_rekam_medik_baru").val();
    
	//alert(kelaspelayanan_id);
	
    // console.log(no_rekam_medik);
    
    if(kelaspelayanan_id !== "" && ruangan_id !== "" && penjamin_id !== "") {		
        $("#form-karcis").addClass("animation-loading");
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('SetKarcis'); ?>',
            data: {
                kelaspelayanan_id:kelaspelayanan_id, 
                ruangan_id : ruangan_id, 
                penjamin_id:penjamin_id, 
                pasien_id:pasien_id,
                no_rekam_medik: no_rekam_medik,
                carabayar_id: carabayar_id,
            },//
            dataType: "json",
            success:function(data){
                $("#form-karcis #content-karcis-html").html(data.listKarcis);
                $("#form-karcis").removeClass("animation-loading");
                $("#PPPasienM_alamat_pasien").blur();
            },
             error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        });
    }else{
        $("#content-karcis-html").html("");
    }
       
}
/** control accordion detail pasien */
$('#form-detailpasien > div > .accordion-heading').click(function(){
//    console.log("Detail Pasien Di Klik!");
});
/** control accordion rujukan */
$('#form-rujukan > div > .accordion-heading').click(function(){
//    console.log("Rujukan Di Klik!");
    var is_pasienrujukan = $("#<?php echo CHtml::activeId($model, "is_pasienrujukan"); ?>");
    if(is_pasienrujukan.val() > 0){ //hide
        is_pasienrujukan.val(0);
    }else{//show
        is_pasienrujukan.val(1);
    }
});
/** control accordion rujukan */
$('#form-bpjs > div > .accordion-heading').click(function(){
//    console.log("Rujukan Di Klik!");
    var is_bpjs = $("#<?php echo CHtml::activeId($model, "is_bpjs"); ?>");
    if(is_bpjs.val() > 0){ //hide
        is_bpjs.val(0);
    }else{//show
        is_bpjs.val(1);
    }
});
/** control accordion rujukan */
$('#form-karcis > div > .accordion-heading').click(function(){
//    console.log("Karcis Di Klik!");
    var is_adakarcis = $("#<?php echo CHtml::activeId($model, "is_adakarcis"); ?>");
    if(is_adakarcis.val() > 0){ //hide
        is_adakarcis.val(1); // dipaksakan ada meskipun accordion disembunyikan
    }else{//show
        is_adakarcis.val(1);
    }
});
/** control accordion penanggung jawab pasien */
$('#form-pjpasien > div > .accordion-heading').click(function(){
//    console.log("Detail PJ Pasien Di Klik!");
    var is_adapjpasien = $("#<?php echo CHtml::activeId($model, "is_adapjpasien"); ?>");
    if(is_adapjpasien.val() > 0){ //hide
        is_adapjpasien.val(0);
    }else{//show
        is_adapjpasien.val(1);
    }
});

function clearRujukan()
{
    $('#<?php echo CHtml::activeId($modRujukan, 'rujukandari_id')?>').find('option').remove().end().append('<option value="">-- Pilih --</option>').val('');
    $('#<?php echo CHtml::activeId($modRujukan, 'nama_perujuk')?>').val('');
    $("#PPPasienM_alamat_pasien").blur();
        
}
/**
 * set otomatis nama_perujuk dari dropdown rujukandari_id
 * @returns {Boolean}
 */
function setNamaPerujuk(){
    var rujukandari_id = $("#<?php echo CHtml::activeId($modRujukan, 'rujukandari_id')?>").val();
    var nama_perujuk = $("#<?php echo CHtml::activeId($modRujukan, 'rujukandari_id')?>").find('option[value="'+rujukandari_id+'"]').text();
    $("#<?php echo CHtml::activeId($modRujukan, 'nama_perujuk')?>").val(nama_perujuk);
    $("#PPPasienM_alamat_pasien").blur();
        
}

function clearRujukanBpjs()
{
    $('#<?php echo CHtml::activeId($modRujukanBpjs, 'rujukandari_id')?>').find('option').remove().end().append('<option value="">-- Pilih --</option>').val('');
    $('#<?php echo CHtml::activeId($modRujukanBpjs, 'nama_perujuk')?>').val('');
    $("#PPPasienM_alamat_pasien").blur();
        
}
/**
 * set otomatis nama_perujuk dari dropdown rujukandari_id untuk BPJS
 * @returns {Boolean}
 */
function setNamaPerujukBpjs(){
    var rujukandari_id = $("#<?php echo CHtml::activeId($modRujukanBpjs, 'rujukandari_id')?>").val();
    var nama_perujuk = $("#<?php echo CHtml::activeId($modRujukanBpjs, 'rujukandari_id')?>").find('option[value="'+rujukandari_id+'"]').text();
    $("#<?php echo CHtml::activeId($modRujukanBpjs, 'nama_perujuk')?>").val(nama_perujuk);
    $("#PPPasienM_alamat_pasien").blur();
        
}

function getPPK(obj) {
    var id = $(obj).val();
    $("#<?php echo CHtml::activeId($modSep, 'ppkrujukan')?>").val("");
    if(id != ''){
        $.post('<?php echo $this->createUrl('getPPKRujukan'); ?>', {rujukan_id: id}, function(data) {
            $("#<?php echo CHtml::activeId($modSep, 'ppkrujukan')?>").val(data);
        });
    }
}

/**
 * menambahkan asal rujukan
 * @returns {Boolean}
 */
function addAsalRujukan()
{
    $.ajax({
       type:'POST',
       url:'<?php echo $this->createUrl('/sistemAdministrator/AsalRujukanM/addAsalRujukan'); ?>',
       data: $(this).serialize(),
       dataType: "json",
       success:function(data){
            if (data.status == 'create_form')
            {
                $('#dialogAddAsalRujukan div.divForFormAsalRujukan').html(data.div);
                $('#dialogAddAsalRujukan div.divForFormAsalRujukan form').submit(addAsalRujukan);
            }
            else
            {
                $('#dialogAddAsalRujukan div.divForFormAsalRujukan').html(data.div);
                $('#PPRujukanT_asalrujukan_id').html(data.asalrujukan);
                setTimeout("$('#dialogAddAsalRujukan').dialog('close')",1000);
            }
       },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
    return false; 
}
/**
 * menambahkan rujukan dari
 * @returns {Boolean}
 */
function addRujukanDari()
{
    $.ajax({
       type:'POST',
       url:'<?php echo $this->createUrl('/sistemAdministrator/RujukandariM/addRujukanDari'); ?>',
       data: $(this).serialize(),
       dataType: "json",
       success:function(data){
            if (data.status == 'create_form')
            {
                $('#dialogAddRujukanDari div.divForFormRujukanDari').html(data.div);
                $('#dialogAddRujukanDari div.divForFormRujukanDari form').submit(addRujukanDari);
            }
            else
            {
                $('#dialogAddRujukanDari div.divForFormRujukanDari').html(data.div);
                $('#PPRujukanT_nama_perujuk').html(data.namarujukan);
                $('#PPRujukanT_rujukandari_id').html(data.namarujukan);
                setTimeout("$('#dialogAddRujukanDari').dialog('close'); $('.rujukandari_id').change(); ",1000);
            }
       },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
    return false; 
}
/**
 * menambah data propinsi
 * @returns {Boolean} */
function addPropinsi()
{
    $.ajax({
       type:'POST',
       url:'<?php echo $this->createUrl('/sistemAdministrator/PropinsiM/addPropinsi'); ?>',
       data: $(this).serialize(),
       dataType: "json",
       success:function(data){
            if (data.status == 'create_form')
            {
                $('#dialog-addpropinsi div.dialog-content').html(data.div);
                $('#dialog-addpropinsi div.dialog-content form').submit(addPropinsi);
            }
            else
            {
                $('#dialog-addpropinsi div.dialog-content').html(data.div);
                $('#PPPasienM_propinsi_id').html(data.propinsi);
                setTimeout("$('#dialog-addpropinsi').dialog('close')",1000);
            }
       },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
    return false; 
}
/**
 * menambah data Kabupaten 
 * @returns {Boolean} */
function addKabupaten()
{
    $.ajax({
       type:'POST',
       url:'<?php echo $this->createUrl('/sistemAdministrator/KabupatenM/addKabupaten'); ?>',
       data: $(this).serialize(),
       dataType: "json",
       success:function(data){
            if (data.status == 'create_form')
            {
                $('#dialog-addkabupaten div.dialog-content').html(data.div);
                $('#dialog-addkabupaten div.dialog-content form').submit(addKabupaten);
            }
            else
            {
                $('#dialog-addkabupaten div.dialog-content').html(data.div);
                $('#PPPasienM_kabupaten_id').html(data.kabupaten);
                setTimeout("$('#dialog-addkabupaten').dialog('close')",1000);
            }
       },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
    
    return false; 
}
/**
 * Menambah data Kecamatan
 * @returns {Boolean} */
function addKecamatan()
{
    $.ajax({
       type:'POST',
       url:'<?php echo $this->createUrl('/sistemAdministrator/KecamatanM/addKecamatan'); ?>',
       data: $(this).serialize(),
       dataType: "json",
       success:function(data){
            if (data.status == 'create_form')
            {
                $('#dialogAddKecamatan div.dialog-content').html(data.div);
                $('#dialogAddKecamatan div.dialog-content form').submit(addKecamatan);
            }
            else
            {
                $('#dialogAddKecamatan div.dialog-content').html(data.div);
                $('#PPPasienM_kecamatan_id').html(data.kecamatan);
                setTimeout("$('#dialogAddKecamatan').dialog('close')",1000);
            }
       },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
    
    return false; 
}

function addKelurahan()
{
    $.ajax({
       type:'POST',
       url:'<?php echo $this->createUrl('/sistemAdministrator/KelurahanM/addKelurahan'); ?>',
       data: $(this).serialize(),
       dataType: "json",
       success:function(data){
            if (data.status == 'create_form')
            {
                $('#dialog-addkelurahan div.dialog-content').html(data.div);
                $('#dialog-addkelurahan div.dialog-content form').submit(addKelurahan);
            }
            else
            {
                $('#dialog-addkelurahan div.dialog-content').html(data.div);
                $('#PPPasienM_kelurahan_id').html(data.kelurahan);
                setTimeout("$('#dialog-addkelurahan').dialog('close')",1000);
            }
       },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
    
    return false; 
}
/**
 * set antrian ruangan
 * @param {type} obj
 * @returns {undefined} */
function setAntrianRuangan(){
    var ruangan_id = $("#<?php echo CHtml::activeId($model, 'ruangan_id') ?>").val();
    var pegawai_id = $("#<?php echo CHtml::activeId($model, 'pegawai_id') ?>").val();
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('SetAntrianRuangan'); ?>',
        data: {ruangan_id:ruangan_id, pegawai_id:pegawai_id},
        dataType: "json",
        success:function(data){
            $('#max-antrian-ruangan').val(null);
            $('#jam_awal').val(null);
            $('#jam_tutup').val(null);
            $('#jam_awal_a').val(null);
            $('#jam_tutup_a').val(null);
            $('#nama_ruangan').val(null);
            if(data.maxantrianruangan != null){
                if(data.no_urutantri > data.maxantrianruangan){
                    myAlert("Pasien Sudah Mencapai Maksimal Antrian Poliklinik "+data.maxantrianruangan+" Pasien"); 
			$("#<?php echo CHtml::activeId($model,'ruangan_id');?>").val("");
                }
                
                $('#max-antrian-ruangan').val(data.maxantrianruangan);
                $('#jam_awal').val(data.jammulai);
                $('#jam_tutup').val(data.jamtutup);
                $('#jam_awal_a').val(data.jammulai_a);
                $('#jam_tutup_a').val(data.jamtutup_a);
                $('#nama_ruangan').val(data.nama_ruangan);
                
            }else{
                $('#max-antrian-ruangan').val(0);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}
/**
 * set antrian ruangan
 * @param {type} obj
 * @returns {undefined} */
function setAntrianDokter(ruangan_id){
    var ruangan_id = $("#<?php echo CHtml::activeId($model, 'ruangan_id') ?>").val();
    var pegawai_id = $("#<?php echo CHtml::activeId($model, 'pegawai_id') ?>").val();
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('SetAntrianDokter'); ?>',
        data: {ruangan_id:ruangan_id, pegawai_id:pegawai_id},
        dataType: "json",
        success:function(data){
             $('#max-antrian-dokter').val(data.maxantriandokter);
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}
<?php if(Yii::app()->user->getState('isbridging')==TRUE){ ?>
/**
 * set form asuransi 
 * @returns {undefined} */
function setFormAsuransi(carabayar_id){
    $('.cek_sep').hide();
    $("#<?php echo CHtml::activeId($model,'is_langsung_briging') ?>").prop("checked", false);
    sembunyiNoRujukan();
    var carabayar_id_umum = <?php echo Params::CARABAYAR_ID_MEMBAYAR;?>;
    var carabayar_id_bpjs = <?php echo Params::CARABAYAR_ID_BPJS;?>;
    var carabayar_id_badak = <?php echo Params::CARABAYAR_ID_BADAK;?>;
    var carabayar_id_departemen = <?php echo Params::CARABAYAR_ID_DEP_BADAK;?>;
    var carabayar_id_pekerja = <?php echo Params::CARABAYAR_ID_PEKERJA;?>;
    var carabayar_id_jamkespa = <?php echo Params::CARABAYAR_ID_JAMKESPA;?>;
    var carabayar_id_asuransi = <?php echo Params::CARABAYAR_ID_ASURANSI; ?>
    
    /*Form inhealth harus selalu disabled/tutup saat ubah dropdown Jenis Penjamin*/
    sembunyiInhealth();
    $('#form-inhealth').hide();
    
    if(carabayar_id == carabayar_id_umum){
		sembunyiFormAsuBadak();
		sembunyiFormAsuDepartemen();
		sembunyiFormAsuPekerja();
		
        sembunyiFormAsuransi();
        sembunyiFormBpjs();
        sembunyiFormAsuransi();

        $('#form-bpjs').hide(); 
        $('#form-asuransi').hide(); 
        $('#form-rujukan').show();
        tampilFormRujukan();
		$('#form-asubadak').hide();
		$('#form-asudepartemen').hide();
		$('#form-asupekerja').hide();
    }else if(carabayar_id == carabayar_id_bpjs){
        
                var noTelp = $("#<?php echo CHtml::activeId($modPasien,'no_mobile_pasien');?>").val();
                if(noTelp.length < 8){
                    myAlert("No mobile pasien minimal diisi 8 digit untuk syarat SEP");
                    $("#<?php echo CHtml::activeId($modPasien,'no_mobile_pasien');?>").focus();
                }
                
		sembunyiFormAsuBadak();
		sembunyiFormAsuDepartemen();
		sembunyiFormAsuPekerja();
		var pasien_id = $("#<?php echo CHtml::activeId($modPasien,'pasien_id') ?>").val();
                if(pasien_id != ''){ //briging berjalan jika no RM/pasien sudah ada ini untuk pasien lama
                    $('.cek_sep').show();
                    sembunyiFormAsuransi();
                    sembunyiFormBpjs();
                    $('#form-bpjs').hide(); 
                    $('#form-asuransi').show();
                    /*Start - Default briging tercentang*/
                    $("#<?php echo CHtml::activeId($model,'is_langsung_briging') ?>").prop("checked", true);
                    setCreateSep($("#<?php echo CHtml::activeId($model,'is_langsung_briging') ?>"));
                    /*End*/
                }else{
                    $('.cek_sep').hide();
                    sembunyiFormAsuransi();
                    sembunyiFormBpjs();
                    $('#form-bpjs').hide(); 
                    $('#form-asuransi').show();
                }
                        
        $('#form-rujukan').hide(); 
        sembunyiFormRujukan();
        $('#form-asubadak').hide();
        $('#form-asudepartemen').hide();
    }else if(carabayar_id == carabayar_id_badak){
		tampilFormAsuBadak();
		sembunyiFormAsuDepartemen();
		sembunyiFormAsuPekerja();
		
		sembunyiFormBpjs();
        sembunyiFormAsuransi();
        sembunyiFormRujukan();
		
		$('#form-asubadak').show();
        $('#form-asuransi').hide();
        $('#form-bpjs').hide(); 
        $('#form-rujukan').hide(); 
		$('#form-asudepartemen').hide();
		$('#form-asupekerja').hide();
    }else if(carabayar_id == carabayar_id_departemen){
		sembunyiFormAsuBadak();
		tampilFormAsuDepartemen();
		sembunyiFormAsuPekerja();
		
		sembunyiFormBpjs();
        sembunyiFormAsuransi();
        sembunyiFormRujukan();
		
		$('#form-asudepartemen').show();
		$('#form-asubadak').hide();
        $('#form-asuransi').hide();
        $('#form-bpjs').hide(); 
        $('#form-rujukan').hide(); 
		$('#form-asupekerja').hide();
    }else if(carabayar_id == carabayar_id_pekerja){
		sembunyiFormAsuBadak();
		sembunyiFormAsuDepartemen();
		tampilFormAsuPekerja();
		
		sembunyiFormBpjs();
        sembunyiFormAsuransi();
        sembunyiFormRujukan();
		
		$('#form-asupekerja').show();
		$('#form-asudepartemen').hide();
		$('#form-asubadak').hide();
        $('#form-asuransi').hide();
        $('#form-bpjs').hide(); 
        $('#form-rujukan').hide(); 
    } else if (carabayar_id == carabayar_id_jamkespa) {
        sembunyiFormAsuBadak();
        sembunyiFormAsuDepartemen();
        sembunyiFormAsuPekerja();
        tampilFormAsuransi();
        sembunyiFormBpjs();
        $('#form-bpjs').hide(); 
        $('#form-asuransi').show(); 
        $('#form-rujukan').show();
        tampilFormRujukan();
        $('#form-asubadak').hide();
        $('#form-asudepartemen').hide();
        $('#form-asupekerja').hide();
        cekTanggalKonfirmasi();
    } else if (carabayar_id == carabayar_id_asuransi){
        sembunyiFormAsuBadak();
        sembunyiFormAsuDepartemen();
        sembunyiFormAsuPekerja();
        tampilFormAsuransi();
        sembunyiFormBpjs();
        $('#form-bpjs').hide(); 
        $('#form-asuransi').show(); 
        $('#form-rujukan').show();
        tampilFormRujukan();
        $('#form-asubadak').hide();
        $('#form-asudepartemen').hide();
        $('#form-asupekerja').hide();
        cekTanggalKonfirmasi();
    }else{
		sembunyiFormAsuBadak();
		sembunyiFormAsuDepartemen();
		sembunyiFormAsuPekerja();
		sembunyiFormAsuransi();
                //tampilFormAsuransi();
                sembunyiFormBpjs();
                $('#form-bpjs').hide(); 
                $('#form-asuransi').show(); 
                $('#form-rujukan').show();
                tampilFormRujukan();
		$('#form-asubadak').hide();
		$('#form-asudepartemen').hide();
		$('#form-asupekerja').hide();
                cekTanggalKonfirmasi();
    }
    cekJamkespa();
    $("#PPPasienM_alamat_pasien").blur();
        
}
<?php }else{ ?>
/**
 * set form asuransi 
 * @returns {undefined} */
function setFormAsuransi(carabayar_id){
    
    /*Form inhealth harus selalu disabled/tutup saat ubah dropdown Jenis Penjamin*/
    sembunyiInhealth();
    $('#form-inhealth').hide();
    
    sembunyiNoRujukan();
    var carabayar_id_umum = <?php echo Params::CARABAYAR_ID_MEMBAYAR;?>;
    var carabayar_id_bpjs = <?php echo Params::CARABAYAR_ID_BPJS;?>;
    if(carabayar_id == carabayar_id_umum){
        sembunyiFormAsuransi();
        cekJamkespa();
    }else if(carabayar_id == carabayar_id_bpjs){
        tampilNoRujukan();
        tampilFormAsuransi();
    }else{
        tampilFormAsuransi();
        cekJamkespa();
    }
    $("#PPPasienM_alamat_pasien").blur();
        
}
<?php } ?>

function setFormAsuransiInhealth(penjamin_id){
    var penjamin_id_umum = <?php echo Params::PENJAMIN_ID_UMUM;?>;
    var penjamin_id_inhealth = <?php echo Params::PENJAMIN_ID_INHEALTH;?>;
    var penjamin_id_bpjs1 = <?php echo Params::PENJAMIN_ID_BPJS_KESEHATAN;?>;
    var penjamin_id_bpjs2 = <?php echo Params::PENJAMIN_ID_BPJS_KETENAGAKERJAAN;?>;
    var pasien_id = $("#<?php echo CHtml::activeId($modPasien,'pasien_id') ?>").val();
    
    sembunyiInhealth();
    $('#form-inhealth').hide();
    tampilFormAsuransi();
    $('#form-asuransi').show();
    
    if(penjamin_id == penjamin_id_umum){
        sembunyiFormAsuransi();
        $('#form-asuransi').hide();
    }

    if(penjamin_id==penjamin_id_inhealth){
        <?php if(Yii::app()->user->getState('bridging_inhealth')==TRUE){ ?>
            sembunyiFormAsuransi();
            $('#form-asuransi').hide();
            
            if(pasien_id != ''){ //briging berjalan jika no RM/pasien sudah ada ini untuk pasien lama
                tampilInhealth();
                $('#form-inhealth').show();
            }
        <?php } ?>
    }else{
        if(penjamin_id==penjamin_id_bpjs1 || penjamin_id==penjamin_id_bpjs2){
            <?php if(Yii::app()->user->getState('isbridging')==TRUE){ ?>
                setCreateSep($("#PPPendaftaranT_is_langsung_briging"));
            <?php } ?>
        }
    }
    $("#PPPasienM_alamat_pasien").blur();
        
}

function tampilFormPegawai(){
        $('#form-pegawai > .accordion-group > .accordion-heading').find(".btn").addClass("btn-primary");
        $('#form-pegawai > .accordion-group > .accordion-heading').find(".icon-minus").addClass("icon-ok").removeClass("icon-minus");
        $('#content-pegawai').removeClass().addClass("accordion-body in collapse");
        $('#content-pegawai').find(".not-required").addClass("required").removeClass("not-required");
        $('#content-pegawai').removeAttr("style").attr("style","height:auto"); 
        $('#content-pegawai').find("input,select,textarea").removeAttr("disabled");
        $("#PPPasienM_alamat_pasien").blur();
        
}

function sembunyiFormPegawai(){
        $('#content-pegawai').find(".required").addClass("not-required").removeClass("required");
        $('#form-pegawai > .accordion-group > .accordion-heading').find(".btn").removeClass("btn-primary");
        $('#form-pegawai > .accordion-group > .accordion-heading').find(".icon-ok").addClass("icon-minus").removeClass("icon-ok");
        $('#content-pegawai').removeClass().addClass("accordion-body collapse");
        $('#content-pegawai').removeAttr("style").attr("style","height:0px");  
        $('#content-pegawai').find("input,select,textarea").attr("disabled",true); 
        $("#PPPasienM_alamat_pasien").blur();
        
}

function sembunyiFormAsuransi(){
        $('#content-asuransi').find(".required").addClass("not-required").removeClass("required");
        $('#form-asuransi > .accordion-group > .accordion-heading').find(".btn").removeClass("btn-primary");
        $('#form-asuransi > .accordion-group > .accordion-heading').find(".icon-ok").addClass("icon-minus").removeClass("icon-ok");
        $('#content-asuransi').removeClass().addClass("accordion-body collapse");
        $('#content-asuransi').removeAttr("style").attr("style","height:0px");  
        $('#content-asuransi').find("input,select,textarea").attr("disabled",true); 
        $("#PPPasienM_alamat_pasien").blur();
        
}
function tampilFormAsuransi(){
        $('#form-asuransi > .accordion-group > .accordion-heading').find(".btn").addClass("btn-primary");
        $('#form-asuransi > .accordion-group > .accordion-heading').find(".icon-minus").addClass("icon-ok").removeClass("icon-minus");
        $('#content-asuransi').removeClass().addClass("accordion-body in collapse");
        $('#content-asuransi').find(".not-required").addClass("required").removeClass("not-required");
        $('#content-asuransi').removeAttr("style").attr("style","height:auto"); 
        $('#content-asuransi').find("input,select,textarea").removeAttr("disabled");
        $("#<?php echo CHtml::activeId($modAsuransiPasien, "status_konfirmasi"); ?>").prop("checked", true);
        carabayar_id = $("#PPPendaftaranT_carabayar_id").val();
        carabayar_id_ri = $("#PPPasienAdmisiT_carabayar_id").val();
        $("#PPPasienM_alamat_pasien").blur();
        

//        if (carabayar_id=='<?php echo Params::CARABAYAR_ID_BPJS;?>' || carabayar_id_ri=='<?php echo Params::CARABAYAR_ID_BPJS;?>') {
//            $('#content-asuransi').find(".norujukan").addClass("required");
//            $('#content-asuransi').find(".norujukan").show();
//            $('#content-asuransi').find(".rujukan").show();
//        } else {
//            $('#content-asuransi').find(".norujukan").removeClass("required");
//            $('#content-asuransi').find(".norujukan").hide();
//            $('#content-asuransi').find(".rujukan").hide();
//        }
}
function sembunyiFormAsuBadak(){
        $('#content-asubadak').find(".required").addClass("not-required").removeClass("required");
        $('#form-asubadak > .accordion-group > .accordion-heading').find(".btn").removeClass("btn-primary");
        $('#form-asubadak > .accordion-group > .accordion-heading').find(".icon-ok").addClass("icon-minus").removeClass("icon-ok");
        $('#content-asubadak').removeClass().addClass("accordion-body collapse");
        $('#content-asubadak').removeAttr("style").attr("style","height:0px");  
        $('#content-asubadak').find("input,select,textarea").attr("disabled",true); 
        $("#PPPasienM_alamat_pasien").blur();
        
}
function tampilFormAsuBadak(){
        $('#form-asubadak > .accordion-group > .accordion-heading').find(".btn").addClass("btn-primary");
        $('#form-asubadak > .accordion-group > .accordion-heading').find(".icon-minus").addClass("icon-ok").removeClass("icon-minus");
        $('#content-asubadak').removeClass().addClass("accordion-body in collapse");
        $('#content-asubadak').find(".not-required").addClass("required").removeClass("not-required");
        $('#content-asubadak').removeAttr("style").attr("style","height:auto"); 
        $('#content-asubadak').find("input,select,textarea").removeAttr("disabled");
        $("#PPPasienM_alamat_pasien").blur();
        
}
function sembunyiFormAsuDepartemen(){
        $('#content-asudepartemen').find(".required").addClass("not-required").removeClass("required");
        $('#form-asudepartemen > .accordion-group > .accordion-heading').find(".btn").removeClass("btn-primary");
        $('#form-asudepartemen > .accordion-group > .accordion-heading').find(".icon-ok").addClass("icon-minus").removeClass("icon-ok");
        $('#content-asudepartemen').removeClass().addClass("accordion-body collapse");
        $('#content-asudepartemen').removeAttr("style").attr("style","height:0px");  
        $('#content-asudepartemen').find("input,select,textarea").attr("disabled",true); 
        $("#PPPasienM_alamat_pasien").blur();
        
}
function tampilFormAsuDepartemen(){
        $('#form-asudepartemen > .accordion-group > .accordion-heading').find(".btn").addClass("btn-primary");
        $('#form-asudepartemen > .accordion-group > .accordion-heading').find(".icon-minus").addClass("icon-ok").removeClass("icon-minus");
        $('#content-asudepartemen').removeClass().addClass("accordion-body in collapse");
        $('#content-asudepartemen').find(".not-required").addClass("required").removeClass("not-required");
        $('#content-asudepartemen').removeAttr("style").attr("style","height:auto"); 
        $('#content-asudepartemen').find("input,select,textarea").removeAttr("disabled");
        $("#PPPasienM_alamat_pasien").blur();
        
}
function sembunyiFormAsuPekerja(){
        $('#content-asupekerja').find(".required").addClass("not-required").removeClass("required");
        $('#form-asupekerja > .accordion-group > .accordion-heading').find(".btn").removeClass("btn-primary");
        $('#form-asupekerja > .accordion-group > .accordion-heading').find(".icon-ok").addClass("icon-minus").removeClass("icon-ok");
        $('#content-asupekerja').removeClass().addClass("accordion-body collapse");
        $('#content-asupekerja').removeAttr("style").attr("style","height:0px");  
        $('#content-asupekerja').find("input,select,textarea").attr("disabled",true); 
        $("#PPPasienM_alamat_pasien").blur();
        
}
function tampilFormAsuPekerja(){
        $('#form-asupekerja > .accordion-group > .accordion-heading').find(".btn").addClass("btn-primary");
        $('#form-asupekerja > .accordion-group > .accordion-heading').find(".icon-minus").addClass("icon-ok").removeClass("icon-minus");
        $('#content-asupekerja').removeClass().addClass("accordion-body in collapse");
        $('#content-asupekerja').find(".not-required").addClass("required").removeClass("not-required");
        $('#content-asupekerja').removeAttr("style").attr("style","height:auto"); 
        $('#content-asupekerja').find("input,select,textarea").removeAttr("disabled");
  
}
function sembunyiFormBpjs(){
        $('#content-bpjs').find(".required").addClass("not-required").removeClass("required");
        $('#form-bpjs > .accordion-group > .accordion-heading').find(".btn").removeClass("btn-primary");
        $('#form-bpjs > .accordion-group > .accordion-heading').find(".icon-ok").addClass("icon-minus").removeClass("icon-ok");
        $('#content-bpjs').removeClass().addClass("accordion-body collapse");
        $('#content-bpjs').removeAttr("style").attr("style","height:0px");  
        $('#content-bpjs').find("input,select,textarea").attr("disabled",true); 
        var is_bpjs = $("#<?php echo CHtml::activeId($model, "is_bpjs"); ?>");
        is_bpjs.val(0);
        $("#PPPasienM_alamat_pasien").blur();
        
}
function tampilFormBpjs(){
        $('#form-bpjs > .accordion-group > .accordion-heading').find(".btn").addClass("btn-primary");
        $('#form-bpjs > .accordion-group > .accordion-heading').find(".icon-minus").addClass("icon-ok").removeClass("icon-minus");
        $('#content-bpjs').removeClass().addClass("accordion-body in collapse");
        $('#content-bpjs').find(".not-required").addClass("required").removeClass("not-required");
        $('#content-bpjs').removeAttr("style").attr("style", "height:auto");
        $('#content-bpjs').find("input,select,textarea").removeAttr("disabled");
        $('#content-bpjs').find(".nosep").attr("readonly", true);
        setLakaLantas($('input:radio[name="PPSepT[lakalantas]"]:checked'));
        var is_bpjs = $("#<?php echo CHtml::activeId($model, "is_bpjs"); ?>");
        is_bpjs.val(1);
        $("#PPPasienM_alamat_pasien").blur();
        
}
/*function sembunyiFormRujukan(){
        $('#form-bpjs > .accordion-group > .accordion-heading').find(".btn").addClass("btn-primary");
        $('#form-bpjs > .accordion-group > .accordion-heading').find(".icon-minus").addClass("icon-ok").removeClass("icon-minus");
        $('#content-bpjs').removeClass().addClass("accordion-body in collapse");
        $('#content-bpjs').find(".not-required").addClass("required").removeClass("not-required");
        $('#content-bpjs').removeAttr("style").attr("style", "height:auto");
        $('#content-bpjs').find("input,select,textarea").removeAttr("disabled");
        $('#content-bpjs').find(".nosep").attr("readonly", true);
        setLakaLantas($('input:radio[name="PPSepT[lakalantas]"]:checked'));
        var is_bpjs = $("#<?php echo CHtml::activeId($model, "is_bpjs"); ?>");
        is_bpjs.val(1);
}*/
function sembunyiFormRujukan(){
        $('#form-rujukan > .accordion-group > .accordion-heading').find(".btn").addClass("btn-primary");
        $('#form-rujukan > .accordion-group > .accordion-heading').find(".icon-minus").addClass("icon-ok").removeClass("icon-minus");
        $('#content-rujukan').removeClass().addClass("accordion-body in collapse");
        $('#content-rujukan').find(".required").addClass("not-required").removeClass("required");
        $('#content-rujukan').removeAttr("style").attr("style","height:auto"); 
        $('#content-rujukan').find("input,select,textarea").attr("disabled", true);
        var is_pasienrujukan = $("#<?php echo CHtml::activeId($model, "is_pasienrujukan"); ?>");
        is_pasienrujukan.val(0);
        $("#PPPasienM_alamat_pasien").blur();
        
}
function tampilFormRujukan(){
        $('#form-rujukan > .accordion-group > .accordion-heading').find(".btn").addClass("btn-primary");
        $('#form-rujukan > .accordion-group > .accordion-heading').find(".icon-minus").addClass("icon-ok").removeClass("icon-minus");
        $('#content-rujukan').removeClass().addClass("accordion-body in collapse");
        $('#content-rujukan').find(".not-required").addClass("required").removeClass("not-required");
        $('#content-rujukan').removeAttr("style").attr("style","height:auto"); 
        $('#content-rujukan').find("input,select,textarea").removeAttr("disabled"); 
        var is_pasienrujukan = $("#<?php echo CHtml::activeId($model, "is_pasienrujukan"); ?>");
        is_pasienrujukan.val(1);
        $("#PPPasienM_alamat_pasien").blur();
        
}
function tampilNoRujukan(){
    $('#rujukan-nomor').find(".not-required").addClass("required").removeClass("not-required");
    $('#rujukan-nomor').find("input,select,textarea").removeAttr("disabled"); 
    $('.rujukan').show();
    $("#PPPasienM_alamat_pasien").blur();
        
}
function sembunyiNoRujukan(){
    $('#rujukan-nomor').find(".required").addClass("not-required").removeClass("required");
    $('#rujukan-nomor').find("input,select,textarea").removeAttr("disabled");
    $('.rujukan').hide();
    $("#PPPasienM_alamat_pasien").blur();
        
}
function tampilInhealth(){
    $('#form-inhealth > .accordion-group > .accordion-heading').find(".btn").addClass("btn-primary");
    $('#form-inhealth > .accordion-group > .accordion-heading').find(".icon-minus").addClass("icon-ok").removeClass("icon-minus");
    $('#content-inhealth').removeClass().addClass("accordion-body in collapse");
    $('#content-inhealth').find(".not-required").addClass("required").removeClass("not-required");
    $('#content-inhealth').removeAttr("style").attr("style", "height:auto");
    $('#content-inhealth').find("input,select,textarea").removeAttr("disabled");
    $('#content-inhealth').find(".nosep").attr("readonly", true);
    $("#PPPasienM_alamat_pasien").blur();
        
}
function sembunyiInhealth(){
    $('#content-inhealth').find(".required").addClass("not-required").removeClass("required");
    $('#form-inhealth > .accordion-group > .accordion-heading').find(".btn").removeClass("btn-primary");
    $('#form-inhealth > .accordion-group > .accordion-heading').find(".icon-ok").addClass("icon-minus").removeClass("icon-ok");
    $('#content-inhealth').removeClass().addClass("accordion-body collapse");
    $('#content-inhealth').removeAttr("style").attr("style","height:0px");  
    $('#content-inhealth').find("input,select,textarea").attr("disabled",true); 
    $("#PPPasienM_alamat_pasien").blur();
        
}

function cekJamkespa() {
    if ($("#<?php echo CHtml::activeId((!empty($modPasienAdmisi)?$modPasienAdmisi:$model), "carabayar_id"); ?>").val() == 18) {
        // $(".jks_spec").addClass("not-required").removeClass("required").parents(".control-group").hide();
        $("#<?php echo CHtml::activeId($modAsuransiPasien, "nopeserta"); ?>").val($("#<?php echo CHtml::activeId($modPasien, "no_rekam_medik"); ?>").val());
        $("#<?php echo CHtml::activeId($modAsuransiPasien, "nokartuasuransi"); ?>").val($("#<?php echo CHtml::activeId($modPasien, "no_rekam_medik"); ?>").val());
        $("#<?php echo CHtml::activeId($modAsuransiPasien, "namapemilikasuransi"); ?>").val($("#<?php echo CHtml::activeId($modPasien, "nama_pasien"); ?>").val());
        $("#<?php echo CHtml::activeId($modAsuransiPasien, "kelastanggunganasuransi_id"); ?>").val(<?php echo Params::KELASPELAYANAN_ID_KELAS_III; ?>);
        $(".rb_kon").eq(0).change();
    } else {
        //$(".jks_spec").parents(".control-group").show();
        //$(".jks_spec").removeClass("not-required").addClass("required").parents(".control-group").show();
        $("#<?php echo CHtml::activeId($modAsuransiPasien, "nopeserta"); ?>").val("");
        $("#<?php echo CHtml::activeId($modAsuransiPasien, "nokartuasuransi"); ?>").val("");
        $("#<?php echo CHtml::activeId($modAsuransiPasien, "namapemilikasuransi"); ?>").val("");
        $("#<?php echo CHtml::activeId($modAsuransiPasien, "kelastanggunganasuransi_id"); ?>").val("");
    }
    $("#PPPasienM_alamat_pasien").blur();
        
}

/**
 * pilih karcis (check - uncheck)
 * harus pilih salah satu
 * @param {type} obj
 * @returns {undefined} */
function pilihKarcis(obj){
    var is_pilihtindakan = $(obj).parents('tr').find('input[name$="[is_pilihtindakan]"]');
	/*
    $(obj).parents('table').find('tr').each(function(){
        $(this).find('input[name$="[is_pilihtindakan]"]').val(0);
        $(this).removeClass('checked');
		$(this).find('i').removeClass('icon-form-silang');
		$(this).find('i').addClass('icon-form-check');
    });
    */
	
    if(is_pilihtindakan.val() > 0){
        is_pilihtindakan.val(0);
        $(obj).parents('tr').removeClass('checked');
		$(obj).children('i').removeClass('icon-form-check');
		$(obj).children('i').addClass('icon-form-silang');
    }else{
        is_pilihtindakan.val(1);
        $(obj).parents('tr').addClass('checked');
		$(obj).children('i').removeClass('icon-form-silang');
		$(obj).children('i').addClass('icon-form-check');
    }
    $("#PPPasienM_alamat_pasien").blur();
        
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
function setVerifikasi(){
    
    $(".nik").removeClass('error');
    $(".nik").parents(".control-group").removeClass('error');
    $(".nik_pj").removeClass('error');
    $(".nik_pj").parents(".control-group").removeClass('error');
    $(".nama_ibu").removeClass('error');
    $(".nama_ibu").parents(".control-group").removeClass('error');
    
    
    
    if(requiredCheck($("form"))){
        //Komen karena Issue RSST-873
        /*if ($(".rb_rm").eq(1).is(":checked")) {
            if ($("#no_rekam_medik_baru").val().trim() == '') {
                myAlert("No. Rekam Medik harus diisi");
                return false;
            }else if($("#no_rekam_medik_baru").val().trim().length != 8 ){
                myAlert("No. Rekam Medik harus berisi 8 digit angka");
                return false;
            }
        }*/
        
        
        if (!cekNoIdentitas()) return false;
        if (!cekNoIdentitasPJ()) return false;
        // if (!cekIbu()) return false;
//		if (!cekNoAsuransiBpjs()) return false;

        carabayar = $("#PPPendaftaranT_carabayar_id").val();
        carabayarAdmisi = $("#PPPasienAdmisiT_carabayar_id").val();
        var noTelp = $("#<?php echo CHtml::activeId($modPasien,'no_mobile_pasien');?>").val();
        if(carabayar == '<?php echo Params::CARABAYAR_ID_BPJS; ?>' || carabayarAdmisi == '<?php echo Params::CARABAYAR_ID_BPJS; ?>'){
            if(noTelp.length < 8){
                myAlert("No mobile pasien minimal diisi 8 digit untuk syarat SEP");
                $("#<?php echo CHtml::activeId($modPasien,'no_mobile_pasien');?>").focus();
                return false;
            }
        }
        
        $.post('<?php echo $this->createUrl('validasiPasien'); ?>', $("form").serialize(), function(data) {
            if (data.ok == 1) {                
				$('#dialog-verifikasi').dialog("open");
                $.ajax({
                   type:'POST',
                   url:'<?php echo $this->createUrl('verifikasi'); ?>',
                   data: $("form").serialize(),
                   dataType: "json",
                   success:function(data){
						if (data.ok == 1){							
							$('#dialog-verifikasi > .dialog-content').html(data.content);
						}else{
							$('#dialog-verifikasi > .dialog-content').html('');
							$('#dialog-verifikasi').dialog("close");
							alert(data.msg);
						}
                   },
                    error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown); }
                });
                //untuk verifikasi hilangkan srbac loading
                $(".animation-loading").removeClass("animation-loading");
                $("form").find('.float').each(function(){
                    $(this).val(formatFloat($(this).val()));
                });
                $("form").find('.integer').each(function(){
                    $(this).val(formatInteger($(this).val()));
                });
            } else {				
				myAlert(data.msg);				
            }
        }, 'json');
    }
    
    return false;
}

/**
 * Validasi input Nama Ibu nermama 'IBU'
 * 
 * @returns {Boolean} true jika selain bernama 'IBU', false jika sebaliknya. */
function cekIbu() {
    
    var nama_ibu = $(".nama_ibu").val().trim().toLowerCase();
    
    if (nama_ibu == 'ibu') {
        $(".nama_ibu").addClass('error');
        $(".nama_ibu").parents(".control-group").addClass('error');
        $(".nama_ibu")[0].focus();
        myAlert("Nama Ibu Tidak boleh diisi dengan nama 'IBU'");
        return false;
    }

}

/**
* @author Deni Hamdani <denihamdani@piindonesia.co.id>
* 
* Validasi nomor Identitas pada Panel Pasien.  Validasinya berupa Pengecekan Ada 
* tidaknya Jenis identitas, kemudian Jika pasien-nya 17 tahun keatas dan ber KTP 
* maka dilakukan validasi jumlah digit pada KTP, dan kemudian periksa pengulangan angka di awal. 

 * @returns {Boolean} Data-nya sudah divalidasikan, false jika tidak */
function cekNoIdentitas() {
    
    var jenis = null;
    var nomor = null;
    var umur = 1;
        
    $(".jenisidentitas").removeClass('error');    
    $(".jenisidentitas").parents(".control-group").removeClass('error');    
        
        
    if ($(".jenisidentitas").val() == "") {
        
        <?php 
        // rawat darurat tidak mandatory
        if (strtolower($this->id) == 'pendaftaranrawatdarurat'): ?>
                   
        console.log("RD");           
        return true;
        
        <?php else: ?>
        
        console.log("RJ");
        
        
        $(".jenisidentitas").addClass('error');
        $(".jenisidentitas").parents(".control-group").addClass('error');
        $(".jenisidentitas")[0].focus();
        myAlert("Masukkan Jenis Identitas");
        return false;
        
        <?php endif; ?>
    }
    
    jenis = $(".jenisidentitas").val();
    nomor = $(".nik").val().trim();
    
    // set umut
    if ($(".umur").val().trim() != null) {
        umur = $(".umur").val();
        umur = umur.split(" ");
        umur = umur[0];
    }
    
    console.log("KTP", umur, nomor);
    
    if (jenis.trim() == "KTP" && umur > 16) {
        
        
        if (nomor == "") {
            $(".nik").addClass('error');
            $(".nik").parents(".control-group").addClass('error');
            $(".nik")[0].focus();
            myAlert("Nomor KTP Harus Diisi.");
            return false;
            
        }
        
        if (nomor.length != 16) {
            $(".nik").addClass('error');
            $(".nik").parents(".control-group").addClass('error');
            $(".nik")[0].focus();
            myAlert("Nomor KTP harus diinput 16 digit.");
            return false;
        }
        
        if (!cekRendundansiNomor(nomor)) {
            $(".nik").addClass('error');
            $(".nik").parents(".control-group").addClass('error');
            $(".nik")[0].focus();
            myAlert("No KTP yang Anda masukan tidak sesuai. 4 digit diawal tidak boleh sama.");
            return false;
        }
    }
    
    return true;
}

/**
* @author Deni Hamdani <denihamdani@piindonesia.co.id>
* 
* Validasi nomor Identitas pada Panel Penanggunjawab Pasien (Jika aktif).  
* Validasinya berupa Pengecekan Ada tidaknya Jenis identitas, kemudian Jika 
* Pasien-nya 17 tahun keatas dan ber KTP maka dilakukan validasi jumlah digit 
* pada KTP, dan kemudian periksa pengulangan angka di awal. 

 * @returns {Boolean} Data-nya sudah divalidasikan, false jika tidak */
function cekNoIdentitasPJ() {
    
    if ($(".is_adapjpasien").val() != 1)
        return true;
    
    
    var jenis = null;
    var nomor = null;
    
    jenis = $(".jenisidentitas_pj").val();
    nomor = $(".nik_pj").val().trim();
    
    console.log("KTP",  nomor);
    
    if (jenis.trim() == "KTP") {
        
        
        if (nomor == "") {
            $(".nik_pj").addClass('error');
            $(".nik_pj").parents(".control-group").addClass('error');
            $(".nik_pj")[0].focus();
            myAlert("Nomor KTP Penanggung Jawab Harus Diisi.");
            return false;
            
        }
        
        if (nomor.length != 16) {
            $(".nik_pj").addClass('error');
            $(".nik_pj").parents(".control-group").addClass('error');
            $(".nik_pj")[0].focus();
            myAlert("Nomor KTP Penanggung Jawab harus diinput 16 digit.");
            return false;
        }
        
        if (!cekRendundansiNomor(nomor)) {
            $(".nik_pj").addClass('error');
            $(".nik_pj").parents(".control-group").addClass('error');
            $(".nik_pj")[0].focus();
            myAlert("No KTP Penanggung Jawab yang Anda masukan tidak sesuai. 4 digit diawal tidak boleh sama.");
            return false;
        }
    }
    
    return true;
}

function cekRendundansiNomor(nomor) {
    var redundant = 0;
    var arr_nomor = nomor.split("");
    var current_char = arr_nomor[0];
    
    for (var i = 0; i < arr_nomor.length; i++) {
        if (current_char != arr_nomor[i]) break;
        redundant++;    
    }
    
    return (redundant < 4);
}

/**
* tombol batal pada dialogbox
* @param {type} dialog_id
* @returns {undefined} 
*/
function batalDialog(dialog_id){
   if(confirm("Apakah Anda yakin akan membatalkan ini ?")) 
       $('#'+dialog_id).dialog("close");
}
/**
 * refresh daftar pasien rj
 * @returns {Boolean} */
function refreshDaftarPasien(){
        $.fn.yiiGridView.update('pendaftarterakhir-rj-grid', {
            data: $(this).serialize()
        });
        return false;
}
/**
 * set tabel riwayat kunjungan pasien
 * @param {type} pasien_id
 * @returns {undefined} */
function setRiwayatKunjunganPasien(pasien_id){
    $("#content-riwayatpasien > .accordion-inner").addClass("animation-loading");
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('SetRiwayatKunjunganPasien'); ?>',
        data: {pasien_id: pasien_id},
        dataType: "json",
        success:function(data){
            $("#content-riwayatpasien > .accordion-inner").html(data.table);
            $("#content-riwayatpasien > .accordion-inner").removeClass("animation-loading");
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}

/**
 * print kartu pasien
 */
function printKartuPasien()
{       
    window.open('<?php echo $this->createUrl('PendaftaranRawatJalan/printKartuPasien',array('pasien_id'=>$model->pasien_id)); ?>','printwin','left=100,top=100,width=480,height=640');
}
/**
 * print status
 */
function printStatus()
{
    window.open('<?php echo $this->createUrl('printStatus',array('pendaftaran_id'=>$model->pendaftaran_id)); ?>','printwin','left=100,top=100,width=860,height=480');
}
/**
 * print karcis
 */
function printKarcis()
{
    window.open('<?php echo $this->createUrl('printKarcis',array('pendaftaran_id'=>$model->pendaftaran_id)); ?>','printwin','left=100,top=100,width=480,height=640');
}

function autoPrint(){
    setTimeout(function(){window.scrollBy(0,768);},1000);
    <?php if(Yii::app()->user->getState('printkartulsng')==TRUE){ ?>
        printKartuPasien()
    <?php  } ?>
    <?php if(Yii::app()->user->getState('printkunjunganlsng')==TRUE){ ?>
        printStatus();
    <?php  } ?>
}

function printSEP(){
  window.open('<?php echo $this->createUrl('printSep',array('sep_id'=>$modSep->sep_id,'pendaftaran_id'=>$model->pendaftaran_id)); ?>','printwin','left=100,top=100,width=860,height=480');
}

function printSJP(){
  window.open('<?php echo $this->createUrl('printSjp',array('pendaftaran_id'=>$model->pendaftaran_id)); ?>','printwin','left=100,top=100,width=860,height=480');
}

function printLabel(){
  window.open('<?php echo $this->createUrl('printLabel',array('pendaftaran_id'=>$model->pendaftaran_id)); ?>','printwin','left=100,top=100,width=860,height=480');
}
/**
 * fungsi BPJS
 */
function getAsuransiNoKartu(isi, databpjs)
{   
    if (<?php echo (Yii::app()->user->getState('isbridging') == TRUE) ? 1 : 0; ?>) {
    } else {
            myAlert('Fitur Bridging tidak aktif!');
            return false;
    }
    if (isi == "") {
            myAlert('Isi data terlebih dahulu!');
            return false;
    }
    ;
    var aksi = 1; // 1 untuk mencari data peserta berdasarkan Nomor Kartu
    var setting = {
        url: "<?php echo Yii::app()->createUrl('pendaftaranPenjadwalan/PendaftaranRawatJalan/bpjsInterface'); ?>",
        type: 'GET',
        dataType: 'html',
        data: 'param=' + aksi + '&query=' + isi,
        beforeSend: function () {
                $("#content-bpjs").addClass("animation-loading");
        },
        success: function (data) {
                $("#content-bpjs").removeClass("animation-loading");
                var obj = JSON.parse(data);
                if (obj.response != null) {
                    var peserta = obj.response.peserta;
                    if (peserta.statusPeserta.keterangan == 'AKTIF') {

                        var provRujukan = obj.response.rujukan.provPerujuk;

                        $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs, 'nopeserta') ?>").val(peserta.noKartu);
                        $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs, 'nokartuasuransi') ?>").val(peserta.noKartu);
                        $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs, 'namapemilikasuransi') ?>").val(peserta.nama);
                        $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs, 'jenispeserta_id') ?>").val(peserta.jenisPeserta.kode);
                        $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs, 'jenispeserta_nama') ?>").val(peserta.jenisPeserta.keterangan);
                        $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs, 'kelastanggunganasuransi_id') ?>").val(peserta.hakKelas.kode);// <<tidak sama dengan kelaspelayanan_id
                        $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs, 'kelastanggunganasuransi_nama') ?>").val(peserta.hakKelas.keterangan);
                        $("#<?php echo CHtml::activeId($modSep, 'ppkrujukan') ?>").val(provRujukan.kode);
                        $("#<?php echo CHtml::activeId($modRujukanBpjs, 'nama_perujuk') ?>").val(provRujukan.nama);

                        if(peserta.cob.nmAsuransi == null && peserta.cob.noAsuransi == null){
                            $("#<?php echo CHtml::activeId($modSep, 'cob') ?>").val(0);
                            $("#<?php echo CHtml::activeId($modSep, 'status_nosep') ?>").val("TIDAK");
                        }else{
                            $("#<?php echo CHtml::activeId($modSep, 'cob') ?>").val(1);
                            $("#<?php echo CHtml::activeId($modSep, 'no_asuransi_cob') ?>").val(peserta.cob.noAsuransi);
                            $("#<?php echo CHtml::activeId($modSep, 'namaasuransi_cob') ?>").val(peserta.cob.nmAsuransi);
                            $("#<?php echo CHtml::activeId($modSep, 'status_nosep') ?>").val("YA");
                        }

                        // OVERWRITES old selecor
                        jQuery.expr[':'].contains = function (a, i, m) {
                                return jQuery(a).text().toUpperCase().indexOf(m[3].toUpperCase()) >= 0;
                        };
                        $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs, 'kelastanggunganasuransi_id') ?>").find("option:contains('" + peserta.hakKelas.keterangan + "')").attr("selected", true);

                        getRujukanDari(provRujukan.kode);
                        $('#PPSepT_catatansep').val('-');
                    } else {
                        myAlert(peserta.statusPeserta.keterangan);
                    }
                } else {
                        mesage = obj.metaData;
                        myAlert(mesage.message);
                }
        },
        error: function (data) {
                $("#content-bpjs").removeClass("animation-loading");
        }
    }
    
    if(typeof ajax_request !== 'undefined') 
        ajax_request.abort();
    ajax_request = $.ajax(setting);
}

function getRujukanNoRujukan(isi)
{
    if (<?php echo (Yii::app()->user->getState('isbridging') == TRUE) ? 1 : 0; ?>) {
    } else {
            myAlert('Fitur Bridging tidak aktif!');
            return false;
    }
    if (isi == "") {
            myAlert('Isi data terlebih dahulu!');
            return false;
    }

    var jenisfaskes = $('input:radio[name="PPSepT[jenisfaskes]"]:checked').val();
    var aksi = 3; // 3 untuk mencari data rujukan berdasarkan Nomor rujukan
    var setting = {
        url: "<?php echo Yii::app()->createUrl('pendaftaranPenjadwalan/PendaftaranRawatJalan/bpjsInterface'); ?>",
        type: 'GET',
        dataType: 'html',
        data: 'param=' + aksi + '&query=' + isi + '&jenisfaskes=' +jenisfaskes,
        beforeSend: function () {
                $("#content-bpjs").addClass("animation-loading");
        },
        success: function (data) {
            $("#content-bpjs").removeClass("animation-loading");
            var obj = JSON.parse(data);
            if(obj.metaData.code == '201'){
                    myAlert(obj.metaData.message);
            }else{
                if (obj.response != null) {
                    resetFormBpjs();
                    var rujukan = obj.response.rujukan;
                    var noKunjungan = rujukan.noKunjungan;
                    var tglKunjungan = rujukan.tglKunjungan;
                    var peserta = rujukan.peserta;    //array
                    var provKunjungan = rujukan.provKunjungan;    //array
                    var keluhan = rujukan.keluhan;
                    var diagnosa = rujukan.diagnosa;    //array
                    var catatan = rujukan.catatan;
                    var pemFisikLain = rujukan.pemFisikLain;
                    var provRujukan = rujukan.provPerujuk;
                    var poliRujukan = rujukan.poliRujukan;    //array
                    $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs, 'nopeserta') ?>").val(peserta.noKartu);
                    $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs, 'nokartuasuransi') ?>").val(peserta.noKartu);
                    $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs, 'namapemilikasuransi') ?>").val(peserta.nama);
                    $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs, 'jenispeserta_id') ?>").val(peserta.jenisPeserta.kode);
                    $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs, 'jenispeserta_nama') ?>").val(peserta.jenisPeserta.keterangan);
                    $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs, 'kelastanggunganasuransi_id') ?>").val(peserta.hakKelas.kode);// <<tidak sama dengan kelaspelayanan_id
                    $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs, 'kelastanggunganasuransi_nama') ?>").val(peserta.hakKelas.keterangan);
                    $("#<?php echo CHtml::activeId($modRujukanBpjs, 'no_rujukan') ?>").val(noKunjungan);
                    $("#<?php echo CHtml::activeId($modSep, 'ppkrujukan') ?>").val(rujukan.provPerujuk.kode);
                    $("#<?php echo CHtml::activeId($modRujukanBpjs, 'nama_perujuk') ?>").val(rujukan.provPerujuk.nama);
                    $("#<?php echo CHtml::activeId($modRujukanBpjs, 'tanggal_rujukan') ?>").val(tglKunjungan);
                    if(peserta.cob.nmAsuransi == null && peserta.cob.noAsuransi == null){
                        $("#<?php echo CHtml::activeId($modSep, 'cob') ?>").val(0);
                        $("#<?php echo CHtml::activeId($modSep, 'status_nosep') ?>").val("TIDAK");
                    }else{
                        $("#<?php echo CHtml::activeId($modSep, 'cob') ?>").val(1);
                        $("#<?php echo CHtml::activeId($modSep, 'no_asuransi_cob') ?>").val(peserta.cob.noAsuransi);
                        $("#<?php echo CHtml::activeId($modSep, 'namaasuransi_cob') ?>").val(peserta.cob.nmAsuransi);
                        $("#<?php echo CHtml::activeId($modSep, 'status_nosep') ?>").val("YA");
                    }
                    $("#<?php echo CHtml::activeId($modRujukanBpjs, 'kddiagnosa_rujukan') ?>").val(diagnosa.kode);
                    $("#<?php echo CHtml::activeId($modRujukanBpjs, 'diagnosa_rujukan') ?>").val(diagnosa.nama);
//                    setDiagnosaBpjs(diagnosa.kode, diagnosa.nama);
                    getRujukanDari(rujukan.provPerujuk.kode);
                } else {
                    myAlert(obj.metaData.message);
                }
            }
        },
        error: function (data) {
                $("#content-bpjs").removeClass("animation-loading");
        }
    }

    if (typeof ajax_request !== 'undefined')
    ajax_request.abort();
    ajax_request = $.ajax(setting);
}

function verifikasiBpjs(btn){
    if (<?php echo (Yii::app()->user->getState('isbridging')==TRUE)?1:0; ?>) {}else{myAlert('Fitur Bridging tidak aktif!'); return false;}

    var noTelp = $("#<?php echo CHtml::activeId($modPasien,'no_mobile_pasien');?>").val();
    if(noTelp.length < 8){
        myAlert("No mobile pasien minimal diisi 8 digit untuk syarat SEP");
        $("#<?php echo CHtml::activeId($modPasien,'no_mobile_pasien');?>").focus();
        return false;
    }

    var nokartu = $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs,'nopeserta');?>").val();
    var tglsep = $("#<?php echo CHtml::activeId($model,'tgl_pendaftaran');?>").val();
    var kelaspelayanan_id = $("#<?php echo CHtml::activeId($model,'kelaspelayanan_id');?>").val();
    if(tglsep == undefined){
        tglsep = $("#PPPasienAdmisiT_tgladmisi").val();
        if(tglsep == undefined){
            tglsep = $("#<?php echo CHtml::activeId($modSep,'tglsep');?>").val();
        }
    }
    if(kelaspelayanan_id == undefined){
        kelaspelayanan_id = $("#PPPasienAdmisiT_kelaspelayanan_id").val();
        if(kelaspelayanan_id == undefined){
            kelaspelayanan_id = null;
        }
    }
    var tglrujukan = $("#<?php echo CHtml::activeId($modRujukanBpjs,'tanggal_rujukan');?>").val();
    var norujukan = $("#<?php echo CHtml::activeId($modRujukanBpjs,'no_rujukan');?>").val();
    var ppkrujukan = $("#<?php echo CHtml::activeId($modSep,'ppkrujukan');?>").val();
    var ppkpelayanan = $("#<?php echo CHtml::activeId($modSep,'ppkpelayanan');?>").val(); // "1001R012"
    var jnspelayanan = $("#<?php echo CHtml::activeId($modSep,'jnspelayanan');?>").val();
    var catatan = $("#<?php echo CHtml::activeId($modSep,'catatansep');?>").val();
//    var diagawal = $("#diagnosaRujukanKodeBpjs option:first-child").val();
    var diagawal = $("#<?php echo CHtml::activeId($modRujukanBpjs,'kddiagnosa_rujukan');?>").val();
    var politujuan = $("#<?php echo CHtml::activeId($model,'ruangan_id');?>").val();
    if(politujuan == ""){
        myAlert("Pilih Ruangan untuk syarat SEP");
        return false;
    }
    if(politujuan == undefined){
        var politujuan = $("#PPPasienAdmisiT_ruangan_id").val();
    }
    var klsrawat = $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs,'kelastanggunganasuransi_id');?>").val();

    var asalRujukan = $('input:radio[name="PPSepT[jenisfaskes]"]:checked').val();
    var penjamin = $("#<?php echo CHtml::activeId($modSep,'penjamin_lakalantas');?>").val();
    var lokasiLaka = $("#<?php echo CHtml::activeId($modSep,'lokasi_lakalantas');?>").val();
    var eksekutif = $('input:radio[name="PPSepT[poli_eksekutif]"]:checked').val();
    var cob = $("#<?php echo CHtml::activeId($modSep,'cob');?>").val();
//    var lakalantas = $('input:radio[name="PPSepT[lakalantas]"]:checked').val();
    var lakalantas = $("#<?php echo CHtml::activeId($modSep, 'lakalantas') ?>").val();
    
    var tglKejadian = $("#<?php echo CHtml::activeId($modSep, 'tanggal_kejadian') ?>").val();
    var keterangan = $("#<?php echo CHtml::activeId($modSep, 'keterangan_kejadian') ?>").val();
    var suplesi = $('input:radio[name="PPSepT[suplesi_jasaraharja]"]:checked').val();
    var katarak = $('input:radio[name="PPSepT[katarak]"]:checked').val();
    var noSepSuplesi = $("#<?php echo CHtml::activeId($modSep, 'no_suplesi') ?>").val();
    var kdPropinsi = $("#<?php echo CHtml::activeId($modSep, 'propinsi_lakalantas_id') ?>").val();
    var kdKabupaten = $("#<?php echo CHtml::activeId($modSep, 'kabupaten_lakalantas_id') ?>").val();
    var kdKecamatan = $("#<?php echo CHtml::activeId($modSep, 'kecamatan_lakalantas_id') ?>").val();
    var noSurat = $("#<?php echo CHtml::activeId($modSep, 'no_surat') ?>").val();
    var kodeDPJP = $("#<?php echo CHtml::activeId($modSep, 'kode_dpjp') ?>").val();

    <?php 
    $modPegawai = PegawaiM::model()->findByPk(Yii::app()->user->id);
    ?>
    var user = "<?php echo isset($modPegawai->nama_pegawai)?$modPegawai->nama_pegawai:'-';?>";
    var nomr = $("#cari_no_rekam_medik").val();
    if(nomr == undefined){
        nomr = $("#<?php echo CHtml::activeId($modPasien, 'no_rekam_medik') ?>").val();
    }
    var notrans = '<?php echo $model->no_pendaftaran; ?>';

    var aksi = 6; // 6 untuk menCreate SEP
    var setting = {
        url : "<?php echo Yii::app()->createUrl('pendaftaranPenjadwalan/PendaftaranRawatJalan/bpjsInterface'); ?>",
        type : 'GET',
        dataType : 'html',
        data : 'param='+aksi+'&no_kartu='+nokartu+'&tgl_sep='+tglsep+'&tgl_rujukan='+tglrujukan+'&no_rujukan='+norujukan+'&ppk_rujukan='+ppkrujukan+'&ppk_pelayanan='+ppkpelayanan+'&jns_pelayanan='+jnspelayanan+'&lakalantas='+lakalantas+'&catatan='+catatan+'&diag_awal='+diagawal+'&poli_tujuan='+politujuan+'&kls_rawat='+klsrawat+'&user='+user+'&no_mr='+nomr+'&no_trans='+notrans+'&noTelp='+noTelp+'&asalRujukan='+asalRujukan+'&eksekutif='+eksekutif+'&cob='+cob+'&penjamin='+penjamin+'&lokasiLaka='+lokasiLaka+'&kelaspelayanan_id='+kelaspelayanan_id+
        '&tglKejadian='+tglKejadian+'&keterangan='+keterangan+'&suplesi='+suplesi+'&noSepSuplesi='+noSepSuplesi+'&kdPropinsi='+kdPropinsi+'&kdKabupaten='+kdKabupaten+'&kdKecamatan='+kdKecamatan+'&noSurat='+noSurat+'&kodeDPJP='+kodeDPJP+'&katarak='+katarak,
        beforeSend: function(){
            $("#content-bpjs").addClass("animation-loading");
        },
        success: function(data){
            $("#content-bpjs").removeClass("animation-loading");
            var res = JSON.parse(data);
            if(res.response!=null){
                var noSep = res.response.sep;
                myAlert(res.metaData.message);
                $("#<?php echo CHtml::activeId($modSep,'nosep') ?>").val(noSep.noSep);
                $(btn).hide();
                $('#isSepManual').hide();
                $('.verified').show();
            }else{
                myAlert(res.metaData.message);
            }
        },
        error: function(data){
            $("#content-bpjs").removeClass("animation-loading");
        }
    }

    if(typeof ajax_request !== 'undefined') 
    ajax_request.abort();
    ajax_request = $.ajax(setting);

}

function ubahFormatTanggalBpjs(str){
  tgl = str.substr(0,10).split("/");
  tanggal = tgl[2]+'-'+tgl[1]+'-'+tgl[0]
  jam = str.substr(11,8);
  return tanggal+' '+jam;
}


function setDiagnosa(kode_diagnosa,nama_diagnosa){
   
  var chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz";
  var randomId = '';
  for (var i = 0; i < 32; i++) {
      var rnum = Math.floor(Math.random() * chars.length);
      randomId += chars.substring(rnum, rnum + 1);
  }
    

  var op = '<option id="opt_'+randomId+'" class="selected" selected="selected" value="'+nama_diagnosa+'">'+nama_diagnosa+'</option>';
  var list = '<li id="pt_'+randomId+'" class="bit-box" rel="'+nama_diagnosa+'">'+nama_diagnosa+'<a class="closebutton" href="#" onclick="removeItemDiagnosa($(this).parent().attr(\'id\')); return false;"></a></li>';
  var opKode = '<option id="opt_'+randomId+'" class="selected" selected="selected" value="'+kode_diagnosa+'">'+kode_diagnosa+'</option>';
  var listKode = '<li id="pt_'+randomId+'" class="bit-box" rel="'+kode_diagnosa+'">'+kode_diagnosa+'<a class="closebutton" href="#" onclick="removeItemDiagnosa($(this).parent().attr(\'id\')); return false;"></a></li>';
  var objSelect = $('select#diagnosaRujukan').parent().find('select');
  var objList = $('select#diagnosaRujukan').parent().find('ul li.bit-input');
  var objSelectKode = $('select#diagnosaRujukanKode').parent().find('select');
  var objListKode = $('select#diagnosaRujukanKode').parent().find('ul li.bit-input');

  objSelect.append(op);
  objList.before(list);
  objSelectKode.append(opKode);
  objListKode.before(listKode);

}

function setDiagnosaBpjs(kode_diagnosa,nama_diagnosa){
   
  var chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz";
  var randomId = '';
  for (var i = 0; i < 32; i++) {
      var rnum = Math.floor(Math.random() * chars.length);
      randomId += chars.substring(rnum, rnum + 1);
  }
    

  var op = '<option id="opt_'+randomId+'" class="selected" selected="selected" value="'+nama_diagnosa+'">'+nama_diagnosa+'</option>';
  var list = '<li id="pt_'+randomId+'" class="bit-box" rel="'+nama_diagnosa+'">'+nama_diagnosa+'<a class="closebutton" href="#" onclick="removeItemDiagnosa($(this).parent().attr(\'id\')); return false;"></a></li>';
  var opKode = '<option id="opt_'+randomId+'" class="selected" selected="selected" value="'+kode_diagnosa+'">'+kode_diagnosa+'</option>';
  var listKode = '<li id="pt_'+randomId+'" class="bit-box" rel="'+kode_diagnosa+'">'+kode_diagnosa+'<a class="closebutton" href="#" onclick="removeItemDiagnosa($(this).parent().attr(\'id\')); return false;"></a></li>';
  var objSelect = $('select#diagnosaRujukanBpjs').parent().find('select');
  var objList = $('select#diagnosaRujukanBpjs').parent().find('ul li.bit-input');
  var objSelectKode = $('select#diagnosaRujukanKodeBpjs').parent().find('select');
  var objListKode = $('select#diagnosaRujukanKodeBpjs').parent().find('ul li.bit-input');

  objSelect.append(op);
  objList.before(list);
  objSelectKode.append(opKode);
  objListKode.before(listKode);

}

function removeItemDiagnosa(id){
  $('li#'+id).remove();
  var id_opt = id.replace('pt_','opt_');
  $('option#'+id_opt).remove();
}

function setNoKartuAsuransi(){
    var nopeserta       = $("input[name$='[nopeserta]']").val();
    $("input[name$='[nokartuasuransi]']").val(nopeserta);
}

function setNoBpjs(){
    var nopeserta= $("#PPAsuransipasienbpjsM_nopeserta").val();
    $("#PPAsuransipasienbpjsM_nokartuasuransi").val(nopeserta);
}

function setNoBpjsReverse(){
    var nokartuasuransi = $("#PPAsuransipasienbpjsM_nokartuasuransi").val();
	//alert(nokartuasuransi);
    $("#PPAsuransipasienbpjsM_nopeserta").val(nokartuasuransi);
}

<?php 
  if (empty($modPasienAdmisi)) {
?>
function cekAsuransi(){
  var penjamin_id = $("#<?php echo CHtml::activeId($model,'penjamin_id') ?>").val();
  var pasien_id = $("#<?php echo CHtml::activeId($modPasien,'pasien_id') ?>").val();

  if(pasien_id==""){
    myAlert('Masukan terlebih dahulu data pasien!');
  }else if(penjamin_id==""){
    myAlert('Masukan terlebih dahulu penjamin!');
  }else{
    $.fn.yiiGridView.update('asuransi-m-grid', {
        data: {
            "<?php echo get_class($modAsuransiPasien); ?>[pasien_id]":pasien_id,
            "<?php echo get_class($modAsuransiPasien); ?>[penjamin_id]":penjamin_id,
        }
    });
    $("#dialogAsuransi").dialog('open');
  }
  return false;
}
function cekAsuransiBpjs(){
  var penjamin_id = $("#<?php echo CHtml::activeId($model,'penjamin_id') ?>").val();
  var pasien_id = $("#<?php echo CHtml::activeId($modPasien,'pasien_id') ?>").val();

  if(pasien_id==""){
    myAlert('Masukan terlebih dahulu data pasien!');
  }else if(penjamin_id==""){
    myAlert('Masukan terlebih dahulu penjamin!');
  }else{
    $.fn.yiiGridView.update('asuransibpjs-m-grid', {
        data: {
            "<?php echo get_class($modAsuransiPasienBpjs); ?>[pasien_id]":pasien_id,
            "<?php echo get_class($modAsuransiPasienBpjs); ?>[penjamin_id]":penjamin_id,
        }
    });
    $("#dialogAsuransiBpjs").dialog('open');
  }
  return false;
}
<?php } ?>

function resetFormBpjs(){
    $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs,'asuransipasien_id') ?>").val('');
    $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs,'nopeserta') ?>").val('');
    $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs,'nokartuasuransi') ?>").val('');
    $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs,'namapemilikasuransi') ?>").val('');
    $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs,'jenispeserta_id') ?>").val('');
    $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs,'nomorpokokperusahaan') ?>").val('');
    $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs,'namaperusahaan') ?>").val('');
    $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs,'kelastanggunganasuransi_id') ?>").val('');
    $("#<?php echo CHtml::activeId($modRujukanBpjs,'asalrujukan_id') ?>").val('');
    $("#<?php echo CHtml::activeId($modRujukanBpjs,'no_rujukan') ?>").val('');
    $("#<?php echo CHtml::activeId($modRujukanBpjs,'rujukandari_id') ?>").val('');
    $("#<?php echo CHtml::activeId($modRujukanBpjs,'nama_perujuk') ?>").val('');
    $("#<?php echo CHtml::activeId($modRujukanBpjs,'tanggal_rujukan') ?>").val('');
    $("#diagnosaRujukanKodeBpjs").each(function(){
        $(this).find('option').detach();
    });
    $("#diagnosaRujukanKodeBpjs").each(function(){
        $(this).parent().find('.holder .bit-box').detach();
    });
    $("#diagnosaRujukanBpjs").each(function(){
        $(this).find('option').detach();
    });
    $("#diagnosaRujukanBpjs").each(function(){
        $(this).parent().find('.holder .bit-box').detach();
    });
    $("#<?php echo CHtml::activeId($modSep,'sep_id') ?>").val('');
    $("#<?php echo CHtml::activeId($modSep,'ppkrujukan') ?>").val('');
    $("#<?php echo CHtml::activeId($modSep,'catatansep') ?>").val('');
}

/* set dokter ruangan dari dialog jadwal dokter
 * @param {type} pegawai_id
 * @returns {undefined}
 */
function setDokterJadwal(pegawai_id)
{
    $("#<?php echo CHtml::activeId($model,"pegawai_id");?>").val(pegawai_id);
	setAntrianDokter();
	$('#jadwalDokter').dialog('close');
}

function setRuanganJadwalDokter(){
    var ruangan_id = $("#<?php echo CHtml::activeId($model,"ruangan_id");?>").val();
    $.fn.yiiGridView.update('rdjadwaldokter-m-grid', {
        data: {
            "PPJadwaldokterM[ruangan_id]":ruangan_id,
        }
    });
}

function setSEP(obj){
    if($(obj).is(':checked')){
        $('#content-bpjs').find(".nosep").val('-');
        $('#content-bpjs').find(".sep_oto_manual").hide();
        $('.verifikasi_bpjs').hide();
    }else{
        $('#content-bpjs').find(".sep_oto_manual").show(); 
        $('#content-bpjs').find(".nosep").val('');
        $('.verifikasi_bpjs').show();
    }

}

/**
 * checking penjamin pegawai badak apakah msh aktif / tidak
 * @returns {undefined}
 * LNG-48
 */
function cekCaraBayarBadak(carabayar_id){
	var pegawai_id = $("#PPPasienM_pegawai_id").val();
	
	if((carabayar_id == <?= Params::CARABAYAR_ID_BADAK; ?>) || (carabayar_id == <?= Params::CARABAYAR_ID_DEP_BADAK; ?>) || (carabayar_id == <?= Params::CARABAYAR_ID_PEKERJA; ?>)){
		if(pegawai_id == ''){
			myAlert("Pilih data pegawai penanggung jawab terlebih dahulu!");
			$("#<?php echo CHtml::activeId($model,"carabayar_id");?>").val("");
			$("#PPPasienAdmisiT_carabayar_id").val("");
		}else{
			$("#content-asubadak").addClass("animation-loading");
			$("#content-asudepartemen").addClass("animation-loading");
			$("#content-asupekerja").addClass("animation-loading");
			var pasien_id = $("#<?php echo CHtml::activeId($modPasien,"pasien_id");?>").val();
			$.ajax({
				type:'POST',
				url:'<?php echo $this->createUrl('CekCaraBayarBadak'); ?>',
				data: {pasien_id: pasien_id,pegawai_id:pegawai_id},
				dataType: "json",
				success:function(data){
					if(data.status === true){
						setAsuransiBadak();
					}else{
						myAlert(data.pesan);
						$("#<?php echo CHtml::activeId($model,"carabayar_id");?>").val("");
						$("#PPPasienAdmisiT_carabayar_id").val("");
					}
					$("#content-asubadak").removeClass("animation-loading");
					$("#content-asudepartemen").removeClass("animation-loading");
					$("#content-asupekerja").removeClass("animation-loading");
				},
				error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
			});
		}
		
	}
	
}

/**
 * checking validasi penjamin (This Function Dedicate For LNG Projects Only)
 * @returns {undefined}
 * LNG-3
 */
function cekValiditasPenjamin(penjamin_id){
	var carabayar_id = $("#<?php echo CHtml::activeId($model,"carabayar_id");?>").val();
	var pegawai_id = $("#PPPasienM_pegawai_id").val();
	if(carabayar_id == <?= Params::CARABAYAR_ID_BADAK; ?>){
		
		if((penjamin_id == <?= Params::PENJAMIN_ID_PISA; ?> ) || (penjamin_id == <?= Params::PENJAMIN_ID_PROKESPEN; ?> )){
			var pasien_id = $("#<?php echo CHtml::activeId($modPasien,"pasien_id");?>").val();
				$.ajax({
					type:'POST',
					url:'<?php echo $this->createUrl('cekValiditasPenjamin'); ?>',
					data: {type:"badak", pasien_id: pasien_id, penjamin_id: penjamin_id,pegawai_id:pegawai_id},
					dataType: "json",
					success:function(data){
						if((data.status == 'Empty') || (data.status == 'Fail')){
							myAlert(data.pesan);
							$("#<?php echo CHtml::activeId($model,"penjamin_id");?>").html(data.html);
						}else{

							if(data.penj == <?= Params::PENJAMIN_ID_PISA; ?> ){
								if(data.status == 'Tidak Tetap'){
									myAlert(data.pesan);
									$("#PPPendaftaranT_penjamin_id").html(data.html);
								}
							}else{
								myAlert("Prokespen hanya menjamin Pensiunan dan Istri/Suami Pensiunan");
							}
						}
					},
					error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
				});
		}
		setDropdownStatushubungankeluarga(penjamin_id);
		
	}else if(carabayar_id == <?= Params::CARABAYAR_ID_DEP_BADAK; ?>){
	
		
		$.ajax({
			type:'POST',
			url:'<?php echo $this->createUrl('cekValiditasPenjamin'); ?>',
			data: {type:"departemen", penjamin_id: penjamin_id},
			dataType: "json",
			success:function(data){
				$("#<?php echo CHtml::activeId($modAsuransiPasienDepartemen,"namaperusahaan");?>").val(data.data.penjamin_nama);
				$(".judulasuransi").html("Asuransi "+data.data.penjamin_nama);
				
			},
			error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
		});
		
	}
	
}

function cekStatusPekerjaan(obj)
{
    var namaDepan = $('#PPPasienM_namadepan').val();
    var namaPekerjaan = obj.value;
    var umur = $("#<?php echo CHtml::activeId($model,'umur');?>").val().substr(0,2);
    umur = parseInt(umur);

    if(namaDepan.length > 0)
    {
        if(umur < 15){
            if(namaPekerjaan !== '13' && namaPekerjaan != '10'){
                if(namaPekerjaan !== ''){
                    alert('Pasien masih di bawah umur,silakan cek kembali!');
                }
                $(obj).val('');
            }else{
                $(obj).val(namaPekerjaan);
            }
        }else{
            if(namaPekerjaan === '12'){
                if(namaDepan === 'Ny. '){
                    $(obj).val('9');
                }else if(namaDepan === 'Nn. ' && namaPekerjaan === '9'){
                    alert('Pasien belum menikah,silakan cek kembali!');
                    $(obj).val('');
                }else{
                    $(obj).val('');
                }
                alert('Pilih pekerjaan yang tepat');
            }else{
                if(namaPekerjaan === '9'){
                    if(namaDepan !== 'Ny. '){
                      if ($("#PPPasienM_jeniskelamin_0").is(":checked")) alert ("Silakan Cek Kembali Jenis Kelamin Yang Dipilih!");
                      else alert('Silakan Cek Kembali Status Perkawinan Anda!');
                      $(obj).val('');
                    }
                }
            }
        }
/*
        if(namaPekerjaan === '12' && umur < 17)
        {
            if(namaDepan !== 'BY. Ny.' && namaDepan !== 'An.' && namaDepan !== 'Nn')
            {
                alert('Pilih pekerjaan yang sesuai!');
                $(obj).val('');
            }
        }else{
            if(namaDepan === 'BY. Ny.')
            {
                alert('Pilih pekerjaan yang sesuai!');
                $(obj).val('');
            }else{
                if(namaPekerjaan === '11' || namaPekerjaan === '10')
                {
                    if(namaDepan !== 'An.' && namaDepan !== 'Nn'){
                        alert('Pilih pekerjaan yang sesuai!');
                        $(obj).val('');
                    }
                }else{
                    if(namaPekerjaan !== '13' && namaPekerjaan !== '14')
                    {
                        if(namaPekerjaan === '9' && namaDepan !== 'Ny.')
                        {
                            alert('Pilih pekerjaan yang sesuai!');
                            $(obj).val('');
                        }else{
                            if((namaDepan === 'An.' || namaDepan === 'Nn') && umur < 25){
                                alert('Pilih pekerjaan yang sesuai!');
                                $(obj).val('');
                            }
                        }
                    }
                }
            }
        }
*/
    }else{
        $(obj).val('');
        alert('Pilih gelar kehormatan terlebih dahulu!');
    }

}

/**
 * load ruangan pasien terakhir
 * @returns {undefined}
 */
function getRuanganPoliklinikPasien(){
	var pasien_id = $("#<?php echo CHtml::activeId($modPasien,"pasien_id");?>").val();
	var ruangan_id = $("#<?php echo CHtml::activeId($model,"ruangan_id");?>").val();
	$.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('getRuanganPoliklinikPasien'); ?>',
        data: { pasien_id: pasien_id, ruangan_id: ruangan_id},
        dataType: "json",
        success:function(data){
				if(data.status == 'Ya'){
					myAlert(data.pesan);
				}
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}

function resetFormPegawai(){
	$('#PPPasienM_pegawai_id').val('');
	$('#PPPegawaiM_nomorindukpegawai').val('');
	$('#PPPegawaiM_nama_pegawai').val('');
	$('#PPPegawaiM_unit_perusahaan').val('');
	$('#PPPegawaiM_jabatan_nama').val('');
}

function cekPilihSatu(obj) {
    // console.log($(obj).find('option').length);
    if ($(obj).find('option').length == 2) {
        $(obj).val($(obj).find('option').eq(1).val());
        $(obj).change();
    }
    if ($(obj).find('option').length == 1) {
        $(obj).change();
    }
}

function switchOtomatis(obj) {
    otoval = $(obj).val();
    checkOto();
}

function checkOto() {	
	
    if (otoval == 1) {
        $(".labelrm").show();
        $(".rm_lama").hide();
        $(".rm_baru").hide();
        $("#lb_rm_lama").removeClass("required").find("span").removeClass("required").hide();
		<?php 
			if ($model->buatjanjipoli_id == ''){
		?>
			$("#no_rekam_medik_baru, #PPPasienM_nomorindukpegawai").val("");  
		<?php
			}
		?>
        $("#pendaftaranFP").hide();
        $(".rm_nip_baru").show().find(":input").prop("disabled", false);          
        $(".normpilihan").removeClass('hide');	
    } else {
        $(".labelrm").hide();
        $(".rm_baru").show();
        $(".rm_lama").hide();
        $("#lb_rm_lama").addClass("required").find("span").addClass("required").show();
        <?php 
			if ($model->buatjanjipoli_id == ''){
		?>
			$("#no_rekam_medik_baru, #PPPasienM_nomorindukpegawai").val("");  
		<?php
			}
		?>
        $("#pendaftaranFP").show();
        $(".rm_nip_baru").show().find(":input").prop("disabled", true);
        $(".normpilihan").addClass('hide');
    }
	
}

function hideHitunganRM() {
    $(".rm_control").hide();
    $(".rm_state").show();
}

function showHitunganRM() {
    $(".rm_control").show();
    checkOto();
}

function setNamaAsuransiDariPenjamin(obj) {
    var t = ($(obj).find(":selected").text()).toUpperCase();
    $("#<?php echo CHtml::activeId($modAsuransiPasien,"namaperusahaan");?>").val(t);
}

function cekTanggalKonfirmasi() {
    if ($(".rb_kon").eq(0).is(":checked")) {
        var d = new Date();
        var ds = numPads(d.getDate(), "00") + "/" + numPads(d.getMonth()+1, "00") + "/" + d.getFullYear();
        var dt = numPads(d.getHours(), "00") + ":" + numPads(d.getMinutes(), "00") + ":" + numPads(d.getSeconds(), "00");
        
        $("#<?php echo CHtml::activeId($modAsuransiPasien,"tgl_konfirmasi");?>").val(ds + " " + dt);
    } else {
        $("#<?php echo CHtml::activeId($modAsuransiPasien,"tgl_konfirmasi");?>").val("");
    }
}

function numPads(str, pad) {
    return (pad + str).slice(-pad.length);
}

function getBpjsPPKRujukan(ppk) {
    if (<?php echo (Yii::app()->user->getState('isbridging')==TRUE)?1:0; ?>) {}else{myAlert('Fitur Bridging tidak aktif!'); return false;}
    if (ppk=="") {myAlert('Isi data terlebih dahulu!'); return false;}
    if (ppk.trim().length != 8) {myAlert('PPK Rujukan harus 8 Digit'); return false;}
    var aksi = 12; // 12 cari ppk rujukan
    var setting = {
        url : "<?php echo $this->createUrl('bpjsInterface'); ?>",
        type : 'GET',
        dataType : 'html',
        data : 'param='+ aksi + '&ppkrujukan=' + ppk + '&start=0&limit=1',
        beforeSend: function(){
            $("#content-bpjs").addClass("animation-loading");
        },
        success: function(data){
            $("#content-bpjs").removeClass("animation-loading");
            console.log(data);
            var obj = JSON.parse(data);
            if(obj.response!=null){
                console.log(obj.metadata.code);
                myAlert("PKK : " + obj.response.list[0].kdProvider + "\n" +
                        "Nama : " + obj.response.list[0].nmProvider + "\n" +
                        "Cabang : " + obj.response.list[0].nmCabang);
                /*
				var peserta = obj.response.peserta;
				$("#<?php echo CHtml::activeId($modAsuransiPasienBpjs,'nopeserta') ?>").val(peserta.noKartu);
				$("#<?php echo CHtml::activeId($modAsuransiPasienBpjs,'nokartuasuransi') ?>").val(peserta.noKartu);
				$("#<?php echo CHtml::activeId($modAsuransiPasienBpjs,'namapemilikasuransi') ?>").val(peserta.nama);
				$("#<?php echo CHtml::activeId($modAsuransiPasienBpjs,'jenispeserta_id') ?>").val(peserta.jenisPeserta.kdJenisPeserta);
//              $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs,'kelastanggunganasuransi_id') ?>").val(peserta.kelasTanggungan.kdKelas); // <<tidak sama dengan kelaspelayanan_id
				// OVERWRITES old selecor
				jQuery.expr[':'].contains = function(a, i, m) {
				  return jQuery(a).text().toUpperCase()
					  .indexOf(m[3].toUpperCase()) >= 0;
				};
				$("#<?php echo CHtml::activeId($modAsuransiPasienBpjs,'kelastanggunganasuransi_id') ?>").find("option:contains('"+peserta.kelasTanggungan.nmKelas+"')").attr("selected",true);
                */
            }else{
              myAlert(obj.metadata.message);
            }
        },
        error: function(data){
            $("#content-bpjs").removeClass("animation-loading");
        }
    }
    
    if(typeof ajax_request !== 'undefined') 
        ajax_request.abort();
    ajax_request = $.ajax(setting);
}

$(".rb_kon").change(function() {
    cekTanggalKonfirmasi();
});

function cekJamPoli() {
    
    if ($("#jam_awal").val() == "" || $("#jam_tutup").val() == "") return true;
    
    jam_awal = new Date($("#jam_awal").val());
    jam_tutup = new Date($("#jam_tutup").val());
    cur = new Date();
    
    if (cur.getTime() < jam_awal.getTime() || cur.getTime() > jam_tutup.getTime()) {
        myAlert("Tidak bisa mendaftarkan pasien diluar jadwal.\n" +
                $("#nama_ruangan").val() + " : " + $("#jam_awal_a").val() + " - " + $("#jam_tutup_a").val());
        
        return false;
    }
    
    return true;
}

function cekSEP(nosep) {
	var setting = {
        url : "<?php echo $this->createUrl('cekSEP'); ?>",
        type : 'POST',
        dataType : 'json',
        data : {nosep: nosep},
        beforeSend: function(){
            $("#content-bpjs").addClass("animation-loading");
        },
        success: function(data){
            $("#content-bpjs").removeClass("animation-loading");
            console.log(data);
            var obj = data;
            if(obj.response!=null){
                myAlert(
					"Nama Peserta : " + obj.response.peserta.nama + "\n" +
					"Nomor Kartu : " + obj.response.peserta.noKartu + "\n" +
					"No. Sep : " + obj.response.noSep
				);
				$("#PPSepT_ppkrujukan").val(obj.response.provRujukan.kdProvider);
				$("#PPRujukanbpjsT_no_rujukan").val(obj.response.noRujukan);
				getAsuransiNoKartu(obj.response.peserta.noKartu);
				if (obj.rujukan.rujukandari_id.toString().trim() != "") {
					$("#PPRujukanbpjsT_asalrujukan_id").val(obj.rujukan.asalrujukan_id);
					$("#PPRujukanbpjsT_rujukandari_id")
							.html(obj.rujukan.listrujukandari_id)
							.val(obj.rujukan.rujukandari_id)
							.change();
				}
            }else{
              myAlert(obj.metadata.message);
            }
        },
        error: function(data){
            $("#content-bpjs").removeClass("animation-loading");
        }
    }
    
    if(typeof ajax_request !== 'undefined') 
        ajax_request.abort();
    ajax_request = $.ajax(setting);
}

/**
 * javascript yang di running setelah halaman ready / load sempurna
 * posisi script ini harus tetap dibawah
 */
$( document ).ready(function(){

$(".rb_rm").eq(1).click();
    <?php if (isset($_GET['pasien_id']) && !empty($_GET['pasien_id'])): ?>
            $(".rb_rm").eq(1).click();
            $("#no_rekam_medik_baru").val('<?php echo $modPasien->no_rekam_medik; ?>');
            setTimeout(function() {
                $("#no_rekam_medik_baru").blur();
            }, 1500);
            <?php if (isset($ruangan) && !empty($ruangan)): ?>
            $("#<?php echo CHtml::activeId($model, 'ruangan_id') ;?>").val(<?php echo $ruangan; ?>).change();
            <?php endif; ?>
    <?php else: ?>
//            checkOto();
    <?php endif; ?>
    
    $("#form-karcis .accordion-heading a").click(function()
    {
        return false;
    });
    
//    $("#form-bpjs .accordion-heading a").click(function()
//    {
//        return false;
//    });
    
    $("#form-asuransi .accordion-heading a").click(function()
    {
        carabayar_id = $("#PPPendaftaranT_carabayar_id").val();
        carabayar_id_ri = $("#PPPasienAdmisiT_carabayar_id").val();

        if (carabayar_id=='<?php echo Params::CARABAYAR_ID_BPJS;?>' || carabayar_id_ri=='<?php echo Params::CARABAYAR_ID_BPJS;?>') {
            return true;
        } else {
            return false;
        }
        
    });
    
    $("#form-pjpasien .accordion-heading a").click(function()
    {
//        return false; //validasi di hilangkan RSST-722
    });
    
    <?php if(!empty($model->pendaftaran_id)){ ?>
        autoPrint();
        $("input, select, textarea").attr("disabled",true);
        $("#bth-lihatantrian").parent().parent().hide();
        $(".add-on").hide();
    <?php } ?>
    <?php 
    if (!empty($model->antrian_id)) { 
        $antrian = AntrianT::model()->findByPk($model->antrian_id);
        if($konfig->is_nodejsaktif){
        ?>
        socket.emit('send',{conversationID:'antrian',loket_id:<?php echo $antrian->loket_id; ?>});
    <?php 
        }
    } ?>
	setUmur($("#<?php echo CHtml::activeId($modPasien, 'tanggal_lahir') ;?>").val());
	
    // Notifikasi Pasien
    <?php 
        if(isset($_GET['smspasien'])){
            if($_GET['smspasien']==0){
    ?>
        var params = [];
        params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Yii::app()->session['modul_id']; ?>, judulnotifikasi:'GAGAL KIRIM SMS PASIEN', isinotifikasi:'Pasien <?php echo $model->pasien->nama_pasien; ?> tidak memiliki nomor mobile'}; // 16 
        insert_notifikasi(params);
    <?php            
            }
        }
    ?>
    // Notifikasi Dokter
    <?php 
        if(isset($_GET['smsdokter'])){
            if($_GET['smsdokter']==0){
    ?>
        var params = [];
        params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Yii::app()->session['modul_id']; ?>, judulnotifikasi:'GAGAL KIRIM SMS DOKTER', isinotifikasi:'dr. <?php echo $model->pegawai->nama_pegawai; ?> tidak memiliki nomor mobile'}; // 16 
        insert_notifikasi(params);
    <?php            
            }
        }
    ?>
    // Notifikasi Penanggungjawab
    <?php 
        if(isset($_GET['smspenanggungjawab'])){
            if($_GET['smspenanggungjawab']==0){
    ?>
        var params = [];
        params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Yii::app()->session['modul_id']; ?>, judulnotifikasi:'GAGAL KIRIM SMS PENANGGUNG JAWAB', isinotifikasi:'Penanggung jawab pasien <?php echo $model->pasien->nama_pasien; ?> tidak memiliki nomor mobile'}; // 16 
        insert_notifikasi(params);
    <?php            
            }
        }
    ?>
    setTimeout(function() {$(".f_rm:first").focus();}, 500);
    
    cekPengantar();
});

//pengantar
    
    function cekPengantar(){
        var pengantar = $('#<?php echo CHtml::activeId($modPenanggungJawab, 'pengantar') ?>').val();
        
        $('.pj_2').hide();
        $('.pj_1').show();
        
        if (pengantar == '<?php echo Params::PENGANTAR_DIRI_SENDIRI; ?>'){            
            setPengantar();
            $('.pj_2').find(".required").addClass("non-required").removeClass("required");
            $('.pj_1').find(".non-required").addClass("required").removeClass("non-required");
        }else{
            if(pengantar == '<?php echo Params::PENGANTAR_PEGAWAI_RS; ?>'){
                $('.pj_2').show();
                $('.pj_1').hide();
                $('.pj_1').find(".required").addClass("not-required").removeClass("required");
                $('.pj_2').find(".non-required").addClass("required").removeClass("non-required");
            }else{
                $('.pj_2').find(".required").addClass("non-required").removeClass("required");
                $('.pj_1').find(".non-required").addClass("required").removeClass("non-required");
            }
            setResetPengantar();
        }
        
        if (pengantar != '<?php echo Params::PENGANTAR_KELUARGA; ?>'){            
            $('.hubungankeluarga').hide();
        }else{
            $('.hubungankeluarga').show();
        }
    }
    
    function setPengantar(){
        var nama = $("#<?php echo CHtml::activeId($modPasien, 'nama_pasien'); ?>").val();
        var laki = $("#<?php echo CHtml::activeId($modPasien, 'jeniskelamin') ?>_0");
        var perempuan = $("#<?php echo CHtml::activeId($modPasien, 'jeniskelamin') ?>_1");
        var noiden = $("#<?php echo CHtml::activeId($modPasien, 'no_identitas_pasien') ?>").val();
        var jenisiden = $("#<?php echo CHtml::activeId($modPasien, 'jenisidentitas') ?>").val();
        var tanggallahir = $("#<?php echo CHtml::activeId($modPasien, 'tanggal_lahir') ?>").val();
        var tempatlahir = $("#<?php echo CHtml::activeId($modPasien, 'tempat_lahir') ?>").val();
        var umur = $("#<?php echo CHtml::activeId($model, 'umur') ?>").val();
        var alamat = $("#<?php echo CHtml::activeId($modPasien, 'alamat_pasien') ?>").val();
        var telepon = $("#<?php echo CHtml::activeId($modPasien, 'no_telepon_pasien') ?>").val();
        var mobile = $("#<?php echo CHtml::activeId($modPasien, 'no_mobile_pasien') ?>").val();
        var gender = '';
                
        
        $("#<?php echo CHtml::activeId($modPenanggungJawab, 'nama_pj') ?>").val(nama);                       
        if (laki.is(":checked")){
            gender = laki.attr("value");
        }else if (perempuan.is(":checked")){
            gender = perempuan.attr("value");
        }
        
        $("#form-pjpasien").find('input[name$="[jeniskelamin]"][type="radio"]').each(function(){
            if($(this).val() == $.trim(gender)){
                $(this).attr('checked',true);
            }
        });
        
            
        $("#<?php echo CHtml::activeId($modPenanggungJawab, 'jeniskelamin') ?>_1").val();
        $("#<?php echo CHtml::activeId($modPenanggungJawab, 'no_identitas') ?>").val(noiden);
        $("#<?php echo CHtml::activeId($modPenanggungJawab, 'jenisidentitas') ?>").val(jenisiden);
        $("#<?php echo CHtml::activeId($modPenanggungJawab, 'tgllahir_pj') ?>").val(tanggallahir);
        $("#<?php echo CHtml::activeId($modPenanggungJawab, 'tempatlahir_pj') ?>").val(tempatlahir);
        $("#<?php echo CHtml::activeId($modPenanggungJawab, 'umur') ?>").val(umur);
        $("#<?php echo CHtml::activeId($modPenanggungJawab, 'alamat_pj') ?>").val(alamat);
        $("#<?php echo CHtml::activeId($modPenanggungJawab, 'no_teleponpj') ?>").val(telepon);
        $("#<?php echo CHtml::activeId($modPenanggungJawab, 'no_mobilepj') ?>").val(mobile);
    }
    
    function setResetPengantar(){
        $("#<?php echo CHtml::activeId($modPenanggungJawab, 'nama_pj') ?>").val('');
        $("#<?php echo CHtml::activeId($modPenanggungJawab, 'nama_pegawai') ?>").val('');
        $("#<?php echo CHtml::activeId($modPenanggungJawab, 'pegawai_id') ?>").val('');
        $("#<?php echo CHtml::activeId($modPenanggungJawab, 'unit_perusahaan') ?>").val('');
        $("#<?php echo CHtml::activeId($modPenanggungJawab, 'jabatan_nama') ?>").val('');
        $("#<?php echo CHtml::activeId($modPenanggungJawab, 'jeniskelamin') ?>").val('');
        $("#<?php echo CHtml::activeId($modPenanggungJawab, 'no_identitas') ?>").val('');
        $("#<?php echo CHtml::activeId($modPenanggungJawab, 'jenisidentitas') ?>").val('');
        $("#<?php echo CHtml::activeId($modPenanggungJawab, 'tgllahir_pj') ?>").val('');
        $("#<?php echo CHtml::activeId($modPenanggungJawab, 'tempatlahir_pj') ?>").val('');
        $("#<?php echo CHtml::activeId($modPenanggungJawab, 'umur') ?>").val('');
        $("#<?php echo CHtml::activeId($modPenanggungJawab, 'alamat_pj') ?>").val('');
        $("#<?php echo CHtml::activeId($modPenanggungJawab, 'no_teleponpj') ?>").val('');
        $("#<?php echo CHtml::activeId($modPenanggungJawab, 'no_mobilepj') ?>").val('');
    }

/**
 * 
 * @param {type} obj
 * @returns {change attribute maxlength}
 */
function cekLength(obj){
    var cek = $(obj).val();
    
    if (cek == '<?php echo Params::JENIS_IDENTITAS_KTP ?>'){
        $("#<?php echo CHtml::activeId($modPasien, 'no_identitas_pasien') ?>").attr('maxlength',16);
    }else{
        $("#<?php echo CHtml::activeId($modPasien, 'no_identitas_pasien') ?>").attr('maxlength',30);
    }
}

/**
 * 
 * @param {type} obj
 * @returns {change attribute maxlength}
 */
function cekLengthPJ(obj){
    var cek = $(obj).val();
    
    if (cek == '<?php echo Params::JENIS_IDENTITAS_KTP ?>'){
        $("#<?php echo CHtml::activeId($modPenanggungJawab, 'no_identitas') ?>").attr('maxlength',16);
    }else{
        $("#<?php echo CHtml::activeId($modPenanggungJawab, 'no_identitas') ?>").attr('maxlength',30);
    }
}

/**
 * - digunakan untuk menginformasikan ada perbedaan kelas tanggunagn dan kelas pelayanan
 * @param {type} obj
 * @returns {give warning} */
function cekPerbedaanKelas(obj){
	var kelaspelayanan = $("#PPPasienAdmisiT_kelaspelayanan_id option:selected");
		
	var carabayar = $("#PPPasienAdmisiT_carabayar_id option:selected").val();
	
	if (carabayar == <?php echo Params::CARABAYAR_ID_BPJS ?>){		
		<?php if ( Yii::app()->user->getState('isbridging') == true) { ?>
			var kelastanggungan = $("#PPAsuransipasienbpjsM_kelastanggunganasuransi_id option:selected");
		<?php }else{ ?>
			var kelastanggungan = $("#PPAsuransipasienM_kelastanggunganasuransi_id option:selected");
		<?php } ?>
	}else{
		//var kelastanggungan = $("#<?php echo CHtml::activeId($modAsuransiPasien, 'kelastanggunganasuransi_id') ?> option:selected");		
		var kelastanggungan = $("#tampungkelas option:selected");		 // = $("#<?php echo CHtml::activeId($modAsuransiPasien, 'kelastanggunganasuransi_id') ?> option:selected");		
	}	
	//alert(kelaspelayanan.val()+'-'+kelastanggungan.val());
	
	if (typeof kelastanggungan.val() === 'undefined'){
		
	}else{
	
		if (kelaspelayanan.val() != '' && (kelastanggungan.val() != '') ){
			if (kelastanggungan.text() != kelaspelayanan.text()){
				myAlert("Anda memilih kelas pelayanan yang berbeda dengan tanggungan penjamin, maka pasien akan dikenakan selisih biaya","Perhatin!");
			}
		}
	}
}

/**
 * - digunakan untuk mmevalidasi bahwa no asuransi bpjs harus 13 karakter atau tidak boleh dan kurang dari 13 karakter
 * @param {type} obj
 * @returns {give warning} */
function cekNoAsuransiBpjs(){
		<?php if ( Yii::app()->user->getState('isbridging') == true) { ?>
			var nobpjs = $("#PPAsuransipasienbpjsM_nokartuasuransi").val();		
		<?php }else{ ?>
			var nobpjs = $("#PPAsuransipasienM_nokartuasuransi").val();		
		<?php } ?>
		
		<?php if (isset($statusMenu)){ ?>
			var carabayar = $("#PPPasienAdmisiT_carabayar_id option:selected").val();
			var penjamin = $("#PPPasienAdmisiT_penjamin_id option:selected").val();
		<?php }else{ ?>
			var carabayar = $("#PPPendaftaranT_carabayar_id option:selected").val();
			var penjamin = $("#PPPendaftaranT_penjamin_id option:selected").val();
		<?php } ?>
		
		if (typeof nobpjs === 'undefined'){
			
		}else{
			//alert('tenaga');
				if (carabayar == <?php echo Params::CARABAYAR_ID_BPJS ?>){
					if (penjamin == <?php echo Params::PENJAMIN_ID_BPJS_KESEHATAN ?>){
						if (nobpjs.length != 13){
							myAlert("No. Kartu Asuransi BPJS Kesehatan tidak boleh lebih dan tidak boleh kurang dari sama dengan 13 karakter");
							return false;
						}
					}else if (penjamin == <?php echo Params::PENJAMIN_ID_BPJS_KETENAGAKERJAAN ?>){
						
						if (nobpjs.length < 7 || nobpjs.length > 13){
							myAlert("No. Kartu Asuransi BPJS Ketenagakerjaan tidak boleh kurang dari 7 dan lebih dari 13 karakter");
							return false;
						}
					}
				}
		}
		return true;
}

function setKelasTanggunganDrop(){
	<?php
		$drop_kelasbpjs = CHtml::listData(PPPendaftaranT::model()->getKelasTanggunganItems(), 'kelasbpjs_id', 'kelaspelayanan_nama');
		
		$drop_bpjs = '';
		if (count((array)$drop_kelasbpjs)>0){

			if (count((array)$drop_kelasbpjs)>1){
				$drop_bpjs .= CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
			}
			
			foreach($drop_kelasbpjs as $value=>$name)
			{
				$drop_bpjs .= CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
			}
		}
		
		$drop_kelas = CHtml::listData(PPPendaftaranT::model()->getKelasPelayananItems(), 'kelaspelayanan_id', 'kelaspelayanan_nama');
		$drop_asuran = '';

		if (count((array)$drop_kelas)>0){

			if (count((array)$drop_kelas)>1){
				$drop_asuran .= CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
			}
			
			foreach($drop_kelas as $value1=>$name1)
			{
				$drop_asuran .= CHtml::tag('option', array('value'=>$value1),CHtml::encode($name1),true);
			}
		}
	?>
	var dropdown_kelasbpjs = '<?php echo $drop_bpjs; ?>';
	var dropdown_kelas = '<?php echo $drop_asuran; ?>';
	
	<?php if (isset($statusMenu)){ ?>
		var carabayar = $("#PPPasienAdmisiT_carabayar_id option:selected").val();
	<?php }else{ ?>
		var carabayar = $("#PPPendaftaranT_carabayar_id option:selected").val();
	<?php } ?>
		
	if (carabayar == <?php echo Params::CARABAYAR_ID_BPJS ?>){
		$("#PPAsuransipasienM_nokartuasuransi").attr('maxlength',13);
		$("#PPAsuransipasienM_kelastanggunganasuransi_id").html(dropdown_kelasbpjs);
	}else{
		$("#PPAsuransipasienM_nokartuasuransi").attr('maxlength',24);
		$("#PPAsuransipasienM_kelastanggunganasuransi_id").html(dropdown_kelas);
	}
	
	
}

    function setLakaLantas(ojb){
        if($(ojb).val() == 1){
            $("#PPSepT_penjamin_lakalantas").addClass("required");
            $("#PPSepT_lokasi_lakalantas").attr('readonly',false);
            $("#PPSepT_penjamin_lakalantas").attr('disabled',false);
        }else{
            $("#PPSepT_lokasi_lakalantas").attr('readonly',true);
            $("#PPSepT_penjamin_lakalantas").attr('disabled','disabled');
            $("#PPSepT_penjamin_lakalantas").removeClass("required");
            $("#PPSepT_penjamin_lakalantas").removeClass("error");
            $("#PPSepT_penjamin_lakalantas").parents(".control-group").removeClass("error");
        }
    }
    
    function getRujukanDari(kodeppk)
    {
            $.ajax({
                    type: 'POST',
                    url: '<?php echo Yii::app()->createUrl('pendaftaranPenjadwalan/PendaftaranRawatJalan/SetDropdownRujukanDari'); ?>',
                    data: {kodeppk: kodeppk},
                    dataType: "json",
                    success: function (data) {
                        $("#<?php echo CHtml::activeId($modRujukanBpjs,'asalrujukan_id') ?>").html(data.listAsalRujukan);
                        $("#<?php echo CHtml::activeId($modRujukanBpjs,'rujukandari_id') ?>").html(data.listRujukanDari);
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                            console.log(errorThrown);
                    }
            });
    }
    
    function loadFormProsesSEP(obj){
        var url = $(obj).attr('href');
        $('#iframeProsesSEP').attr('src', url);
    }
    
    function loadFormProsesSJP(obj){
        var url = $(obj).attr('href');
        $('#iframeProsesSJP').attr('src', url);
    }
    
    function setCreateSep(obj){
        if ($(obj).is(':checked')) {
            tampilFormBpjs();
            sembunyiFormAsuransi();
            sembunyiFormRujukan();
            $('#form-bpjs').show(); 
            $('#form-asuransi').hide();
            sembunyiNoRujukan();
        }else{
            sembunyiFormBpjs();
            sembunyiFormAsuransi();
            $('#form-bpjs').hide(); 
            $('#form-asuransi').show();
            tampilNoRujukan();
        }
    }
    
    function loadDpjpSkdp(){
        var kode_spesialis = $("#kode_spesialis").val();
        var dpjs_is_load = $("#dpjs_is_load").val();
        
        if(dpjs_is_load == '' && kode_spesialis != ''){
            cariDataDokter();
            $("#dpjs_is_load").val('1');
        }
    }
    
    function setNoPeserta(obj){
        $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs,'nokartuasuransi') ?>").val($(obj).val());
    }
    
    function cekRuanganIGD(){
        var ruangan_id = $("#<?php echo CHtml::activeId($model,'ruangan_id');?>").val();
        var jenisKelamin = $("#PPPasienM_jeniskelamin_0").is(":checked");
        if(ruangan_id == undefined){
            var ruangan_id = $("#PPPasienAdmisiT_ruangan_id").val();
        }
        if(jenisKelamin && ruangan_id=='<?php echo Params::RUANGAN_ID_VK?>'){
            myAlert('Jenis kelamin pasien (Laki-laki) tidak sesuai dengan ruangan tujuan pendaftaran.');
            $("#PPPasienM_jeniskelamin_0").prop( "checked", false );
            $("#PPPasienM_jeniskelamin_1").prop( "checked", true );
        }
    }
    
</script>
    