<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'bkpengisian-saldoawal-t-search',
    'type' => 'horizontal',
)); ?>
<table width="100%">
    <tr>
        <td>
            <div class="row-fluid">
                <div class="col-sm-6">
                    <?php echo $form->textFieldRow($model, 'nilaisaldoawal', array('class' => 'span3', 'maxlength' => 50)); ?>
                    <?php echo $form->textFieldRow($model, 'ruangan_nama', array('class' => 'span3', 'maxlength' => 50)); ?>
                    <?php //echo $form->textFieldRow($model,'kelompoktindakan_persencyto',array('class'=>'span1','maxlength'=>3)); 
                    ?>
                </div>
                <div class="col-sm-6">
                    <div class="control-group">
                        <?php echo CHtml::label("", 'is_kirim', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->checkBox($model, 'is_kirim', array('checked' => 'kelompoktindakan_aktif')); ?> <label for="">Aktif</label>
                        </div>
                    </div>
                </div>
            </div>
            <?php //echo $form->checkBoxRow($model,'kelompoktindakan_aktif', array('checked'=>'$data->kelompoktindakan_aktif')); 
            ?>
        </td>
    </tr>
</table>
<?php //echo $form->textFieldRow($model,'kelompoktindakan_id',array('class'=>'span5')); 
?>
<?php //echo $form->textFieldRow($model,'kelompoktindakan_urutan',array('class'=>'span5')); 
?>
<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="fa fa-search"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit')); ?>
</div>
<?php $this->endWidget(); ?>