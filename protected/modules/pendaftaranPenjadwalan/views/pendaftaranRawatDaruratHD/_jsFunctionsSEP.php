<script type="text/javascript">
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
function clearRujukanBpjs()
{
    $('#<?php echo CHtml::activeId($modRujukanBpjs, 'rujukandari_id')?>').find('option').remove().end().append('<option value="">-- Pilih --</option>').val('');
    $('#<?php echo CHtml::activeId($modRujukanBpjs, 'nama_perujuk')?>').val('');
}
/**
 * set otomatis nama_perujuk dari dropdown rujukandari_id untuk BPJS
 * @returns {Boolean}
 */
function setNamaPerujukBpjs(){
    var rujukandari_id = $("#<?php echo CHtml::activeId($modRujukanBpjs, 'rujukandari_id')?>").val();
    var nama_perujuk = $("#<?php echo CHtml::activeId($modRujukanBpjs, 'rujukandari_id')?>").find('option[value="'+rujukandari_id+'"]').text();
    $("#<?php echo CHtml::activeId($modRujukanBpjs, 'nama_perujuk')?>").val(nama_perujuk);
	getAsalRujukanDari(null,rujukandari_id);
}

function setNamaPerujuk(){
    var rujukandari_id = $("#<?php echo CHtml::activeId($modRujukan, 'rujukandari_id')?>").val();
    var nama_perujuk = $("#<?php echo CHtml::activeId($modRujukan, 'rujukandari_id')?>").find('option[value="'+rujukandari_id+'"]').text();
    $("#<?php echo CHtml::activeId($modRujukan, 'nama_perujuk')?>").val(nama_perujuk);
	
	getAsalRujukanDari(null,rujukandari_id);
}

<?php if(Yii::app()->user->getState('isbridging')==TRUE){ ?>
/**
 * set form asuransi 
 * @returns {undefined} */
function setFormAsuransi(carabayar_id){
    var carabayar_id_umum = <?php echo Params::CARABAYAR_ID_MEMBAYAR;?>;
    var carabayar_id_bpjs = <?php echo Params::CARABAYAR_ID_BPJS;?>;
	
	var no_rekam_medik = $("#cari_no_rekam_medik").val();
    if(carabayar_id == carabayar_id_umum){		
        sembunyiFormAsuransi();
        sembunyiFormBpjs();

        $('#form-bpjs').hide(); 
        $('#form-asuransi').show(); 
        $('#form-rujukan').show();
    }else if(carabayar_id == carabayar_id_bpjs){
		if(no_rekam_medik != ''){
			tampilFormBpjs();
			sembunyiFormAsuransi();
			sembunyiFormRujukan();

			$('#form-asuransi').hide();
			$('#form-bpjs').show(); 
			$('#form-rujukan').hide(); 
		}else{
			sembunyiFormBpjs();
			sembunyiFormAsuransi();
			sembunyiFormRujukan();

			$('#form-asuransi').hide();
			$('#form-bpjs').hide(); 
			$('#form-rujukan').hide(); 
		}		
    }else{
        tampilFormAsuransi();
        sembunyiFormBpjs();
        $('#form-bpjs').hide(); 
        $('#form-asuransi').show(); 
        $('#form-rujukan').show();
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
function sembunyiFormAsuBadak(){
        $('#content-asubadak').find(".required").addClass("not-required").removeClass("required");
        $('#form-asubadak > .accordion-group > .accordion-heading').find(".btn").removeClass("btn-primary");
        $('#form-asubadak > .accordion-group > .accordion-heading').find(".icon-minus").addClass("icon-plus").removeClass("icon-minus");
        $('#content-asubadak').removeClass().addClass("accordion-body collapse");
        $('#content-asubadak').removeAttr("style").attr("style","height:0px");  
        $('#content-asubadak').find("input,select,textarea").attr("disabled",true); 
}
function tampilFormAsuBadak(){
        $('#form-asubadak > .accordion-group > .accordion-heading').find(".btn").addClass("btn-primary");
        $('#form-asubadak > .accordion-group > .accordion-heading').find(".icon-plus").addClass("icon-minus").removeClass("icon-plus");
        $('#content-asubadak').removeClass().addClass("accordion-body in collapse");
        $('#content-asubadak').find(".not-required").addClass("required").removeClass("not-required");
        $('#content-asubadak').removeAttr("style").attr("style","height:auto"); 
        $('#content-asubadak').find("input,select,textarea").removeAttr("disabled");
  
}
function sembunyiFormAsuDepartemen(){
        $('#content-asudepartemen').find(".required").addClass("not-required").removeClass("required");
        $('#form-asudepartemen > .accordion-group > .accordion-heading').find(".btn").removeClass("btn-primary");
        $('#form-asudepartemen > .accordion-group > .accordion-heading').find(".icon-minus").addClass("icon-plus").removeClass("icon-minus");
        $('#content-asudepartemen').removeClass().addClass("accordion-body collapse");
        $('#content-asudepartemen').removeAttr("style").attr("style","height:0px");  
        $('#content-asudepartemen').find("input,select,textarea").attr("disabled",true); 
}
function tampilFormAsuDepartemen(){
        $('#form-asudepartemen > .accordion-group > .accordion-heading').find(".btn").addClass("btn-primary");
        $('#form-asudepartemen > .accordion-group > .accordion-heading').find(".icon-plus").addClass("icon-minus").removeClass("icon-plus");
        $('#content-asudepartemen').removeClass().addClass("accordion-body in collapse");
        $('#content-asudepartemen').find(".not-required").addClass("required").removeClass("not-required");
        $('#content-asudepartemen').removeAttr("style").attr("style","height:auto"); 
        $('#content-asudepartemen').find("input,select,textarea").removeAttr("disabled");
  
}
function sembunyiFormAsuPekerja(){
        $('#content-asupekerja').find(".required").addClass("not-required").removeClass("required");
        $('#form-asupekerja > .accordion-group > .accordion-heading').find(".btn").removeClass("btn-primary");
        $('#form-asupekerja > .accordion-group > .accordion-heading').find(".icon-minus").addClass("icon-plus").removeClass("icon-minus");
        $('#content-asupekerja').removeClass().addClass("accordion-body collapse");
        $('#content-asupekerja').removeAttr("style").attr("style","height:0px");  
        $('#content-asupekerja').find("input,select,textarea").attr("disabled",true); 
}
function tampilFormAsuPekerja(){
        $('#form-asupekerja > .accordion-group > .accordion-heading').find(".btn").addClass("btn-primary");
        $('#form-asupekerja > .accordion-group > .accordion-heading').find(".icon-plus").addClass("icon-minus").removeClass("icon-plus");
        $('#content-asupekerja').removeClass().addClass("accordion-body in collapse");
        $('#content-asupekerja').find(".not-required").addClass("required").removeClass("not-required");
        $('#content-asupekerja').removeAttr("style").attr("style","height:auto"); 
        $('#content-asupekerja').find("input,select,textarea").removeAttr("disabled");
  
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
        //$('#content-bpjs').find(".nosep").attr("disabled",false); 
        var is_bpjs = $("#<?php echo CHtml::activeId($model, "is_bpjs"); ?>");
        is_bpjs.val(1);
}
function sembunyiFormRujukan(){
        $('#content-rujukan').find(".required").addClass("not-required").removeClass("required");
        $('#form-rujukan > .accordion-group > .accordion-heading').find(".btn").removeClass("btn-primary");
        $('#form-rujukan > .accordion-group > .accordion-heading').find(".icon-minus").addClass("icon-plus").removeClass("icon-minus");
        $('#content-rujukan').removeClass().addClass("accordion-body collapse");
        $('#content-rujukan').removeAttr("style").attr("style","height:0px");  
        $('#content-rujukan').find("input,select,textarea").attr("disabled",true);
        var is_pasienrujukan = $("#<?php echo CHtml::activeId($model, "is_pasienrujukan"); ?>");
        is_pasienrujukan.val(0);
}
function tampilFormRujukan(){
        $('#form-rujukan > .accordion-group > .accordion-heading').find(".btn").addClass("btn-primary");
        $('#form-rujukan > .accordion-group > .accordion-heading').find(".icon-plus").addClass("icon-minus").removeClass("icon-plus");
        $('#content-rujukan').removeClass().addClass("accordion-body in collapse");
        $('#content-rujukan').find(".not-required").addClass("required").removeClass("not-required");
        $('#content-rujukan').removeAttr("style").attr("style","height:auto"); 
        $('#content-rujukan').find("input,select,textarea").removeAttr("disabled"); 
        var is_pasienrujukan = $("#<?php echo CHtml::activeId($model, "is_pasienrujukan"); ?>");
        is_pasienrujukan.val(0);
}

/**
 * simpan SEP
 * @returns {undefined}
 */
function simpanProsesSEP(){
    if(requiredCheck($("#ppsep-t-form"))){
		$("#ppsep-t-form").submit();
        $(".animation-loading").removeClass("animation-loading");
        $("#ppsep-t-form").find('.float').each(function(){
            $(this).val(formatFloat($(this).val()));
        });
        $("#ppsep-t-form").find('.integer').each(function(){
            $(this).val(formatInteger($(this).val()));
        });
    }
    return false;
}

function loadFormProsesSEP(obj){
	var url = $(obj).attr('href');
	$('#iframeProsesSEP').attr('src', url);
}
/**
* tombol batal pada dialogbox
* @param {type} dialog_id
* @returns {undefined} 
*/
function batalDialog(dialog_id){
   if(confirm("Apakah Anda yakin akan membatalkan ini ?")) 
		window.parent.$('#'+dialog_id).dialog("close");
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

function printSEP(){
	window.open('<?php echo $this->createUrl('pendaftaranRawatJalan/printSep',array('sep_id'=>$modSep->sep_id,'pendaftaran_id'=>$model->pendaftaran_id)); ?>','printwin','left=100,top=100,width=860,height=480');
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
        url : "<?php echo $this->createUrl('pendaftaranRawatJalan/bpjsInterface'); ?>",
        type : 'GET',
        dataType : 'html',
        data : 'param='+ aksi + '&query=' + isi,
        beforeSend: function(){
            $("#content-bpjs").addClass("animation-loading");
        },
        success: function(data){
            $("#content-bpjs").removeClass("animation-loading");
			var obj = JSON.parse(data);
				if(obj.metadata != null && obj.metadata.code == '201' || obj.metadata.code == '402' || obj.metadata.code == '401' || obj.metadata.code == '50000' && obj.response.peserta == null){
				   myAlert(obj.metadata.message);
				}else{
				  if (obj.response != null) {
					  var peserta = obj.response.peserta;
			//					if (peserta.statusPeserta.keterangan == 'AKTIF') {
						  $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs, 'nopeserta') ?>").val(peserta.noKartu);
						  $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs, 'nokartuasuransi') ?>").val(peserta.noKartu);
						  $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs, 'namapemilikasuransi') ?>").val(peserta.nama);
						  $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs, 'jenispeserta_id') ?>").val(peserta.jenisPeserta.kdJenisPeserta);
						  $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs, 'jenispeserta_nama') ?>").val(peserta.jenisPeserta.nmJenisPeserta);
						  $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs, 'kelastanggunganasuransi_id') ?>").val(peserta.kelasTanggungan.kdKelas);// <<tidak sama dengan kelaspelayanan_id
						  $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs, 'kelastanggunganasuransi_nama') ?>").val(peserta.kelasTanggungan.nmKelas);
						  $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs, 'kodefeskestk1') ?>").val(peserta.provUmum.kdProvider);
						  $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs, 'nama_feskestk1') ?>").val(peserta.provUmum.nmProvider);
						  $("#<?php echo CHtml::activeId($modSep, 'ppkrujukan') ?>").val(peserta.provUmum.kdProvider);
						  $("#<?php echo CHtml::activeId($modRujukanBpjs, 'nama_perujuk') ?>").val(peserta.provUmum.nmProvider);
						  // OVERWRITES old selecor
						  jQuery.expr[':'].contains = function (a, i, m) {
							  return jQuery(a).text().toUpperCase()
									  .indexOf(m[3].toUpperCase()) >= 0;
						  };
						  $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs,'kelastanggunganasuransi_id') ?>").find("option:contains('"+peserta.kelasTanggungan.nmKelas+"')").attr("selected",true);

						  $("#<?php echo CHtml::activeId($model,'penjamin_id') ?>").val(peserta.jenisPeserta.kdJenisPeserta);
						  //Rujukan Dari & Asal Rujukan
						  getAsalRujukanDari(peserta.provUmum.kdProvider,null);
			//					} else {
			//						myAlert('Peserta Tidak Aktif');
			//					}
				  } else {
					  myAlert(obj.metaData.message);
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

function getAsalRujukanDari(kodeppk,rujukandari_id){
	$.ajax({
		type:'POST',
		url:'<?php echo $this->createUrl('pendaftaranRawatJalan/getAsalRujukanDari'); ?>',
		data: {kodeppk: kodeppk,rujukandari_id:rujukandari_id},
		dataType: "json",
		success:function(data){
			if(data.status === true){
				$("#<?php echo CHtml::activeId($modRujukanBpjs,'asalrujukan_id') ?>").val(data.asalrujukan_id);
				$("#<?php echo CHtml::activeId($modRujukanBpjs,'rujukandari_id') ?>").val(data.rujukandari_id);
				$("#<?php echo CHtml::activeId($modSep,'ppkrujukan') ?>").val(data.kodeppk);
				$("#<?php echo CHtml::activeId($modRujukanBpjs, 'nama_perujuk')?>").val(data.namaperujuk);
			}
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
        url : "<?php echo $this->createUrl('pendaftaranRawatJalan/bpjsInterface'); ?>",
        type : 'GET',
        dataType : 'html',
        data : 'param='+ aksi + '&query=' + isi,
        beforeSend: function(){
            $("#content-bpjs").addClass("animation-loading");
        },
        success: function(data){
            $("#content-bpjs").removeClass("animation-loading");
            var obj = JSON.parse(data);
			if(obj.metadata != null && obj.metadata.code == '201' || obj.metadata.code == '402' || obj.metadata.code == '401' || obj.metadata.code == '50000' && obj.response.peserta == null){
				myAlert(obj.metadata.message);
			}else{
				if (obj.response != null) {
					var rujukan = obj.response.item;
					var noKunjungan = rujukan.noKunjungan;
					var tglKunjungan = rujukan.tglKunjungan;
					var peserta = rujukan.peserta;    //array
					var provKunjungan = rujukan.provKunjungan;    //array
					var keluhan = rujukan.keluhan;
					var diagnosa = rujukan.diagnosa;    //array
					var catatan = rujukan.catatan;
					var pemFisikLain = rujukan.pemFisikLain;
					var provRujukan = rujukan.provRujukan;
					var poliRujukan = rujukan.poliRujukan;    //array
					$("#<?php echo CHtml::activeId($modAsuransiPasienBpjs, 'nopeserta') ?>").val(peserta.noKartu);
					$("#<?php echo CHtml::activeId($modAsuransiPasienBpjs, 'nokartuasuransi') ?>").val(peserta.noKartu);
					$("#<?php echo CHtml::activeId($modAsuransiPasienBpjs, 'namapemilikasuransi') ?>").val(peserta.nama);
					$("#<?php echo CHtml::activeId($modAsuransiPasienBpjs, 'jenispeserta_id') ?>").val(peserta.jenisPeserta.kdJenisPeserta);
					$("#<?php echo CHtml::activeId($modAsuransiPasienBpjs, 'jenispeserta_nama') ?>").val(peserta.jenisPeserta.nmJenisPeserta);
					$("#<?php echo CHtml::activeId($modAsuransiPasienBpjs, 'kelastanggunganasuransi_id') ?>").val(peserta.kelasTanggungan.kdKelas);// <<tidak sama dengan kelaspelayanan_id
					$("#<?php echo CHtml::activeId($modAsuransiPasienBpjs, 'kelastanggunganasuransi_nama') ?>").val(peserta.kelasTanggungan.nmKelas);
					$("#<?php echo CHtml::activeId($modRujukanBpjs, 'no_rujukan') ?>").val(noKunjungan);
					$("#<?php echo CHtml::activeId($modSep, 'ppkrujukan') ?>").val(peserta.provUmum.kdProvider);
					$("#<?php echo CHtml::activeId($modRujukanBpjs, 'nama_perujuk') ?>").val(peserta.provUmum.nmProvider);
					$("#<?php echo CHtml::activeId($modRujukanBpjs, 'tanggal_rujukan') ?>").val(tglKunjungan);
					$("#<?php echo CHtml::activeId($modAsuransiPasienBpjs, 'kodefeskestk1') ?>").val(peserta.provUmum.kdProvider);
					$("#<?php echo CHtml::activeId($modAsuransiPasienBpjs, 'nama_feskestk1') ?>").val(peserta.provUmum.nmProvider);

					setDiagnosaBpjs(diagnosa.kdDiag, diagnosa.nmDiag);
				} else {
					myAlert(obj.metaData.message);
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

function verifikasiBpjs(btn){
    if (<?php echo (Yii::app()->user->getState('isbridging')==TRUE)?1:0; ?>) {}else{myAlert('Fitur Bridging tidak aktif!'); return false;}
    var nokartu = $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs,'nopeserta');?>").val();
    var tglsep = $("#<?php echo CHtml::activeId($modSep,'tglsep');?>").val();
    var tglrujukan = $("#<?php echo CHtml::activeId($modRujukanBpjs,'tanggal_rujukan');?>").val();
    var norujukan = $("#<?php echo CHtml::activeId($modRujukanBpjs,'no_rujukan');?>").val();
    var ppkrujukan = $("#<?php echo CHtml::activeId($modSep,'ppkrujukan');?>").val();
    var ppkpelayanan = $("#<?php echo CHtml::activeId($modSep,'ppkpelayanan');?>").val(); // "1001R012"
    var jnspelayanan = $("#<?php echo CHtml::activeId($modSep,'jnspelayanan');?>").val();
	var lakalantas = $("#<?php echo CHtml::activeId($modSep,'lakalantas');?>").val();
    var catatan = $("#<?php echo CHtml::activeId($modSep,'catatansep');?>").val();
    var diagawal = $("#diagnosaRujukanKodeBpjsSEP option:first-child").val();
    var politujuan = '<?php echo $model->ruangan_id; ?>';
    var klsrawat = $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs,'kelastanggunganasuransi_id');?>").val();
    <?php 
    $modPegawai = PegawaiM::model()->findByPk(Yii::app()->user->id);
    ?>
    var user = "<?php echo isset($modPegawai->nama_pegawai)?$modPegawai->nama_pegawai:'-';?>";
    var nomr = '<?php echo $modPasien->no_rekam_medik; ?>';
    var notrans = '<?php echo $model->no_pendaftaran; ?>';

    
    var aksi = 6; // 6 untuk menCreate SEP
    var setting = {
        url : "<?php echo $this->createUrl('pendaftaranRawatJalan/bpjsInterface'); ?>",
        type : 'GET',
        dataType : 'html',
        data : 'param='+aksi+'&no_kartu='+nokartu+'&tgl_sep='+tglsep+'&tgl_rujukan='+tglrujukan+'&no_rujukan='+norujukan+'&ppk_rujukan='+ppkrujukan+'&ppk_pelayanan='+ppkpelayanan+'&jns_pelayanan='+jnspelayanan+'&lakalantas='+lakalantas+'&catatan='+catatan+'&diag_awal='+diagawal+'&poli_tujuan='+politujuan+'&kls_rawat='+klsrawat+'&user='+user+'&no_mr='+nomr+'&no_trans='+notrans,
        beforeSend: function(){
            $("#content-bpjs").addClass("animation-loading");
        },
        success: function(data){
            $("#content-bpjs").removeClass("animation-loading");
            var res = JSON.parse(data);
            if(res.response!=null){
              var noSep = res.response;
              $("#<?php echo CHtml::activeId($modSep,'nosep') ?>").val(noSep);
			  $('.btn-sep').attr('style','display:block;');
			  $('.btn-ver-sep').attr('style','display:none;');
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

//    $(btn).hide();
//    $('.verified').show();
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
  var objSelect = $('select#diagnosaRujukanBpjsSEP').parent().find('select');
  var objList = $('select#diagnosaRujukanBpjsSEP').parent().find('ul li.bit-input');
  var objSelectKode = $('select#diagnosaRujukanKodeBpjsSEP').parent().find('select');
  var objListKode = $('select#diagnosaRujukanKodeBpjsSEP').parent().find('ul li.bit-input');

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
  var objSelect = $('select#diagnosaRujukanBpjsSEP').parent().find('select');
  var objList = $('select#diagnosaRujukanBpjsSEP').parent().find('ul li.bit-input');
  var objSelectKode = $('select#diagnosaRujukanKodeBpjsSEP').parent().find('select');
  var objListKode = $('select#diagnosaRujukanKodeBpjsSEP').parent().find('ul li.bit-input');

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

</script>
    