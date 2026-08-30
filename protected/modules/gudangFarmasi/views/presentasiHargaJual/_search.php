<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'gfkonfigfarmasi-k-search',
        'type'=>'horizontal',
)); ?>
                <div class="control-group">
                    <div class="control-label">
                        <?php echo CHtml::label('Tgl. Berlaku','SAKonfigfarmasiK_tglberlaku'); ?>
                    </div>
                    <div class="controls">
                        <?php   
                                $this->widget('MyDateTimePicker',array(
                                                'model'=>$model,
                                                'attribute'=>'tglberlaku',
                                                'mode'=>'date',
                                                'options'=> array(
                                                    'dateFormat'=>Params::DATE_FORMAT,
                                                    'maxDate' => 'd',
                                                ),
                                                'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3'),
                        )); 
                                ?>
                    </div>
                </div>
	<?php echo $form->textFieldRow($model,'persenppn',array('autofocus'=>true,'class'=>'span2')); ?>

	<?php echo $form->textFieldRow($model,'persenpph',array('class'=>'span2')); ?>

	<?php echo $form->textFieldRow($model,'persjualbebas',array('class'=>'span2')); ?>
        <?php echo CHtml::hiddenfield('GFKonfigfarmasiK[totalpersenhargajual]');?>
	<?php echo $form->checkBoxRow($model,'konfigfarmasi_aktif',array('checked'=>'konfigfarmasi_aktif')); ?>

	<div class="form-actions">
		                <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
	</div>

<?php $this->endWidget(); ?>
