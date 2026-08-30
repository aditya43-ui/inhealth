<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
        'type'=>'horizontal',
	'method'=>'get',
        'id'=>'bahanmenudiet-m-search',
)); ?>
<table width='100%'>
    <tr>
        <td>
            <?php echo $form->dropDownListRow($model,'menudiet_id',CHtml::listData($model->getMenudietItems(),'menudiet_id','menudiet_nama'),array('empty'=>'-- Pilih --','class'=>'span3')); ?>
        </td>
        <td>
            <?php echo $form->dropDownListRow($model,'bahanmakanan_id',CHtml::listData($model->getBahanmakananItems(),'bahanmakanan_id','namabahanmakanan'),array('empty'=>'-- Pilih --','class'=>'span3')); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'jmlbahan'); ?>
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