<script type="text/javascript">
function setHari() {
    var tanggal = $('#PPJadwalhemodialisaT_jadwalhemodialisa_tgl_ke').val();

    jQuery.ajax({
        'url':'<?php echo Yii::app()->createUrl('pendaftaranPenjadwalan/pendaftaranRawatDaruratHD/konfersitanggal') ?>',
        'data':{tanggal: tanggal},
        'type':'post',
        'dataType':'json',
        'success':function(data) {
            $('#PPJadwalhemodialisaT_jadwalhemodialisa_hari').val(data.value);
        } ,
        'cache':false});

}

function updateKamarByKelasLantai(status) {
    <?php $url = $this->createUrl('GetKamarKosongByKelasLantai', array('encode' => false, 'namaModel' => 'PPPendaftaranT')); ?>
    var idRuangan = $('#<?php echo CHtml::activeId($model, 'ruangan_id') ?>').val();
    var kelaspelayanan_id = $('#<?php echo CHtml::activeId($model, 'kelaspelayanan_id') ?>').val();
    var lantai_hd = $('#<?php echo CHtml::activeId($model, 'lantai_hd') ?>').val();
    jQuery.ajax({'type':'POST',
        'url':'<?php echo $url ?>',
        'cache':false,
        'data':{ ruangan_id:idRuangan, kelaspelayanan_id:kelaspelayanan_id, lantai_hd:lantai_hd, is_status:status},
        'success':function(html){
            jQuery("#<?php echo CHtml::activeId($model, 'kamarruangan_id') ?>").html(html)
        }
    });
}
    
/** control accordion kecelakaan */
$('#form-kecelakaan > div > .accordion-heading').click(function(){
//    console.log("Kecelakaan Di Klik!");
    var is_pasienkecelakaan = $("#<?php echo CHtml::activeId($model, "is_pasienkecelakaan"); ?>");
    if(is_pasienkecelakaan.val() > 0){ //hide
        is_pasienkecelakaan.val(0);
    }else{//show
        is_pasienkecelakaan.val(1);
    }
});

function cekDokter(){
  var ruangan_id = $("#<?php echo CHtml::activeId($model,'ruangan_id') ?>").val();

  if(ruangan_id==""){
    myAlert('Silakan pilih ruangan terlebih dahulu!');
  }else{
    $.fn.yiiGridView.update('dokter-v-grid', {
        data: {
            "PegawaiV[ruangan_id]":ruangan_id,
            "PegawaiV[kelompokpegawai_id]":'<?php echo Params::KELOMPOKPEGAWAI_ID_DOKTER_TETAP; ?>',
        }
    });
    $("#dialogDokter").dialog('open');
  }
  return false;
}


$('#form-karcis > div > .accordion-heading').click(function() {
        //    console.log("Karcis Di Klik!");
        var is_adakarcis = $("#<?php echo CHtml::activeId($model, "is_adakarcis"); ?>");
        if (is_adakarcis.val() > 0) { //hide
            is_adakarcis.val(1); // dipaksakan ada meskipun accordion disembunyikan
        } else { //show
            is_adakarcis.val(1);
        }
    });


    function validasiBpjs(carabayarid, pasien_id) {
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('ValidasiBpjs'); ?>',
            data: {
                carabayar_id: carabayarid,
                pasien_id: pasien_id
            },
            dataType: "json",
            success: function(data) {
                if (data.message != "") {
                    $('#PPPendaftaranT_carabayar_id').val(null);
                    $('#PPPendaftaranT_penjamin_id').val(null);
                    // sembunyiFormBpjs()
                    $('#form-bpjs').hide()

                    myAlert(data.message);

                    return false;
                }
                // console.log(data)
                //$('#dialog-verifikasi > .dialog-content').html(data.content);
                // if (data.ok == 1){							
                // 	$('#dialog-verifikasi > .dialog-content').html(data.content);
                // }else{
                // 	$('#dialog-verifikasi > .dialog-content').html('');
                // 	$('#dialog-verifikasi').dialog("close");
                // 	alert(data.msg);
                // }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }
    
function cekPpjp(){
  var ruangan_id = $("#<?php echo CHtml::activeId($model,'ruangan_id') ?>").val();

  if(ruangan_id==""){
    myAlert('Silakan pilih ruangan terlebih dahulu!');
  }else{
    $.fn.yiiGridView.update('dokterPpjp-v-grid', {
        data: {
            "PegawaiV[ruangan_id]":ruangan_id,
            "PegawaiV[kelompokpegawai_id]":'<?php echo Params::KELOMPOKPEGAWAI_ID_TENAGA_KEPERAWATAN; ?>',
        }
    });
    $("#dialogPpjp").dialog('open');
  }
  return false;
}

function getRuanganPoliklinikPasien(){
	// Hanya digunakan di transaksi Pendaftaran Rawat Jalan
}

/**
 * print status rawat darurat dan karcis
 */ 
/**
 * set dropdown dokter ruangan
 * override setDropDownKelasPelayanan() di pendaftaranPenjadwalan/views/pendaftaranRawatInap/_jsFunctions.php
 * @param {type} ruangan_id
 * @param {type} pegawai_id
 * @returns {undefined}
 */
function setDropDownKelasPelayanan(ruangan_id)
{
    $.ajax({
       type:'POST',
       url:'<?php echo $this->createUrl('SetDropdownKelasPelayananRI'); ?>',
       data: {ruangan_id : ruangan_id},//
       dataType: "json",
       success:function(data){
           $("#<?php echo CHtml::activeId($model,"kelaspelayanan_id");?>").html(data.listKelas);
       },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
} 

function updateKamarRuangan(idKelas, status)
{
    <?php $url = $this->createUrl('GetKamarKosong',array('encode'=>false,'namaModel'=>'PPPendaftaranT')); ?>
    var idRuangan = $('#<?php echo CHtml::activeId($model,'ruangan_id') ?>').val();
    jQuery.ajax({'type':'POST',
        'url':'<?php echo $url ?>',
        'cache':false,
        'data':{ ruangan_id:idRuangan, kelaspelayanan_id:idKelas, is_status:status},
        'success':function(html){
            jQuery("#<?php echo CHtml::activeId($model,'kamarruangan_id') ?>").html(html)
        }
    });
} 
function printStatusRD()
{
    window.open('<?php echo $this->createUrl('printStatusRD',array('pendaftaran_id'=>$model->pendaftaran_id)); ?>','printwin','left=100,top=100,width=480,height=640');
    <?php if($model->carabayar_id == Params::CARABAYAR_ID_MEMBAYAR){ ?>
        window.open('<?php echo $this->createUrl('printKarcis',array('pendaftaran_id'=>$model->pendaftaran_id)); ?>','','left=600,top=100,width=480,height=640');
    <?php } ?>
}

function printStatus()
{
    window.open('<?php echo $this->createUrl('printStatus',array('pendaftaran_id'=>$model->pendaftaran_id)); ?>','printwin','left=100,top=100,width=860,height=480');
}
/**
 * print karcis
 */
function printKarcis()
{
    window.open('<?php echo $this->createUrl('pendaftaranRawatJalan/printKarcis',array('pendaftaran_id'=>$model->pendaftaran_id)); ?>','printwin','left=100,top=100,width=480,height=640');
}
/**
* print etiket pasien RD
*/
function printEtiketPasienRD()
{
	$("#print_win").attr('src', "<?php echo $this->createUrl('pendaftaranRawatDarurat/printEtiketPasienRD', array('pasien_id' => $model->pasien_id, 'pendaftaran_id' => $model->pendaftaran_id)); ?>");
} 

function printIdentitasPasienRD()
{
	$("#print_win").attr('src', "<?php echo $this->createUrl('pendaftaranRawatDaruratHD/printIdentitasPasienRD', array('pasien_id' => $model->pasien_id, 'pendaftaran_id' => $model->pendaftaran_id)); ?>");
} 

function printLembarResep()
	{
//		window.open('<?php // echo $this->createUrl('printLembarResep', array('pasien_id'=>$model->pasien_id,'pendaftaran_id' => $model->pendaftaran_id)); ?>', 'printwin', 'left=100,top=100,width=860,height=480');
		window.open('<?php echo $this->createUrl('printLembarResep', array('pasien_id'=>$model->pasien_id,'pendaftaran_id' => $model->pendaftaran_id)); ?>', '', 'location=_new, width=1000px');
	}

/**
 * override function yang di pendaftaranRawatJalan
 */
//function autoPrint(){
//    printStatusRD();   
//      printLembarResep();
//}

/**
 * menampilkan form verifikasi
 * @returns {undefined}
 */
function setVerifikasi(){
    if(requiredCheck($(".form_pendaftaran"))){
		//	LNG-1578 untuk notif pemberitahuan sbelum simpan, jika pasien yang sudah terdaftar.	
		//	NIK : 201410001 
		var pasien_id  = $('#<?php echo CHtml::activeId($modPasien, 'pasien_id') ?>').val();
		var nama_pasien  = $('#<?php echo CHtml::activeId($modPasien, 'nama_pasien') ?>').val();
		
		$('#table-pasienterakhir').find("tbody > tr").each(function(){
			row_pasienid = $(this).find(".pasien_id").val();
			if(row_pasienid === pasien_id){
				myAlert('Pasien '+nama_pasien+' Sudah Terdaftar');
			}
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
            // $(this).val(formatFloat($(this).val()));
        });
        $(".form_pendaftaran").find('.integer').each(function(){
            console.log('destroy mask money nih');
            $(this).maskMoney('destroy');
        });
    }

    if($('#PPPasienM_jeniskelamin_0').is(':checked') == false && $('#PPPasienM_jeniskelamin_1').is(':checked') == false) {


setTimeout(function(){
    alert('Silahkan memilih jenis kelamin pasien');
}, 1500);

} 
    // x = $('input:radio[name="PPPasienM[jeniskelamin]"]:checked').val();
    // if(x!=undefined){
    //     $('#jenkel').removeClass("error");
    // }else{
    //     $('#jenkel').addClass("error");
    // }
    return false;
} 

function setAntrianRuangan() {
		var ruangan_id = $("#<?php echo CHtml::activeId($model, 'ruangan_id') ?>").val(); 
		var pegawai_id = $("#<?php echo CHtml::activeId($model, 'pegawai_id') ?>").val();
		$.ajax({
			type: 'POST',
			url: '<?php echo $this->createUrl('pendaftaranRawatDaruratHD/SetAntrianRuangan'); ?>',
		    data: {ruangan_id: ruangan_id, pegawai_id:pegawai_id},
			dataType: "json",
			success: function (data) {
				if (data.maxantrianruangan != null) {
					if (data.no_urutantri > data.maxantrianruangan) {
						myAlert("Pasien Sudah Mencapai Maksimal Antrian Poliklinik " + data.maxantrianruangan + " Pasien");
						$("#<?php echo CHtml::activeId($model, 'ruangan_id'); ?>").val("");
					}
					$('#max-antrian-ruangan').val(data.maxantrianruangan);
				} else {
					$('#max-antrian-ruangan').val(0);
				}
			},
			error: function (jqXHR, textStatus, errorThrown) {
				console.log(errorThrown);
			}
		});
	}

$(document).ready(function () {
		setHari();
/* Ini ketika pendaftaran HD dari informasi Jadwal HD */
<?php if(isset($_GET['jadwalhemodialisa_id']) && !empty($_GET['jadwalhemodialisa_id'])){ ?>
        setDropDownKelasPelayanan(<?php echo $model->ruangan_id;?>);
<?php } ?>
/*--*/

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

</script>
    