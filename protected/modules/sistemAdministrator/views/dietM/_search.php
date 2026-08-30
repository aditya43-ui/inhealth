<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action'=>Yii::app()->createUrl($this->route),
    'id'=>'sadiet-m_search',
    'method'=>'get',
    'type'=>'horizontal',
)); ?>
<table width='100%'>
    <tr>
        <td>
            <?php echo $form->dropDownListRow($model,'tipediet_id',CHtml::listData($model->TipeDietItems, 'tipediet_id', 'tipediet_nama'),
                    array('class'=>'inputRequire', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --',)); ?>
        </td>
        <td>
            <?php echo $form->dropDownListRow($model,'jenisdiet_id',CHtml::listData($model->JenisdietItems, 'jenisdiet_id', 'jenisdiet_nama'),
                    array('class'=>'inputRequire', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --',)); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'diet_kandungan'); ?>
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