<script type="text/javascript">
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
            "PPDokterV[ruangan_id]":ruangan_id,
        }
    });
    $("#dialogDokter").dialog('open');
  }
  return false;
}

function getRuanganPoliklinikPasien(){
	// Hanya digunakan di transaksi Pendaftaran Rawat Jalan
}

/**
 * print status rawat darurat dan karcis
 */
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
 * print gelang pasien
 */

function printGelangPasien()
{
   window.open('<?php echo $this->createUrl('PendaftaranRawatInap/printLabelGelang',array('pendaftaran_id'=>$model->pendaftaran_id)); ?>','printwin','left=100,top=100,width=480,height=640');
}
/**
 * print karcis
 */
function printKarcis()
{
    window.open('<?php echo $this->createUrl('printKarcis',array('pendaftaran_id'=>$model->pendaftaran_id)); ?>','printwin','left=100,top=100,width=480,height=640');
}

/**
 * override function yang di pendaftaranRawatJalan
 */
function autoPrint(){
    printStatusRD();  
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
    
    if(requiredCheck($("pppendaftaran-t-form"))){
		//	LNG-1578 untuk notif pemberitahuan sbelum simpan, jika pasien yang sudah terdaftar.	
		//	NIK : 201410001 
		var pasien_id  = $('#<?php echo CHtml::activeId($modPasien, 'pasien_id') ?>').val();
		var nama_pasien  = $('#<?php echo CHtml::activeId($modPasien, 'nama_pasien') ?>').val();
		
		//if (!cekNoAsuransiBpjs()) return false;
		
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
				   data: $("form").serialize(),
				   dataType: "json",
				   success:function(data){
						//$('#dialog-verifikasi > .dialog-content').html(data.content);
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
		
    }
    return false;
}
$(document).ready(function() {
    cekPilihSatu($("#PPPendaftaranT_ruangan_id"));
});

function showUmumBpjs(carabayar){       
   
    if (carabayar == '<?php echo Params::CARABAYAR_ID_MEMBAYAR ?>'){
        $("#isumumbpjs").attr('style','display:block;');
    }else{
        $("#isumumbpjs").attr('style','display:none;');
    }
}
</script>
    