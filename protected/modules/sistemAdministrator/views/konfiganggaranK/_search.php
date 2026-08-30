<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'agkonfiganggaran-k-search',
	'type'=>'horizontal',
	'focus'=>'#AGKonfiganggaranK_tgl_awal',
)); ?>

	<div class="row">
            <div class="col-sm-6">
                <?php $model->tglanggaran  = $format->formatDateTimeForUser($model->tglanggaran); ?>
                <?php echo $form->labelEx($model,'Periode Anggaran', array('class'=>'control-label')) ?>
                <div class="controls">  
                    <?php $this->widget('MyDateTimePicker',array(
                                                            'model'=>$model,
                                                            'attribute'=>'tglanggaran',
                                                            'mode'=>'date',
                                                            'options'=> array(
                                                               //'maxDate'=>'d',
                                                               'dateFormat'=>Params::DATE_FORMAT,
                                                            ),
                                                            'htmlOptions'=>array('readonly'=>true,
                                                            'class'=>'dtPicker2',
                                                            'onkeypress'=>"return $(this).focusNextInputField(event)"),
                                               )); ?>

                </div> 
                <?php $model->sd_tglanggaran = $format->formatDateTimeForUser($model->sd_tglanggaran); ?>
                <?php echo CHtml::label('Sampai Dengan',' Sampai Dengan', array('class'=>'control-label', 'style' => 'text-align:center;' )) ?>
                <div class="controls">  
                    <?php $this->widget('MyDateTimePicker',array(
                                                             'model'=>$model,
                                                             'attribute'=>'sd_tglanggaran',
                                                             'mode'=>'date',
                                                             'options'=> array(
                                                                    //'maxDate'=>'d',
                                                                    'dateFormat'=>Params::DATE_FORMAT,
                                                            ),
                                                             'htmlOptions'=>array('readonly'=>true,
                                                             'class'=>'dtPicker2',
                                                             'onkeypress'=>"return $(this).focusNextInputField(event)"),
                                                    )); ?>
                </div> 
                <div>
                    <?php echo $form->checkBoxRow($model,'isclosing_anggaran'); ?>
                </div>
            </div>
            <div>
                <?php echo $form->textAreaRow($model,'deskripsiperiode',array('cols'=>6, 'rows'=>3)); ?>
            </div>
	</div>
	<div class="form-actions">
		<?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
		<?php echo CHtml::htmlButton(
    Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
    array('title' => 'Ulang', 'class' => 'btn btn-default', 'type' => 'reset')
); ?>
	</div>

<?php $this->endWidget(); ?>
