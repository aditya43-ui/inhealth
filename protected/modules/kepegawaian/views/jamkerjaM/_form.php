
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'kppresensi-t-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        'focus'=>'#KPRegistrasifingerprint_nama_pegawai',
)); ?>

<!--	<!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>-->-->
        <?php $this->renderPartial('_pegawai', array('model'=>$modPegawai, 'form'=>$form)); ?>

    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
	<?php echo $form->errorSummary($model); ?>

            <?php echo $form->dropDownListRow($model,'statuskehadiran_id', CHtml::listData(StatuskehadiranM::model()->findAll('statuskehadiran_aktif = true'), 'statuskehadiran_id', 'statuskehadiran_nama'), array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", "empty"=>'-- Pilih --')); ?>
            <?php //echo $form->textFieldRow($model,'pegawai_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->dropDownListRow($model,'statusscan_id',CHtml::listData(StatusscanM::model()->findAll('statusscan_aktif = true'), 'statusscan_id', 'statusscan_nama'), array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", "empty"=>'-- Pilih --')); ?>
            <?php //echo $form->textFieldRow($model,'tglpresensi',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <?php
                $format = new MyFormatter();
                $model->tglpresensi = $format->formatDateTimeForUser($model->tglpresensi);
            ?>
            <div class="control-group">
                <?php echo $form->labelEx($model, 'tglpresensi', array('class' => 'control-label')); ?>
                <div class="controls">
                <?php $this->widget('MyDateTimePicker',array(
                                        'model'=>$model,
                                        'attribute'=>'tglpresensi',
                                        'mode'=>'datetime',
                                        'options'=> array(
                                            'dateFormat'=>Params::DATE_FORMAT,
                                        ),
                                        'htmlOptions'=>array('readonly'=>true,
                                                              'onkeypress'=>"return $(this).focusNextInputField(event)",
                                                              'class'=>'dtPicker3',
                                         ),
                )); ?> 
                </div>
            </div>
            <?php //echo $form->textFieldRow($model,'no_fingerprint',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>30)); ?>
            <?php //echo $form->checkBoxRow($model,'verifikasi', array('onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->textAreaRow($model,'keterangan',array('rows'=>6, 'cols'=>50, 'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <?php //echo $form->textFieldRow($model,'jamkerjamasuk',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <div class="control-group">
                <?php echo $form->labelEx($model, 'jamkerjamasuk', array('class' => 'control-label')); ?>
                <div class="controls">
                <?php $this->widget('MyDateTimePicker',array(
                                        'model'=>$model,
                                        'attribute'=>'jamkerjamasuk',
                                        'mode'=>'time',
                                        'options'=> array(
                                            'dateFormat'=>Params::DATE_FORMAT,
                                        ),
                                        'htmlOptions'=>array('readonly'=>true,
                                                              'onkeypress'=>"return $(this).focusNextInputField(event)",
                                                              'class'=>'dtPicker3',
                                         ),
                )); ?> 
                </div>
            </div>
            <?php //echo $form->textFieldRow($model,'jamkerjapulang',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <div class="control-group">
                <?php echo $form->labelEx($model, 'jamkerjapulang', array('class' => 'control-label')); ?>
                <div class="controls">
                <?php $this->widget('MyDateTimePicker',array(
                                        'model'=>$model,
                                        'attribute'=>'jamkerjapulang',
                                        'mode'=>'time',
                                        'options'=> array(
                                            'dateFormat'=>Params::DATE_FORMAT,
                                        ),
                                        'htmlOptions'=>array('readonly'=>true,
                                                              'onkeypress'=>"return $(this).focusNextInputField(event)",
                                                              'class'=>'dtPicker3',
                                         ),
                )); ?> 
                </div>
            </div>
            <?php echo $form->textFieldRow($model,'terlambat_mnt',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->textFieldRow($model,'pulangawal_mnt',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <?php //echo $form->textFieldRow($model,'create_time',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <?php //echo $form->textFieldRow($model,'update_time',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <?php //echo $form->textFieldRow($model,'create_loginpemakai_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <?php //echo $form->textFieldRow($model,'update_loginpemakai_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <?php //echo $form->textFieldRow($model,'create_ruangan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
	<div class="form-actions">
		                <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="entypo-check"></i>')) : 
                                    Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),
                                    array('class' => 'btn btn-danger', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
                        <?php echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), $this->createUrl('jamkerjaM/create&modul_id='.Yii::app()->session['modul_id']), array('class'=>'btn btn-danger')); ?>
                        <?php
                        echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Jam Kerja', array('{icon}'=>'<i class="icon-file icon-white"></i>')), $this->createUrl(Yii::app()->controller->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',));

                            $content = $this->renderPartial('kepegawaian.views.tips.tipsaddedit5',array(),true);
                            $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));
                        ?>
    </div>

<?php $this->endWidget(); ?>
