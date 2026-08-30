<?php
$this->widget('bootstrap.widgets.BootAlert');

$form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'jurnalposting-t-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'method'=>'post',
	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'requiredCheck();'),
));
?>
<?php 
if(isset($_GET['sukses'])){
	Yii::app()->user->setFlash('success', "Data posting jurnal berhasil disimpan!");
}
?>
<div class="white-container">
	<legend class="rim2">Posting <b>Jurnal</b></legend>
	<fieldset class="box">
		<legend class="rim">Data Jurnal Rekening</legend>
		<div class="row">
			<div class="col-sm-6">
				<?php echo $form->textFieldRow($model,'tglbuktijurnal',array('class'=>'span3','readonly'=>true)); ?>
				<?php echo $form->textFieldRow($model,'nobuktijurnal',array('class'=>'span3','readonly'=>true)); ?>
				<div class="control-group">
					<?php echo $form->labelEx($model,'Jenis Jurnal', array('class'=>'control-label')) ?>
					<div class="controls">
						<?php echo $form->textField($model,'jenisjurnal_nama',array('class'=>'span3','readonly'=>true)); ?>
					</div>
				</div>
				
			</div>
			<div class="col-sm-6">
				<?php echo $form->textFieldRow($model,'rekperiode_nama',array('class'=>'span3','readonly'=>true)); ?>
				<?php echo $form->textFieldRow($model,'kodejurnal',array('class'=>'span3','readonly'=>true)); ?>
				<?php echo $form->textFieldRow($model,'urianjurnal',array('class'=>'span3','readonly'=>true)); ?>
			</div>
		</div>
	</fieldset>
	
	<fieldset class="box">
		<legend class="rim">Tabel Posting Jurnal</legend>
		<table class="items table table-striped table-condensed" id="table-postingjurnal">
			<thead>
				<tr>
					<th rowspan="2" style="text-align: center;">Tgl. Jurnal</th>
					<th rowspan="2" style="text-align: center;">Kode Jurnal</th>
					<th rowspan="2" style="text-align: center;">No. Bukti Jurnal</th>
					<th rowspan="2" style="text-align: center;">Tgl. Referensi <br> No. Referensi</th>
					<th rowspan="2" style="text-align: center;">Rekening</th>
					<th colspan="2" style="text-align: center;">Saldo</th>
				</tr>
				<tr>
					<th>Debit</th>
					<th>Kredit</th>
				</tr>
			</thead>
			<tbody>
				<?php
					if(count((array)$modDetail) > 0){
						$total_debit = 0;
						$total_kredit = 0;
						foreach($modDetail as $i=>$postingJurnal){
							$total_debit += $postingJurnal->saldodebit;
							$total_kredit += $postingJurnal->saldokredit;
							$this->renderPartial('_rowPostingJurnal',array('modDetail'=>$postingJurnal,'form'=>$form));
						}
					}
				?>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="5" style="text-align: right;">Total</td>
					<td><?php echo CHtml::textField('total_debit',MyFormatter::formatNumberForUser($total_debit),array('class'=>'span2 integer','readonly'=>true)); ?></td>
					<td><?php echo CHtml::textField('total_kredit',MyFormatter::formatNumberForUser($total_debit),array('class'=>'span2 integer','readonly'=>true)); ?></td>
				</tr>
			</tfoot>
		</table>
	</fieldset>
	<fieldset class="box">
		<legend class="rim">Data Posting Jurnal</legend>
		<div class="row">
			<div class="col-sm-6">
				<div class="control-group">
					<?php echo $form->labelEx($modPostingJurnal,'tgljurnalpost', array('class'=>'control-label')) ?>
					<div class="controls">
						<?php   
						$modPostingJurnal->tgljurnalpost = (!empty($modPostingJurnal->tgljurnalpost) ? date("d/m/Y H:i:s",strtotime($modPostingJurnal->tgljurnalpost)) : null);
						$this->widget('MyDateTimePicker',array(
												'model'=>$modPostingJurnal,
												'attribute'=>'tgljurnalpost',
												'mode'=>'datetime',
												'options'=> array(
													'showOn' => false,
													'minDate' => 'd',
													'yearRange'=> "-150:+0",
												),
												'htmlOptions'=>array('placeholder'=>'00/00/0000','class'=>'dtPicker2 datetimemask', 'onkeyup'=>"return $(this).focusNextInputField(event)"
												),
						)); ?>
						<?php echo $form->error($modPostingJurnal, 'tgljurnalpost'); ?>
					</div>
				</div>
			</div>
			<div class="col-sm-6">
				<?php echo $form->textAreaRow($modPostingJurnal,'keterangan',array('class'=>'span3')); ?>
			</div>
		</div>
	</fieldset>
	<div class="form-actions">
		<?php 
			$sukses = isset($_GET['sukses']) ? $_GET['sukses'] : null;
			$disableSave = false;
			$disableSave = (!empty($_GET['jurnalrekening_id'])) ? true : (($sukses > 0) ? true : false);
		?>
		<?php $disablePrint = ($disableSave) ? false : true; ?>
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),array('class' => 'btn btn-danger', 'type'=>'submit','disabled'=>$disableSave,'onKeypress'=>'return formSubmit(this,event)')); ?>
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="entypo-cancel"></i>')),array('class' => 'btn btn-default','onclick'=>'window.parent.$("#dialogPostingJurnal").dialog(\'close\')')); ?>
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'disabled'=>$disablePrint,'type'=>'button','onclick'=>'print(\'PRINT\')')); ?>
    </div>
</div>

<?php $this->endWidget(); ?>
<?php $this->renderPartial('_jsFunctions', array('model'=>$model,'modDetail'=>$modDetail,'modPostingJurnal'=>$modPostingJurnal)); ?>