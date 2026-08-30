<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'umdns-m-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
	'focus'=>'#'.CHtml::activeId($model,'umdns_nama'),
)); ?>
<div class="row-fluid">
	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>
	<?php echo $form->errorSummary($model); ?>
	<div class="col-sm-6">
		<?php echo $form->textFieldRow($model,'umdns_kode',array('class'=>'span3 numbers-only','placeholder'=>'Ketik Kode UMDNS','onkeyup'=>'setKode(this);', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($model,'umdns_nama',array('onkeyup' => 'namaLain(this)','placeholder'=>'Ketik Nama UMDNS','class'=>'span3 custom-only', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>		
        
	</div>
	<div class="col-sm-6">
		<?php echo $form->textFieldRow($model,'umdns_namalainnya',array('class'=>'span3 custom-only','placeholder'=>'Ketik Nama Lain UMDNS', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
        <div class="control-group">
                    <?php echo CHtml::label("","",array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php
                            if($model->umdns_aktif == true){
                        ?>
                        <?php  echo $form->checkBox($model,'umdns_aktif',array('value'=>1,'uncheckValue'=>0,'checked'=>'umdns_aktif')); ?> <label>Aktif</label>
                        <?php
                            }else{
                        ?>
                        <?php  echo $form->checkBox($model,'umdns_aktif',array('value'=>1,'uncheckValue'=>0)); ?> <label>Aktif</label>
                        <?php
                            }
                        ?>
                    </div>
                </div>  
		<?php //echo $form->checkBoxRow($model,'umdns_aktif', array('onkeypress'=>"return $(this).focusNextInputField(event);")); ?>		
	</div>
</div>
           
<div class="form-actions">
	<?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="entypo-check"></i>')) : 
		Yii::t('mds','{icon} Simpan',array('{icon}'=>'<i class="entypo-check"></i>')),
		array('class'=>'btn btn-danger', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
	<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
		'',
		array('class'=>'btn btn-default',
		'onclick'=>'myConfirm("Apakah Anda yakin ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
	<?php //$this->widget('UserTips',array('type'=>'create'));?>
	<?php
		echo CHtml::link(Yii::t('mds', '{icon} Pengaturan UMDNS', array('{icon}'=>'<i class="icon-file icon-white"></i>')), $this->createUrl(Yii::app()->controller->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp";
		$tips = array(
			'0' => 'simpan',
			'1' => 'ulang',
		);
		$content = $this->renderPartial($this->path_tips.'master',array('tips'=>$tips),true);
		$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
	?>
</div>
<?php $this->endWidget(); ?>
<script>
function namaLain(obj){
    $("#<?php echo Chtml::activeId($model, 'umdns_namalainnya') ?>").val($(obj).val());
}
</script>
