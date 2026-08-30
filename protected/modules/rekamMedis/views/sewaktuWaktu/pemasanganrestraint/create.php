<?php $this->widget('bootstrap.widgets.BootAlert');?>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Observasi Pemasangan Restraint</div>
    </div>
    <div class="panel-body">

		<div class="panel panel-success">
			<div class="panel-heading">
				<div class="panel-title">Riwayat</div>
			</div>
			<div class="panel-body">
				<?php echo $this->renderPartial($this->path_view_pemasanganrestraint.'_riwayat', array('model'=>$model)); ?>


			</div>
		</div>

		<?php echo $this->renderPartial($this->path_view_pemasanganrestraint.'_form', array('model'=>$model,'modPasien'=>$modPasien,'modPendaftaran'=>$modPendaftaran,'ubah'=>$ubah)); ?>
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

    
<?php
//========= Dialog Detail Asesmen Awal Keperawatan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogDetail',
    'options' => array(
        'title' => 'Detail Observasi Pemasangan Restraint',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'height' => 500,
        'resizable' => false,
    ),
));
?>

<iframe src="" name="frameasesmenawal" width="100%" height="100%">
</iframe>
<?php
$this->endWidget();
//=======================================================================
?>
