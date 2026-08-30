<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'matauang-m-search',
    'type' => 'horizontal',
)); ?>
<table>
    <tr>
        <td>
            <?php echo $form->textFieldRow($model, 'matauang', array('placeholder' => 'Mata Uang', 'class' => 'span3', 'maxlength' => 50)); ?>

            <?php echo $form->textFieldRow($model, 'singkatan', array('placeholder' => 'Singkatan', 'class' => 'span3', 'maxlength' => 50)); ?>

            <div class="control-group">
                <?php echo CHtml::label("", "matauang_aktif", array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->checkBox($model, 'matauang_aktif', array('checked' => "matauang_aktif")); ?> <label for="AKMatauangM_matauang_aktif">Aktif</label>
                </div>
            </div>
        </td>
    </tr>
</table>
<?php //echo $form->textFieldRow($model,'matauang_id',array('class'=>'span5')); 
?>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
    ); ?>
</div>

<?php $this->endWidget(); ?>