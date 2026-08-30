<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'saasalaset-m-search',
    'type' => 'horizontal',
)); ?>

<div class="row">
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'asalrujukan_nama', array(
            'class' => 'form-control span3',
            'maxlength' => 50,
            'placeholder' => 'Asal Rujukan',
        )); ?>

        <?php echo $form->textFieldRow($model, 'asalrujukan_institusi', array(
            'class' => 'form-control span3',
            'maxlength' => 50,
            'placeholder' => 'Institusi Asal Rujukan',
        )); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'asalrujukan_namalainnya', array(
            'class' => 'form-control span3',
            'maxlength' => 50,
            'placeholder' => 'Nama Lain Asal Rujukan',
        )); ?>

        <div class="control-group">
            <?php echo CHtml::label("", 'asalrujukan_aktif', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'asalrujukan_aktif', array('checked' => 'checked')); ?> <label>Aktif</label>
            </div>
        </div>
    </div>
</div>


<?php //echo $form->checkBoxRow($model,'asalrujukan_aktif', array('checked'=>'$data->asalrujukan_aktif')); 
?>

<?php //echo $form->textFieldRow($model,'asalrujukan_id',array('class'=>'span5')); 
?>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('class' => 'btn btn-primary', 'type' => 'submit', 'title' => 'Cari')
    ); ?>
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        array('class' => 'btn btn-default', 'type' => 'reset', 'title' => 'Ulang')
    ); ?>
</div>

<?php $this->endWidget(); ?>