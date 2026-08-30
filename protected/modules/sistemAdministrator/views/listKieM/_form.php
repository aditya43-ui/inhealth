

<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'sacara-bayar-m-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'focus'=>'#'.CHtml::activeId($model,'listkie_nama'),
)); ?>

	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

	<?php echo $form->errorSummary($model); ?>
        <?php echo $form->dropDownListRow($model, 'jeniskie', LookupM::getItems('jeniskie'),array('class'=>'span3', 'empty' => '-- Pilih --')) ?>
    
        <?php echo $form->textFieldRow($model,'listkie_nama',array('class'=>'span5', 'maxlength'=>200)); ?>
        <?php echo $form->textFieldRow($model,'listkie_namalain',array('class'=>'span5', 'maxlength'=>200)); ?>
        <div class="control-group">
            <label class="control-label"></label>
            <div class="controls">
                <?php echo $form->checkbox($model,'listkie_aktif',array()); ?><label> Aktif</label>
                
            </div>
        </div>

        <div class="form-actions">
                <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="fa fa-check"></i>')) : 
                                                     Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="fa fa-check"></i>')),
                                array('class'=>'btn btn-primary', 'type'=>'submit','id'=>'btn_simpan')); ?>
                <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="fa fa-refresh"></i>')), 
                        Yii::app()->createUrl($this->module->id.'/listkieM/admin'), 
                        array('class'=>'btn btn-danger',
                              'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
                <?php
                    $content = $this->renderPartial('../tips/tipsaddedit',array(),true);
                    $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
                ?>
                <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan List KIE', array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('/sistemAdministrator/ListKieM/Admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'));?>
        </div>

<?php $this->endWidget(); ?>
