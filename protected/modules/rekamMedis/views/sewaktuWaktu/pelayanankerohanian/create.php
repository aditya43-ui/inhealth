<?php $this->widget('bootstrap.widgets.BootAlert');?>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Pelayanan Kerohanian</div>
    </div>
    <div class="panel-body">

		<div class="panel panel-success">
			<div class="panel-heading">
				<div class="panel-title">Riwayat</div>
			</div>
			<div class="panel-body">
				<?php echo $this->renderPartial($this->path_view_kerohanian.'_riwayat', array('model'=>$model)); ?>


			</div>
		</div>

		<?php echo $this->renderPartial($this->path_view_kerohanian.'_form', array('model'=>$model)); ?>
	</div>
</div>

<script type="text/javascript">
	function cekMenyatakan(){
		var nama = $('#PelayanankerohanianT_penerima_informasi').val();
		var pasien = '<?php echo $modPasien->nama_pasien;?>';
		if (nama == 'Pasien'){
			$('#PelayanankerohanianT_nama_penerima').val(pasien);
		}else{
			$('#PelayanankerohanianT_nama_penerima').val('');
		}
	}
</script>