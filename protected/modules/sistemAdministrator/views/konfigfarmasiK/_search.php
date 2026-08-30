<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'sakonfigfarmasi-k-search',
        'type'=>'horizontal',
)); ?>
<table>
    <tr>
        <td>
            <div class="control-group">
                <div class="control-label">
                    <?php echo CHtml::label('Tgl. Berlaku','SAKonfigfarmasiK_tglberlaku'); ?>
                </div>
                <div class="controls">
                    <?php   
                            $this->widget('MyDateTimePicker',array(
                                            'model'=>$model,
                                            'attribute'=>'tglberlaku',
                                            'mode'=>'datetime',
                                            'options'=> array(
                                                'dateFormat'=>Params::DATE_FORMAT,
                                                'maxDate' => 'd',
                                            ),
                                            'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3'),
                    )); 
                            ?>
                </div>
            </div>
            <?php echo $form->textFieldRow($model,'persenppn',array('class'=>'span2')); ?>
            <?php echo $form->textFieldRow($model,'persenpph',array('class'=>'span2')); ?>
            <div>
                <?php echo $form->checkBoxRow($model,'bayarlangsung', array('onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            </div>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'ri_persjualppn',array('class'=>'span2 integer')); ?>
            <?php echo $form->textFieldRow($model,'rd_persjualppn',array('class'=>'span2 integer')); ?>
            <?php echo $form->textFieldRow($model,'rj_persjualppn',array('class'=>'span2 integer')); ?>
            <div>
                <?php echo $form->checkBoxRow($model,'konfigfarmasi_aktif',array('checked'=>'konfigfarmasi_aktif')); ?>
            </div>
        </td>
    </tr>
</table>
	<?php //echo $form->textFieldRow($model,'konfigfarmasi_id',array('class'=>'span5')); ?>

	<?php // echo $form->textFieldRow($model,'tglberlaku',array('class'=>'span2')); ?>

	<div class="form-actions">
		                <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
	</div>

<?php $this->endWidget(); ?>
