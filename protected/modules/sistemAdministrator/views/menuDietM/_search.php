<div class="wide form">

<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
     'id'=>'sadiet-m_search',
)); ?>
    <table>
        <tr>
            <td>
                <div>
                    <?php echo $form->dropDownListRow($model,'jenisdiet_id',
                    CHtml::listData($model->JenisdietItems, 'jenisdiet_id', 'jenisdiet_nama'),
                    array('class'=>'inputRequire', 'onkeypress'=>"return $(this).focusNextInputField(event)",
                    'empty'=>'-- Pilih --',)); ?>
                </div>
                <div>
                    <?php echo $form->textFieldRow($model,'menudiet_nama',array('size'=>60,'maxlength'=>200)); ?>
                </div>
            </td>
            <td>
                <div>
                    <?php echo $form->textFieldRow($model,'menudiet_namalain',array('size'=>60,'maxlength'=>200)); ?>
                </div>
                <div>
                    <?php echo $form->textFieldRow($model,'jml_porsi',array('class'=>'span1')); ?>
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

</div><!--search-form-->