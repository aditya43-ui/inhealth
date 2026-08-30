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
$('#tab1-datapasien').fadeIn(100);
$('#tab1-datapesanan').hide();
function tab1(obj){
	var poli = obj.id;
	if(poli == 'datapasien'){
		$('#datapasien').attr('class', 'active');
		$('#datapesanan').removeAttr('class');
		$('#tab1-datapesanan').fadeOut(100);
		$('#tab1-datapasien').fadeIn(100);
	}else{
		$('#datapesanan').attr('class', 'active');
		$('#datapasien').removeAttr('class');
		$('#tab1-datapasien').fadeOut(100);
		$('#tab1-datapesanan').fadeIn(100);
	}
}

/**
 * set pasien lama
 * @param {type} pasien_id
 * @returns {undefined}
 */
function setPasienLama(pasien_id, no_rekam_medik ){
    $("#form-pasien > div").addClass("animation-loading");
//    setPasienBaru(); 
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('GetDataPasien'); ?>',
        data: {pasien_id:pasien_id, no_rekam_medik:no_rekam_medik},
        dataType: "json",
        success:function(data){
            
            // if (data.isbpjs){
            //     myAlert("Maaf, Pemesanan kamar ini hanya dapat diproses untuk penjamin selain BPJS");
            //     $("#form-pasien > div").removeClass("animation-loading");
            //     $("#<?php // echo CHtml::activeId($modPasien, 'nama_pasien'); ?>").focus(); 
            //     return false;
            // }
            
            if(data.statusrekammedis.trim() == "<?php echo Params::STATUSREKAMMEDIS_AKTIF?>"){
				$("#cari_nomorindukpegawai").val(data.nomorindukpegawai); // untuk load filed NIP
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
    
	$("#<?php echo CHtml::activeId($model,"carabayar_id");?>").val("");
	$("#<?php echo CHtml::activeId($model,"penjamin_id");?>").val("");
	setAsuransiBadakReset();
	
    $("#<?php echo CHtml::activeId($modPasien,"photopasien");?>").val("");
    $('#photo-preview').attr('src','<?php echo Params::urlPhotoPasienDirectory()."no_photo.jpeg"?>');

    setJenisKelaminPasien("");
	setPegawaiReset();

    $("#form-pasien > legend > .judul").html('Data Pasien Baru ');
    $("#form-pasien > legend > .tombol").attr('style','display:none;');
    $("#form-pasien > .well").addClass("box").removeClass("well");
    $("#cari_no_rekam_medik").val("");
	$("#cari_nomorindukpegawai").val("");
}

function tampilFormPegawai(){
	$('#form-pegawai > .accordion-group > .accordion-heading').find(".btn").addClass("btn-primary");
	$('#form-pegawai > .accordion-group > .accordion-heading').find(".icon-plus").addClass("icon-minus").removeClass("icon-plus");
	$('#content-pegawai').removeClass().addClass("accordion-body in collapse");
	$('#content-pegawai').find(".not-required").addClass("required").removeClass("not-required");
	$('#content-pegawai').removeAttr("style").attr("style","height:auto"); 
	$('#content-pegawai').find("input,select,textarea").removeAttr("disabled");
}

function sembunyiFormPegawai(){
	$('#content-pegawai').find(".required").addClass("not-required").removeClass("required");
	$('#form-pegawai > .accordion-group > .accordion-heading').find(".btn").removeClass("btn-primary");
	$('#form-pegawai > .accordion-group > .accordion-heading').find(".icon-minus").addClass("icon-plus").removeClass("icon-minus");
	$('#content-pegawai').removeClass().addClass("accordion-body collapse");
	$('#content-pegawai').removeAttr("style").attr("style","height:0px");  
	$('#content-pegawai').find("input,select,textarea").attr("disabled",true); 
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

function getStatus(obj){    
	idKamarruangan = (obj.value);
	$.ajax({
		type:'POST',
		url:'<?php echo $this->createUrl('getStatusKamar'); ?>',
		data: {idKamarruangan : idKamarruangan},
		dataType: "json",
		success:function(data){
			$('div.divForForm').html(data.status);
			if(data.kamar=="IN USE"){
				$('#PPBookingKamarT_statusbooking').val("ANTRI");
				$('#PPBookingKamarT_statusbooking_dropdown').val("ANTRI");
			}else{
				$('#PPBookingKamarT_statusbooking').val("NON ANTRI");
				$('#PPBookingKamarT_statusbooking_dropdown').val("NON ANTRI");
			}
		},
		error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
	});
}

function print()
{
	var bookingkamar_id = '<?php echo isset($_GET['bookingkamar_id']) ? $_GET['bookingkamar_id'] : null; ?>';
	if (bookingkamar_id=='') {
		myAlert("Kosong");
	}
	window.open('<?php echo $this->createUrl('lembarBookingKamar',array('bookingkamar_id'=>'')); ?>'+bookingkamar_id,'printwin','left=100,top=100,width=400,height=400');
}
	
$(document).ready(function(){

});
</script>