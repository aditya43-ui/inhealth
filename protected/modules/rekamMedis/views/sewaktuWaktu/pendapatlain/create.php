<?php $this->widget('bootstrap.widgets.BootAlert');?>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Permintaan Pendapat Lain</div>
    </div>
    <div class="panel-body">

		<div class="panel panel-success">
			<div class="panel-heading">
				<div class="panel-title">Riwayat</div>
			</div>
			<div class="panel-body">
				<?php echo $this->renderPartial($this->path_view_pendapatlain.'_riwayat', array('model'=>$model)); ?>


			</div>
		</div>

		<?php echo $this->renderPartial($this->path_view_pendapatlain.'_form', array('model'=>$model,'modPasien'=>$modPasien,'modPendaftaran'=>$modPendaftaran,'ubah'=>$ubah)); ?>
	</div>
</div>

<script>
function cekLuar(){
	var cek = $('#FormpendapatlainT_is_luar').is(':checked');
	if (cek == true){
		$(".pilihdokter").hide();
		$(".inputdokter").show();
	}else{
		$(".inputdokter").hide();
		$(".pilihdokter").show();
	}
}



function cekMenyatakan(){
	var nama = $('#FormpendapatlainT_penerima_informasi').val();
	var pasien = '<?php echo $modPasien->nama_pasien;?>';
	if (nama == 'Pasien'){
		$('#FormpendapatlainT_nama_penerima').val(pasien);
	}else{
		$('#FormpendapatlainT_nama_penerima').val('');
	}
}

$(document).ready(function(){
	cekLuar();
});
</script>