<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'sabahansterilisasi-m-search',
    'type' => 'horizontal',
)); ?>

<div class="col-sm-6">
    <?php //echo $form->textFieldRow($model,'bahansterilisasi_id',array('class'=>'span3')); 
    ?>

    <?php echo $form->textFieldRow($model, 'bahansterilisasi_nama', array('placeholder' => 'Nama Bahan Sterilisasi', 'class' => 'span3', 'maxlength' => 100)); ?>
    <?php echo $form->textFieldRow($model, 'bahansterilisasi_namalain', array('placeholder' => 'Nama Lain', 'class' => 'span3', 'maxlength' => 100)); ?>
    <?php echo $form->textFieldRow($model, 'bahansterilisasi_jumlah', array('placeholder' => 'Jumlah', 'class' => 'span3')); ?>
</div>
<div class="col-sm-6">
    <?php echo $form->dropdownListRow($model, 'bahansterilisasi_satuan', LookupM::getItems('satuanbarang'), array('empty' => '-- Pilih --', 'onkeypress' => 'return $(this).focusNextInputField(event)', 'class' => 'span3')); ?>
    <?php echo $form->textFieldRow($model, 'bahansterilisasi_warna', array('placeholder' => 'Warna', 'class' => 'span3', 'maxlength' => 50)); ?>
    <?php echo $form->textFieldRow($model, 'bahansterilisasi_maksuhu', array('placeholder' => 'Maksimal Suhu °C', 'class' => 'span3')); ?>
</div>
<div class="clear"></div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Cari', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        array('title' => 'Ulang', 'class' => 'btn btn-default', 'type' => 'reset')
    ); ?>
</div>

<?php $this->endWidget(); ?>