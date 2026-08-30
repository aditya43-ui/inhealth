<?php $this->widget('bootstrap.widgets.BootAlert');?>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Penundaan dan Kelambatan</div>
    </div>
    <div class="panel-body">

		<div class="panel panel-success">
			<div class="panel-heading">
				<div class="panel-title">Riwayat</div>
			</div>
			<div class="panel-body">
				<?php echo $this->renderPartial($this->path_view_penundaankelambatan.'_riwayat', array('model'=>$model)); ?>


			</div>
		</div>

		<?php echo $this->renderPartial($this->path_view_penundaankelambatan.'_form', array('model'=>$model,'modPasien'=>$modPasien,'modPendaftaran'=>$modPendaftaran,'ubah'=>$ubah)); ?>
	</div>
</div>

<script type="text/javascript">
	function cekMenyatakan(){
		var nama = $('#PenundaandankelambatanT_penerima_informasi').val();
		var pasien = '<?php echo $modPasien->nama_pasien;?>';
		if (nama == 'Pasien'){
			$('#PenundaandankelambatanT_nama_penerima').val(pasien);
		}else{
			$('#PenundaandankelambatanT_nama_penerima').val('');
		}
	}
</script>