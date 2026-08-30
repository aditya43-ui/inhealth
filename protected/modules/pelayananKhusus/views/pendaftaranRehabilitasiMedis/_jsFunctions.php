<script type="text/javascript">
/**
 * 
 * @param {type} obj
 * @returns {change attribute maxlength}
 */
function cekLength(obj){
    var cek = $(obj).val();                            
    
    $("#<?php echo CHtml::activeId($modPasien, 'no_identitas_pasien') ?>").attr('onkeyup','setAlphaNumericOnly(this);return $(this).focusNextInputField(event);');
    
    if (cek == '<?php echo Params::JENIS_IDENTTITAS_KTP ?>'){
        $("#<?php echo CHtml::activeId($modPasien, 'no_identitas_pasien') ?>").attr('maxlength',16);
        $("#<?php echo CHtml::activeId($modPasien, 'no_identitas_pasien') ?>").keyup();
    }else{        
        $("#<?php echo CHtml::activeId($modPasien, 'no_identitas_pasien') ?>").attr('maxlength',30);
                
        if (cek == '<?php echo Params::JENIS_IDENTTITAS_PASPOR ?>'){                                    
            $("#<?php echo CHtml::activeId($modPasien, 'no_identitas_pasien') ?>").attr('onkeyup','setAlphaNumericOnly(this);return $(this).focusNextInputField(event);');                                    
        }
    }
    
   
}
    
/**
 * set pasien lama
 * @param {type} pasien_id
 * @returns {undefined}
 */
function setPasienLama(pasien_id, no_rekam_medik ){
    $("#form-pasien > div").addClass("animation-loading");
    setPasienBaru();
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('GetDataPasien'); ?>',
        data: {pasien_id:pasien_id, no_rekam_medik:no_rekam_medik},
        dataType: "json",
        success:function(data){
            
            if (data.adaInap) {
                myAlert("Pasien " + data.listDaftar.pasien.namadepan + data.listDaftar.pasien.nama_pasien + " (" + data.listDaftar.no_pendaftaran + ")\n\
                Hari ini sedang di rawat inap di " + data.listDaftar.ruangan.ruangan_nama + ".");
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
                Hari ini sedang di Instalasi " + data.listDaftar.instalasi.instalasi_nama + " -> " + data.listDaftar.ruangan.ruangan_nama + " dengan status pemeriksan '"
                + data.listDaftar.statusperiksa + "'.");
                $("#form-pasien > div").removeClass("animation-loading");
                $("#<?php echo CHtml::activeId($modPasien,'nama_pasien');?>").val("");
                setPasienBaru();
                isSetLama = false;
                return false;
            }
            
            if(data.statusrekammedis.trim() == "<?php echo Params::STATUSREKAMMEDIS_AKTIF?>"){
                $("#cari_no_rekam_medik").val(data.no_rekam_medik);
                $("#<?php echo CHtml::activeId($modPasien,'pasien_id');?>").val(data.pasien_id);
                $("#<?php echo CHtml::activeId($modPasien,"jenisidentitas");?>").val(data.jenisidentitas);
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
                cekDisabled('form');
                $("#form-pasien > legend > .judul").html('Data Pasien Lama ');
                $("#form-pasien > legend > .tombol").attr('style','display:true;');
                $("#form-pasien > .box").addClass("well").removeClass("box");
            }else{
                myConfirm('Apakah anda akan menggunakan No. Rekam Medik Non-Aktif ?','Perhatian!',
                function(r){
                    if(r){
                        $("#cari_no_rekam_medik").val(data.no_rekam_medik);
                        $("#<?php echo CHtml::activeId($modPasien,'pasien_id');?>").val(data.pasien_id);
                        $("#form-pasien > legend > .judul").html('Data Pasien No. Rekam Medik Lama ');
                        $("#form-pasien > legend > .tombol").attr('style','display:true;');
                        $("#form-pasien > .box").addClass("well").removeClass("box");
                        $("#<?php echo CHtml::activeId($modPasien,'jenisidentitas'); ?>").focus();
                    }
                }); 
            }
            $("#<?php echo CHtml::activeId($model, 'ruangan_id'); ?>").focus(); //<<RND-820 (custom)
            window.scrollBy(0,380); //<<RND-820 (custom)
            $("#form-pasien > div").removeClass("animation-loading");
        },
        error: function (jqXHR, textStatus, errorThrown) { myAlert("Data Pasien tidak ditemukan !"); $("#form-pasien > div").removeClass("animation-loading");}
    });

}
/**
 * set form pasien ke pasien baru 
 * @returns {undefined} */
function setPasienBaru(){
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
    $("#<?php echo CHtml::activeId($modPasien,"kelurahan_id");?>").val("");
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
    
    $("#<?php echo CHtml::activeId($modPasien,"photopasien");?>").val("");
    $('#photo-preview').attr('src','<?php echo Params::urlPhotoPasienDirectory()."no_photo.jpeg"?>');

    setJenisKelaminPasien("");
    setKarcis();

    $("#form-pasien > legend > .judul").html('Data Pasien Baru ');
    $("#form-pasien > legend > .tombol").attr('style','display:none;');
    $("#form-pasien > .well").addClass("box").removeClass("well");
    $("#cari_no_rekam_medik").val("");
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
 * @returns {undefined} */
function setNamaDepan(){
    //belum dapat rule (lihat di pendaftaran RJ)
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
           $("#<?php echo CHtml::activeId($modPenanggungJawab,"umur_pj");?>").val(data.umur);
       },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}
/** bersihkan dropdown kecamatan */
function setClearDropdownKecamatan()
{
    $("#<?php echo CHtml::activeId($modPasien,"kecamatan_id");?>").find('option').remove().end().append('<option value="">-- Pilih --</option>').val('');
}
/** bersihkan dropdown kelurahan */
function setClearDropdownKelurahan()
{
    $("#<?php echo CHtml::activeId($modPasien,"kelurahan_id");?>").find('option').remove().end().append('<option value="">-- Pilih --</option>').val('');
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
       },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
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
       },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}

function setAsuransiLama(){
	$(".judulasuransi").html("Asuransi Lama");
	$(".refreshasuransi").attr("style","display:true;");
}
/**
 * load otomatis asuransi pasien terakhir
 * @returns {undefined}
 */
function setAsuransiPasienLama(pasien_id){
	$.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('SetAsuransiPasienLama'); ?>',
        data: { pasien_id: pasien_id},
        dataType: "json",
        success:function(data){
			myConfirm("Apakah pasien ini akan menggunakan penjamin "+data.penjamin_nama+"?","Konfirmasi!",function(r) {
				if(r){
					setFormAsuransi(data.carabayar_id);
					if(data.carabayar_id == <?php echo Params::CARABAYAR_ID_BPJS ?>){
						getAsuransiNoKartu(data.nopeserta);
					}else{
						$("#<?php echo CHtml::activeId($modAsuransiPasien,'nopeserta') ?>").val(data.nopeserta);
						$("#<?php echo CHtml::activeId($modAsuransiPasien,'asuransipasien_id') ?>").val(data.asuransipasien_id);
						$("#<?php echo CHtml::activeId($modAsuransiPasien,'nokartuasuransi') ?>").val(data.nokartuasuransi);
						$("#<?php echo CHtml::activeId($modAsuransiPasien,'namapemilikasuransi') ?>").val(data.namapemilikasuransi);
						$("#<?php echo CHtml::activeId($modAsuransiPasien,'nomorpokokperusahaan') ?>").val(data.nomorpokokperusahaan);
						$("#<?php echo CHtml::activeId($modAsuransiPasien,'kelastanggunganasuransi_id') ?>").val(data.kelastanggunganasuransi_id);
						$("#<?php echo CHtml::activeId($modAsuransiPasien,'namaperusahaan') ?>").val(data.namaperusahaan);
						$("#<?php echo CHtml::activeId($modAsuransiPasien,'status_konfirmasi') ?>").val(data.status_konfirmasi);
						$("#<?php echo CHtml::activeId($modAsuransiPasien,'tgl_konfirmasi') ?>").val(data.tgl_konfirmasi);
					}
					$("#<?php echo CHtml::activeId($model,"carabayar_id");?>").val(data.carabayar_id);
					$("#<?php echo CHtml::activeId($model,"penjamin_id");?>").html(data.listPenjamin);
					$("#<?php echo CHtml::activeId($model,"penjamin_id");?>").val(data.penjamin_id);
				} 
			}); 
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
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
<?php } ?>
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

/** control accordion penanggung jawab pasien */
$('#form-pjpasien > div > .accordion-heading').click(function(){
    var is_adapjpasien = $("#<?php echo CHtml::activeId($model, "is_adapjpasien"); ?>");
    if(is_adapjpasien.val() > 0){ //hide
        is_adapjpasien.val(0);
    }else{//show
        is_adapjpasien.val(1);
    }
});
/** control accordion karcis rehabilitasi medis*/
$('#form-karcis > div > .accordion-heading').click(function(){
    var is_adakarcis = $("#form-karcis").parent().find('input[name$="[is_adakarcis]"]');
    if(is_adakarcis.val() > 0){ //hide
        is_adakarcis.val(0);
    }else{//show
        is_adakarcis.val(1);
    }
});

/**
 * bersihkan form rujukan
 */
function clearRujukan()
{
    $('#<?php echo CHtml::activeId($modRujukan, 'rujukandari_id')?>').find('option').remove().end().append('<option value="">-- Pilih --</option>').val('');
}
/**
 * set otomatis nama_perujuk dari dropdown rujukandari_id
 * @returns {Boolean}
 */
function setNamaPerujuk(){
    var rujukandari_id = $("#<?php echo CHtml::activeId($modRujukan, 'rujukandari_id')?>").val();
    var nama_perujuk = $("#<?php echo CHtml::activeId($modRujukan, 'rujukandari_id')?>").find('option[value="'+rujukandari_id+'"]').text();
    $("#<?php echo CHtml::activeId($modRujukan, 'nama_perujuk')?>").val(nama_perujuk);
}
/**
 * set form asuransi 
 * @returns {undefined} */
function setFormAsuransi(carabayar_id){
    var carabayar_id_umum = <?php echo Params::CARABAYAR_ID_MEMBAYAR;?>;
    if(carabayar_id != carabayar_id_umum && carabayar_id != ""){
        $('#form-asuransi > .accordion-group > .accordion-heading').find(".btn").addClass("btn-primary");
        $('#form-asuransi > .accordion-group > .accordion-heading').find(".icon-minus").addClass("icon-ok").removeClass("icon-minus");
        $('#content-asuransi').removeClass().addClass("accordion-body in collapse");
        $('#content-asuransi').find(".not-required").addClass("required").removeClass("not-required");
        $('#content-asuransi').removeAttr("style").attr("style","height:auto"); 
        $('#content-asuransi').find("input,select,textarea").removeAttr("disabled"); 
    }else{
        $('#content-asuransi').find(".required").addClass("not-required").removeClass("required");
        $('#form-asuransi > .accordion-group > .accordion-heading').find(".btn").removeClass("btn-primary");
        $('#form-asuransi > .accordion-group > .accordion-heading').find(".icon-ok").addClass("icon-minus").removeClass("icon-ok");
        $('#content-asuransi').removeClass().addClass("accordion-body collapse");
        $('#content-asuransi').removeAttr("style").attr("style","height:0px"); 
        $('#content-asuransi').find("input,select,textarea").attr("disabled",true); 
    }
}

/**
 * menampilkan karcis berdasarkan index form
 */
function setKarcis()
{
    var pasien_id=$("#<?php echo CHtml::activeId($modPasien,"pasien_id");?>").val();
    var penjamin_id=$("#<?php echo CHtml::activeId($model,"penjamin_id");?>").val();
    var ruangan_id = $("#form-pemeriksaan").find('input[name$="[ruangan_id]"]').val();
    var kelaspelayanan_id = $("#form-pemeriksaan").find('select[name$="[kelaspelayanan_id]"]').val();
    if(ruangan_id !== "" && kelaspelayanan_id !== "" && penjamin_id !== "") {
        $("#form-karcis").addClass("animation-loading");
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('SetKarcis'); ?>',
            data: {kelaspelayanan_id:kelaspelayanan_id, ruangan_id : ruangan_id, penjamin_id:penjamin_id, pasien_id:pasien_id},//
            dataType: "json",
            success:function(data){
                $("#form-karcis #content-karcis-html").html(data.listKarcis);
                $("#form-karcis").removeClass("animation-loading");
            },
             error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        });
    }else{
       $("#form-karcis").find("#content-karcis-html").html("");
    }
       
}

/**
 * pilih karcis (check - uncheck)
 * harus pilih salah satu
 */
function pilihKarcis(obj){
    var is_pilihtindakan = $(obj).parents('tr').find('input[name$="[is_pilihkarcis]"]');
    $(obj).parents('table').find('tr').each(function(){
        $(this).find('input[name$="[is_pilihkarcis]"]').val(0);
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
 * menampilkan form verifikasi
 * @returns {undefined}
 */
function setVerifikasi(){
    if(requiredCheck($("form"))){
        $('#dialog-verifikasi').dialog("open");
        $.ajax({
           type:'POST',
           url:'<?php echo $this->createUrl('verifikasi'); ?>',
           data: $("form").serialize(),
           dataType: "json",
           success:function(data){
                $('#dialog-verifikasi > .dialog-content').html(data.content);
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
    }
    return false;
}

/**
* tombol batal pada dialogbox
* @param {type} dialog_id
* @returns {undefined} 
*/
function batalDialog(dialog_id){
   myConfirm('Apakah anda yakin akan membatalkan ini?','Perhatian!',
    function(r){
        if(r){
           $('#'+dialog_id).dialog("close");
        }
    }); 
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
 * update (refresh) checklist pemeriksaan lab
 * harus include /js/jquery.tiler.js
 * @param {obj} form_checklist
 */
function updateChecklistPemeriksaanRehab(){
    $('#dialog-pilihpemeriksaan .dialog-content').addClass("animation-loading");
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('SetChecklistPemeriksaanRehab'); ?>',
        data: {data:$("#form-caripemeriksaan :input").serialize()},
        dataType: "json",
        success:function(data){
            $('#dialog-pilihpemeriksaan .dialog-content').html(data.content);
            $('.checkboxlist-tile').tile({widths : [ 256 ]});
            $('#dialog-pilihpemeriksaan .dialog-content').removeClass("animation-loading");
            setCheckedPemeriksaan($("#form-tindakanpemeriksaan-"),$('#dialog-pilihpemeriksaan .dialog-content'));
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}

/**
 * Set checklist pemeriksaan lab
 * obj = div yang berisi elemen ruangan_id, kelaspelayanan_id
 */
function setChecklistPemeriksaanRehab(obj){
    var penjamin_id = $("#<?php echo CHtml::activeId($model, 'penjamin_id') ?>").val();
    var ruangan_id = $(obj).find("input[name$='[ruangan_id]']").val();
    var kelaspelayanan_id = $(obj).find("select[name$='[kelaspelayanan_id]']").val();
    if(penjamin_id == ""){
        myAlert("Silakan pilih penjamin!");
    }else if(kelaspelayanan_id == ""){
        myAlert("Silakan pilih kelas pelayanan!");
    }else{
        $("#form-caripemeriksaan").find("input[name$='[ruangan_id]']").val(ruangan_id);
        $("#form-caripemeriksaan").find("input[name$='[penjamin_id]']").val(penjamin_id);
        $("#form-caripemeriksaan").find("input[name$='[kelaspelayanan_id]']").val(kelaspelayanan_id);
        updateChecklistPemeriksaanRehab();
        $('#dialog-pilihpemeriksaan').dialog('open'); 
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
 * Centang pemeriksaan rad dari checkboxlist
 */
function pilihPemeriksaanIni(obj){
    var jenistindakanrm_id = $(obj).parent().find('input[name$="[jenistindakanrm_id]"]').val();
    var jenistindakanrm_nama = $(obj).parent().find('input[name$="[jenistindakanrm_nama]"]').val();
    var tindakanrm_nama = $(obj).parent().find('input[name$="[tindakanrm_nama]"]').val();
    var tindakanrm_id = $(obj).parent().find('input[name$="[tindakanrm_id]"]').val();
    var daftartindakan_id = $(obj).parent().find('input[name$="[daftartindakan_id]"]').val();
    var jenistarif_id = $(obj).parent().find('input[name$="[jenistarif_id]"]').val();
    var harga_tariftindakan = $(obj).parent().find('input[name$="[harga_tariftindakan]"]').val();
    var rowtindakan = '<?php echo CJSON::encode($this->renderPartial($this->path_view.'_rowTindakanPemeriksaan',array('modTindakan'=>$modTindakan),true));?>';
    if($(obj).is(':checked')){
        $("#form-tindakanpemeriksaan").find('tbody').append(rowtindakan);
        $("#form-tindakanpemeriksaan").find('input[name$="[ii][tindakanpelayanan_id]"]').val("");
        $("#form-tindakanpemeriksaan").find('input[name$="[ii][jenistindakanrm_id]"]').val(jenistindakanrm_id);
        $("#form-tindakanpemeriksaan").find('input[name$="[ii][tindakanrm_id]"]').val(tindakanrm_id);
        $("#form-tindakanpemeriksaan").find('input[name$="[ii][daftartindakan_id]"]').val(daftartindakan_id);
        $("#form-tindakanpemeriksaan").find('input[name$="[ii][jenistarif_id]"]').val(jenistarif_id);
        $("#form-tindakanpemeriksaan").find('span[name$="[ii][tindakanrm_nama]"]').html(tindakanrm_nama);
        $("#form-tindakanpemeriksaan").find('input[name$="[ii][satuantindakan]"]').val("<?php echo Params::SATUAN_TINDAKAN_LABORATORIUM; ?>");
        $("#form-tindakanpemeriksaan").find('input[name$="[ii][tarif_satuan]"]').val(harga_tariftindakan);
        $("#form-tindakanpemeriksaan").find('input[name$="[ii][tarif_tindakan]"]').val(formatInteger(harga_tariftindakan));
    }else{
        var delete_row = $("#form-tindakanpemeriksaan").find('input[name$="[tindakanrm_id]"][value="'+tindakanrm_id+'"]').parents('tr');
        delete_row.detach();
    }
    renameInputRow($("#form-tindakanpemeriksaan"));
}

function setNoKartuAsuransi(){
    var nopeserta       = $("input[name$='[nopeserta]']").val();
    $("input[name$='[nokartuasuransi]']").val(nopeserta);
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
function setCheckedPemeriksaan(obj_table,obj_dialog){
    $(obj_table).find('input[name$="[pemeriksaanrad_id]"]').each(function(){
        var pemeriksaanrad_id = $(this).val();
        $(obj_dialog).find('input[name$="[is_pilih]"][value='+pemeriksaanrad_id+']').attr('checked',true);
    });
}

function setNamaPemilikUntukCaraBayar() {
    if ($("#RMPendaftaranT_carabayar_id").val() != <?php echo Params::CARABAYAR_ID_MEMBAYAR; ?>) {
        $("#RMAsuransipasienM_namapemilikasuransi").val($("#RMPasienM_nama_pasien").val());
    }
}


/**
 * print kartu pasien
 */
function printKartuPasien(pasien_id)
{       
    window.open('<?php echo $this->createUrl('printKartuPasien'); ?>&pasien_id='+pasien_id,'printwin','left=100,top=100,width=480,height=640');
}

/**
 * print status 
 */
function printStatus(pendaftaran_id)
{
    window.open('<?php echo $this->createUrl('printStatusRehabMedis'); ?>&pendaftaran_id='+pendaftaran_id,'printwin','left=100,top=100,width=480,height=640');
}

function printLabel(){
  window.open('<?php echo $this->createUrl('printLabel',array('pendaftaran_id'=>$model->pendaftaran_id)); ?>','printwin','left=100,top=100,width=860,height=480');
}



/**
 * untuk print otomatis */
function autoPrint(){
    window.scrollBy(0,10000);
    <?php if(Yii::app()->user->getState('printkartulsng')==TRUE){ ?>
        window.open('<?php echo $this->createUrl('PendaftaranRawatJalan/printKartuPasien',array('pasien_id'=>$model->pasien_id)); ?>','','left=100,top=100,width=480,height=640');
    <?php  } ?>
    <?php if(Yii::app()->user->getState('printkunjunganlsng')==TRUE){ ?>
        window.open('<?php echo $this->createUrl('printStatusRehabMedis',array('pendaftaran_id'=>$model->pendaftaran_id)); ?>','printwin','left=100,top=100,width=480,height=640');
    <?php  } ?>
}

/**
 * javascript yang di running setelah halaman ready / load sempurna
 * posisi script ini harus tetap dibawah
 */
$( document ).ready(function(){
    setUmur($("#<?php echo CHtml::activeId($modPasien, 'tanggal_lahir') ;?>").val());
    renameInputRow($("#form-tindakanpemeriksaan-0"));
    renameInputRow($("#form-tindakanpemeriksaan-1"));
    <?php if(!$model->isNewRecord){ ?>
        autoPrint();
        $("input, select, textarea").attr("disabled",true);
    <?php } ?>

    // Notifikasi Pasien
    <?php 
        if(isset($_GET['smspasien'])){
            if($_GET['smspasien']==0){
    ?>
        var params = [];
        params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Yii::app()->session['modul_id']; ?>, judulnotifikasi:'GAGAL KIRIM SMS PASIEN', isinotifikasi:'Pasien <?php echo $model->pasien->nama_pasien; ?> tidak memiliki nomor mobile'}; // 16 
        simpanNotifikasi(params);
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
        simpanNotifikasi(params);
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
        simpanNotifikasi(params);
    <?php            
            }
        }
    ?>
});

</script>