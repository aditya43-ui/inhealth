<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'ppkelaspelayanan-m-search',
        'type'=>'horizontal',
)); ?>
<table style="width: 100%; border: none;">
    <tr>
        <td>
            <?php //echo $form->textFieldRow($model,'kelaspelayanan_id',array('class'=>'span5')); ?>
            <div class="control-group">
                <?php echo CHtml::activeLabel($model,'jeniskelas_id',array('class'=>'control-label')); ?>
                <div class="controls">
                    <?php echo $form->dropDownList($model,'jeniskelas_id',  CHtml::listData($model->JenisKelasItems, 'jeniskelas_id', 'jeniskelas_nama'),array('class'=>'span3 form-control', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
                </div>
            </div>
        </td>
        <td>
            <div class="control-group">
                <?php echo CHtml::activeLabel($model,'kelaspelayanan_nama',array('class'=>'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($model,'kelaspelayanan_nama',array('class'=>'span3  form-control','maxlength'=>50)); ?>
                </div>
            </div>
        </td>
        <td>
            <div class="control-group">
                <?php echo CHtml::activeLabel($model,'kelaspelayanan_namalainnya',array('class'=>'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($model,'kelaspelayanan_namalainnya',array('class'=>'span3  form-control','maxlength'=>50)); ?>
                </div>
            </div>
        </td>
    </tr>
    <tr>
        <td colspan="3">
            <?php //echo $form->checkBoxRow($model,'kelaspelayanan_aktif',array('checked'=>'checked')); ?>
			<div class="control-group">
				<?php echo CHtml::label("",'kelaspelayanan_aktif', array('class'=>'control-label')) ?>
				<div class="controls">
					  <?php echo $form->checkBox($model,'kelaspelayanan_aktif',array('checked'=>'checked')); ?> <label>Aktif</label>
				</div>
			</div>
        </td>
    </tr>
</table>
            
            
            
	

	<div class="form-actions">
		                <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
	</div>

<?php $this->endWidget(); ?>
