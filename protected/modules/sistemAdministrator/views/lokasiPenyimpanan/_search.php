<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'salokasipenyimpanan-m-search',
    'type' => 'horizontal',
)); ?>

<?php //echo $form->textFieldRow($model,'lokasipenyimpanan_id',array('class'=>'span3')); 
?>

<div class="row">
    <div class="col-sm-6">
        <?php echo $form->dropDownListRow($model, 'instalasi_id',  CHtml::listData($model->InstalasiItems, 'instalasi_id', 'instalasi_nama'), array('class' => 'span3', 'empty' => '-- Pilih --')); ?>
        <?php echo $form->textFieldRow($model, 'lokasipenyimpanan_kode', array('placeholder' => 'Kode', 'class' => 'span3', 'maxlength' => 10)); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'lokasipenyimpanan_nama', array('placeholder' => 'Nama Lokasi Penyimpanan', 'class' => 'span3', 'maxlength' => 100)); ?>
        <?php echo $form->textFieldRow($model, 'lokasipenyimpanan_namalain', array('placeholder' => 'Nama Lain', 'class' => 'span3', 'maxlength' => 100)); ?>

        <div class="control-group">
            <?php echo CHtml::label("", 'lokasipenyimpanan_aktif', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'lokasipenyimpanan_aktif', array('checked' => 'lokasipenyimpanan_aktif')); ?> <label>Aktif</label>
            </div>
        </div>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Cari', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Ulang', 'class' => 'btn btn-default', 'type' => 'reset')
    ); ?>
</div>

<?php $this->endWidget(); ?>