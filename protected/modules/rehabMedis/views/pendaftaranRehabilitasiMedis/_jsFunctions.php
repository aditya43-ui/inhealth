<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>

<style>
    .checked td {
        background-color: yellow;
    }
</style>
<script type="text/javascript">

function switchOtomatis(obj) {
    otoval = $(obj).val();
    checkOto();
}

/**
 * print kartu pasien
 */
function printKartuPasien()
{
    window.open('<?php echo $this->createUrl('PendaftaranRawatJalan/printKartuPasien',array('pasien_id'=>$model->pasien_id)); ?>','printwin','left=100,top=100,width=480,height=640');
}

function setPegawai(pegawai_id, nip) {
    $.post('<?php echo $this->createUrl('getDataPegawaiUntukPasienBaru'); ?>', {
        pegawai_id: pegawai_id, nip: nip
    }, function(data) {
        if (data.ok == 0) {
            myAlert(data.msg);
            $("#RMPasienM_nomorindukpegawai").val("").focus();
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

function checkOto() {

    if (otoval == 1) {
        $(".labelrm").show();
        $(".rm_lama").hide();
        $(".rm_baru").hide();
        $("#lb_rm_lama").removeClass("required").find("span").removeClass("required").hide();
		<?php
			if ($model->buatjanjipoli_id == ''){
		?>
			$("#no_rekam_medik_baru, #RMPasienM_nomorindukpegawai").val("");
		<?php
			}
		?>
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
			$("#no_rekam_medik_baru, #RMPasienM_nomorindukpegawai").val("");
		<?php
			}
		?>
        $(".rm_nip_baru").show().find(":input").prop("disabled", true);
        $(".normpilihan").addClass('hide');
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
            if(data.statusrekammedis.trim() == "<?php echo Params::STATUSREKAMMEDIS_AKTIF?>"){
                $("#cari_no_rekam_medik").val(data.no_rekam_medik);
                $("#no_rekam_medik_baru").val(data.no_rekam_medik);
                $("#cari_nomorindukpegawai").val(data.nomorindukpegawai);
                $("#<?php echo CHtml::activeId($modPasien,'pasien_id');?>").val(data.pasien_id);
                $("#<?php echo CHtml::activeId($modPasien,'no_rekam_medik');?>").val(data.pasien_id);
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
                $("#<?php echo CHtml::activeId($modPasien,"is_ambilfoto");?>").val(0);

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
                                
                if (getDataRiwayatVaksinasi != null) {
                    getDataRiwayatVaksinasi(data.pasien_id);
                }                
                                
                cekDisabled('.form_pendaftaran');
                $("#form-pasien > legend > .judul").html('Data Pasien Lama ');
                $("#form-pasien > legend > .tombol").attr('style','display:true;');
                $("#form-pasien > .box").addClass("well").removeClass("box");
            }else{
                myConfirm('Apakah Anda akan menggunakan No. Rekam Medik Non-Aktif?','Perhatian!',
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
        error: function (jqXHR, textStatus, errorThrown) { myAlert("Data Pasien tidak ditemukan!"); $("#form-pasien > div").removeClass("animation-loading");}
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
 *
 * @returns {undefined} */
function setNamaDepan(){

    var statusperkawinan = $('#RMPasienM_statusperkawinan').val();
    var namadepan = $('#RMPasienM_namadepan');
    var umur = $("#<?php echo CHtml::activeId($model,'umur');?>").val().substr(0,2);
    umur = parseInt(umur);

    console.log(umur);

    if(umur <= 5){
        var namadepan = $('#RMPasienM_namadepan').val('By. ');
        if(statusperkawinan.length > 0 && statusperkawinan != "DIBAWAH UMUR"){
            $('#RMPasienM_statusperkawinan').val('');
            alert('Maaf status perkawinan belum cukup usia');
        }
    }else if(umur <= 14){ //
        var namadepan = $('#RMPasienM_namadepan').val('An. ');
        if(statusperkawinan.length > 0 && statusperkawinan != "DIBAWAH UMUR"){
            $('#RMPasienM_statusperkawinan').val('');
            alert('Maaf status perkawinan belum cukup usia');
        }
    }else{;
        if($('#RMPasienM_jeniskelamin_0').is(':checked')){
            if(statusperkawinan !== 'JANDA'){
                var namadepan = $('#RMPasienM_namadepan').val('Tn. ');
            }else{
                alert('Pilih status pernikahan yang sesuai!');
                $('#RMPasienM_statusperkawinan').val('KAWIN');
                var namadepan = $('#RMPasienM_namadepan').val('Tn. ')
            }

        }

        if($('#RMPasienM_jeniskelamin_1').is(':checked')) {
            $('#RMPasienM_namadepan').val('Nn. ');
            if(statusperkawinan !== 'DUDA') {
                var namadepan = $('#RMPasienM_namadepan').val('Nn. ');
                if(statusperkawinan === 'KAWIN' || statusperkawinan == 'JANDA' || statusperkawinan == 'NIKAH SIRIH' || statusperkawinan == 'POLIGAMI'){
                    var namadepan = $('#RMPasienM_namadepan').val('Ny. ');
                } else {
                    var namadepan = $('#RMPasienM_namadepan').val('Nn. ');
                }
            } else {
                alert('Pilih status pernikahan yang sesuai!');
                $('#RMPasienM_statusperkawinan').val('KAWIN');
                var namadepan = $('#RMPasienM_namadepan').val('Ny. ');
            }
        }

        if (statusperkawinan == "DIBAWAH UMUR"){
            alert('Pilih status pernikahan yang sesuai!');
            $('#RMPasienM_statusperkawinan').val('BELUM KAWIN');
        }
    }
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
	var pegawai_id = $("#RMPasienM_pegawai_id").val();
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
											getAsuransiNoKartu(datanopeserta, data);
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
					}
//				});
			}
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
    var carabayar_id_bpjs = <?php echo Params::CARABAYAR_ID_BPJS;?>;
    var carabayar_id_asuransi = <?php echo Params::CARABAYAR_ID_ASURANSI; ?>
    
    if(carabayar_id == carabayar_id_umum){
        sembunyiFormAsuransi();
        sembunyiFormBpjs();
        
        $('#form-bpjs').hide();
        $('#form-asuransi').hide();
    } else if(carabayar_id == carabayar_id_bpjs){
        
        tampilFormBpjs();
        $('.cekBPJS').removeClass('hidden');
        sembunyiFormAsuransi();
        $('#form-asuransi').hide();
        $('#form-bpjs').show();
        
    } else if (carabayar_id == carabayar_id_asuransi) {
        
        tampilFormAsuransi();
        sembunyiFormBpjs();
        $('#form-bpjs').hide();
        $('#form-asuransi').show();
        
    }
    
    
//    if(carabayar_id != carabayar_id_umum && carabayar_id != ""){
//        $('#form-asuransi > .accordion-group > .accordion-heading').find(".btn").addClass("btn-primary");
//        $('#form-asuransi > .accordion-group > .accordion-heading').find(".icon-minus").addClass("icon-ok").removeClass("icon-minus");
//        $('#content-asuransi').removeClass().addClass("accordion-body in collapse");
//        $('#content-asuransi').find(".not-required").addClass("required").removeClass("not-required");
//        $('#content-asuransi').removeAttr("style").attr("style","height:auto");
//        $('#content-asuransi').find("input,select,textarea").removeAttr("disabled");
//    }else{
//        $('#content-asuransi').find(".required").addClass("not-required").removeClass("required");
//        $('#form-asuransi > .accordion-group > .accordion-heading').find(".btn").removeClass("btn-primary");
//        $('#form-asuransi > .accordion-group > .accordion-heading').find(".icon-ok").addClass("icon-minus").removeClass("icon-ok");
//        $('#content-asuransi').removeClass().addClass("accordion-body collapse");
//        $('#content-asuransi').removeAttr("style").attr("style","height:0px");
//        $('#content-asuransi').find("input,select,textarea").attr("disabled",true);
//    }
}


function sembunyiFormAsuransi(){
        $('#content-asuransi').find(".required").addClass("not-required").removeClass("required");
        $('#form-asuransi > .accordion-group > .accordion-heading').find(".btn").removeClass("btn-primary");
        $('#form-asuransi > .accordion-group > .accordion-heading').find(".icon-ok").addClass("icon-minus").removeClass("icon-ok");
        $('#content-asuransi').removeClass().addClass("accordion-body collapse");
        $('#content-asuransi').removeAttr("style").attr("style","height:0px");
        $('#content-asuransi').find("input,select,textarea").attr("disabled",true);

}
function tampilFormAsuransi(){
        $('#form-asuransi > .accordion-group > .accordion-heading').find(".btn").addClass("btn-primary");
        $('#form-asuransi > .accordion-group > .accordion-heading').find(".icon-minus").addClass("icon-ok").removeClass("icon-minus");
        $('#content-asuransi').removeClass().addClass("accordion-body in collapse");
        $('#content-asuransi').find(".not-required").addClass("required").removeClass("not-required");
        $('#content-asuransi').removeAttr("style").attr("style","height:auto");
        $('#content-asuransi').find("input,select,textarea").removeAttr("disabled");
        $("#<?php echo CHtml::activeId($modAsuransiPasien, "status_konfirmasi"); ?>").prop("checked", true);
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
        $('.cekBPJS').addClass('hidden');
}
function tampilFormBpjs(){
        $('#form-bpjs > .accordion-group > .accordion-heading').find(".btn").addClass("btn-primary");
        $('#form-bpjs > .accordion-group > .accordion-heading').find(".icon-minus").addClass("icon-ok").removeClass("icon-minus");
        $('#content-bpjs').removeClass().addClass("accordion-body in collapse");
        $('#content-bpjs').find(".not-required").addClass("required").removeClass("not-required");
        $('#content-bpjs').removeAttr("style").attr("style","height:auto");
        $('#content-bpjs').find("input,select,textarea").removeAttr("disabled");
        $('#content-bpjs').find(".nosep").attr("disabled",true);
        var is_bpjs = $("#<?php echo CHtml::activeId($model, "is_bpjs"); ?>");
        is_bpjs.val(1);
        $('.cekBPJS').removeClass('hidden');
}

function bpjsManual() {
        // console.log(obj);
        //if ($(obj).is(':checked') ) {
        if ($('.permanent').is(':checked') ) {
            // console.log("masuk sini nggk");
            $('#content-bpjs').find(".bpjs").find("input,select,textarea,label").attr("disabled", true);
            $('#content-bpjs').find(".bpjs").addClass('hidden');

            $('#content-bpjs').find(".bpjs-manual").find("input,select,textarea,label").attr("disabled", false);
            $('#content-bpjs').find(".bpjs-manual").removeClass('hidden');
        } else {
            $('#content-bpjs').find(".bpjs").find("input,select,textarea,label").attr("disabled", false);
            $('#content-bpjs').find(".bpjs").removeClass('hidden');
            
            $('#content-bpjs').find(".bpjs-manual").find("input,select,textarea,label").attr("disabled", true);
            $('#content-bpjs').find(".bpjs-manual").addClass('hidden');
        }
    }


/**
 * fungsi BPJS
 */
 function getAsuransiNoKartu(isi, databpjs)
 {
     if (<?php echo (Yii::app()->user->getState('isbridging')==TRUE)?1:0; ?>) {}else{myAlert('Fitur Bridging tidak aktif!'); return false;}
     if (isi=="") {myAlert('Isi data terlebih dahulu!'); return false;};
     var aksi = 4; // 1 untuk mencari data peserta berdasarkan Nomor Kartu

         resetFormBpjs();

     var setting = {
         url : "<?php echo $this->createUrl('/pendaftaranPenjadwalan/pendaftaranRawatJalan/bpjsInterface'); ?>",
         type : 'GET',
         dataType : 'html',
         data : 'param='+ aksi + '&query=' + isi,
         beforeSend: function(){
             $("#content-bpjs").addClass("animation-loading");
         },
         success: function(data){
             $("#content-bpjs").removeClass("animation-loading");
             var obj = JSON.parse(data);

             if(obj != null && obj.response !=null){
                 if(obj.response.rujukan != null && obj.response.rujukan != undefined){
                      var rujukan = obj.response.rujukan;
                     var peserta = rujukan.peserta;
                 }else{
                     var peserta = obj.response.peserta;
                 }

             if (peserta.statusPeserta.keterangan == 'AKTIF') {

                var provRujukan = rujukan.provPerujuk;

                 setKelasTanggunganDrop();
                 getRujukanDari(provRujukan.kode);
                 $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs,'jenispersertakode_bpjs') ?>").val(peserta.jenisPeserta.kode);
                 $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs,'jenispeserta_bpjs') ?>").val(peserta.jenisPeserta.keterangan);
                 $("#<?php echo CHtml::activeId($modSep,'ppkrujukan') ?>").val(peserta.provUmum.kdProvider);
                 $("#<?php echo CHtml::activeId($modRujukanBpjs, 'nama_perujuk') ?>").val(provRujukan.nama);
                 $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs,'nopeserta') ?>").val(peserta.noKartu);
                 $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs,'nokartuasuransi') ?>").val(peserta.noKartu);
                 $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs,'namapemilikasuransi') ?>").val(peserta.nama);
                  $("#RMAsuransipasienbpjsM_kelastanggunganasuransi_id").val(peserta.hakKelas.kode);
                  $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs,'jenispersertakode_bpjs') ?>").val(peserta.jenisPeserta.kode);
               $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs,'jenispeserta_bpjs') ?>").val(peserta.jenisPeserta.keterangan);

                 <?php if($this->id == "pendaftaranRawatDarurat"){ ?>
                     getPPKPelayanan();
                 <?php }else if($this->id == "pendaftaranRawatInapDariRJRD"){ ?>
                     if($('#instalasiasalRI_id').val() != undefined && $('#instalasiasalRI_id').val() == '<?php echo Params::INSTALASI_ID_RD; ?>'){
                         getPPKPelayanan();
                     }
                 <?php } ?>

                 if(rujukan != null && rujukan != undefined){
                     $("#<?php echo CHtml::activeId($modRujukanBpjs,'no_rujukan') ?>").val(rujukan.noKunjungan);
                     $("#<?php echo CHtml::activeId($modRujukanBpjs,'nama_perujuk') ?>").val(rujukan.provPerujuk.nama);
                     $("#<?php echo CHtml::activeId($modRujukanBpjs,'tanggal_rujukan') ?>").val(rujukan.tglKunjungan);
                     setDiagnosaBpjs(rujukan.diagnosa.kode,rujukan.diagnosa.nama);
                 }
                 $("#<?php echo CHtml::activeId($modSep,'no_telpon_peserta') ?>").val($("#<?php echo CHtml::activeId($modPasien,'no_mobile_pasien') ?>").val());
             }

             }else{
                 if (obj != null) {
                     if (typeof obj.metaData !== 'undefined'){
                          if(obj.metaData.message != 'Rujukan Tidak Ada'){
                             myAlert(obj.metaData.message);
                         }
                     }else{
                             if (typeof databpjs !== 'undefined'){
                                     $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs,'nopeserta') ?>").val(databpjs.nopeserta);
                                     $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs,'asuransipasien_id') ?>").val(databpjs.asuransipasien_id);
                                     $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs,'nokartuasuransi') ?>").val(databpjs.nokartuasuransi);
                                     $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs,'namapemilikasuransi') ?>").val(databpjs.namapemilikasuransi);
                                     $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs,'jenispeserta_id') ?>").val(databpjs.jenispeserta_id);
                                     $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs,'kelastanggunganasuransi_id') ?>").val(databpjs.kelastanggunganasuransi_id); // <<tidak sama dengan kelaspelayanan_id
                             }
                     }
                 }else{

                         if (typeof databpjs !== 'undefined'){
                                 $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs,'nopeserta') ?>").val(databpjs.nopeserta);
                                 $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs,'asuransipasien_id') ?>").val(databpjs.asuransipasien_id);
                                 $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs,'nokartuasuransi') ?>").val(databpjs.nokartuasuransi);
                                 $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs,'namapemilikasuransi') ?>").val(databpjs.namapemilikasuransi);
                                 $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs,'jenispeserta_id') ?>").val(databpjs.jenispeserta_id);
                                 $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs,'kelastanggunganasuransi_id') ?>").val(databpjs.kelastanggunganasuransi_id); // <<tidak sama dengan kelaspelayanan_id
                         }
                 }
 				//alert(3);
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
                $(".form_pendaftaran").find('.integer-decimal').each(function(){
                    $(this).val(formatThousandDecimal($(this).val()));
                });
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
    /*
    $(obj).parents('table').find('tr').each(function(){
        $(this).find('input[name$="[is_pilihkarcis]"]').val(0);
        $(this).removeClass('checked');
    });
    */
    if(is_pilihtindakan.val() > 0){
        is_pilihtindakan.val(0);
        $(obj).parents('tr').removeClass('checked');
		$(obj).find('i').removeClass('icon-form-check');
		$(obj).find('i').addClass('icon-form-silang');
    }else{
        is_pilihtindakan.val(1);
        $(obj).parents('tr').addClass('checked');
		$(obj).find('i').removeClass('icon-form-silang');
		$(obj).find('i').addClass('icon-form-check');
    }
}

/**
 * menampilkan form verifikasi
 * @returns {undefined}
 */
function setVerifikasi(){
    
    if (cekValidasiRiwayatVaksinasi != null) {
        if (!cekValidasiRiwayatVaksinasi()) {
            return false;
        }
    }
    
    if(requiredCheck($(".form_pendaftaran"))){
      $(".form_pendaftaran").find('.integer-decimal, .float, .integer').each(function(){
          $(this).val(unformatNumber($(this).val()));
      });
        $('#dialog-verifikasi').dialog("open");
        $.ajax({
           type:'POST',
           url:'<?php echo $this->createUrl('verifikasi'); ?>',
           data: $(".form_pendaftaran").serialize(),
           dataType: "json",
           success:function(data){
                $('#dialog-verifikasi > .dialog-content').html(data.content);
           },
            error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown); }
        });
        //untuk verifikasi hilangkan srbac loading
        $(".animation-loading").removeClass("animation-loading");
        $(".form_pendaftaran").find('.float').each(function(){
            $(this).val(formatFloat($(this).val()));
        });
        $(".form_pendaftaran").find('.integer').each(function(){
            $(this).val(formatInteger($(this).val()));
        });
        $(".form_pendaftaran").find('.integer-decimal').each(function(){
            $(this).val(formatThousandDecimal($(this).val()));
        });
    }
    return false;
}

function setVerifikasi2(){
    
    if (cekValidasiRiwayatVaksinasi != null) {
        if (!cekValidasiRiwayatVaksinasi()) {
            return false;
        }
    }
    
    if(requiredCheck($(".form_pendaftaran"))){

        if ($(".is_adapjpasien").val() == 1){
                myAlert("Penanggung jawab pasien harus diisi.");
                return false;
            }
      $(".form_pendaftaran").find('.integer-decimal, .float, .integer').each(function(){
          $(this).val(unformatNumber($(this).val()));
      });
        $('#dialog-verifikasi').dialog("open");
        $.ajax({
           type:'POST',
           url:'<?php echo $this->createUrl('verifikasi'); ?>',
           data: $(".form_pendaftaran").serialize(),
           dataType: "json",
           success:function(data){
                $('#dialog-verifikasi > .dialog-content').html(data.content);
           },
            error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown); }
        });
        //untuk verifikasi hilangkan srbac loading
        $(".animation-loading").removeClass("animation-loading");
        $(".form_pendaftaran").find('.float').each(function(){
            $(this).val(formatFloat($(this).val()));
        });
        $(".form_pendaftaran").find('.integer').each(function(){
            $(this).val(formatInteger($(this).val()));
        });
        $(".form_pendaftaran").find('.integer-decimal').each(function(){
            $(this).val(formatThousandDecimal($(this).val()));
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
   myConfirm('Apakah Anda yakin akan membatalkan ini?','Perhatian!',
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
        data: {data:$("#form-caripemeriksaan :input, #RMPasienmasukpenunjangT_ruangan_id").serialize()},
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

/**
 * print kartu pasien
 */
function printKartuPasien(pasien_id)
{
    window.open('<?php echo $this->createUrl('PendaftaranRawatJalan/printKartuPasien'); ?>&pasien_id='+pasien_id,'printwin','left=100,top=100,width=480,height=640');
}}

/**
 * print status
 */
function printStatus(pendaftaran_id)
{
    window.open('<?php echo $this->createUrl('printStatusRehabMedis'); ?>&pendaftaran_id='+pendaftaran_id,'printwin','left=100,top=100,width=480,height=640');
}
function printKlaim(pendaftaran_id)
{
    window.open('<?php echo $this->createUrl('printKlaim'); ?>&pendaftaran_id='+pendaftaran_id,'printwin','left=100,top=100,width=480,height=640');
}
function printKlaim2() {
    window.open('<?php echo $this->createUrl('printKlaim2', array('pendaftaran_id' => $model->pendaftaran_id, 'caraPrint'=>'Print')); ?>', '_blank', 'printwin', 'left=100,top=100,width=860,height=480');
}
function printSEP(){
  window.open('<?php echo $this->createUrl('printSep',array('sep_id'=>$modSep->sep_id,'pendaftaran_id'=>$model->pendaftaran_id)); ?>','printwin_sep','left=100,top=100,width=860,height=480');
}
function printLabel() {
    window.open('<?php echo $this->createUrl('printLabel', array('pendaftaran_id' => $model->pendaftaran_id)); ?>', 'printwin', 'left=100,top=100,width=860,height=480');
}

/**
 * untuk print otomatis */
function autoPrint(){
    window.scrollBy(0,10000);
    <?php if(Yii::app()->user->getState('printkartulsng')==TRUE){ ?>
        window.open('<?php echo $this->createUrl('PendaftaranRawatJalan/printKartuPasien',array('pasien_id'=>$model->pasien_id)); ?>','','left=100,top=100,width=480,height=640');
    <?php  } ?>
    <?php if(Yii::app()->user->getState('printkunjunganlsng')==TRUE){ ?>
        // window.open('<?php //echo $this->createUrl('printStatusRehabMedis',array('pendaftaran_id'=>$model->pendaftaran_id)); ?>','printwin','left=100,top=100,width=480,height=640');
        window.open('<?php echo $this->createUrl('printKlaim', array('pendaftaran_id' => $model->pendaftaran_id, 'caraPrint'=>'Print')); ?>', '_blank', 'printwin', 'left=100,top=100,width=860,height=480');
        printKlaim2();
    <?php  } ?>
    <?php if (Yii::app()->user->getState('isbridging') && isset($modSep->sep_id)) { ?>
        printSEP();
    <?php } ?>
}

/**
 * javascript yang di running setelah halaman ready / load sempurna
 * posisi script ini harus tetap dibawah
 */
$( document ).ready(function(){

    $(".rb_rm").eq(1).click();

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
    <?php if (isset($_GET['sukses'])){ ?>
     $("#no_rekam_medik_baru").val('<?php echo $modPasien->no_rekam_medik; ?>');
     $("#pendaftaranFP").prop("disabled", false );
     $("#verifikasiFP").prop("disabled", false );
    <?php } ?>
});

function setInputBerdasarkanNoKTP() {
    var jenis = $('#<?php echo CHtml::activeId($modPasien,'jenisidentitas'); ?>').val();
    var no_ktp = $('#<?php echo CHtml::activeId($modPasien,'no_identitas_pasien'); ?>').val();
    
    
    if (otoval != 1 || jenis != 'KTP') {
        return false;
    }
    
    //$('#<?php echo CHtml::activeId($modPasien,'no_identitas_pasien'); ?>').addClass("animation-loading");
    
    $.post('<?php echo $this->createUrl('inputDariNoKTP'); ?>', {
        no_ktp: no_ktp
    }, function(data) {
        $('#<?php echo CHtml::activeId($modPasien,'tanggal_lahir'); ?>').val(data.tanggal_lahir_format);
        setJenisKelaminPasien(data.jeniskelamin);
        if (data.propinsi_id != null && data.kabupaten_id != null && data.kecamatan_id != null) {
            setDaerahPasien(data.propinsi_id, data.kabupaten_id, data.kecamatan_id, null);
        }
        setUmur(data.tanggal_lahir);
        //$('#<?php echo CHtml::activeId($modPasien,'no_identitas_pasien'); ?>').removeClass("animation-loading");
    }, 'json');
    
}


 function getAsuransiNoPeserta(isi)
 {
     if (<?php echo (Yii::app()->user->getState('isbridging')==TRUE)?1:0; ?>) {}else{myAlert('Fitur Bridging tidak aktif!'); return false;}
     if (isi=="") {myAlert('Isi data terlebih dahulu!'); return false;};
     var aksi = 1; // 1 untuk mencari data peserta berdasarkan Nomor Kartu

         resetFormBpjs();

     var setting = {
         url : "<?php echo $this->createUrl('/pendaftaranPenjadwalan/pendaftaranRawatJalan/bpjsInterface'); ?>",
         type : 'GET',
         dataType : 'html',
         data : 'param='+ aksi + '&query=' + isi,
         beforeSend: function(){
             $("#content-bpjs").addClass("animation-loading");
         },
         success: function(data){
             $("#content-bpjs").removeClass("animation-loading");
             var obj = JSON.parse(data);

             if(obj != null && obj.response !=null){
                 var peserta = obj.response.peserta;

 		getAsuransiNoKartu(peserta.noKartu);
                 setKelasTanggunganDrop();
                 getRujukanDari(peserta.provUmum.kdProvider);
                 $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs,'jenispersertakode_bpjs') ?>").val(peserta.jenisPeserta.kode);
                $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs,'jenispeserta_bpjs') ?>").val(peserta.jenisPeserta.keterangan);
                $("#<?php echo CHtml::activeId($modSep,'ppkrujukan') ?>").val(peserta.provUmum.kdProvider);
                 $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs,'nopeserta') ?>").val(peserta.noKartu);
                 $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs,'nokartuasuransi') ?>").val(peserta.noKartu);
                 $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs,'namapemilikasuransi') ?>").val(peserta.nama);
                 $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs,'jenispersertakode_bpjs') ?>").val(peserta.jenisPeserta.kode);
               $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs,'jenispeserta_bpjs') ?>").val(peserta.jenisPeserta.keterangan);

               $("#<?php echo CHtml::activeId($modSep,'no_telpon_peserta') ?>").val($("#<?php echo CHtml::activeId($modPasien,'no_mobile_pasien') ?>").val());



 //              $("#<?php // echo CHtml::activeId($modRujukanBpjs,'no_rujukan') ?>").val(noKunjungan);
 //              $("#<?php // echo CHtml::activeId($modRujukanBpjs,'nama_perujuk') ?>").val(provRujukan.nama);
 //              $("#<?php // echo CHtml::activeId($modRujukanBpjs,'tanggal_rujukan') ?>").val(tglKunjungan);

 //              setDiagnosaBpjs(diagnosa.kode,diagnosa.nama);
 //              $("#RMSepT_ppkrujukan").val(provRujukan.kode);
               $("#RMAsuransipasienbpjsM_nopeserta").val(peserta.noKartu);
               $("#RMAsuransipasienbpjsM_nokartuasuransi").val(peserta.noKartu);
               $("#RMAsuransipasienbpjsM_namapemilikasuransi").val(peserta.nama);
 //              $("#PPAsuransipasienbpjsM_jenispeserta_id").val(peserta.jenisPeserta.kode);
               $("#RMAsuransipasienbpjsM_kelastanggunganasuransi_id").val(peserta.hakKelas.kode);
               <?php if($this->id == "pendaftaranRawatDarurat"){ ?>
                     getPPKPelayanan();
                 <?php }else if($this->id == "pendaftaranRawatInapDariRJRD"){ ?>
                     if($('#instalasiasalRI_id').val() != undefined && $('#instalasiasalRI_id').val() == '<?php echo Params::INSTALASI_ID_RD; ?>'){
                         getPPKPelayanan();
                     }
                 <?php } ?>
 //              pemilik_bpjs = peserta.nama;
 //            jQuery.expr[':'].contains = function(a, i, m) {
 //              return jQuery(a).text().toUpperCase()
 //                      .indexOf(m[3].toUpperCase()) >= 0;
 //            };
 //				if (peserta != null){
 //
 ////                                        getJenisPesertaBpjs(peserta.jenisPeserta.kode);
 //
 //
 ////					$("#<?php // echo CHtml::activeId($modAsuransiPasienBpjs,'kelastanggunganasuransi_id') ?>").val(peserta.hakKelas.kode); // <<tidak sama dengan kelaspelayanan_id
 //					// OVERWRITES old selecor
 //
 //					// $("#<?php // echo CHtml::activeId($modAsuransiPasienBpjs,'kelastanggunganasuransi_id') ?>").find(peserta.kelasTanggungan.nmKelas).attr("selected",true);
 //				}else{
 //
 //					if (typeof databpjs !== 'undefined'){
 //						$("#<?php // echo CHtml::activeId($modAsuransiPasienBpjs,'nopeserta') ?>").val(databpjs.nopeserta);
 //						$("#<?php // echo CHtml::activeId($modAsuransiPasienBpjs,'asuransipasien_id') ?>").val(databpjs.asuransipasien_id);
 //						$("#<?php // echo CHtml::activeId($modAsuransiPasienBpjs,'nokartuasuransi') ?>").val(databpjs.nokartuasuransi);
 //						$("#<?php // echo CHtml::activeId($modAsuransiPasienBpjs,'namapemilikasuransi') ?>").val(databpjs.namapemilikasuransi);
 //						$("#<?php // echo CHtml::activeId($modAsuransiPasienBpjs,'jenispeserta_id') ?>").val(databpjs.jenispeserta_id);
 //						$("#<?php // echo CHtml::activeId($modAsuransiPasienBpjs,'kelastanggunganasuransi_id') ?>").val(databpjs.kelastanggunganasuransi_id); // <<tidak sama dengan kelaspelayanan_id
 //					}
 //				}
             }else{
                 if (obj != null) {
                     if (typeof obj.metaData !== 'undefined'){
                             myAlert(obj.metaData.message);
                     }
                 }
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

 function getRujukanDari(kodeppk){
     var asarujukan = $("#<?php echo CHtml::activeId($modRujukanBpjs, 'asalrujukan_id') ?>").val();

     $.ajax({
         type:'POST',
         url:'<?php echo $this->createUrl('/pendaftaranPenjadwalan/pendaftaranRawatJalan/GetRujukanDariBpjs'); ?>',
         data: {kodeppk: kodeppk, asarujukan: asarujukan},
         dataType: "json",
         success:function(data){
              $("#<?php echo CHtml::activeId($modRujukanBpjs,'asalrujukan_id') ?>").val(data.asalrujukan);
              $("#<?php echo CHtml::activeId($modRujukanBpjs,'rujukandari_id') ?>").html(data.datarujukandari);
            $("#<?php echo CHtml::activeId($modRujukanBpjs,'rujukandari_id') ?>").val(data.rujukandari);
         },
         error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
     });
 }

 function getRujukanNoRujukan(isi)
 {
     if (<?php echo (Yii::app()->user->getState('isbridging')==TRUE)?1:0; ?>) {}else{myAlert('Fitur Bridging tidak aktif!'); return false;}
     if (isi=="") {myAlert('Isi data terlebih dahulu!'); return false;};
     var aksi = 3; // 3 untuk mencari data rujukan berdasarkan Nomor rujukan
     var setting = {
         url : "<?php echo $this->createUrl('/pendaftaranPenjadwalan/pendaftaranRawatJalan/bpjsInterface'); ?>",
         type : 'GET',
         dataType : 'html',
         data : 'param='+ aksi + '&query=' + isi,
         beforeSend: function(){
             $("#content-bpjs").addClass("animation-loading");
         },
         success: function(data){
             $("#content-bpjs").removeClass("animation-loading");
             var obj = JSON.parse(data);

             if(obj.response.rujukan!=null){
               var rujukan = obj.response.rujukan;
               var noKunjungan = rujukan.noKunjungan;
               var tglKunjungan = rujukan.tglKunjungan;
               var peserta = rujukan.peserta;    //array
               var provKunjungan = rujukan.provKunjungan;    //array
               var keluhan = rujukan.keluhan;
               var diagnosa = rujukan.diagnosa;    //array
               var catatan = rujukan.catatan;
               var pemFisikLain = rujukan.pemFisikLain;
               var provRujukan = rujukan.provPerujuk;    //array
               var poliRujukan = rujukan.poliRujukan;    //array

               getRujukanDari(provRujukan.kode);
 //              getJenisPesertaBpjs(peserta.jenisPeserta.kode);
 $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs,'jenispersertakode_bpjs') ?>").val(peserta.jenisPeserta.kode);
               $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs,'jenispeserta_bpjs') ?>").val(peserta.jenisPeserta.keterangan);
               $("#<?php echo CHtml::activeId($modSep,'ppkrujukan') ?>").val(peserta.provUmum.kdProvider);

               $("#<?php echo CHtml::activeId($modRujukanBpjs,'no_rujukan') ?>").val(noKunjungan);
               $("#<?php echo CHtml::activeId($modRujukanBpjs,'nama_perujuk') ?>").val(provRujukan.nama);
               $("#<?php echo CHtml::activeId($modRujukanBpjs,'tanggal_rujukan') ?>").val(tglKunjungan);

               setDiagnosaBpjs(diagnosa.kode,diagnosa.nama);
               $("#RMSepT_ppkrujukan").val(provRujukan.kode);
               $("#RMAsuransipasienbpjsM_nopeserta").val(peserta.noKartu);
               $("#RMAsuransipasienbpjsM_nokartuasuransi").val(peserta.noKartu);
               $("#RMAsuransipasienbpjsM_namapemilikasuransi").val(peserta.nama);
 //              $("#RMAsuransipasienbpjsM_jenispeserta_id").val(peserta.jenisPeserta.kode);
               $("#RMAsuransipasienbpjsM_kelastanggunganasuransi_id").val(peserta.hakKelas.kode);
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

function verifikasiBpjs(btn){
    if (<?php echo (Yii::app()->user->getState('isbridging')==TRUE)?1:0; ?>) {}else{myAlert('Fitur Bridging tidak aktif!'); return false;}
    var nokartu = $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs,'nosep');?>").val();

    // var tglsep = ubahFormatTanggalBpjs($("#<?php echo CHtml::activeId($modSep,'tglsep');?>").val());
    // var tglrujukan = ubahFormatTanggalBpjs($("#<?php echo CHtml::activeId($modRujukanBpjs,'tanggal_rujukan');?>").val());
    var tglsep = $("#<?php echo CHtml::activeId($modSep,'tglsep');?>").val();
    var tglrujukan = $("#<?php echo CHtml::activeId($modRujukanBpjs,'tanggal_rujukan');?>").val();
    var norujukan = $("#<?php echo CHtml::activeId($modRujukanBpjs,'no_rujukan');?>").val();
    var ppkrujukan = $("#<?php echo CHtml::activeId($modSep,'ppkrujukan');?>").val();
    var ppkpelayanan = $("#<?php echo CHtml::activeId($modSep,'ppkpelayanan');?>").val(); // "1001R012"
    var jnspelayanan = $("#<?php echo CHtml::activeId($modSep,'jnspelayanan');?>").val();
    var catatan = $("#<?php echo CHtml::activeId($modSep,'catatan');?>").val();
    var diagawal = $("#diagnosaRujukanKodeBpjs option:first-child").val();
    var politujuan = $("#<?php echo CHtml::activeId($model,'ruangan_id');?>").val();
    var klsrawat = $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs,'kelastanggunganasuransi_id');?>").val();
    <?php
    $modPegawai = PegawaiM::model()->findByPk(Yii::app()->user->id);
    ?>
    var user = "<?php echo isset($modPegawai->nama_pegawai)?$modPegawai->nama_pegawai:'-';?>";
    var nomr = $("#<?php echo CHtml::activeId($modPasien,'no_rekam_medik');?>").val();
    var notrans = '<?php echo $model->no_pendaftaran; ?>';

    var aksi = 6; // 6 untuk menCreate SEP
    var setting = {
        url : "<?php echo $this->createUrl('/pendaftaranPenjadwalan/pendaftaranRawatJalan/bpjsInterface'); ?>",
        type : 'GET',
        dataType : 'html',
        data : 'param='+aksi+'&no_kartu='+nokartu+'&tgl_sep='+tglsep+'&tgl_rujukan='+tglrujukan+'&no_rujukan='+norujukan+'&ppk_rujukan='+ppkrujukan+'&ppk_pelayanan='+ppkpelayanan+'&jns_pelayanan='+jnspelayanan+'&catatan='+catatan+'&diag_awal='+diagawal+'&poli_tujuan='+politujuan+'&kls_rawat='+klsrawat+'&user='+user+'&no_mr='+nomr+'&no_trans='+notrans,
        beforeSend: function(){
            $("#content-bpjs").addClass("animation-loading");
        },
        success: function(data){
            $("#content-bpjs").removeClass("animation-loading");
            var res = JSON.parse(data);
            if(res.response!=null){
              var noSep = res.response;
              $("#<?php echo CHtml::activeId($modSep,'nosep') ?>").val(noSep);
            }else{
              myAlert(res.metadata.message);
            }
        },
        error: function(data){
            $("#content-bpjs").removeClass("animation-loading");
        }
    }

    if(typeof ajax_request !== 'undefined')
        ajax_request.abort();
    ajax_request = $.ajax(setting);


    $(btn).hide();
    $('.verified').show();
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
    var nopeserta= $("#RMAsuransipasienbpjsM_nopeserta").val();
    $("#RMAsuransipasienbpjsM_nokartuasuransi").val(nopeserta);
}

function setNoBpjsReverse(){
    var nokartuasuransi = $("#RMAsuransipasienbpjsM_nokartuasuransi").val();
	//alert(nokartuasuransi);
    $("#RMAsuransipasienbpjsM_nopeserta").val(nokartuasuransi);
}

var data_kontrol = null;
function cariSuratKontrol() {
    var isi = $("#PPSepT_no_surat").val();
    var aksi = 18;
    
    
    var setting = {
        url : "<?php echo $this->createUrl('bpjsInterface'); ?>",
        type : 'GET',
        dataType : 'html',
        data : 'param='+ aksi + '&query=' + isi,
        beforeSend: function(){
            $("#content-bpjs").addClass("animation-loading");
        },
        success: function(data){			
            // console.log(data);
            $("#content-bpjs").removeClass("animation-loading");
            var res = JSON.parse(data);
            console.log(res);
            if(res.response!=null){
                data_kontrol = res.response;
                showDialogSuratKontrol();
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

function showDialogSuratKontrol() {
    $("#tab_sc #sc_nama_pasien").html(data_kontrol.sep.peserta.nama);
    $("#tab_sc #sc_jeniskelamin").html(data_kontrol.sep.peserta.kelamin == "L" ? "LAKI-LAKI" : "PEREMPUAN");
    $("#tab_sc #sc_tanggal_lahir").html(data_kontrol.sep.peserta.tglLahir);
    $("#tab_sc #sc_nosurat").html(data_kontrol.noSuratKontrol);
    $("#tab_sc #sc_tanggal_entri").html(data_kontrol.tglTerbit);
    $("#tab_sc #sc_tanggal_rencana").html(data_kontrol.tglRencanaKontrol);
    $("#tab_sc #sc_poli_tujuan").html(data_kontrol.poli_tujuan);
    $("#tab_sc #sc_dokter_kontrol").html(data_kontrol.namaDokter);
    $("#tab_sc #sc_no_sep").html(data_kontrol.sep.noSep);
    $("#tab_sc #sc_tgl_sep").html(data_kontrol.sep.tglSep);
    
    if (data_kontrol.status_kontrol == 1) {
        $("#tab_sc #sc_status").html("Sudah melewati jadwal kontrol yang Direncanakan!");
    } else if (data_kontrol.status_kontrol == -1) {
        $("#tab_sc #sc_status").html("Belum Masuk jadwal kontrol yang Direncanakan!");
    }
    
    $("#dialogSuratKontrol").dialog("open");
}

function setSuratKontrol() {
    $("#dialogSuratKontrol").dialog("close");
    if (data_kontrol.status_kontrol != 0) {
        $("#RMSepT_no_surat").val("");
    } else {
        $("#RMSepT_nama_dpjp").val(data_kontrol.namaDokter);
        $("#RMSepT_kode_dpjp").val(data_kontrol.kodeDokter);
        $("#RMSepT_no_surat").val(data_kontrol.noSuratKontrol);
        if (data_kontrol.sep.noSep) {
            $("#isSepManual").prop("checked", true).change();
            $("#RMSepT_nosep").val(data_kontrol.sep.noSep);
        }
        $("#RMSepT_politujuan").val(data_kontrol.poliTujuan);
    }
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

function setSEP(obj){
    if($(obj).is(':checked')){
        $('#content-bpjs').find(".nosep").removeAttr("disabled");
    }else{
        $('#content-bpjs').find(".nosep").attr("disabled",true);
    }

}

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
    $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs,'jenispersertakode_bpjs') ?>").val('');
    $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs,'jenispeserta_bpjs') ?>").val('');
}



function cekSEP(nosep) {
	var setting = {
        url : "<?php echo $this->createUrl('/pendaftaranPenjadwalan/pendaftaranRawatJalan/cekSEP'); ?>",
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
				$("#RMSepT_ppkrujukan").val(obj.response.provRujukan.kdProvider);
				$("#RMRujukanbpjsT_no_rujukan").val(obj.response.noRujukan);
				getAsuransiNoKartu(obj.response.peserta.noKartu);
				if (obj.rujukan.rujukandari_id.toString().trim() != "") {
					$("#RMRujukanbpjsT_asalrujukan_id").val(obj.rujukan.asalrujukan_id);
					$("#RMRujukanbpjsT_rujukandari_id")
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

function getBpjsPPKRujukan(ppk) {
    if (<?php echo (Yii::app()->user->getState('isbridging')==TRUE)?1:0; ?>) {}else{myAlert('Fitur Bridging tidak aktif!'); return false;}
    if (ppk=="") {myAlert('Isi data terlebih dahulu!'); return false;}
    if (ppk.trim().length != 8) {myAlert('PPK Rujukan harus 8 Digit'); return false;}
    var aksi = 12; // 12 cari ppk rujukan
    var setting = {
        url : "<?php echo $this->createUrl('/pendaftaranPenjadwalan/pendaftaranRawatJalan/bpjsInterface'); ?>",
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

function setKelasTanggunganDrop(){
	<?php
		$drop_kelasbpjs = CHtml::listData(RMPendaftaranT::model()->getKelasTanggunganItems(), 'kelasbpjs_id', 'kelaspelayanan_nama');

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

		$drop_kelas = CHtml::listData(RMPendaftaranT::model()->getKelasPelayananItems(), 'kelaspelayanan_id', 'kelaspelayanan_nama');
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
		var carabayar = $("#RMPasienAdmisiT_carabayar_id option:selected").val();
	<?php }else{ ?>
		var carabayar = $("#RMPendaftaranT_carabayar_id option:selected").val();
	<?php } ?>

	if (carabayar == <?php echo Params::CARABAYAR_ID_BPJS ?>){
		$("#RMAsuransipasienM_nokartuasuransi").attr('maxlength',13);
		$("#RMAsuransipasienM_kelastanggunganasuransi_id").html(dropdown_kelasbpjs);
	}else{
		$("#RMAsuransipasienM_nokartuasuransi").attr('maxlength',24);
		$("#RMAsuransipasienM_kelastanggunganasuransi_id").html(dropdown_kelas);
	}

}

function clearRujukanBpjs()
{
    $('#<?php echo CHtml::activeId($modRujukanBpjs, 'rujukandari_id')?>').find('option').remove().end().append('<option value="">-- Pilih --</option>').val('');
    $('#<?php echo CHtml::activeId($modRujukanBpjs, 'nama_perujuk')?>').val('');
}

/**
 * set otomatis nama_perujuk dari dropdown rujukandari_id Untuk BPJS
 * @returns {Boolean}
 */
function setNamaPerujukBpjs(){
    var rujukandari_id = $("#<?php echo CHtml::activeId($modRujukanBpjs, 'rujukandari_id')?>").val();
    var nama_perujuk = $("#<?php echo CHtml::activeId($modRujukanBpjs, 'rujukandari_id')?>").find('option[value="'+rujukandari_id+'"]').text();
    $("#<?php echo CHtml::activeId($modRujukanBpjs, 'nama_perujuk')?>").val(nama_perujuk);
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
                $('#RMRujukanT_nama_perujuk').html(data.namarujukan);
                $('#RMRujukanT_rujukandari_id').html(data.namarujukan);
                setTimeout("$('#dialogAddRujukanDari').dialog('close'); $('.rujukandari_id').change(); ",1000);
            }
       },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
    return false;
}

function getPPKPelayanan()
{
	if (<?php echo (Yii::app()->user->getState('isbridging') == TRUE) ? 1 : 0; ?>) {
	} else {
		myAlert('Fitur Bridging tidak aktif!');
		return false;
	}

        var jenis_rujukan = 2;
        var kodeppkpelayanan = '<?php echo Yii::app()->user->getState('ppkpelayanan'); ?>';

	var aksi = 16;
	var setting = {
		url: "<?php echo $this->createUrl('bpjsInterface'); ?>",
		type: 'GET',
		dataType: 'html',
		data: 'param=' + aksi + '&kodeppkpelayanan=' + kodeppkpelayanan + '&jenis_rujukan=' +jenis_rujukan,
		beforeSend: function () {
			$("#content-bpjs").addClass("animation-loading");
		},
		success: function (data) {
                    $("#content-bpjs").removeClass("animation-loading");
                    var obj = JSON.parse(data);
                    if(obj.metaData.code == '201'){
//				myAlert(obj.metaData.message);
                    }else{
                        if (obj.response != null) {
                            var faskes = obj.response.faskes;
                            $('#<?php echo CHtml::activeId($model,'ppkpelayanan_nama'); ?>').val(faskes[0].nama);

                            <?php if($this->id == "pendaftaranRawatDarurat"){ ?>
                                $('#<?php echo CHtml::activeId($modSep,'ppkrujukan'); ?>').val(faskes[0].kode);
                                $('#<?php echo CHtml::activeId($modRujukanBpjs,'nama_perujuk'); ?>').val(faskes[0].nama);
                            <?php }else if($this->id == "pendaftaranRawatInapDariRJRD"){ ?>
                                if($('#instalasiasalRI_id').val() != undefined && $('#instalasiasalRI_id').val() == '<?php echo Params::INSTALASI_ID_RD; ?>'){
                                    $('#<?php echo CHtml::activeId($modSep,'ppkrujukan'); ?>').val(faskes[0].kode);
                                    $('#<?php echo CHtml::activeId($modRujukanBpjs,'nama_perujuk'); ?>').val(faskes[0].nama);
                                }
                            <?php } ?>
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

function getPPK(obj) {
    var id = $(obj).val();
    $("#<?php echo CHtml::activeId($modSep, 'ppkrujukan')?>").val("");
    $.post('<?php echo $this->createUrl('getPPKRujukan'); ?>', {rujukan_id: id}, function(data) {
        $("#<?php echo CHtml::activeId($modSep, 'ppkrujukan')?>").val(data);
    });
}

function setPenanggungjawabPS() {

if ($('.pp_sb').is(':checked')) {
    setDataPJP();
} else {
    $("#<?php echo CHtml::activeId($modPenanggungJawab, 'pengantar') ?>").val('');
    $("#<?php echo CHtml::activeId($modPenanggungJawab, 'nama_pj') ?>").val('');
    $("#<?php echo CHtml::activeId($modPenanggungJawab, 'jeniskelamin') ?>").prop('');
    $("#<?php echo CHtml::activeId($modPenanggungJawab, 'jenisidentitas') ?>").val('');
    $("#<?php echo CHtml::activeId($modPenanggungJawab, 'no_identitas') ?>").val('');
    $("#<?php echo CHtml::activeId($modPenanggungJawab, 'no_teleponpj') ?>").val('');
    $("#<?php echo CHtml::activeId($modPenanggungJawab, 'no_mobilepj') ?>").val('');
    $("#<?php echo CHtml::activeId($modPenanggungJawab, 'hubungankeluarga') ?>").val('');
    $("#<?php echo CHtml::activeId($modPenanggungJawab, 'tempatlahir_pj') ?>").val('');
    $("#<?php echo CHtml::activeId($modPenanggungJawab, 'tgllahir_pj') ?>").val('');
    $("#<?php echo CHtml::activeId($modPenanggungJawab, 'alamat_pj') ?>").val('');
}
}

function setDataPJP() {

var pasien_id = $('#RMPasienM_pasien_id').val();
if (pasien_id) {
    $.ajax({
        type: 'POST',
        url: '<?php echo $this->createUrl('GetPJPasien'); ?>',
        data: {
            pasien_id: pasien_id
        },
        dataType: "json",
        success: function(data) {

            if (data) {
                $("#<?php echo CHtml::activeId($modPenanggungJawab, 'pengantar') ?>").val(data.pengantar);
                $("#<?php echo CHtml::activeId($modPenanggungJawab, 'nama_pj') ?>").val(data.nama_pj);
                $("#<?php echo CHtml::activeId($modPenanggungJawab, 'jeniskelamin') ?>").prop(data.jeniskelamin);
                $("#<?php echo CHtml::activeId($modPenanggungJawab, 'jenisidentitas') ?>").val(data.jenisidentitas);
                $("#<?php echo CHtml::activeId($modPenanggungJawab, 'no_identitas') ?>").val(data.no_identitas);
                $("#<?php echo CHtml::activeId($modPenanggungJawab, 'no_teleponpj') ?>").val(data.no_teleponpj);
                $("#<?php echo CHtml::activeId($modPenanggungJawab, 'no_mobilepj') ?>").val(data.no_mobilepj);
                $("#<?php echo CHtml::activeId($modPenanggungJawab, 'hubungankeluarga') ?>").val(data.hubungankeluarga);
                $("#<?php echo CHtml::activeId($modPenanggungJawab, 'tempatlahir_pj') ?>").val(data.tempatlahir_pj);
                $("#<?php echo CHtml::activeId($modPenanggungJawab, 'tgllahir_pj') ?>").val(data.tgllahir_pj);
                $("#<?php echo CHtml::activeId($modPenanggungJawab, 'alamat_pj') ?>").val(data.alamat_pj);
            } else {
                myAlert('Pasien balum memiliki penanggungjawab sebelumnya')
            }

        },
        error: function(jqXHR, textStatus, errorThrown) {
            myAlert('ERORR');
        }
    });
}

}

$('input:radio[name="rb_rm"]').change(
function() {
    if ($(this).is(':checked') && $(this).val() == '1') {
        $('.pj_sb').hide()
    } else {
        $('.pj_sb').show()
    }
});

$(document).ready(function() {		
            var cara = jQuery('#<?php echo CHtml::activeId($model, 'carabayar_id') ?>');		
            var penj = jQuery('#<?php echo CHtml::activeId($model, 'penjamin_id') ?>');
        /**
        * multi select cara bayar dan penjamin
            */

        jQuery(cara).multiselect({
                includeSelectAllOption: true,
                buttonClass: "form-control",
                maxHeight: 300,
                buttonWidth: '182px',
                enableCaseInsensitiveFiltering: true,
                onChange: function(element, checked) {				
                                var cara  = jQuery('#<?php echo CHtml::activeId($model, 'carabayar_id') ?>');
                                var cara_all = jQuery('#<?php echo CHtml::activeId($model, 'carabayar_id') ?>   option:selected');
                                var penj  = jQuery('#<?php echo CHtml::activeId($model, 'penjamin_id') ?>');
                                var v = $(element).val();

                                var brands = cara_all;
                                var selected = [];
                                setFormAsuransi(v);

                                $(brands).each(function(index, brand){
                                        selected.push($(this).val());
                                });

                                penj.addClass('animation-loading');
                                //alert(selected);

                                jQuery.ajax({
                                        type:'POST',
                                        url: '<?php echo $this->createUrl('/ActionDynamic/GetPenjaminByMultiSelect') ?>',					
                                        dataType: "json",
                                        data: {carabayar_id:selected},
                                        success: function(data){	

                                                if (data.sukses != '1'){

                                                        //toastr.error(data.pesan);
                                                        penj.addClass('animation-loading');
                                                }else{							
                                                        //alert(data.ruangan);
                                                        penj.html(data.penjamin);								
                                                        penj.multiselect('rebuild');																
                                                        penj.removeClass('animation-loading');
                                                }
                                        },
                                        error: function (jqXHR, textStatus, errorThrown) { 					
                                                console.log(errorThrown);

                                        }
                                });

                },
                onSelectAll: function() {
                                var cara  = jQuery('#<?php echo CHtml::activeId($model, 'carabayar_id') ?>');
                                var cara_all = jQuery('#<?php echo CHtml::activeId($model, 'carabayar_id') ?>   option:selected');
                                var penj  = jQuery('#<?php echo CHtml::activeId($model, 'penjamin_id') ?>');

                                var brands = cara_all;
                                var selected = [];

                                $(brands).each(function(index, brand){
                                        selected.push($(this).val());
                                });

                                penj.addClass('animation-loading');

                                jQuery.ajax({
                                        type:'POST',
                                        url: '<?php echo $this->createUrl('/ActionDynamic/GetRuanganByMultiSelect') ?>',					
                                        dataType: "json",
                                        data: {carabayar_id:selected},
                                        success: function(data){	

                                                if (data.sukses != '1'){

                                                        //toastr.error(data.pesan);
                                                        penj.addClass('animation-loading');
                                                }else{							
                                                        //alert(data.ruangan);
                                                        penj.html(data.penjaminan);								
                                                        penj.multiselect('rebuild');																
                                                        penj.removeClass('animation-loading');
                                                }
                                        },
                                        error: function (jqXHR, textStatus, errorThrown) { 					
                                                console.log(errorThrown);

                                        }
                                });

                },
                onDeselectAll: function() {		
                        var cara  = jQuery('#<?php echo CHtml::activeId($model, 'carabayar_id') ?>');
                        var cara_all = jQuery('#<?php echo CHtml::activeId($model, 'carabayar_id') ?>   option:selected');
                        var penj  = jQuery('#<?php echo CHtml::activeId($model, 'penjamin_id') ?>');

                        var brands = cara_all;
                        var selected = '';


                        penj.addClass('animation-loading');

                        jQuery.ajax({
                                type:'POST',
                                url: '<?php echo $this->createUrl('/ActionDynamic/GetRuanganByMultiSelect') ?>',					
                                dataType: "json",
                                data: {carabayar_id:selected},
                                success: function(data){	

                                        if (data.sukses != '1'){

                                                //toastr.error(data.pesan);
                                                penj.addClass('animation-loading');
                                        }else{							
                                                //alert(data.ruangan);
                                                penj.html(data.penjamin);								
                                                penj.multiselect('rebuild');															
                                                penj.removeClass('animation-loading');
                                        }
                                },
                                error: function (jqXHR, textStatus, errorThrown) { 					
                                        console.log(errorThrown);

                                }
                        });

                },
        
            }).hide();

        jQuery(penj).multiselect({
                includeSelectAllOption: true,
                buttonClass: "form-control",
                maxHeight: 300,
                buttonWidth: '182px',
                enableCaseInsensitiveFiltering: true,
            onChange: function(element, checked) {

                var v = $(element).val();

                setKarcis(0);
                setKarcis(1);
            }
        }).hide();


    });

</script>
