<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
        'id'=>'sazatmenudiet-m-search',
        'type'=>'horizontal',
)); ?>
<table width='100%'>
    <tr>
        <td>
            <div>
                <?php echo $form->dropDownListRow($model,'zatgizi_id',
                CHtml::listData($model->ZatgiziItems, 'zatgizi_id', 'zatgizi_nama'),
                array('class'=>'inputRequire', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --',)); ?>
            </div>
        </td>
        <td>
            <div>
                <?php echo $form->dropDownListRow($model,'menudiet_id',
                CHtml::listData($model->MenuDietItems, 'menudiet_id', 'menudiet_nama'),
                array('class'=>'inputRequire', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --',)); ?>
            </div>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'kandunganmenudiet',array('class'=>'span1')); ?>
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

