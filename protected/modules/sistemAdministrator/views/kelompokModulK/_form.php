

<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'sakelompok-modul-k-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'focus'=>'#SAKelompokModulK_kelompokmodul_nama',
)); ?>

	<!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>-->

	<?php echo $form->errorSummary($model); ?>

            <?php echo $form->textFieldRow($model,'kelompokmodul_nama',array('class'=>'span3', 'onkeypress'=>"return nextFocus(this,event,'SAKelompokModulK_kelompokmodul_namalainnya','')", 'maxlength'=>50)); ?>
            <?php echo $form->textFieldRow($model,'kelompokmodul_namalainnya',array('class'=>'span3', 'onkeypress'=>"return nextFocus(this,event,'SAKelompokModulK_kelompokmodul_fungsi','SAKelompokModulK_kelompokmodul_nama')", 'maxlength'=>50)); ?>
            <?php echo $form->textAreaRow($model,'kelompokmodul_fungsi',array('rows'=>6, 'cols'=>50, 'class'=>'span5', 'onkeypress'=>"return nextFocus(this,event,'SAKelompokModulK_kelompokmodul_aktif','SAKelompokModulK_kelompokmodul_namalainnya')")); ?>
            <?php //echo $form->checkBoxRow($model,'kelompokmodul_aktif', array('onkeypress'=>"return nextFocus(this,event,'btn_simpan','SAKelompokModulK_kelompokmodul_fungsi')")); ?>
	<div class="form-actions">
                        <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="entypo-check"></i>')) : 
                            Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),
                            array('class' => 'btn btn-danger', 'type'=>'submit', 'id'=>'btn_simpan')); ?>
                        <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
                            $this->createUrl(Yii::app()->controller->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), 
                            array('class' => 'btn btn-default',
                            'onclick'=>'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
                        <?php
                            echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Kelompok Modul', array('{icon}'=>'<i class="icon-file icon-white"></i>')), $this->createUrl(Yii::app()->controller->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',));
                            $content = $this->renderPartial('../tips/tipsaddedit',array(),true);
                            $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
                        ?>
        </div>

<?php $this->endWidget(); ?>
