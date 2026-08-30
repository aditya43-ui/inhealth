<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'rujukandari-m-search',
    'type' => 'horizontal',
));
?>

<div class="row">
    <div class="col-sm-6">
        <?php
        echo $form->dropDownListRow($model, 'asalrujukan_id', CHtml::listData(AsalrujukanM::model()->findAll('asalrujukan_aktif = TRUE ORDER BY asalrujukan_nama ASC'), 'asalrujukan_id', 'asalrujukan_nama'), array(
            'class' => 'span3',
            'empty' => '-- Pilih --',
            'onkeypress' => "return $(this).focusNextInputField(event)"
        ));
        ?>
        <?php echo $form->textFieldRow($model, 'namaperujuk', array(
            'class' => 'span3 form-control',
            'maxlength' => 100,
            'placeholder' => 'Nama Perujuk',
        )); ?>
        <?php echo $form->textFieldRow($model, 'spesialis', array(
            'class' => 'span3 form-control',
            'maxlength' => 50,
            'placeholder' => 'Spesialis',
        )); ?>
        <?php echo $form->textFieldRow($model, 'ppkrujukan', array(
            'class' => 'span3 form-control',
            'maxlength' => 50,
            'placeholder' => 'PPK Rujukan',
        )); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textAreaRow($model, 'alamatlengkap', array(
            'rows' => 5,
            'cols' => 30,
            'class' => 'span3 form-control',
            'placeholder' => 'Alamat Lengkap',
        )); ?>
        <?php echo $form->textFieldRow($model, 'notelp', array(
            'class' => 'span3 form-control',
            'maxlength' => 100,
            'placeholder' => 'No. Telepon',
        )); ?>
    </div>

</div>

<?php //echo $form->textFieldRow($model,'rujukandari_id',array('class'=>'span5')); 
?>

<?php //echo $form->textFieldRow($model,'asalrujukan_id',array('class'=>'span3'));  
?>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array(
            'class' => 'btn btn-primary',
            'type' => 'submit',
            'title' => 'Cari',
        )
    ); ?>
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        array(
            'class' => 'btn btn-default',
            'type' => 'reset',
            'title' => 'Ulang',
        )
    ); ?>
</div>

<?php $this->endWidget(); ?>