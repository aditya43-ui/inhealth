<?php
$form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'penyebearanpasien-peta-search',
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
	<div class="span8">
		<fieldset class="box2">
			<legend class="rim">Berdasarkan Periode Waktu</legend>
				<div class="control-group">
				<?php echo CHtml::label('Periode ','Periode ', array('class'=>'control-label'));?>
				<div class="controls">
						<?php echo $form->dropDownList($model,'jns_periode', array('hari'=>'Hari','bulan'=>'Bulan','tahun'=>'Tahun'), 
								array(
								'onChange'=>'ubahJnsPeriode()',
								'onkeypress'=>"return $(this).focusNextInputField(event)",
								'style'=>'width:120px;',
								'style'=>'width:120px;float:left', 
								'onchange'=>'ubahJnsPeriode();')); 
						?>
					<div style="margin-left:10px;float:left;">
				<div class='control-group hari'>
					<?php echo CHtml::label('Dari Tanggal', 'dari_tanggal', array('class' => 'control-label')) ?>
					<div class="controls">
						<?php
						$this->widget('MyDateTimePicker', array(
							'model' => $model,
							'attribute' => 'tgl_awal',
							'mode' => 'date',
							'options' => array(
								'dateFormat' => Params::DATE_FORMAT,
								'maxDate'=>'d',
							),
							'htmlOptions' => array('readonly' => true, 'class' => "span2",'style'=>'width:90px;',
								'onkeypress' => "return $(this).focusNextInputField(event)"),
						));
						?>
					</div> 
				</div>
				<div class='control-group bulan'>
					<?php echo CHtml::label('Dari Bulan', 'dari_tanggal', array('class' => 'control-label')) ?>
					<div class="controls">
						<?php 
							$this->widget('MyMonthPicker', array(
								'model' => $model,
								'attribute' => 'bln_awal', 
								'options'=>array(
									'dateFormat' => Params::MONTH_FORMAT,
								),
								'htmlOptions' => array('readonly' => true,'style'=>'width:90px;',
									'class' => "span2",
									'onkeypress' => "return $(this).focusNextInputField(event)"),
							));  
						?>
					</div> 
				</div>
				<div class='control-group tahun'>
					<?php echo CHtml::label('Dari Tahun', 'dari_tanggal', array('class' => 'control-label')) ?>
					<div class="controls">
						<?php 
						echo $form->dropDownList($model, 'thn_awal', CustomFunction::getTahun(null,null), array('class' => "span2",'style'=>'width:90px;','onkeypress' => "return $(this).focusNextInputField(event)")); 
						?>
					</div>
				</div>
				</div>
				<div style="margin-left:10px;float:left;">
					<div class='control-group hari'>
						<?php echo CHtml::label('Sampai Dengan', 'sampai_dengan', array('class' => 'control-label')) ?>
						<div class="controls">
							<?php
							$this->widget('MyDateTimePicker', array(
								'model' => $model,
								'attribute' => 'tgl_akhir',
								'mode' => 'date',
								'options' => array(
									'dateFormat' => Params::DATE_FORMAT,
									'maxDate'=>'d',
								),
								'htmlOptions' => array('readonly' => true,'class' => "span2",'style'=>'width:90px;',
									'onkeypress' => "return $(this).focusNextInputField(event)"),
							));
							?>
						</div> 
					</div>
					<div class='control-group bulan'>
						<?php echo CHtml::label('Sampai Dengan', 'sampai_dengan', array('class' => 'control-label')) ?>
						<div class="controls">
							<?php 
								$this->widget('MyMonthPicker', array(
									'model' => $model,
									'attribute' => 'bln_akhir', 
									'options'=>array(
										'dateFormat' => Params::MONTH_FORMAT,
									),
									'htmlOptions' => array('readonly' => true,'class' => "span2",'style'=>'width:90px;',
										'onkeypress' => "return $(this).focusNextInputField(event)"),
								));  
							?>
						</div> 
					</div>
					<div class='control-group tahun'>
						<?php echo CHtml::label('Sampai Dengan', 'sampai_dengan', array('class' => 'control-label')) ?>
						<div class="controls">
							<?php 
							echo $form->dropDownList($model, 'thn_akhir', CustomFunction::getTahun(null,null), array('class' => "span2",'style'=>'width:90px;','onkeypress' => "return $(this).focusNextInputField(event)")); 
							?>
						</div>
					</div>
				</div>
			</div>
		</fieldset>
	</div>
	<div class="col-sm-4">
		<fieldset class="box2" id="cb-typerumah">
			<legend class="rim">Berdasarkan Jenis Tempat Tinggal</legend>
			<div class='control-group'>
				<?php echo CHtml::label('Jenis Tempat Tinggal ','Periode ', array('class'=>'control-label'));?>
				<div class="controls">
					<?php echo $form->checkBox($model,'is_typerumah', array('onkeyup'=>"return $(this).focusNextInputField(event)",'checked'=>false)); ?>
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
			$('#SGPetapenyebaranpasienR_tgl_awal').val(data.periodeawal);
			$('#SGPetapenyebaranpasienR_tgl_akhir').val(data.periodeakhir);
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
