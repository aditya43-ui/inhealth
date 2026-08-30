<?php $this->widget('bootstrap.widgets.BootAlert');?>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Pelepasan Tindakan Restraint</div>
    </div>
    <div class="panel-body">

		<div class="panel panel-success">
			<div class="panel-heading">
				<div class="panel-title">Riwayat</div>
			</div>
			<div class="panel-body">
				<?php echo $this->renderPartial($this->path_view_pelepasantindakanrestraint.'_riwayat', array('model'=>$model)); ?>


			</div>
		</div>

		<?php echo $this->renderPartial($this->path_view_pelepasantindakanrestraint.'_form', array('model'=>$model,'modPasien'=>$modPasien,'modPendaftaran'=>$modPendaftaran,'ubah'=>$ubah)); ?>
	</div>
</div>

<script type="text/javascript">
	function cekKeterangan(){
	var cek = $('.lain').is(':checked');
		if (cek == true){
			$('#<?php echo CHtml::activeId($model,'keterangan_lainnya') ?>').attr('disabled',false);
		}else{
			$('#<?php echo CHtml::activeId($model,'keterangan_lainnya') ?>').attr('disabled',true);
		}
	}


	$(document).ready(function(){
		cekKeterangan();
	});
</script>

    
<?php
//========= Dialog Detail Asesmen Awal Keperawatan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogDetailAsesmenAwal',
    'options' => array(
        'title' => 'Detail Restraint',
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
