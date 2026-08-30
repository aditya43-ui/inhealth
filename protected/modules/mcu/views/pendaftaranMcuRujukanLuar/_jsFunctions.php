<script type="text/javascript">
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
				$("#cari_nomorindukpegawai").val(data.nomorindukpegawai);
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
                setKarcis();
                setRiwayatKunjunganPasien(data.pasien_id);
				setAsuransiPasienLama(data.pasien_id);				
				
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
    
    $("#<?php echo CHtml::activeId($modPasien,"photopasien");?>").val("");
    $('#photo-preview').attr('src','<?php echo Params::urlPhotoPasienDirectory()."no_photo.jpeg"?>');

    setJenisKelaminPasien("");
    setKarcis();
	
    $("#form-pasien > legend > .judul").html('Data Pasien Baru ');
    $("#form-pasien > legend > .tombol").attr('style','display:none;');
    $("#form-pasien > .well").addClass("box").removeClass("well");
    $("#cari_no_rekam_medik").val("");
}

function setAsuransiLama(){
	$(".judulasuransi").html("Asuransi Lama");
	$(".refreshasuransi").attr("style","display:true;");
}

function setAsuransiBaru(){
    $("#MCAsuransipasienM_nopeserta").val("");
    $("#MCAsuransipasienM_asuransipasien_id").val("");
    $("#MCAsuransipasienM_nokartuasuransi").val("");
    $("#MCAsuransipasienM_namapemilikasuransi").val("");
    $("#MCAsuransipasienM_nomorpokokperusahaan").val("");
    $("#MCAsuransipasienM_kelastanggunganasuransi_id").val("");
    $("#MCAsuransipasienM_namaperusahaan").val("");
    $("#MCAsuransipasienM_status_konfirmasi").val("");
    $("#MCAsuransipasienM_tgl_konfirmasi").val("");
	$(".judulasuransi").html("Asuransi Baru");
	$(".refreshasuransi").attr("style","display:none;");
	
}
/**
 * load otomatis asuransi pasien terakhir
 * @returns {undefined}
 */
function setAsuransiPasienLama(pasien_id){
	var pegawai_id = $("#<?php echo CHtml::activeId($modPasien,"pegawai_id");?>").val();
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
/**
 * menampilkan karcis
 */
function setKarcis()
{
    var kelaspelayanan_id=$("#<?php echo CHtml::activeId($model,"kelaspelayanan_id");?>").val();
    var ruangan_id=$("#<?php echo CHtml::activeId($model,"ruangan_id");?>").val();
    var penjamin_id=$("#<?php echo CHtml::activeId($model,"penjamin_id");?>").val();
    var pasien_id=$("#<?php echo CHtml::activeId($modPasien,"pasien_id");?>").val();
    
    if(kelaspelayanan_id !== "" && ruangan_id !== "" && penjamin_id !== "") {
        $("#form-karcis").addClass("animation-loading");
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('SetKarcis'); ?>',
            data: {kelaspelayanan_id:kelaspelayanan_id, ruangan_id : ruangan_id, penjamin_id:penjamin_id, pasien_id:pasien_id},//
            dataType: "json",
            success:function(data){
                $("#content-karcis-html").html(data.listKarcis);
                $("#form-karcis").removeClass("animation-loading");
            },
             error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        });
    }else{
        $("#content-karcis-html").html("");
    }
	updateChecklistTindakanMcuDiluarPaket();
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
        is_adakarcis.val(0);
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
/** control accordion rujukan keluar */
$('#form-rujukan-keluar > div > .accordion-heading').click(function(){
//    console.log("Rujukan Di Klik!");
    var is_pasienrujukankeluar = $("#<?php echo CHtml::activeId($modRujukanKeluar, "is_pasienrujukankeluar"); ?>");
    if(is_pasienrujukankeluar.val() > 0){ //hide
        is_pasienrujukankeluar.val(0);
    }else{//show
        is_pasienrujukankeluar.val(1);
    }
});
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
				$('#MCRujukanT_asalrujukan_id').html(data.asalrujukan);
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
                $('#MCRujukanT_nama_perujuk').html(data.namarujukan);
                setTimeout("$('#dialogAddRujukanDari').dialog('close')",1000);
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
                $('#MCPasienM_propinsi_id').html(data.propinsi);
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
                $('#MCPasienM_kabupaten_id').html(data.kabupaten);
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
                $('#MCPasienM_kecamatan_id').html(data.kecamatan);
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
                $('#MCPasienM_kelurahan_id').html(data.kelurahan);
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
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('SetAntrianRuangan'); ?>',
        data: {ruangan_id:ruangan_id},
        dataType: "json",
        success:function(data){
            if(data.maxantrianruangan != null){
                if(data.no_urutantri > data.maxantrianruangan){
                    myAlert("Pasien Sudah Mencapai Maksimal Antrian Poliklinik "+data.maxantrianruangan+" Pasien"); 
			$("#<?php echo CHtml::activeId($model,'ruangan_id');?>").val("");
                }
                $('#max-antrian-ruangan').val(data.maxantrianruangan);
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
    var carabayar_id_umum = <?php echo Params::CARABAYAR_ID_MEMBAYAR;?>;
    var carabayar_id_bpjs = <?php echo Params::CARABAYAR_ID_BPJS;?>;
	
    if(carabayar_id == carabayar_id_umum){
		
		
        sembunyiFormAsuransi();
        sembunyiFormBpjs();

        $('#form-bpjs').hide(); 
        $('#form-asuransi').show(); 
//        $('#form-rujukan').show();
    }else if(carabayar_id == carabayar_id_bpjs){
		
        tampilFormBpjs();
        sembunyiFormAsuransi();
        //sembunyiFormRujukan();

        $('#form-asuransi').hide();
        $('#form-bpjs').show(); 
//        $('#form-rujukan').hide(); 
    }else{
		
        tampilFormAsuransi();
        sembunyiFormBpjs();
        $('#form-bpjs').hide(); 
        $('#form-asuransi').show(); 
//        $('#form-rujukan').show();
    }
}
<?php }else{ ?>
/**
 * set form asuransi 
 * @returns {undefined} */
function setFormAsuransi(carabayar_id){
    var carabayar_id_umum = <?php echo Params::CARABAYAR_ID_MEMBAYAR;?>;
    var carabayar_id_bpjs = <?php echo Params::CARABAYAR_ID_BPJS;?>;
    if(carabayar_id == carabayar_id_umum){
        sembunyiFormAsuransi();
    }else{
        tampilFormAsuransi();
    }
}
<?php } ?>
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
function sembunyiFormAsuransi(){
        $('#content-asuransi').find(".required").addClass("not-required").removeClass("required");
        $('#form-asuransi > .accordion-group > .accordion-heading').find(".btn").removeClass("btn-primary");
        $('#form-asuransi > .accordion-group > .accordion-heading').find(".icon-minus").addClass("icon-plus").removeClass("icon-minus");
        $('#content-asuransi').removeClass().addClass("accordion-body collapse");
        $('#content-asuransi').removeAttr("style").attr("style","height:0px");  
        $('#content-asuransi').find("input,select,textarea").attr("disabled",true); 
  
}
function tampilFormAsuransi(){
        $('#form-asuransi > .accordion-group > .accordion-heading').find(".btn").addClass("btn-primary");
        $('#form-asuransi > .accordion-group > .accordion-heading').find(".icon-plus").addClass("icon-minus").removeClass("icon-plus");
        $('#content-asuransi').removeClass().addClass("accordion-body in collapse");
        $('#content-asuransi').find(".not-required").addClass("required").removeClass("not-required");
        $('#content-asuransi').removeAttr("style").attr("style","height:auto"); 
        $('#content-asuransi').find("input,select,textarea").removeAttr("disabled");
  
}
function sembunyiFormBpjs(){
        $('#content-bpjs').find(".required").addClass("not-required").removeClass("required");
        $('#form-bpjs > .accordion-group > .accordion-heading').find(".btn").removeClass("btn-primary");
        $('#form-bpjs > .accordion-group > .accordion-heading').find(".icon-minus").addClass("icon-plus").removeClass("icon-minus");
        $('#content-bpjs').removeClass().addClass("accordion-body collapse");
        $('#content-bpjs').removeAttr("style").attr("style","height:0px");  
        $('#content-bpjs').find("input,select,textarea").attr("disabled",true); 
        var is_bpjs = $("#<?php echo CHtml::activeId($model, "is_bpjs"); ?>");
        is_bpjs.val(0);
}
function tampilFormBpjs(){
        $('#form-bpjs > .accordion-group > .accordion-heading').find(".btn").addClass("btn-primary");
        $('#form-bpjs > .accordion-group > .accordion-heading').find(".icon-plus").addClass("icon-minus").removeClass("icon-plus");
        $('#content-bpjs').removeClass().addClass("accordion-body in collapse");
        $('#content-bpjs').find(".not-required").addClass("required").removeClass("not-required");
        $('#content-bpjs').removeAttr("style").attr("style","height:auto"); 
        $('#content-bpjs').find("input,select,textarea").removeAttr("disabled"); 
        var is_bpjs = $("#<?php echo CHtml::activeId($model, "is_bpjs"); ?>");
        is_bpjs.val(1);
}
function sembunyiFormRujukan(){
        $('#content-rujukan-keluar').find(".required").addClass("not-required").removeClass("required");
        $('#form-rujukan-keluar > .accordion-group > .accordion-heading').find(".btn").removeClass("btn-primary");
        $('#form-rujukan-keluar > .accordion-group > .accordion-heading').find(".icon-minus").addClass("icon-plus").removeClass("icon-minus");
        $('#content-rujukan-keluar').removeClass().addClass("accordion-body collapse");
        $('#content-rujukan-keluar').removeAttr("style").attr("style","height:0px");  
        $('#content-rujukan-keluar').find("input,select,textarea").attr("disabled",true);
        var is_pasienrujukankeluar = $("#<?php echo CHtml::activeId($modRujukanKeluar, "is_pasienrujukankeluar"); ?>");
        is_pasienrujukankeluar.val(0);
}
function tampilFormRujukan(){
        $('#form-rujukan-keluar > .accordion-group > .accordion-heading').find(".btn").addClass("btn-primary");
        $('#form-rujukan-keluar > .accordion-group > .accordion-heading').find(".icon-plus").addClass("icon-minus").removeClass("icon-plus");
        $('#content-rujukan-keluar').removeClass().addClass("accordion-body in collapse");
        $('#content-rujukan-keluar').find(".not-required").addClass("required").removeClass("not-required");
        $('#content-rujukan-keluar').removeAttr("style").attr("style","height:auto"); 
        $('#content-rujukan-keluar').find("input,select,textarea").removeAttr("disabled"); 
        var is_pasienrujukankeluar = $("#<?php echo CHtml::activeId($modRujukanKeluar, "is_pasienrujukankeluar"); ?>");
        is_pasienrujukankeluar.val(0);
}
/**
 * pilih karcis (check - uncheck)
 * harus pilih salah satu
 * @param {type} obj
 * @returns {undefined} */
function pilihKarcis(obj){
//    console.log("Karcis Dipilih!");
    var is_pilihtindakan = $(obj).parents('tr').find('input[name$="[is_pilihtindakan]"]');
    $(obj).parents('table').find('tr').each(function(){
        $(this).find('input[name$="[is_pilihtindakan]"]').val(0);
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
    window.open('<?php echo $this->createUrl('pendaftaranPasien/printKartuPasien',array('pasien_id'=>$model->pasien_id)); ?>','printwin','left=100,top=100,width=480,height=640,scrollbars=yes');
}
/**
 * print status
 */
function printStatus()
{
    window.open('<?php echo $this->createUrl('printStatus',array('pendaftaran_id'=>$model->pendaftaran_id)); ?>','printwin','left=100,top=100,width=860,height=480,scrollbars=yes');
}
/**
 * print surat mcu
 */
function printSuratMcu()
{
    window.open('<?php echo $this->createUrl('printSuratMcu',array('pendaftaran_id'=>$model->pendaftaran_id,'pasiendirujukeluar_id'=>$modRujukanKeluar->pasiendirujukkeluar_id)); ?>','printwin','left=100,top=100,width=860,height=480,scrollbars=yes');
}
/**
 * print karcis
 */
function printKarcis()
{
    window.open('<?php echo $this->createUrl('printKarcis',array('pendaftaran_id'=>$model->pendaftaran_id)); ?>','printwin','left=100,top=100,width=480,height=640,scrollbars=yes');
}

function autoPrint(){
    setTimeout(function(){window.scrollBy(0,768);},1000);
    <?php if(Yii::app()->user->getState('printkartulsng')==TRUE){ ?>
        printKartuPasien()
    <?php  } ?>
    <?php if(Yii::app()->user->getState('printkunjunganlsng')==TRUE){ ?>
        printSuratMcu();
    <?php  } ?>
}

function printSEP(){
  window.open('<?php echo $this->createUrl('printSep',array('sep_id'=>$modSep->sep_id,'pendaftaran_id'=>$model->pendaftaran_id)); ?>','printwin','left=100,top=100,width=860,height=480,srollbars=yes');
}

/**
 * fungsi BPJS
 */
function getAsuransiNoKartu(isi)
{   
    if (<?php echo (Yii::app()->user->getState('isbridging')==TRUE)?1:0; ?>) {}else{myAlert('Fitur Bridging tidak aktif!'); return false;}
    if (isi=="") {myAlert('Isi data terlebih dahulu!'); return false;};
    var aksi = 1; // 1 untuk mencari data peserta berdasarkan Nomor Kartu
    var setting = {
        url : "<?php echo $this->createUrl('bpjsInterface'); ?>",
        type : 'GET',
        dataType : 'html',
        data : 'param='+ aksi + '&query=' + isi,
        beforeSend: function(){
            $("#content-bpjs").addClass("animation-loading");
        },
        success: function(data){
            $("#content-bpjs").removeClass("animation-loading");
            var obj = JSON.parse(data);
            if(obj.response!=null){
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
            }else{
              myAlert(obj.metaData.message);
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

function getRujukanNoRujukan(isi)
{   
    if (<?php echo (Yii::app()->user->getState('isbridging')==TRUE)?1:0; ?>) {}else{myAlert('Fitur Bridging tidak aktif!'); return false;}
    if (isi=="") {myAlert('Isi data terlebih dahulu!'); return false;};
    var aksi = 3; // 3 untuk mencari data rujukan berdasarkan Nomor rujukan
    var setting = {
        url : "<?php echo $this->createUrl('bpjsInterface'); ?>",
        type : 'GET',
        dataType : 'html',
        data : 'param='+ aksi + '&query=' + isi,
        beforeSend: function(){
            $("#content-bpjs").addClass("animation-loading");
        },
        success: function(data){
            $("#content-bpjs").removeClass("animation-loading");
            var obj = JSON.parse(data);
            if(obj.response!=null){
              var rujukan = obj.response.item;
              var noKunjungan = rujukan.noKunjungan;
              var tglKunjungan = rujukan.tglKunjungan;
              var peserta = rujukan.peserta;    //array
              var provKunjungan = rujukan.provKunjungan;    //array
              var keluhan = rujukan.keluhan;
              var diagnosa = rujukan.diagnosa;    //array
              var catatan = rujukan.catatan;
              var pemFisikLain = rujukan.pemFisikLain;
              var provRujukan = rujukan.provRujukan;    //array
              var poliRujukan = rujukan.poliRujukan;    //array
              $("#<?php echo CHtml::activeId($modRujukanBpjs,'no_rujukan') ?>").val(noKunjungan);
              $("#<?php echo CHtml::activeId($modRujukanBpjs,'nama_perujuk') ?>").val(provRujukan.nmProvider);
              $("#<?php echo CHtml::activeId($modRujukanBpjs,'tanggal_rujukan') ?>").val(tglKunjungan);
              setDiagnosa(diagnosa.kdDiag,diagnosa.nmDiag);
            }else{
              myAlert(obj.metaData.message);
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
        url : "<?php echo $this->createUrl('bpjsInterface'); ?>",
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
            "MCAsuransipasienM[pasien_id]":pasien_id,
            "MCAsuransipasienM[penjamin_id]":penjamin_id,
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
            "MCAsuransipasienbpjsM[pasien_id]":pasien_id,
            "MCAsuransipasienbpjsM[penjamin_id]":penjamin_id,
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

/**
 * Function Pemeriksaan MCU
*/
/**
 * Centang pemeriksaan lab dari checkboxlist
 */
function pilihPemeriksaanIni(obj){
    var paketpelayanan_id = $(obj).val();
    var namatindakan = $(obj).parent().find('input[name$="[namatindakan]"]').val();
    var daftartindakan_id = $(obj).parent().find('input[name$="[daftartindakan_id]"]').val();
    var tipepaket_id = $(obj).parent().find('input[name$="[tipepaket_id]"]').val();
    var ruangan_id = $(obj).parent().find('input[name$="[ruangan_id]"]').val();
    var tarifpaketpel = $(obj).parent().find('input[name$="[tarifpaketpel]"]').val();
    var rowtindakan = [];
    rowtindakan = '<?php echo CJSON::encode($this->renderPartial($this->path_view_mcu.'_rowTindakanPemeriksaanMcu',array('i'=>0,'modPermintaanMcu'=>$modPermintaanMcu),true));?>';
    if($(obj).is(':checked')){
        $("#form-tindakanpemeriksaan").find('tbody').append(rowtindakan);
        $("#form-tindakanpemeriksaan").find('input[name$="[ii][tindakanpelayanan_id]"]').val("");
        $("#form-tindakanpemeriksaan").find('input[name$="[ii][paketpelayanan_id]"]').val(paketpelayanan_id);
        $("#form-tindakanpemeriksaan").find('input[name$="[ii][daftartindakan_id]"]').val(daftartindakan_id);
        $("#form-tindakanpemeriksaan").find('input[name$="[ii][tipepaket_id]"]').val(tipepaket_id);$("#form-tindakanpemeriksaan").find('span[name$="[ii][namatindakan]"]').html(namatindakan);
        $("#form-tindakanpemeriksaan").find('input[name$="[ii][satuantindakan]"]').val("<?php echo Params::SATUAN_TINDAKAN_LABORATORIUM; ?>");
        $("#form-tindakanpemeriksaan").find('input[name$="[ii][ruangantujuan_id]"]').val(ruangan_id);
        $("#form-tindakanpemeriksaan").find('input[name$="[ii][qty_tindakan]"]').val(1);
        $("#form-tindakanpemeriksaan").find('input[name$="[ii][tarif_satuan]"]').val(tarifpaketpel);
        $("#form-tindakanpemeriksaan").find('input[name$="[ii][tarif_tindakan]"]').val(formatInteger(tarifpaketpel));
        $("#form-tindakanpemeriksaan").find('a').tooltip({"placement":"<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
		$("#form-tindakanpemeriksaan input[name*='[i]']").each(function(){ //element <input>
            var old_name = $(this).attr("name").replace(/]/g,"");
            var old_name_arr = old_name.split("[");
            if(old_name_arr.length == 4){
                $(this).attr("id",old_name_arr[0]+"_"+ruangan_id+"_"+old_name_arr[2]+"_"+old_name_arr[3]);
                $(this).attr("name",old_name_arr[0]+"["+ruangan_id+"]["+old_name_arr[2]+"]["+old_name_arr[3]+"]");
            }
        });
    }else{
        var delete_row = $("#form-tindakanpemeriksaan").find('input[name$="[paketpelayanan_id]"][value="'+paketpelayanan_id+'"]').parents('tr');
        delete_row.detach();
    }
    renameInputRow($("#form-tindakanpemeriksaan"));
}

/**
 * Centang pemeriksaan tindakan diluar paket checkboxlist
 */
function pilihPemeriksaanDiluarPaket(obj){
    var daftartindakan_id = $(obj).val();
    var daftartindakan_nama = $(obj).parent().find('input[name$="[daftartindakan_nama]"]').val();
    var daftartindakan_id = $(obj).parent().find('input[name$="[daftartindakan_id]"]').val();
    var tipepaket_id = $(obj).parent().find('input[name$="[tipepaket_id]"]').val();
    var ruangan_id = $(obj).parent().find('input[name$="[ruangan_id]"]').val();
    var tarifpaketpel = $(obj).parent().find('input[name$="[harga_tariftindakan]"]').val();
    var rowtindakan = [];
    rowtindakan = '<?php echo CJSON::encode($this->renderPartial($this->path_view_mcu.'_rowTindakanPemeriksaanMcuDiluarPaket',array('i'=>0,'modTindakan'=>$modTindakan),true));?>';
    if($(obj).is(':checked')){
        $("#form-tindakanpemeriksaan-diluar-paket").find('tbody').append(rowtindakan);
        $("#form-tindakanpemeriksaan-diluar-paket").find('input[name$="[ii][tindakanpelayanan_id]"]').val("");
        $("#form-tindakanpemeriksaan-diluar-paket").find('input[name$="[ii][daftartindakan_id]"]').val(daftartindakan_id);
        $("#form-tindakanpemeriksaan-diluar-paket").find('input[name$="[ii][tipepaket_id]"]').val(tipepaket_id);$("#form-tindakanpemeriksaan-diluar-paket").find('span[name$="[ii][namatindakan]"]').html(daftartindakan_nama);
        $("#form-tindakanpemeriksaan-diluar-paket").find('input[name$="[ii][ruangan_id]"]').val(ruangan_id);
        $("#form-tindakanpemeriksaan-diluar-paket").find('input[name$="[ii][satuantindakan]"]').val("<?php echo Params::SATUAN_TINDAKAN_LABORATORIUM; ?>");
        $("#form-tindakanpemeriksaan-diluar-paket").find('input[name$="[ii][ruangantujuan_id]"]').val(ruangan_id);
        $("#form-tindakanpemeriksaan-diluar-paket").find('input[name$="[ii][qty_tindakan]"]').val(1);
        $("#form-tindakanpemeriksaan-diluar-paket").find('input[name$="[ii][tarif_satuan]"]').val(tarifpaketpel);
        $("#form-tindakanpemeriksaan-diluar-paket").find('input[name$="[ii][tarif_tindakan]"]').val(formatInteger(tarifpaketpel));
        $("#form-tindakanpemeriksaan-diluar-paket").find('a').tooltip({"placement":"<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
		$("#form-tindakanpemeriksaan-diluar-paket input[name*='[i]']").each(function(){ //element <input>
            var old_name = $(this).attr("name").replace(/]/g,"");
            var old_name_arr = old_name.split("[");
            if(old_name_arr.length == 4){
                $(this).attr("id",old_name_arr[0]+"_"+ruangan_id+"_"+old_name_arr[2]+"_"+old_name_arr[3]);
                $(this).attr("name",old_name_arr[0]+"["+ruangan_id+"]["+old_name_arr[2]+"]["+old_name_arr[3]+"]");
            }
        });
    }else{
        var delete_row = $("#form-tindakanpemeriksaan-diluar-paket").find('input[name$="[daftartindakan_id]"][value="'+daftartindakan_id+'"]').parents('tr');
        delete_row.detach();
    }
    renameInputRow($("#form-tindakanpemeriksaan-diluar-paket"));
}

/**
 * update (refresh) checklist tindakan mcu
 * harus include /js/jquery.tiler.js
 * @param {obj} form_checklist
 */
function updateChecklistTindakanMcu(){
    $('#content-pemeriksaan-lab .checklists').addClass("animation-loading");
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('/mcu/pendaftaranPasien/SetChecklistTindakanMcu'); ?>',
        data: {data:$("#form-caripemeriksaan :input").serialize()},
        dataType: "json",
        success:function(data){
            $('#content-pemeriksaan-mcu-paket .checklists').html(data.content);
            $('.checkboxlist-tile').tile({widths : [ 256 ]});
            $('#content-pemeriksaan-mcu-paket .checklists').removeClass("animation-loading");
            setCheckedPemeriksaan($("#form-tindakanpemeriksaan"));
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}

/**
 * update (refresh) checklist tindakan mcu diluar paket
 * harus include /js/jquery.tiler.js
 * @param {obj} form_checklist
 */
function updateChecklistTindakanMcuDiluarPaket(){
    $('#content-pemeriksaan-mcu-diluar-paket .checklists-mcu-diluar-paket').addClass("animation-loading");
	var ruangan_id = $('#<?php echo CHtml::activeId($model,'ruangan_id'); ?>').val();
	var kelaspelayanan_id = $('#<?php echo CHtml::activeId($model,'kelaspelayanan_id'); ?>').val();
	var tipepaket_id = '<?php echo Params::TIPEPAKET_ID_NONPAKET; ?>';
	var penjamin_id = $('#<?php echo CHtml::activeId($model,'penjamin_id'); ?>').val();
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('/mcu/pendaftaranPasien/SetChecklistTindakanMcuDiluarPaket'); ?>',
        data: {data:$("#form-caripemeriksaan-diluar-paket :input").serialize(),ruangan_id:ruangan_id,kelaspelayanan_id:kelaspelayanan_id,penjamin_id:penjamin_id,tipepaket_id:tipepaket_id},
        dataType: "json",
        success:function(data){
            $('#content-pemeriksaan-mcu-diluar-paket .checklists-mcu-diluar-paket').html(data.content);
            $('.checkboxlist-tile-diluar-paket').tile({widths : [ 256 ]});
            $('#content-pemeriksaan-mcu-diluar-paket .checklists-mcu-diluar-paket').removeClass("animation-loading");
            setCheckedPemeriksaanDiluarPaket($("#form-tindakanpemeriksaan-diluar-paket"));
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}
/**
 * set checked pemeriksaan yang sudah ada di daftar
 */
function setCheckedPemeriksaan(obj_table){
    $("div.checklists").find('input[name$="[is_pilih]"]').removeAttr('checked');
    $(obj_table).find('input[name$="[paketpelayanan_id]"]').each(function(){
        var paketpelayanan_id = $(this).val();
        $("div.checklists").find('input[name$="[is_pilih]"][value='+paketpelayanan_id+']').attr('checked',true);
    });
    
}
/**
 * set checked pemeriksaan yang sudah ada di daftar
 */
function setCheckedPemeriksaanDiluarPaket(obj_table){
    $("div.checklists-mcu-diluar-paket").find('input[name$="[is_pilih]"]').removeAttr('checked');
    $(obj_table).find('input[name$="[daftartindakan_id]"]').each(function(){
        var daftartindakan_id = $(this).val();
        $("div.checklists-mcu-diluar-paket").find('input[name$="[is_pilih]"][value='+daftartindakan_id+']').attr('checked',true);
    });
    
}
/**
 * Set checklist tindakan mcu
 */
function setChecklistTindakanMcu(){
    var penjamin_id = $("#penjamin_id").val();
    var ruangan_id = $("#<?php echo CHtml::activeId($modPasienMasukPenunjang,'ruangan_id') ?>").val();
    var kelaspelayanan_id = $("#<?php echo CHtml::activeId($modPasienMasukPenunjang,'kelaspelayanan_id') ?>").val();
    if(penjamin_id == "" && kelaspelayanan_id==""){
        myAlert("Silakan pilih data rujukan!");
        setChecklistPemeriksaanLabReset();
    }else{
        $("#form-caripemeriksaan").find("input[name$='[ruangan_id]']").val(ruangan_id);
        $("#form-caripemeriksaan").find("input[name$='[penjamin_id]']").val(penjamin_id);
        $("#form-caripemeriksaan").find("input[name$='[kelaspelayanan_id]']").val(kelaspelayanan_id);
        updateChecklistTindakanMcu();
    }
}
function setChecklistTindakanMcuDiluarPaket(){
    var penjamin_id = $("#penjamin_id").val();
    var ruangan_id = $("#<?php echo CHtml::activeId($modPasienMasukPenunjang,'ruangan_id') ?>").val();
    var kelaspelayanan_id = $("#<?php echo CHtml::activeId($modPasienMasukPenunjang,'kelaspelayanan_id') ?>").val();
    if(penjamin_id == "" && kelaspelayanan_id==""){
        myAlert("Silakan pilih data rujukan!");
        setChecklistPemeriksaanLabReset();
    }else{
        $("#form-caripemeriksaan-diluar-paket").find("input[name$='[ruangan_id]']").val(ruangan_id);
        $("#form-caripemeriksaan-diluar-paket").find("input[name$='[penjamin_id]']").val(penjamin_id);
        $("#form-caripemeriksaan-diluar-paket").find("input[name$='[kelaspelayanan_id]']").val(kelaspelayanan_id);
        updateChecklistTindakanMcuDiluarPaket();
    }
}
/**
 * reset pencarian & checklist tindakan mcu
 */
function setChecklistTindakanMcuReset(){
    $("#form-caripemeriksaan").find("input:not(:disabled):not([readonly])").each(function(){
        $(this).val("");
    });
    updateChecklistTindakanMcu();
}
/**
 * reset pencarian & checklist tindakan mcu diluar paket
 */
function setChecklistTindakanMcuDiluarPaketReset(){
    $("#form-caripemeriksaan-diluar-paket").find("input:not(:disabled):not([readonly])").each(function(){
        $(this).val("");
    });
    updateChecklistTindakanMcuDiluarPaket();
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
 * 
 * @param {int} tipepaket_id
*/
function pilihPemeriksaanSemua(obj){
	if($(obj).is(':checked')){
		$(obj).parents('.boxtindakan').find("input[name*='is_pilih']").each(function(){
			$(this).attr('checked',true);
			pilihPemeriksaanIni(this);
		});
    }else{
		$(obj).parents('.boxtindakan').find("input[name*='is_pilih']").each(function(){
			$(this).attr('checked',false);
			pilihPemeriksaanIni(this);
		});
    }
}

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
 * set nilai umur dari tglberlakusurat 
 * @param {type} tglberlakusurat
 * @returns {undefined} */
function setTglAkhir(tglberlakusurat)
{
    $.ajax({
       type:'POST',
       url:'<?php echo $this->createUrl('SetTglAkhir'); ?>',
       data: {tglberlakusurat : tglberlakusurat},//
       dataType: "json",
       success:function(data){
           $("#<?php echo CHtml::activeId($modRujukanKeluar,"tglberlakusurat");?>").val(tglberlakusurat);
           $("#<?php echo CHtml::activeId($modRujukanKeluar,"sampaidengan");?>").val(data.tglAkhir);
       },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}

function setPegawaiReset(){ 
        <?php
        $modPegawai = new MCPegawaiM ?>
	$("#<?php echo CHtml::activeId($modPasien,'pegawai_id')?>").val("");
	$("#<?php echo CHtml::activeId($modPegawai,'nomorindukpegawai')?>").val("");
	$("#<?php echo CHtml::activeId($modPegawai,'nama_pegawai')?>").val("");
	$("#<?php echo CHtml::activeId($modPegawai,'gelardepan')?>").val("");
	$("#<?php echo CHtml::activeId($modPegawai,'gelarbelakang_nama')?>").val("");
	$("#<?php echo CHtml::activeId($modPegawai,'unit_perusahaan')?>").val("");
	$("#<?php echo CHtml::activeId($modPegawai,'jabatan_nama')?>").val("");
}
function resetFormPegawai(){
	$('#MCPasienM_pegawai_id').val('');
	$('#MCPegawaiM_nomorindukpegawai').val('');
	$('#MCPegawaiM_nama_pegawai').val('');
	$('#MCPegawaiM_unit_perusahaan').val('');
	$('#MCPegawaiM_jabatan_nama').val('');
}

/**
 * javascript yang di running setelah halaman ready / load sempurna
 * posisi script ini harus tetap dibawah
 */
$(document).ready(function(){
	updateChecklistTindakanMcu();
	updateChecklistTindakanMcuDiluarPaket();
    setUmur($("#<?php echo CHtml::activeId($modPasien, 'tanggal_lahir') ;?>").val());
	setTglAkhir($("#<?php echo CHtml::activeId($modRujukanKeluar, 'tglberlakusurat') ;?>").val())
    <?php if(!empty($model->pendaftaran_id)){ ?>
        autoPrint();
        $("input, select, textarea").attr("disabled",true);
        $("#btn-panggilantrian").parent().parent().hide();
        $(".add-on").hide();
    <?php } ?> 
         cekDisabled($('#mcpendaftaran-t-form'));
});
</script>
    