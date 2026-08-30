<?php $this->widget('bootstrap.widgets.BootAlert');?>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Penolakan Resusitasi</div>
    </div>
    <div class="panel-body">

		<div class="panel panel-success">
			<div class="panel-heading">
				<div class="panel-title">Riwayat</div>
			</div>
			<div class="panel-body">
				<?php echo $this->renderPartial($this->path_view_penolakanresusitasi.'_riwayat', array('model'=>$model)); ?>


			</div>
		</div>

		<?php echo $this->renderPartial($this->path_view_penolakanresusitasi.'_form', array('model'=>$model,'modPasien'=>$modPasien,'modPendaftaran'=>$modPendaftaran,'ubah'=>$ubah,'modDiagnosa'=>$modDiagnosa)); ?>
	</div>
</div>

<script>
function cekresusitasi(){
	var cek = $('#TindakanresusitasiT_pasienbutuh_resusitasi_0').is(':checked');
	if (cek == true){
		$('#<?php echo CHtml::activeId($model,'resusitasi_tidak') ?>').attr('disabled',true);
		$('#<?php echo CHtml::activeId($model,'resusitasi_lainnya') ?>').attr('disabled',true);
		$('#<?php echo CHtml::activeId($model,'resusitasi_tidak') ?>').val('');
		$('#<?php echo CHtml::activeId($model,'resusitasi_lainnya') ?>').val('');
		$('.pilihanresus').attr('disabled',true);
		$('.pilihanresus').prop('checked',false);
	}else{
		$('#<?php echo CHtml::activeId($model,'resusitasi_tidak') ?>').attr('disabled',false);
		$('#<?php echo CHtml::activeId($model,'resusitasi_lainnya') ?>').attr('disabled',false);
		$('.pilihanresus').attr('disabled',false);
	}
}

function diskusipasien(){
	var cek = $('#TindakanresusitasiT_isdiskusidengan_pasien_0').is(':checked');
	if (cek == true){
		$('#<?php echo CHtml::activeId($model,'diskusipasien_tidak') ?>').attr('disabled',true);
		$('#<?php echo CHtml::activeId($model,'diskusipasien_tidak') ?>').val('');
		
	}else{
		$('#<?php echo CHtml::activeId($model,'diskusipasien_tidak') ?>').attr('disabled',false);
	}
}

function diskusikeluarga(){
	var cek = $('#TindakanresusitasiT_isdiskusidengan_keluarga_0').is(':checked');
	if (cek == true){
		$('#<?php echo CHtml::activeId($model,'diskusikeluarga_tidak') ?>').attr('disabled',true);
		$('#<?php echo CHtml::activeId($model,'diskusikeluarga_tidak') ?>').val('');
		
	}else{
		$('#<?php echo CHtml::activeId($model,'diskusikeluarga_tidak') ?>').attr('disabled',false);
	}
}


function cekMenyatakan(){
	var nama = $('#TindakanresusitasiT_penerima_informasi').val();
	var pasien = '<?php echo $modPasien->nama_pasien;?>';
	if (nama == 'Pasien'){
		$('#TindakanresusitasiT_nama_penerima').val(pasien);
	}else{
		$('#TindakanresusitasiT_nama_penerima').val('');
	}
}

$(document).ready(function(){
	cekresusitasi();
	diskusipasien();
	diskusikeluarga();
});
</script>