<div class="search-form">
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'id' => 'pencarianbarang-form',
        'type' => 'horizontal',
        'focus' => '#' . CHtml::activeId($modBarang, 'barang_kode'),
    ));
    ?>
    <div class="row">
        <div class="col-sm-6">
            <?php echo $form->textFieldRow($modBarang, 'barang_kode', array('placeholder' => 'Kode Barang', 'class' => 'span3 custom-only', 'maxlength' => 50, 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->textFieldRow($modBarang, 'barang_nama', array('placeholder' => 'Nama Barang', 'class' => 'span3 custom-only', 'maxlength' => 50, 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->textFieldRow($modBarang, 'barang_noseri', array('placeholder' => 'No. Seri Barang', 'class' => 'span3 custom-only', 'maxlength' => 200, 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        </div>
        <div class="col-sm-6">
            <?php echo $form->textFieldRow($modBarang, 'barang_merk', array('placeholder' => 'Merk Barang', 'class' => 'span3 custom-only', 'maxlength' => 200, 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->dropDownListRow($modBarang, 'barang_satuan', CHtml::listData(SatuankecilM::model()->findAll("satuankecil_aktif = TRUE ORDER BY satuankecil_nama ASC"), 'satuankecil_nama', 'satuankecil_nama'), array('empty' => '-- Pilih --', 'class' => 'span3', 'maxlength' => 50, 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <div class="form-actions">
        <?php echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Cari', array('{icon}' => '<i class="entypo-search"></i>')),
            array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
        ); ?>
    </div>
    <?php $this->endWidget(); ?>
</div>