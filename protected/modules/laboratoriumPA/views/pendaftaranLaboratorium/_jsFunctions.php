<script type="text/javascript">
/**
    * 
    * @param {type} obj
    * @returns {change attribute maxlength}
    */
   function cekLength(obj){
       var cek = $(obj).val();

       $("#<?php echo CHtml::activeId($modPasien, 'no_identitas_pasien') ?>").attr('onkeyup','setNumbersOnly(this);return $(this).focusNextInputField(event);');    
       if (cek == '<?php echo Params::JENIS_IDENTITAS_KTP ?>'){
           $("#<?php echo CHtml::activeId($modPasien, 'no_identitas_pasien') ?>").attr('maxlength',16);
           $("#<?php echo CHtml::activeId($modPasien, 'no_identitas_pasien') ?>").keyup();
       }else{
           $("#<?php echo CHtml::activeId($modPasien, 'no_identitas_pasien') ?>").attr('maxlength',30);        

           if (cek == '<?php echo Params::JENIS_IDENTITAS_PASPOR ?>'){                                                
               $("#<?php echo CHtml::activeId($modPasien, 'no_identitas_pasien') ?>").attr('onkeyup','setAlphaNumericOnly(this);return $(this).focusNextInputField(event);');                                    
           }
           $("#<?php echo CHtml::activeId($modPasien, 'no_identitas_pasien') ?>").keyup();
       }
   }

   /**
    * 
    * @param {type} obj
    * @returns {change attribute maxlength}
    */
   function cekLengthPJ(obj){
       var cek = $(obj).val();

       $("#<?php echo CHtml::activeId($modPenanggungJawab, 'no_identitas') ?>").attr('onkeyup','setNumbersOnly(this);return $(this).focusNextInputField(event);');    
       if (cek == '<?php echo Params::JENIS_IDENTITAS_KTP ?>'){
           $("#<?php echo CHtml::activeId($modPenanggungJawab, 'no_identitas') ?>").attr('maxlength',16);
           $("#<?php echo CHtml::activeId($modPenanggungJawab, 'no_identitas') ?>").keyup();
       }else{
           $("#<?php echo CHtml::activeId($modPenanggungJawab, 'no_identitas') ?>").attr('maxlength',30);        

           if (cek == '<?php echo Params::JENIS_IDENTITAS_PASPOR ?>'){                                                
               $("#<?php echo CHtml::activeId($modPenanggungJawab, 'no_identitas') ?>").attr('onkeyup','setAlphaNumericOnly(this);return $(this).focusNextInputField(event);');                                    
           }
           $("#<?php echo CHtml::activeId($modPenanggungJawab, 'no_identitas') ?>").keyup();
       }    
   }   
    
function refreshDialog(filter){    
     $.fn.yiiGridView.update('dialog-pegawai-grid', {
        data: {
            "PegawairuanganV[ruangan_id]":filter.ruangan_id,                                            
            "PegawairuanganV[kelompokpegawai_id]":filter.kelompokpegawai_id,
            "PegawairuanganV[notkelompokpegawai_id]":filter.notkelompokpegawai_id,
            "PegawairuanganV[default]":filter.default,
        }
    }); 
}

    
function setDialog(jenis,dlg,obj){        
    $("#jenisdialog").val(jenis);
    $("#norow").val($(obj).parents('.form-inputan-penunjang').attr('norow'));

    var kelompokpegawai_id = 1;
    var ruangan_id = $(obj).parents('.form-inputan-penunjang').find('.rpenunjang_id').val();
    var notkelompokpegawai_id = 1;
    var filter = {};
    var dev = 'ada';

    if (jenis == 'dpjtm'){
        $(".judul-dialog-petugas").html('DPJTM');  
        notkelompokpegawai_id = '';
        dev = '';
    }else if(jenis == 'analis'){
        $(".judul-dialog-petugas").html('Analis');
        dev = '';
        kelompokpegawai_id = '';
    }
    
    if (ruangan_id == ''){
        dev = 'ada';
    }
    
    filter = {
        'kelompokpegawai_id':kelompokpegawai_id,
        'ruangan_id':ruangan_id,
        'notkelompokpegawai_id':notkelompokpegawai_id,
        'default':dev
    }
    
    refreshDialog(filter);

    $("#"+dlg).dialog('open');
}

function setPegawai(data,jenis, obj){        
    if (typeof jenis === 'undefined'){
        var jenis = $("#jenisdialog").val();
    }
    
    if (typeof $(obj).parents('.control-group').attr('norow') === 'undefined'){
        var no = $("#norow").val();
    }else{
        var no = $(obj).parents('.control-group').attr('norow');
    }
        
    if (jenis == 'dpjtm'){
        $(".form-inputan-penunjang[norow='"+no+"']").find('.pegawai_id').val(data.pegawai_id);        
        $(".form-inputan-penunjang[norow='"+no+"']").find('.pegawai_nama').val(data.namaLengkap);        
    }else if (jenis == 'analis'){
        $(".form-inputan-penunjang[norow='"+no+"']").find('.ppjp_id').val(data.pegawai_id);
        $(".form-inputan-penunjang[norow='"+no+"']").find('.ppjp_nama').val(data.namaLengkap);
    }else if(jenis == 'ppds'){
        $(".form-inputan-penunjang[norow='"+no+"']").find('.ppds_id').val(data.ppds_id);
        $(".form-inputan-penunjang[norow='"+no+"']").find('.ppds_nama').val(data.ppds_nama);
    }

    if (jenis == 'ppds'){
        $("#dialogPPDS").dialog('close');
    }else{
        $("#dialogPetugas").dialog('close');
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
    $("#kunjungan_ke").text('');
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('GetDataPasien'); ?>',
        data: {pasien_id:pasien_id, no_rekam_medik:no_rekam_medik},
        dataType: "json",
        success:function(data){
            if (data.tgl_meninggal != ''){                
                myAlert("Pasien " + data.namadepan + data.nama_pasien + " Sudah Meninggal! ","Perhatian!");
                $("#<?php echo CHtml::activeId($modPasien,'no_rekam_medik');?>").val("");
                $("#cari_nomorindukpegawai").val("");
                $("#form-pasien > div").removeClass("animation-loading");
                setPasienBaru();                
                return false;
            }
            
            
            if(data.statusrekammedis.trim() == "<?php echo Params::STATUSREKAMMEDIS_AKTIF?>"){
				$("#cari_nomorindukpegawai").val(data.nomorindukpegawai); // untuk load filed NIP
                $("#cari_no_rekam_medik").val(data.no_rekam_medik);
                $("#<?php echo CHtml::activeId($modPasien,'no_rekam_medik');?>").val(data.no_rekam_medik);
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
                if (data.nofingerprint != null){
                    $("#pesanVerifikasi").html("Pasien Sudah Melakukan Pendaftaran Sidik Jari "+data.nofingerprint);
                }else{
                    $("#pesanVerifikasi").html("Pasien Belum Melakukan Pendaftaran Sidik jari ");
                }
                
                $('#photo-preview').attr('src','<?php echo Params::urlPhotoPasienDirectory()."no_photo.jpeg"?>');
                if(data.photopasien != null && data.photopasien != ""){ //set photo
                    $("#<?php echo CHtml::activeId($modPasien,"photopasien");?>").val(data.photopasien);
                    $('#photo-preview').attr('src','<?php echo Params::urlPasienTumbsDirectory()."kecil_"?>'+data.photopasien);
                }
                
                $("#kunjungan_ke").text("Kunjungan Ke - "+data.kunjungan_ke);

                setJenisKelaminPasien(data.jeniskelamin);
                setRhesusPasien(data.rhesus);
                setDaerahPasien(data.propinsi_id, data.kabupaten_id, data.kecamatan_id, data.kelurahan_id);
                setUmur(data.tanggal_lahir);
                setKarcis(0);
                setKarcis(1);
                setRiwayatKunjunganPasien(data.pasien_id);
				setAsuransiPasienLama(data.pasien_id);
                cekDisabled($('#lkpendaftaran-t-form'));
                $("#form-pasien > legend > .judul").html('Data Pasien Lama ');
                $("#form-pasien > legend > .tombol").attr('style','display:true;');
                $("#form-pasien > .box").addClass("well").removeClass("box");
            }else{
                myConfirm('Apakah anda akan menggunakan No. Rekam Medik Non-Aktif?', 'Perhatian!', function(r)
                {
                    if(r){
                        $("#cari_no_rekam_medik").val(data.no_rekam_medik);
                        $("#<?php echo CHtml::activeId($modPasien,'pasien_id');?>").val(data.pasien_id);
                        $("#form-pasien > legend > .judul").html('Data Pasien No. Rekam Medik Lama ');
                        $("#form-pasien > legend > .tombol").attr('style','display:true;');
                        $("#form-pasien > .box").addClass("well").removeClass("box");
                        $("#<?php echo CHtml::activeId($modPasien,'jenisidentitas'); ?>").focus();
                        $("#kunjungan_ke").text("Kunjungan Ke - "+data.kunjungan_ke);
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
    
	$("#<?php echo CHtml::activeId($model,"carabayar_id");?>").val("");
	$("#<?php echo CHtml::activeId($model,"penjamin_id");?>").val("");
	setAsuransiBadakReset();
	
    $("#<?php echo CHtml::activeId($modPasien,"photopasien");?>").val("");
    $('#photo-preview').attr('src','<?php echo Params::urlPhotoPasienDirectory()."no_photo.jpeg"?>');

    setJenisKelaminPasien("");
    setKarcis(0);
    setKarcis(1);
	setAsuransiBadakReset();

    $("#form-pasien > legend > .judul").html('Data Pasien Baru ');
    $("#form-pasien > legend > .tombol").attr('style','display:none;');
    $("#form-pasien > .well").addClass("box").removeClass("well");
    $("#cari_no_rekam_medik").val("");
	$("#cari_nomorindukpegawai").val("");
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
    
    var statusperkawinan = $('#LBPasienM_statusperkawinan').val();
    var namadepan = $('#LBPasienM_namadepan');
    var umur = $("#<?php echo CHtml::activeId($model,'umur');?>").val().substr(0,2);
    var tanggal_lahir = $("#<?php echo CHtml::activeId($modPasien, 'tanggal_lahir') ?>").val();
    
    umur = parseInt(umur);
    
    if(tanggal_lahir != ""){
        $.ajax({
            type:'POST',
            url:'<?php echo Yii::app()->createUrl('pendaftaranPenjadwalan/PendaftaranRawatJalan/SetUmurBulan'); ?>',
            data: {tanggal_lahir : tanggal_lahir},
            dataType: "json",
            success:function(data){
                
                umur = data.bulan;
                
                console.log(umur);

                if(umur >= 0 && umur < 12){
                    $('#LBPasienM_namadepan').val('By. ');
                    if(statusperkawinan.length > 0 && statusperkawinan != "DIBAWAH UMUR" && statusperkawinan != "TIDAK KAWIN"){
                        $('#LBPasienM_statusperkawinan').val('');
                        myAlert('Maaf status perkawinan belum cukup usia');
                    }
                }else if(umur >= 12 && umur < 18){
                    $('#LBPasienM_namadepan').val('An. ');
                    if(statusperkawinan.length > 0 && statusperkawinan != "DIBAWAH UMUR" && statusperkawinan != "TIDAK KAWIN"){
                        $('#LBPasienM_statusperkawinan').val('');
                        myAlert('Maaf status perkawinan belum cukup usia');
                    }
                }else{
                    if($('#LBPasienM_jeniskelamin_0').is(':checked')){
                        if(statusperkawinan !== 'JANDA'){
                            $('#LBPasienM_namadepan').val('Tn. ');
                        }else{
                            alert('Pilih status pernikahan yang sesuai');
                            $('#LBPasienM_statusperkawinan').val('KAWIN');
                            $('#LBPasienM_namadepan').val('Tn. ')
                        }
                    } else if($('#LBPasienM_jeniskelamin_1').is(':checked')) {
                        $('#LBPasienM_namadepan').val('Nn. ');
                        if(statusperkawinan !== 'DUDA') {
                            $('#LBPasienM_namadepan').val('Nn. ');
                            if(statusperkawinan === 'KAWIN' || statusperkawinan == 'JANDA' || statusperkawinan == 'NIKAH SIRIH' || statusperkawinan == 'POLIGAMI'){
                                $('#LBPasienM_namadepan').val('Ny. ');
                            } else {
                                $('#LBPasienM_namadepan').val('Nn. ');
                            }
                        } else {
                            myAlert('Pilih status pernikahan yang sesuai');
                            $('#LBPasienM_statusperkawinan').val('KAWIN');
                            $('#LBPasienM_namadepan').val('Ny. ');
                        }
                    }

                    if (statusperkawinan == "DIBAWAH UMUR"){
                        myAlert('Pilih status pernikahan yang sesuai');
                        $('#LBPasienM_statusperkawinan').val('BELUM KAWIN');
                    }
                }
                
            },
             error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        });
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
           setNamaDepan();
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
           cekPekerjaanByUmur();
           setNamaDepan();
       },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}

function cekPekerjaanByUmur(){
    var umur_tahun = $("#<?php echo CHtml::activeId($model,'umur'); ?>").val().substr(0,2);
    var umur_hari = $("#<?php echo CHtml::activeId($model,'umur'); ?>").val().substr(14,2);

    if (umur_tahun != ''){
        if (umur_tahun < 5){            
            $("#<?php echo CHtml::activeId($modPasien, 'pekerjaan_id') ?>").val(<?php echo Params::PEKERJAAN_ID_DIBAWAHUMUR ?>);            
        }else{
            if ($("#<?php echo CHtml::activeId($modPasien, 'pekerjaan_id') ?>").val() == '<?php echo Params::PEKERJAAN_ID_DIBAWAHUMUR ?>'){
                $("#<?php echo CHtml::activeId($modPasien, 'pekerjaan_id') ?>").val('');
            }
        }
    }else{
        $("#<?php echo CHtml::activeId($modPasien, 'pekerjaan_id') ?>").val('');            
    }
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
			if(data.penjamin_nama != ''){
				myConfirm("Apakah pasien ini akan menggunakan penjamin "+data.penjamin_nama+"?","Konfirmasi!",function(r) {
					if(r){
						setFormAsuransi(data.carabayar_id);
						$("#<?php echo CHtml::activeId($model,"carabayar_id");?>").val(data.carabayar_id);
						$("#<?php echo CHtml::activeId($model,"penjamin_id");?>").html(data.listPenjamin);
						$("#<?php echo CHtml::activeId($model,"penjamin_id");?>").val(data.penjamin_id);
						if(data.carabayar_id == <?php echo Params::CARABAYAR_ID_BPJS ?>){
							getAsuransiNoKartu(data.nopeserta);
						}else if((data.carabayar_id == <?php echo Params::CARABAYAR_ID_BADAK; ?>) || (data.carabayar_id == <?php echo Params::CARABAYAR_ID_DEP_BADAK; ?>) || (data.carabayar_id == <?php echo Params::CARABAYAR_ID_PEKERJA; ?>)){
							setAsuransiBadak(data);
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
					} 
				}); 
			}
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
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

/** control accordion penanggung jawab pasien */
$('#form-pjpasien > div > .accordion-heading').click(function(){
    var is_adapjpasien = $("#<?php echo CHtml::activeId($model, "is_adapjpasien"); ?>");
    if(is_adapjpasien.val() > 0){ //hide
        is_adapjpasien.val(0);
    }else{//show
        is_adapjpasien.val(1);
    }
});
/** control accordion pemeriksaan lab klinik*/
$('#form-pemeriksaan-0 > div > .accordion-heading').click(function(){
    var is_pilihpenunjang = $("#<?php echo CHtml::activeId($modPasienMasukPenunjangs[0],"[0]is_pilihpenunjang");?>");
    if(is_pilihpenunjang.val() > 0){ //hide
        is_pilihpenunjang.val(0);
    }else{//show
        is_pilihpenunjang.val(1);
    }
});
/** control accordion pemeriksaan lab patologi anatomi*/
$('#form-pemeriksaan-1 > div > .accordion-heading').click(function(){
    var is_pilihpenunjang = $("#<?php echo CHtml::activeId($modPasienMasukPenunjangs[1],"[1]is_pilihpenunjang");?>");
    if(is_pilihpenunjang.val() > 0){ //hide
        is_pilihpenunjang.val(0);
    }else{//show
        is_pilihpenunjang.val(1);
    }
});
/** control accordion karcis lab klinik*/
$('#form-karcis-0 > div > .accordion-heading').click(function(){
    var is_adakarcis = $("#form-karcis-0").parent().find('input[name$="[is_adakarcis]"]');
    if(is_adakarcis.val() > 0){ //hide
        is_adakarcis.val(0);
    }else{//show
        is_adakarcis.val(1);
    }
});
/** control accordion karcis lab pa*/
$('#form-karcis-1 > div > .accordion-heading').click(function(){
    var is_adakarcis = $("#form-karcis-1").parent().find('input[name$="[is_adakarcis]"]');
    if(is_adakarcis.val() > 0){ //hide
        is_adakarcis.val(0);
    }else{//show
        is_adakarcis.val(1);
    }
});
/** control accordion sampel laboratorium klinik */
$('#form-pengambilan-sample-0 > div > .accordion-heading').click(function(){
    var is_adasample = $("#form-pengambilan-sample-0").parent().find('input[name$="[is_adasample]"]');
    if(is_adasample.val() > 0){ //hide
        is_adasample.val(0);
    }else{//show
        is_adasample.val(1);
        $(this).parent().parent().find('textarea').removeAttr("disabled");
    }
});
/** control accordion sampel laboratorium pa */
$('#form-pengambilan-sample-1 > div > .accordion-heading').click(function(){
    var is_adasample = $("#form-pengambilan-sample-1").parent().find('input[name$="[is_adasample]"]');
    if(is_adasample.val() > 0){ //hide
        is_adasample.val(0);
    }else{//show
        is_adasample.val(1);
        $(this).parent().parent().find('textarea').removeAttr("disabled");
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
	var carabayar_id_badak = <?php echo Params::CARABAYAR_ID_BADAK;?>;
    var carabayar_id_departemen = <?php echo Params::CARABAYAR_ID_DEP_BADAK;?>;
    var carabayar_id_pekerja = <?php echo Params::CARABAYAR_ID_PEKERJA;?>;
	if(carabayar_id == carabayar_id_umum){
		sembunyiFormAsuransi();
		sembunyiFormAsuBadak();
		sembunyiFormAsuDepartemen();
		sembunyiFormAsuPekerja();
		$('#form-asuransi').hide(); 
		$('#form-asubadak').hide();
		$('#form-asudepartemen').hide();
		$('#form-asupekerja').hide();
	}else if(carabayar_id == carabayar_id_badak){
		sembunyiFormAsuransi();
		tampilFormAsuBadak();
		sembunyiFormAsuDepartemen();
		sembunyiFormAsuPekerja();
		$('#form-asuransi').hide();
		$('#form-asubadak').show();
		$('#form-asudepartemen').hide();
		$('#form-asupekerja').hide();
	}else if(carabayar_id == carabayar_id_departemen){
		sembunyiFormAsuransi();
		sembunyiFormAsuBadak();
		tampilFormAsuDepartemen();
		sembunyiFormAsuPekerja();
		$('#form-asuransi').hide();
		$('#form-asubadak').hide();
		$('#form-asudepartemen').show();
		$('#form-asupekerja').hide();
	}else if(carabayar_id == carabayar_id_pekerja){
		sembunyiFormAsuransi();
		sembunyiFormAsuBadak();
		sembunyiFormAsuDepartemen();
		tampilFormAsuPekerja();
		$('#form-asuransi').hide();
		$('#form-asubadak').hide();
		$('#form-asudepartemen').hide();
		$('#form-asupekerja').show();
	}else{
		tampilFormAsuransi();
		sembunyiFormAsuBadak();
		sembunyiFormAsuDepartemen();
		sembunyiFormAsuPekerja();
		$('#form-asuransi').show(); 
		$('#form-asubadak').hide();
		$('#form-asudepartemen').hide();
		$('#form-asupekerja').hide();
	}
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
  
}
function sembunyiFormAsuBadak(){
        $('#content-asubadak').find(".required").addClass("not-required").removeClass("required");
        $('#form-asubadak > .accordion-group > .accordion-heading').find(".btn").removeClass("btn-primary");
        $('#form-asubadak > .accordion-group > .accordion-heading').find(".icon-ok").addClass("icon-minus").removeClass("icon-ok");
        $('#content-asubadak').removeClass().addClass("accordion-body collapse");
        $('#content-asubadak').removeAttr("style").attr("style","height:0px");  
        $('#content-asubadak').find("input,select,textarea").attr("disabled",true); 
}
function tampilFormAsuBadak(){
        $('#form-asubadak > .accordion-group > .accordion-heading').find(".btn").addClass("btn-primary");
        $('#form-asubadak > .accordion-group > .accordion-heading').find(".icon-minus").addClass("icon-ok").removeClass("icon-minus");
        $('#content-asubadak').removeClass().addClass("accordion-body in collapse");
        $('#content-asubadak').find(".not-required").addClass("required").removeClass("not-required");
        $('#content-asubadak').removeAttr("style").attr("style","height:auto"); 
        $('#content-asubadak').find("input,select,textarea").removeAttr("disabled");
  
}
function sembunyiFormAsuDepartemen(){
        $('#content-asudepartemen').find(".required").addClass("not-required").removeClass("required");
        $('#form-asudepartemen > .accordion-group > .accordion-heading').find(".btn").removeClass("btn-primary");
        $('#form-asudepartemen > .accordion-group > .accordion-heading').find(".icon-ok").addClass("icon-minus").removeClass("icon-ok");
        $('#content-asudepartemen').removeClass().addClass("accordion-body collapse");
        $('#content-asudepartemen').removeAttr("style").attr("style","height:0px");  
        $('#content-asudepartemen').find("input,select,textarea").attr("disabled",true); 
}
function tampilFormAsuDepartemen(){
        $('#form-asudepartemen > .accordion-group > .accordion-heading').find(".btn").addClass("btn-primary");
        $('#form-asudepartemen > .accordion-group > .accordion-heading').find(".icon-minus").addClass("icon-ok").removeClass("icon-minus");
        $('#content-asudepartemen').removeClass().addClass("accordion-body in collapse");
        $('#content-asudepartemen').find(".not-required").addClass("required").removeClass("not-required");
        $('#content-asudepartemen').removeAttr("style").attr("style","height:auto"); 
        $('#content-asudepartemen').find("input,select,textarea").removeAttr("disabled");
  
}
function sembunyiFormAsuPekerja(){
        $('#content-asupekerja').find(".required").addClass("not-required").removeClass("required");
        $('#form-asupekerja > .accordion-group > .accordion-heading').find(".btn").removeClass("btn-primary");
        $('#form-asupekerja > .accordion-group > .accordion-heading').find(".icon-ok").addClass("icon-minus").removeClass("icon-ok");
        $('#content-asupekerja').removeClass().addClass("accordion-body collapse");
        $('#content-asupekerja').removeAttr("style").attr("style","height:0px");  
        $('#content-asupekerja').find("input,select,textarea").attr("disabled",true); 
}
function tampilFormAsuPekerja(){
        $('#form-asupekerja > .accordion-group > .accordion-heading').find(".btn").addClass("btn-primary");
        $('#form-asupekerja > .accordion-group > .accordion-heading').find(".icon-minus").addClass("icon-ok").removeClass("icon-minus");
        $('#content-asupekerja').removeClass().addClass("accordion-body in collapse");
        $('#content-asupekerja').find(".not-required").addClass("required").removeClass("not-required");
        $('#content-asupekerja').removeAttr("style").attr("style","height:auto"); 
        $('#content-asupekerja').find("input,select,textarea").removeAttr("disabled");
  
}

/**
 * checking penjamin pegawai badak apakah msh aktif / tidak
 * @returns {undefined}
 * LNG-48
 */
function cekCaraBayarBadak(carabayar_id){
	var pegawai_id = $("#<?php echo CHtml::activeId($modPasien,"pegawai_id");?>").val();
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
						$("#LBPendaftaranT_carabayar_id").val("");
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
 * unset asuransi badak (This Function Dedicate For LNG Projects Only)
 * @returns {undefined}
 * LNG-3
 */
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
}

/**
 * set asuransi badak (This Function Dedicate For LNG Projects Only)
 * @returns {undefined}
 * LNG-3
 */
function setAsuransiBadak(){
	var pasien_id = $("#<?php echo CHtml::activeId($modPasien,'pasien_id') ?>").val();
	var penjamin_id = $("#<?php echo CHtml::activeId($model,'penjamin_id') ?>").val();
	var pegawai_id = $("#<?php echo CHtml::activeId($modPasien,"pegawai_id");?>").val();
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
			},
			error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown); }
		});
	
}

/**
 * checking validasi penjamin (This Function Dedicate For LNG Projects Only)
 * @returns {undefined}
 * LNG-3
 */
function cekValiditasPenjamin(penjamin_id){
	var carabayar_id = $("#<?php echo CHtml::activeId($model,"carabayar_id");?>").val();
	var pegawai_id = $("#<?php echo CHtml::activeId($modPasien,"pegawai_id");?>").val();
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
									$("#<?php echo CHtml::activeId($model,"penjamin_id");?>").html(data.html);
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
}

/**
 * menampilkan karcis berdasarkan index form
 */
function setKarcis(form_index)
{
    var pasien_id=$("#<?php echo CHtml::activeId($modPasien,"pasien_id");?>").val();
    var penjamin_id=$("#<?php echo CHtml::activeId($model,"penjamin_id");?>").val();
    var ruangan_id = $("#form-pemeriksaan-"+form_index).find('select[name$="[ruangan_id]"]').val();
    var kelaspelayanan_id = $("#form-pemeriksaan-"+form_index).find('select[name$="[kelaspelayanan_id]"]').val();
    if(ruangan_id !== "" && kelaspelayanan_id !=="" && penjamin_id !== "") {
        $("#form-karcis-"+form_index).addClass("animation-loading");
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('SetKarcis'); ?>',
            data: {form_index:form_index, kelaspelayanan_id:kelaspelayanan_id, ruangan_id : ruangan_id, penjamin_id:penjamin_id, pasien_id:pasien_id},//
            dataType: "json",
            success:function(data){
                $("#form-karcis-"+form_index+" #content-karcis-html").html(data.listKarcis[form_index]);
                $("#form-karcis-"+form_index).removeClass("animation-loading");
            },
             error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        });
    }else{
       $("#form-karcis-"+form_index).find("#content-karcis-html").html("");
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
    var is_pilihpenunjangs = ($("#<?php echo CHtml::activeId($modPasienMasukPenunjangs[0],"[0]is_pilihpenunjang");?>").val()) + ($("#<?php echo CHtml::activeId($modPasienMasukPenunjangs[1],"[1]is_pilihpenunjang");?>").val());
    if(requiredCheck($("form"))){
//        if(is_pilihpenunjangs > 0){
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
//        }else{
//            myAlert("Silahkan pilih tujuan pemeriksaan laboratorium!");
//        }
    }
    return false;
}

/**
* tombol batal pada dialogbox
* @param {type} dialog_id
* @returns {undefined} 
*/
function batalDialog(dialog_id){
   myConfirm('Apakah anda yakin akan membatalkan ini?', 'Perhatian!', function(r)
   {
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

function setNoKartuAsuransi(){
    var nopeserta       = $("input[name$='[nopeserta]']").val();
    $("input[name$='[nokartuasuransi]']").val(nopeserta);
}

/**
 * update (refresh) checklist pemeriksaan lab
 * harus include /js/jquery.tiler.js
 * @param {obj} form_checklist
 */
function updateChecklistPemeriksaanLab(){
    var form_index = $('#form_index').val();
    $('#dialog-pilihpemeriksaan .dialog-content').addClass("animation-loading");
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('/laboratorium/pendaftaranLaboratorium/SetChecklistPemeriksaanLab'); ?>',
        data: {data:$("#form-caripemeriksaan :input").serialize()},
        dataType: "json",
        success:function(data){
            $('#dialog-pilihpemeriksaan .dialog-content').html(data.content);
            $('.checkboxlist-tile').tile({widths : [ 190 ]});
            $('#dialog-pilihpemeriksaan .dialog-content').removeClass("animation-loading");
            setCheckedPemeriksaan($("#form-tindakanpemeriksaan-"+form_index),$('#dialog-pilihpemeriksaan .dialog-content'));
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}

/**
 * Set checklist pemeriksaan lab
 * obj = div yang berisi elemen ruangan_id, kelaspelayanan_id
 */
function setChecklistPemeriksaanLab(obj,form_index){
    var penjamin_id = $("#<?php echo CHtml::activeId($model, 'penjamin_id') ?>").val();
    var ruangan_id = $(obj).find("select[name$='[ruangan_id]']").val();
    var kelaspelayanan_id = $(obj).find("select[name$='[kelaspelayanan_id]']").val();
    $("#form_index").val(form_index);
    if(penjamin_id == ""){
        myAlert("Silahkan pilih penjamin!");
    }else if(kelaspelayanan_id == ""){
        myAlert("Silahkan pilih kelas pelayanan!");
    }else{
        $("#form-caripemeriksaan").find("input[name$='[ruangan_id]']").val(ruangan_id);
        $("#form-caripemeriksaan").find("input[name$='[penjamin_id]']").val(penjamin_id);
        $("#form-caripemeriksaan").find("input[name$='[kelaspelayanan_id]']").val(kelaspelayanan_id);
        updateChecklistPemeriksaanLab();
        $('#dialog-pilihpemeriksaan').dialog('open'); 
    }
}
/**
 * reset pencarian & checklist pemeriksaan lab
 */
function setChecklistPemeriksaanLabReset(){
    $("#form-caripemeriksaan").find("input:not(:disabled):not([readonly])").each(function(){
        $(this).val("");
    });
    updateChecklistPemeriksaanLab();
}
/**
 * Centang pemeriksaan lab dari checkboxlist
 */
function pilihPemeriksaanIni(obj){
    var form_index = $('#form_index').val();
    var pemeriksaanlab_id = $(obj).val();
    var pemeriksaanlab_nama = $(obj).parent().find('input[name$="[pemeriksaanlab_nama]"]').val();
    var daftartindakan_id = $(obj).parent().find('input[name$="[daftartindakan_id]"]').val();
    var jenistarif_id = $(obj).parent().find('input[name$="[jenistarif_id]"]').val();
    var harga_tariftindakan = $(obj).parent().find('input[name$="[harga_tariftindakan]"]').val();
    var rowtindakan = [];
    rowtindakan[0] = '<?php echo CJSON::encode($this->renderPartial($this->path_view.'_rowTindakanPemeriksaan',array('i'=>0,'modTindakan'=>$modTindakan),true));?>';
    rowtindakan[1] = '<?php echo CJSON::encode($this->renderPartial($this->path_view.'_rowTindakanPemeriksaan',array('i'=>1,'modTindakan'=>$modTindakan),true));?>';
    if($(obj).is(':checked')){
        $("#form-tindakanpemeriksaan-"+form_index).find('tbody').append(rowtindakan[form_index]);
        $("#form-tindakanpemeriksaan-"+form_index).find('input[name$="[ii][tindakanpelayanan_id]"]').val("");
        $("#form-tindakanpemeriksaan-"+form_index).find('input[name$="[ii][pemeriksaanlab_id]"]').val(pemeriksaanlab_id);
        $("#form-tindakanpemeriksaan-"+form_index).find('input[name$="[ii][daftartindakan_id]"]').val(daftartindakan_id);
        $("#form-tindakanpemeriksaan-"+form_index).find('input[name$="[ii][jenistarif_id]"]').val(jenistarif_id);$("#form-tindakanpemeriksaan-"+form_index).find('span[name$="[ii][pemeriksaanlab_nama]"]').html(pemeriksaanlab_nama);
        $("#form-tindakanpemeriksaan-"+form_index).find('input[name$="[ii][satuantindakan]"]').val("<?php echo Params::SATUAN_TINDAKAN_LABORATORIUM; ?>");
        $("#form-tindakanpemeriksaan-"+form_index).find('input[name$="[ii][tarif_satuan]"]').val(formatInteger(harga_tariftindakan));
        $("#form-tindakanpemeriksaan-"+form_index).find('input[name$="[ii][tarif_tindakan]"]').val(formatInteger(harga_tariftindakan));
    }else{
        var delete_row = $("#form-tindakanpemeriksaan-"+form_index).find('input[name$="[pemeriksaanlab_id]"][value="'+pemeriksaanlab_id+'"]').parents('tr');
        delete_row.detach();
    }
    renameInputRow($("#form-tindakanpemeriksaan-"+form_index));
}
/**
 * rename input row yang terakhir di tambahkan
 * @param {type} obj_table
 */
function renameInputRow(obj_table){
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
/**
 * set checked pemeriksaan yang sudah ada di daftar
 */
function setCheckedPemeriksaan(obj_table,obj_dialog){
    var form_index = $('#form_index').val();
    $(obj_table).find('input[name$="[pemeriksaanlab_id]"]').each(function(){
        var pemeriksaanlab_id = $(this).val();
        $(obj_dialog).find('input[name$="[is_pilih]"][value='+pemeriksaanlab_id+']').attr('checked',true);
    });
    
}

/**
* hitung tarif tindakan RND-4168
*/ 
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

/**
 * print kartu pasien
 */
function printKartuPasien(pasien_id)
{       
    window.open('<?php echo $this->createUrl('PendaftaranRawatJalan/printKartuPasien'); ?>&pasien_id='+pasien_id,'printwin','left=100,top=100,width=480,height=640');
}
/**
 * print status 
 */
function printStatus(pendaftaran_id)
{
    window.open('<?php echo $this->createUrl('printStatusLab'); ?>&pendaftaran_id='+pendaftaran_id,'printwin','left=100,top=100,width=480,height=640');
}
/**
 * print status 
 */
function printStatusLabel(pendaftaran_id)
{
    window.open('<?php echo $this->createUrl('printStatusLabel'); ?>&pendaftaran_id='+pendaftaran_id,'printwin','left=100,top=100,width=480,height=640');
}

/**
 * untuk print otomatis */
function autoPrint(){
    window.scrollBy(0,10000);
    <?php if(Yii::app()->user->getState('printkartulsng')==TRUE){ ?>
        window.open('<?php echo $this->createUrl('PendaftaranRawatJalan/printKartuPasien',array('pasien_id'=>$model->pasien_id)); ?>','','left=100,top=100,width=480,height=640');
    <?php  } ?>
    <?php if(Yii::app()->user->getState('printkunjunganlsng')==TRUE){ ?>
        window.open('<?php echo $this->createUrl('printStatusLab',array('pendaftaran_id'=>$model->pendaftaran_id)); ?>','printwin','left=100,top=100,width=480,height=640');
    <?php  } ?>
		
}

/**
 * untuk refresh / reset form pegawai
 * @returns {undefined}
 */
function setPegawaiReset(){
	$("#<?php echo CHtml::activeId($modPasien,'pegawai_id')?>").val("");
	$("#<?php echo CHtml::activeId($modPegawai,'nomorindukpegawai')?>").val("");
	$("#<?php echo CHtml::activeId($modPegawai,'nama_pegawai')?>").val("");
	$("#<?php echo CHtml::activeId($modPegawai,'gelardepan')?>").val("");
	$("#<?php echo CHtml::activeId($modPegawai,'gelarbelakang_nama')?>").val("");
	$("#<?php echo CHtml::activeId($modPegawai,'unit_perusahaan')?>").val("");
	$("#<?php echo CHtml::activeId($modPegawai,'jabatan_nama')?>").val("");
}

    /**
     * Validasi untuk pengantar penanggung jawab
     */
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
                $('.pj_1').find(".required").addClass("non-required").removeClass("required");
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
    
    /**
     * load pengantar penanggung jawab
     */
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
    
    /**
     * Reset untuk pengantar penanggung jawab
     */
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
        cekDisabled($('#lkpendaftaran-t-form'));
        
    cekPengantar();
});

</script>