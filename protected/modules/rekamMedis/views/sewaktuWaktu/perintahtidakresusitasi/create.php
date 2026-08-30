<?php $this->widget('bootstrap.widgets.BootAlert');?>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Perintah Tidak Dilakukan Resusitasi</div>
    </div>
    <div class="panel-body">

		<div class="panel panel-success">
			<div class="panel-heading">
				<div class="panel-title">Riwayat</div>
			</div>
			<div class="panel-body">
				<?php echo $this->renderPartial($this->path_view_perintahtidakresusitasi.'_riwayat', array('model'=>$model)); ?>


			</div>
		</div>

		<?php echo $this->renderPartial($this->path_view_perintahtidakresusitasi.'_form', array('model'=>$model,'modPasien'=>$modPasien,'modPendaftaran'=>$modPendaftaran,'ubah'=>$ubah)); ?>
	</div>
</div>

<script type="text/javascript">
	function cekMenyatakan(){
		var nama = $('#TidakdilakukanresusitasiT_pasienmenyatakan').val();
		var pasien = '<?php echo $modPasien->nama_pasien;?>';
		if (nama == 'Pasien'){
			$('#TidakdilakukanresusitasiT_nama_menyatakan').val(pasien);
		}else{
			$('#TidakdilakukanresusitasiT_nama_menyatakan').val('');
		}
	}
</script>