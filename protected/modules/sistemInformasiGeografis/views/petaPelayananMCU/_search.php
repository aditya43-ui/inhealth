<?php
$form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'pelayananmcu-peta-search',
	'type'=>'horizontal',

)); ?>
<style>
	label.checkbox{
		margin-left: 50px;
		width: 50px;
		display:inline-block;
	}
</style>
<div class="row">
	<div class="col-sm-6">
	<fieldset class="box2">
		<legend class="rim">Berdasarkan Tahun</legend>
			<?php echo CHtml::activeHiddenField($model, 'jns_periode', array('readonly'=>true)); ?>
			<div class='control-group tahun'>
				<?php echo CHtml::label('Tahun', 'dari_tanggal', array('class' => 'control-label')) ?>
				<div class="controls">
					<?php 
					echo $form->dropDownList($model, 'thn_awal', CustomFunction::getTahun(null,null), array('class' => "span2",'onkeypress' => "return $(this).focusNextInputField(event)")); 
					?>
				</div>
				<?php // echo CHtml::label('Sampai Dengan', 'sampai_dengan', array('class' => 'control-label')) ?>
				<!--<div class="controls">-->
					<?php 
//					echo $form->dropDownList($model, 'thn_akhir', CustomFunction::getTahun(null,null), array('class' => "span2",'onkeypress' => "return $(this).focusNextInputField(event)")); 
					?>
				<!--</div>-->
			</div>
	</fieldset>
	</div>
	<div class="col-sm-6">
		<fieldset class="box2" id="cb-jenispasienbadak">
		<legend class="rim">Berdasarkan Jenis Pasien</legend>
		<div class='control-group'>
			 <div class="controls">
				   <?php echo $form->checkBoxList($model, 'jenispasienbadak', LookupM::getItems('jenispasienbadak')) ?>
			 </div>
		</div>
		</fieldset>
	</div>
</div>
<div class="form-actions">
	<?php
			echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')), 
					array('class' => 'btn btn-primary', 'type' => 'submit', 'id' => 'btn_simpan'));
	?>
	<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')),$this->createUrl($this->id.'/index'),array('class' => 'btn btn-default','onclick'=>'return refreshForm(this);')); ?>
</div>

<?php $this->endWidget(); ?>

<script>
function setPeriode(){
	var namaPeriode = $('#PeriodeName').val();
		$.post('<?php echo Yii::app()->createUrl('actionAjax/GantiPeriode'); ?>',{namaPeriode:namaPeriode},function(data){
			$('#SGPetapenyebaranmcuR_tgl_awal').val(data.periodeawal);
			$('#SGPetapenyebaranmcuR_tgl_akhir').val(data.periodeakhir);
		},'json');
}

function ubahJnsPeriode(){
	var obj = $("#<?php echo CHtml::activeId($model, 'jns_periode')?>");
	if(obj.val() == 'hari'){
		$('.hari').show();
		$('.bulan').hide();
		$('.tahun').hide();
	}else if(obj.val() == 'bulan'){
		$('.hari').hide();
		$('.bulan').show();
		$('.tahun').hide();
	}else if(obj.val() == 'tahun'){
		$('.hari').hide();
		$('.bulan').hide();
		$('.tahun').show();
	}
}
$(document).ready(function() {
	ubahJnsPeriode();
});
</script>
