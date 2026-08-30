<?php
	$enableInputPasien = ($modPasien->isPasienLama) ? 1 : 0;
	$cekKartuPasien=Yii::app()->user->getState('printkartulsng');
	if(!empty($cekKartuPasien)){ //Jika Kunjungan Pasien diisi TRUE
		$statusKartuPasien=$cekKartuPasien;
	}else{ //JIka Print Kunjungan Diset FALSE
		$statusKartuPasien=0;
	}
?>
<script type="text/javascript">
function checkedRM(){
	$("#isPasienLama").attr('checked',true);
}

function printKarcis(){
	window.open('<?php echo $this->createUrl('printKarcis',array('buatjanjipoli_id'=>$model->buatjanjipoli_id)); ?>','printwin','left=100,top=100,width=480,height=640');
}

function getTglLahir(obj)
{   
    var str = obj.value;
    obj.value = str.replace(/_/gi, "0");
    $.post("<?php echo $this->createUrl('GetTglLahir'); ?>",{umur: obj.value},
        function(data){
           $('#PPPasienM_tanggal_lahir').val(data.tglLahir); 
    },"json");
}
	
function getUmur(obj)
{
    if(obj.value == '')
	obj.value = 0;
    $.post("<?php echo $this->createUrl('SetUmur'); ?>",{tanggal_lahir: obj.value},
        function(data){
           $('#PPPasienM_umur').val(data.umur);
    },"json");
}
	
if(<?php echo $enableInputPasien ?>) { 
    $('#no_rekam_medik').removeAttr('readonly', 'true');
    $('#tombolPasienDialog').removeClass('hide');
}
else {
    $('#no_rekam_medik').attr('readonly','true');  
    $('#tombolPasienDialog').addClass('hide');
}

function hariBaru(tipe)
{
	var ruangan_id = $("#<?php echo CHtml::activeId($model, 'ruangan_id') ?>").val();
	var pegawai_id = $("#<?php echo CHtml::activeId($model, 'pegawai_id') ?>").val();
	
	
	if (ruangan_id != '' && pegawai_id != ''){
		var tanggal = $('.tgl_jadwal').val();
		var jam = $('#PPBuatJanjiPoliT_jamjadwal').val();
		
		if (tanggal != '' && jam != ''){
			$.post("<?php echo $this->createUrl('GetHari'); ?>",{tanggal: tanggal, ruangan_id:ruangan_id, pegawai_id:pegawai_id, jam:jam, tipe:tipe},
			function(data){
				if (data.jadwal == 'ada'){
					$('#PPBuatJanjiPoliT_harijadwal').val(data.hari); 
				}else if (data.jadwal == 'tidak'){
					myAlert(data.dokter+" tidak memiliki jadwal pada tanggal "+data.tanggal+" di "+data.ruangan);//+" pada tanggal "+data.tanggal+" untuk klinik ".data.ruangan." tidak ada "
					//myAlert("No RM digunakan untuk hitungan otomatis. Pilih antara 000001 - 347499");
					$('#PPBuatJanjiPoliT_harijadwal').val(''); 
					return false;
				}else if (data.jadwal == 'diluar'){
					if (tipe != 'tanggal'){
						myConfirm("Anda memilih jadwal janji diluar jadwal dokter. Apakah Anda ingin melanjutkan?","Perhatian",
						function(r){
							if(r){
								$('#PPBuatJanjiPoliT_harijadwal').val(data.hari); 
							}else{
								$('#PPBuatJanjiPoliT_harijadwal').val(''); 
								return false;
							}
						});
					}else{
						$('#PPBuatJanjiPoliT_harijadwal').val(data.hari); 
						$('#PPBuatJanjiPoliT_jamjadwal').val(data.jamtanggal); 
					}
				}else if (data.jadwal == 'sama'){
					myConfirm("Anda memilih jadwal janji pada jam selesai jadwal dokter. Apakah Anda ingin melanjutkan?","Perhatian",
					function(r){
						if(r){
							$('#PPBuatJanjiPoliT_harijadwal').val(data.hari); 
						}else{
							$('#PPBuatJanjiPoliT_harijadwal').val(''); 
							return false;
						}
					});
				}

			},"json");
		}			
			
	}else{
		alert('Maaf, Data Ruangan atau Dokter belum diisi');			
		$('#PPBuatJanjiPoliT_harijadwal').val(''); 
		$('#PPBuatJanjiPoliT_tgljadwal').val('');
		return false;
	}

}

function AmbilHari()
{
    var tanggal = $('.tgl_jadwal').val();		
			
    $.post("<?php echo $this->createUrl('GetHari'); ?>",{tanggal: tanggal},
    function(data){
            $('#PPBuatJanjiPoliT_harijadwal').val(data.hari); 
    },"json");						
}

function listDokterRuangan(idRuangan)
{
    $.post("<?php echo $this->createUrl('listDokterRuangan'); ?>", { idRuangan: idRuangan },
        function(data){
            var pg  = jQuery('#PPBuatJanjiPoliT_pegawai_id');
            $('#PPBuatJanjiPoliT_pegawai_id').html(data.listDokter);
            pg.multiselect('rebuild');															
    }, "json");
}

function loadUmur(tglLahir)
{
    $.post("<?php echo $this->createUrl('SetUmur'); ?>",{tanggal_lahir: tglLahir},
        function(data){
           $("#PPPasienM_umur").val(data.umur);
    },"json");
}
	
function setNip(pegawai_id)
{
    $.post("<?php echo $this->createUrl('SetNip'); ?>",{pegawai_id: pegawai_id},
        function(data){
//           $("#cari_nomorindukpegawai").val(data.nomorindukpegawai);
//	RND-9167
			 $("#nomorindukpegawai").val(data.nomorindukpegawai);
    },"json");
}

function setJenisKelaminPasien(jenisKelamin)
{
    $('input[name="PPPasienM[jeniskelamin]"]').each(function(){
            if(this.value == jenisKelamin)
                $(this).attr('checked',true);
        }
    );
}

function setRhesusPasien(rhesus)
{
    $('input[name="PPPasienM[rhesus]"]').each(function(){
            if(this.value == rhesus)
                $(this).attr('checked',true);
        }
    );
}

function loadDaerahPasien(idProp,idKab,idKec,pasien_id)
{
    $.post("<?php echo $this->createUrl('getListDaerahPasien'); ?>", { idProp: idProp, idKab: idKab, idKec: idKec, pasien_id: pasien_id },
        function(data){
            $('#PPPasienM_propinsi_id').html(data.listPropinsi);
            $('#PPPasienM_kabupaten_id').html(data.listKabupaten);
            $('#PPPasienM_kecamatan_id').html(data.listKecamatan);
            $('#PPPasienM_kelurahan_id').html(data.listKelurahan);
    }, "json");
}
    
function pilihNoRm(){
    if($('#isPasienLama').is(':checked')){
        $('#no_rekam_medik').removeAttr('readonly', 'true');
        $('#tombolPasienDialog').removeClass('hide');
    }else{
        $('#no_rekam_medik').val(''); 
        $('#no_rekam_medik').attr('readonly','true'); 
        $('#tombolPasienDialog').addClass('hide');
    }
} 

/**
 * 
 * @param {type} obj
 * @param {type} st
 * @returns {undefined}
 */
function listDataPasienJanjiPoli(obj, st){
	$("#<?php echo CHtml::activeId($model, 'harijadwal') ?>").val('');
	
	$.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('GetJadwalJanjiPolik'); ?>',
        data: {st: st, id:$(obj).val()},
        dataType: "json",
        success:function(data){
			if (st == 'ruangan'){
				$("#janjipoli-klinik").html(data.tr);
				//$)('#klinikNama')
			}else{
				$("#janjipoli-dokter").html(data.tr);
			}
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
	
}

/**
 * load otomatis asuransi pasien terakhir
 * @returns {undefined}
 */
function setAsuransiPasienLama(pasien_id){
	$.ajax({
        type:'POST',
        url:'<?php echo Yii::app()->createUrl('pendaftaranPenjadwalan/PendaftaranRawatJalan/SetAsuransiPasienLama'); ?>',
        data: { pasien_id: pasien_id},
        dataType: "json",
        success:function(data){
            console.log(data);
            if(data != null){
                var datacarabayar_id = data.carabayar_id;
		var datalistPenjamin = data.listPenjamin;
		$("#<?php echo CHtml::activeId($modPasien, "carabayar_id"); ?>").val(datacarabayar_id);
		$("#<?php echo CHtml::activeId($modPasien, "penjamin_id"); ?>").html(datalistPenjamin);
            if(data.isBpjs){
                $("#AsuransipasienM_nopeserta").val(data.nopeserta);
            }
            }
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}

function listKuota() {
    var pegawai_id = $("#PPBuatJanjiPoliT_pegawai_id").val();
    var tgl = $(".tgl_jadwal").val();
    var ruangan_id = $("#PPBuatJanjiPoliT_ruangan_id").val();
    
    console.log(pegawai_id, ruangan_id, tgl);
    
    
    if (pegawai_id == "" || ruangan_id == "" || tgl == "") {
        return false;
    }

    $(".panel_jadwal").empty();
    
    $.post("<?php echo $this->createUrl("getKuotaJanjiPoli") ?>", {pegawai_id: pegawai_id, ruangan_id: ruangan_id, tgl: tgl}, function(data) {
        
        if (data.is_penuh == 1) {
            myAlert(data.msg);
            $("#kuota_janji").val("");
            $("#sisa_kuota").val("");
            $("#PPBuatJanjiPoliT_pegawai_id").val(null);
            $(".panel_jadwal").html("");
            return false;
        }
        
        $("#kuota_janji").val(data.kuota);
        $("#sisa_kuota").val(data.sisa);
        $(".slot_jadwal").html(data.slot);
        $(".panel_jadwal").html(data.checkbox_jadwal);
        setCeklisJadwalDokter();
    }, 'json');
}

function setCeklisJadwalDokter() {
    var jadwal = $(".ceklis_jadwal:checked").val();

    $(".slot_jadwal option[data-item='1']").hide();

    if (jadwal != null) {
        $(".slot_jadwal option[data-jadwal='" + jadwal + "']").show();
    }
}

function cekSlotTersedia() {
    $(".no_antrianjanji").val("");
    if ($(".slot_jadwal :selected").data('terisi') == 1
    || $(".slot_jadwal :selected").data('terisi-jadwal') == 1) {
        $(".slot_jadwal").val("");
        myAlert("Slot jadwal yang dipilih sudah terisi.");
    } else {
        $(".no_antrianjanji").val($(".slot_jadwal :selected").data('slot'));
    }

}

function setNoKartu(){
    var mod = ('#PPPasienM_penjamin_id').val();
    console.log(mod);
}

    function setPasienLama(pasien_id, no_rekam_medik, is_manual) {
        
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('GetDataPasien'); ?>',
            data: {
                pasien_id: pasien_id,
                no_rekam_medik: no_rekam_medik,
                is_manual: is_manual
            },
            dataType: "json",
            success: function(data) {
                if (data.lebih) {
                    myAlert("No. RM digunakan untuk hitungan otomatis. Pilih antara 000001 - 347499");
                    $("#form-pasien > div").removeClass("animation-loading");
                    $("#no_rekam_medik_baru").val("");
                    return false;
                }

                if (data.adaInap) {
                    myAlert("Pasien " + data.listDaftar.pasien.namadepan + data.listDaftar.pasien.nama_pasien + " (" + data.listDaftar.no_pendaftaran + ")\n\
                Hari ini sedang dirawat inap di " + data.listDaftar.ruangan.ruangan_nama + ".");
                    $("#form-pasien > div").removeClass("animation-loading");
                    $("#<?php echo CHtml::activeId($modPasien, 'nama_pasien'); ?>").val("");
                    setPasienBaru();
                    isSetLama = false;
                    return false;
                }
                if (data.tindakLanjut) {
                    myAlert("Pasien " + data.listDaftar.pasien.namadepan + data.listDaftar.pasien.nama_pasien + " (" + data.listDaftar.no_pendaftaran + ")\n\
                    Hari ini menunggu tindak lanjut ke rawat inap di " + data.listDaftar.instalasi.instalasi_nama + " -> " + data.listDaftar.ruangan.ruangan_nama + ".");
                    $("#form-pasien > div").removeClass("animation-loading");
                    $("#<?php echo CHtml::activeId($modPasien, 'nama_pasien'); ?>").val("");
                    setPasienBaru();
                    isSetLama = false;
                    return false;
                }
                if (data.adaDaftar) {
                    myAlert("Pasien " + data.listDaftar.pasien.namadepan + data.listDaftar.pasien.nama_pasien + " (" + data.listDaftar.no_pendaftaran + ")\n\
                Hari ini sedang di instalasi " + data.listDaftar.instalasi.instalasi_nama + " -> " + data.listDaftar.ruangan.ruangan_nama + " dengan status pemeriksan '" +
                        data.listDaftar.statusperiksa + "'.");
                    $("#form-pasien > div").removeClass("animation-loading");
                    $("#<?php echo CHtml::activeId($modPasien, 'nama_pasien'); ?>").val("");
                    setPasienBaru();
                    isSetLama = false;
                    return false;
                }
                if (data.is_kabur) {
                    myAlert("PASIEN BELUM MENYELESAIKAN ADMINISTRASI KUNJUNGAN SEBELUMNYA!!!");
                }

                <?php //    endif; 
                ?>

                if (data.statusrekammedis.trim() == "<?php echo Params::STATUSREKAMMEDIS_AKTIF ?>") {
                    $("#cari_nomorindukpegawai").val(data.nomorindukpegawai); // untuk load filed NIP
                    $("#no_rekam_medik").val(data.no_rekam_medik);
                    $("#AsuransipasienM_nopeserta").val(data.asuransi);
                    // $("#PPPasienM_carabayar_id").val(data.carabayar_id);
                    $("#isPasienLama").val(data.isPasienLama);

                    $("#PPBuatJanjiPoliT_pasien_id").val(data.pasien_id);
                    $("#<?php echo CHtml::activeId($modPasien, "jenisidentitas"); ?>").val(data.jenisidentitas);
                    $("#<?php echo CHtml::activeId($modPasien, "no_jamkespa"); ?>").val(data.no_jamkespa);
                    $("#<?php echo CHtml::activeId($modPasien, "no_identitas_pasien"); ?>").val(data.no_identitas_pasien);
                    $("#<?php echo CHtml::activeId($modPasien, "namadepan"); ?>").val(data.namadepan);
                    $("#<?php echo CHtml::activeId($modPasien, "nama_pasien"); ?>").val(data.nama_pasien);
                    $("#<?php echo CHtml::activeId($modPasien, "nama_bin"); ?>").val(data.nama_bin);
                    $("#<?php echo CHtml::activeId($modPasien, "tempat_lahir"); ?>").val(data.tempat_lahir);
                    $("#<?php echo CHtml::activeId($modPasien, "nama_ayah"); ?>").val(data.nama_ayah);
                    $("#<?php echo CHtml::activeId($modPasien, "nama_ibu"); ?>").val(data.nama_ibu);
                    $("#<?php echo CHtml::activeId($modPasien, "tanggal_lahir"); ?>").val(data.tanggal_lahir);
                    $("#<?php echo CHtml::activeId($modPasien, "kelompokumur_id"); ?>").val(data.kelompokumur_id);
                    $("#<?php echo CHtml::activeId($modPasien, "statusperkawinan"); ?>").val(data.statusperkawinan);
                    $("#<?php echo CHtml::activeId($modPasien, "golongandarah"); ?>").val(data.golongandarah);
                    $("#<?php echo CHtml::activeId($modPasien, "rhesus"); ?>").val(data.rhesus);
                    $("#<?php echo CHtml::activeId($modPasien, "alamat_pasien"); ?>").val(data.alamat_pasien);
                    $("#<?php echo CHtml::activeId($modPasien, "rt"); ?>").val(data.rt);
                    $("#<?php echo CHtml::activeId($modPasien, "rw"); ?>").val(data.rw);
                    $("#<?php echo CHtml::activeId($modPasien, "no_telepon_pasien"); ?>").val(data.no_telepon_pasien);
                    $("#<?php echo CHtml::activeId($modPasien, "no_mobile_pasien"); ?>").val(data.no_mobile_pasien).blur();
                    $("#<?php echo CHtml::activeId($modPasien, "suku_id"); ?>").val(data.suku_id).change().multiselect('rebuild');
                    $("#<?php echo CHtml::activeId($modPasien, "alamatemail"); ?>").val(data.alamatemail);
                    $("#<?php echo CHtml::activeId($modPasien, "anakke"); ?>").val(data.anakke);
                    $("#<?php echo CHtml::activeId($modPasien, "jumlah_bersaudara"); ?>").val(data.jumlah_bersaudara);
                    $("#<?php echo CHtml::activeId($modPasien, "pendidikan_id"); ?>").val(data.pendidikan_id);
                    $("#<?php echo CHtml::activeId($modPasien, "pekerjaan_id"); ?>").val(data.pekerjaan_id);
                    $("#<?php echo CHtml::activeId($modPasien, "agama"); ?>").val(data.agama);
                    $("#<?php echo CHtml::activeId($modPasien, "warga_negara"); ?>").val(data.warga_negara);

                    setJenisKelaminPasien(data.jeniskelamin);
                
                    // setDaerahPasien(data.propinsi_id, data.kabupaten_id, data.kecamatan_id, data.kelurahan_id);
                    setUmur(data.tanggal_lahir);
            
                } else {
                    if (confirm("Apakah anda akan menggunakan No. Rekam Medik Non-Aktif ?")) {
                        $("#cari_no_rekam_medik").val(data.no_rekam_medik);
                        $("#<?php echo CHtml::activeId($modPasien, 'pasien_id'); ?>").val(data.pasien_id);

                        $("#form-pasien > legend > .judul").html('Data Pasien No. Rekam Medik Lama ');
                        $("#form-pasien > legend > .tombol").attr('style', 'display:true;');
                        $("#form-pasien > .box").addClass("well").removeClass("box");
                        $("#<?php echo CHtml::activeId($modPasien, 'jenisidentitas'); ?>").focus();
                    }
                }
                $("#isPasienLama").attr('checked',true);
                $("#no_rekam_medik").prop('readonly', false);
                $("#<?php echo CHtml::activeId($model, 'ruangan_id'); ?>").focus(); //<<RND-820 (custom)
                window.scrollBy(0, 380); //<<RND-820 (custom)
                $("#form-pasien > div").removeClass("animation-loading");
            },
            error: function(jqXHR, textStatus, errorThrown) {
                if (!is_manual) myAlert("Data Pasien tidak ditemukan!");
                else $("#no_rekam_medik_baru").val(no_rekam_medik);

                isSetLama = false;
                $("#form-pasien > div").removeClass("animation-loading");

            }
        });
    }

    /**
     * set nilai umur dari tanggal_lahir
     * @param {type} tanggal_lahir
     * @returns {undefined} */
    function setUmur(tanggal_lahir) {
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('SetUmur'); ?>',
            data: {
                tanggal_lahir: tanggal_lahir
            }, //
            dataType: "json",
            success: function(data) {
                console.log(data.umur);
                $("#PPPasienM_umur").val(data.umur);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    function setDaerahPasien(propinsi_id, kabupaten_id, kecamatan_id, kelurahan_id) {
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('SetDropdownDaerahPasien'); ?>',
            data: {
                propinsi_id: propinsi_id,
                kabupaten_id: kabupaten_id,
                kecamatan_id: kecamatan_id,
                kelurahan_id: kelurahan_id
            },
            dataType: "json",
            success: function(data) {
                $("#<?php echo CHtml::activeId($modPasien, "propinsi_id"); ?>").html(data.listPropinsi).multiselect('rebuild');
                $("#<?php echo CHtml::activeId($modPasien, "kabupaten_id"); ?>").html(data.listKabupaten).multiselect('rebuild');
                $("#<?php echo CHtml::activeId($modPasien, "kecamatan_id"); ?>").html(data.listKecamatan).multiselect('rebuild');
                $("#<?php echo CHtml::activeId($modPasien, "kelurahan_id"); ?>").html(data.listKelurahan).multiselect('rebuild');
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    function kirimWA (){
        $("#form-buat-janji-poli > div").addClass("animation-loading");
        var queryString = window.location.search;
        var urlParams = new URLSearchParams(queryString);
        var janjipoli = urlParams.get('janjipoli')
    
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('kirimWhatsApp') ?>',
            data: {
                janjipoli: janjipoli,
            },
            dataType: "json",
            success: function(data) {
                if (data.status == 'ok') {
                    myAlert('Notifikasi Whatsap berhasil dikirim');
                } else {
                    if (data.status == 'gagal') {
                        myAlert('Whatsap gagal dikirim');
                    }
                }
                $('#tombolwa').attr('disabled', true);
                $("#form-buat-janji-poli > div").removeClass("animation-loading");
            },
        });

    }

$(document).ready(function(){
  
    <?php if (isset($_GET['ok'])){ ?>
        // myAlert('ok');
        $('#tombolwa').attr("disabled", false);
    <?php } else {?>
        $('#tombolwa').attr('disabled', true);
        // myAlert('not ok');
    <?php }?>
  <?php
    if(isset($model->buatjanjipoli_id)){
        $tgl_jadwal = implode($model->tgljadwal).":00";
  ?>
      var params = [];
      params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Params::MODUL_ID_RJ; ?>, judulnotifikasi:'Janji Poliklinik', isinotifikasi:'<?php echo $modPasien->nama_pasien ?>  dengan <?php echo $modPasien->no_rekam_medik ?> memiliki janji poliklinik pada <?php echo $tgl_jadwal ?> di <?php echo $model->ruangan->ruangan_nama ?>'}; // 16 
      insert_notifikasi(params);
  <?php
    }
  ?>
   var ruangan_id = $('#<?php echo CHtml::activeId($model,'ruangan_id'); ?>').val();
   var pegawai_id = '<?php echo isset($model->pegawai_id) ? $model->pegawai_id : null; ?>';
   if(ruangan_id != ''){
		listDokterRuangan(ruangan_id);
		$('#<?php echo CHtml::activeId($model,'pegawai_id'); ?>').val(pegawai_id);
	}

    $("#isPasienLama").click();
     var ruangan  = jQuery('.ruanganpoli');
     var dokter  = jQuery('.dokterpoli');

     jQuery(ruangan).multiselect({
			includeSelectAllOption: true,
			buttonClass: "form-control",
			maxHeight: 300,
			buttonWidth: '182px',
			enableCaseInsensitiveFiltering: false
		}).hide();

        jQuery(dokter).multiselect({
			includeSelectAllOption: true,
			buttonClass: "form-control",
			maxHeight: 300,
			buttonWidth: '182px',
			enableCaseInsensitiveFiltering: false
		}).hide();

        

});

function cekSlotTersedia() {
            var pasien_id = $("#PPPasienM_pasien_id").val();
            $(".no_antrianjanji").val("");
            if ($(".slot_jadwal :selected").data('terisi') == 1
            || $(".slot_jadwal :selected").data('terisi-jadwal') == 1) {
                if ($(".slot_jadwal :selected").data('pasien') != pasien_id) {
                    $(".slot_jadwal").val("");
                    myAlert("Slot jadwal yang dipilih sudah terisi.");
                } else {
                    $(".no_antrianjanji").val($(".slot_jadwal :selected").data('slot'));
                }
            } else {
                $(".no_antrianjanji").val($(".slot_jadwal :selected").data('slot'));
            }

        }
        
function setAntrianDokter(ruangan_id) {
        var ruangan_id = $("#<?php echo CHtml::activeId($model, 'ruangan_id') ?>").val();
        var pegawai_id = $("#<?php echo CHtml::activeId($model, 'pegawai_id') ?>").val();
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('SetAntrianDokter'); ?>',
            data: {
                ruangan_id: ruangan_id,
                pegawai_id: pegawai_id
            },
            dataType: "json",
            success: function(data) {
                $('#max-antrian-dokter').val(data.maxantriandokter);
                $('#sisa-antrian-dokter').val(data.maxantriandokter - data.sisaantriandokter);

                <?php if ($this->id == "pendaftaranRawatJalan"): ?>
                listKuota();
                <?php endif; ?>
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }
    
    
    

$(function () {
        $("#antrian").click(function () {
            if ($(this).is(":checked")) {
                $(".slot_jadwal").hide();
                $(".ceklis_jadwal").hide();
            } else {
                $(".slot_jadwal").show();
                $(".ceklis_jadwal").show();
                cekSlotTersedia();
            }
        });
    });

</script>