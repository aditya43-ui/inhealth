<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'sarencana-keperawatan-m-search',
    'type' => 'horizontal',
)); ?>

<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo $form->dropDownListRow($model, 'diagnosakeperawatan_id', CHtml::listData($model->DiagnosaKeperawatanItems, 'diagnosakeperawatan_id', 'diagnosakeperawatan_kode'), array('class' => 'span3', 'empty' => '-- Pilih --')); ?>
        </div>
        <div class="control-group">
            <?php echo $form->textAreaRow($model, 'rencana_intervensi', array('rows' => 3, 'cols' => 30, 'class' => 'span3')); ?>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo $form->textFieldRow($model, 'rencana_kode', array('class' => 'span3', 'maxlength' => 20)); ?>
        </div>
        <div class="control-group">
            <?php echo $form->textAreaRow($model, 'rencana_rasionalisasi', array('rows' => 3, 'cols' => 30, 'class' => 'span3')); ?>
        </div>
    </div>
</div>

<?php //echo $form->textFieldRow($model,'diagnosakeperawatan_id',array('class'=>'span3')); 
?>
<?php /*
    <tr>
        <td colspan="2">
            <?php echo $form->checkBoxRow($model,'iskolaborasiintervensi', array('checked'=>'$data->iskolaborasiintervensi')); ?>
        </td>
    </tr>
     * 
     */ ?>
<?php //echo $form->textFieldRow($model,'rencanakeperawatan_id',array('class'=>'span5')); 
?>

<?php //echo $form->textAreaRow($model,'rencana_intervensi',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); 
?>

<?php //echo $form->textAreaRow($model,'rencana_rasionalisasi',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); 
?>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
</div>

<?php $this->endWidget(); ?>