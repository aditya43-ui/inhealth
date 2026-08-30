<?php
//======================================================JAVA SCRIPT===================================================                          
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$url=  Yii::app()->createAbsoluteUrl($module.'/'.$controller);
$urlPrintLembarPoli = Yii::app()->createUrl('pendaftaranPenjadwalan/pendaftaranRawatJalan/printStatus',array('pendaftaran_id'=>''));
$urlPrintKartuPasien = Yii::app()->createUrl('print/kartuPasien',array('pendaftaran_id'=>''));
$urlListDokterRuangan = $this->createUrl('listDokterRuangan');
$urlGetRuangan=$this->createUrl('GetRuanganPasien'); 
$simpanRuanganBaru=$this->createUrl('SaveRuanganBaru'); 
$statusPeriksaBatalPeriksa=Params::STATUSPERIKSA_BATAL_PERIKSA;
//inisialisasi model untuk selector elemen (js) harus sama dengan yang ada di actionUbahcaraBayar
$model = new RKUbahcarabayarR();
$modPendaftaran = new RKPendaftaranT();
$modAsuransiPasien = new RKAsuransipasienM();
?>

<script type="text/javascript">

/**
 * set form dan submit ubah carabayar
 * @param {type} pendaftaran_id
 * @returns {undefined}
 */
function ubahCaraBayar(pendaftaran_id,submit=0)
{   
	var data = [];
	if(submit == 1){
		var valid = requiredCheck("#formubahcarabayar");
		if(valid == false){
			myAlert("Silakan isi yang bertanda * !");
			return false;
		}
		$("#formubahcarabayar").addClass("animation-loading");
		data = $("#formubahcarabayar input,textarea,select").serialize();
	}
    jQuery.ajax({'url':'<?php echo $this->createUrl('ubahCaraBayar')?>&pendaftaran_id='+pendaftaran_id,
                 'data':data,
                 'type':'post',
                 'dataType':'json',
                 'success':function(data) {
							$('#carabayardialog div.divForFormUbahCaraBayar').html(data.form);
                            if (data.sukses == 0) {
								setFormAsuransiPasien();
								$('#titleNamaPasienCaraBayar').html(data.nama_pasien);
                            }
							if(data.pesan.length > 0){
								myAlert(data.pesan);
								$.fn.yiiGridView.update('rminfo-pasien-v-grid', {
									data: $(this).serialize()
								});
								setTimeout("$('#carabayardialog').dialog('close') ",500);
							}
							
							$("#formubahcarabayar").removeClass("animation-loading");
                 } ,
                 'cache':false});
    return false; 
}
/**
 * dropdown penjamin dinamis
 */
function setDropdownPenjamin(){
	var carabayar_id = $("#<?php echo CHtml::activeId($modPendaftaran, "carabayar_id"); ?>").val();
	var pendaftaran_id = $("#<?php echo CHtml::activeId($model, "pendaftaran_id"); ?>").val();
	$.ajax({'url':'<?php echo $this->createUrl('SetDropdownPenjamin')?>',
		'data':{carabayar_id:carabayar_id, pendaftaran_id:pendaftaran_id},
		'type':'post',
		'dataType':'json',
		'success':function(data) {
					$("#<?php echo CHtml::activeId($modPendaftaran, "penjamin_id"); ?>").html(data.listPenjamin);
					setFormAsuransiPasien();
				},
		'cache':false});
    return false; 
}
/**
 * dropdown penjamin dinamis
 */
function setFormAsuransiPasien(){
	$("#formasuransipasien").addClass("animation-loading");
	var carabayar_id = $("#<?php echo CHtml::activeId($modPendaftaran, "carabayar_id"); ?>").val();
	var penjamin_id = $("#<?php echo CHtml::activeId($modPendaftaran, "penjamin_id"); ?>").val();
	var pendaftaran_id = $("#<?php echo CHtml::activeId($model, "pendaftaran_id"); ?>").val();
	$.ajax({'url':'<?php echo $this->createUrl('SetFormAsuransiPasien')?>',
		'data':{penjamin_id:penjamin_id, pendaftaran_id:pendaftaran_id},
		'type':'post',
		'dataType':'json',
		'success':function(data) {
					$("#formasuransipasien").html(data.form);
					$("#formasuransipasien .datetimemask").mask("99/99/9999 99:99:99");
					if(data.asuransipasien_id.length > 0 || carabayar_id != "<?php echo Params::CARABAYAR_ID_MEMBAYAR?>"){
						$("#formasuransipasien").show();
						$("#formasuransipasien .not-required").addClass("required");
						$("#formasuransipasien .not-required").removeClass("not-required");
					}else{
						$("#formasuransipasien").hide();
						$("#formasuransipasien .required").addClass("not-required");
						$("#formasuransipasien .required").removeClass("required");
					}
					$("#formasuransipasien").removeClass("animation-loading");
				},
		'cache':false});
    return false; 
}
/**
 * menentukan nilai default tgl_konfirmasi
 */
function defaultTanggalKonfirmasi(){
	var status_konfirmasi = $("#<?php echo CHtml::activeId($modAsuransiPasien, "status_konfirmasi"); ?>");
	var tglubahcarabayar = $("#<?php echo CHtml::activeId($model, "tglubahcarabayar"); ?>").val();
	var dateserver = '';
	if(status_konfirmasi.is(":checked")){
		var dateserver = tglubahcarabayar;
	}
	$("#<?php echo CHtml::activeId($modAsuransiPasien, "tgl_konfirmasi"); ?>").val(dateserver);
}

function print(pendaftaran_id)
{
   window.open('<?php echo $urlPrintLembarPoli?>'+pendaftaran_id,'printwin','left=100,top=100,width=400,height=400');    
}
//========================================Akhir Print Lembar Poli========================================================

//========================================Awal Ganti Ruangan=============================================================

function gantiPoli(pendaftaran_id,ruangan_id,instalasi_id,pasien_id,namaPasien)
    {
        $('#titleNamaPasien').html(namaPasien);
           $.post("<?php echo $urlGetRuangan; ?>", { pendaftaran_id: pendaftaran_id, ruangan_id: ruangan_id, instalasi_id:instalasi_id, pasien_id:pasien_id},
           function(data){
            $('#ganti_poli').dialog('open');
            $('#ganti_poli #ruangan_awal').val(ruangan_id);
            $('#ganti_poli #ruangan_sebelumnya').html(data.dropDown);
            $('#ganti_poli #ruangan_id_ganti').html(data.dropDown);
            $('#ganti_poli #pendaftaran_id').val(pendaftaran_id);
            $('#ganti_poli #pasien_id').val(pasien_id);
        }, "json");
    }
    
 function simpanRuanganBaru()
    {
        if($('#ganti_poli #alasanperubahan').val()==''){
           myAlert('Alasan Perubahan tidak boleh kosong!');
           $('#ganti_poli #alasanperubahan').addClass('error');
           return false;
        }
        $('#ganti_poli').dialog('close');
        var pendaftaran_id= $('#ganti_poli #pendaftaran_id').val();
        var pasien_id= $('#ganti_poli #pasien_id').val();
        var ruangan_id= $('#ganti_poli #ruangan_id_ganti').val();
        var ruangan_awal= $('#ganti_poli #ruangan_awal').val();
        var alasan = $('#ganti_poli #alasanperubahan').val();
        $.post("<?php echo $simpanRuanganBaru; ?>", { pendaftaran_id: pendaftaran_id, ruangan_id: ruangan_id, ruangan_awal: ruangan_awal, alasan:alasan, pasien_id:pasien_id},
            function(data){
                if(data.status=='Gagal')
                    myAlert(data.status);
                $.fn.yiiGridView.update('PPInfoKunjungan-v', {
                            data: $('#formCari').serialize()
                });
            }, "json");
    }
//========================================Akhir Ganti Ruangan===========================================================

$('.numberOnly').keyup(function() {
var d = $(this).attr('numeric');
var value = $(this).val();
var orignalValue = value;
value = value.replace(/[0-9]*/g, "");
var msg = "Only Integer Values allowed.";

if (d == 'decimal') {
value = value.replace(/\./, "");
msg = "Only Numeric Values allowed.";
}

if (value != '') {
orignalValue = orignalValue.replace(/([^0-9].*)/g, "")
$(this).val(orignalValue);
}
});
</script>
