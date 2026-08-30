<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'tipeinsiden-m-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
	'focus'=>'#'.CHtml::activeId($model,'tipeinsiden_nama')
)); ?>

<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>
<?php echo $form->errorSummary($model); ?>
<div class="row-fluid">
    <div class = "col-sm-12">
        <?php echo $form->textFieldRow($model,'tipeinsiden_nama',array('onkeyup' => 'namaLain(this);','class'=>'span4', 'maxlength'=>100)); ?>
        <?php echo $form->textFieldRow($model,'tipeinsiden_namalainnya',array('class'=>'span4', 'maxlength'=>100)); ?>
        <div class="control-group">
            <?php echo CHtml::label("",'tipeinsiden_aktif', array('class' => 'control-label')) ?>
            <div class="controls" style="padding-top: 2px">
                <?php echo $form->checkBox($model,'tipeinsiden_aktif',array('checked'=>'tipeinsiden_aktif')); ?> <label>Aktif</label>
            </div>				
        </div>
    </div>
</div>
<div class="row-fluid">
    <div class="form-actions">
        <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="entypo-check"></i>')) : 
		Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),
		array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
        <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
                $this->createUrl('admin'), 
                array('class'=>'btn btn-danger',
                        'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
        <?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Tipe Insiden',array('{icon}'=>'<i class="entypo-folder"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
        <?php  
            $tips = array(
                '0' => 'autocomplete-search',
                '1' => 'simpan',
                '2' => 'ulang',
            );
            $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips',array('tips' => $tips),true);
            $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
        ?>
    </div>
</div>
<?php $this->endWidget(); ?>
<script>
    function namaLain(obj){
        var upper = $(obj).val().toUpperCase();
        $("#TipeinsidenM_tipeinsiden_namalainnya").val(upper);
    }
</script>