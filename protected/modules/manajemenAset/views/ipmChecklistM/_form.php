<?php
/**
* - digunakan sebagai Admin IPM CHECKLIST
* @author : Elham Budianto
* @email : elhambudianto1@gmail.com
* @wiki : ..
**/
?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'ipm-m-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
	'focus'=>'#'.CHtml::activeId($model,'ipm_nama'),
)); ?>
<div class="row-fluid">
	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>
	<?php echo $form->errorSummary($model); ?>
	<div class="col-sm-6">
        <div class="control-group">
            <?php echo $form->labelEx($model,'ipm_jenis',array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::activeDropDownList($model, 'ipm_jenis', LookupM::getItems('ipmchecklist'), array(
                    'empty'=>'-- Pilih --',
                ))?>
		    </div>
        </div>  
        <?php echo $form->textFieldRow($model,'ipm_listnama',array('class'=>'span3 custom-only','placeholder'=>'Ketik Nama IPM','onkeyup'=>'setKode(this);', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($model,'ipm_list_nourut',array('onkeyup' => 'namaLain(this)','placeholder'=>'Ketik No Urut IPM','class'=>'span3 numbers-only', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>		
        
	</div>
	<div class="col-sm-6">
		<?php echo $form->textAreaRow($model,'ipm_ket',array('class'=>'span3 custom-only','placeholder'=>'Ketik Keterangan IPM', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
        <div class="control-group">
                    <?php echo CHtml::label("","",array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php
                            if($model->ipm_aktif == true){
                        ?>
                        <?php  echo $form->checkBox($model,'ipm_aktif',array('value'=>1,'uncheckValue'=>0,'checked'=>'ipm_aktif')); ?> <label>Aktif</label>
                        <?php
                            }else{
                        ?>
                        <?php  echo $form->checkBox($model,'ipm_aktif',array('value'=>1,'uncheckValue'=>0)); ?> <label>Aktif</label>
                        <?php
                            }
                        ?>
                    </div>
                </div>  
		<?php //echo $form->checkBoxRow($model,'ipm_aktif', array('onkeypress'=>"return $(this).focusNextInputField(event);")); ?>		
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
		echo CHtml::link(Yii::t('mds', '{icon} Pengaturan IPM Checklist', array('{icon}'=>'<i class="icon-file icon-white"></i>')), $this->createUrl(Yii::app()->controller->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp";
		$tips = array(
			'0' => 'simpan',
			'1' => 'ulang',
		);
		$content = $this->renderPartial($this->path_tips.'informasi',array('tips'=>$tips),true);
		$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
	?>
</div>
<?php $this->endWidget(); ?>
<script>
function namaLain(obj){
    $("#<?php echo Chtml::activeId($model, 'ipm_namalainnya') ?>").val($(obj).val());
}
</script>
