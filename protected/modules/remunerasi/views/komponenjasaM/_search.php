<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'komponenjasa-m-search',
    'type' => 'horizontal',
)); ?>

<div class="row">
    <div class="col-sm-4">
        <?php echo $form->dropDownListRow($model, 'komponentarif_id', CHtml::listData($model->getKomponentarifItems(), 'komponentarif_id', 'komponentarif_nama'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --',)) ?>
        <?php //golongan
        echo $form->dropDownListRow(
            $model,
            'jenistarif_id',
            CHtml::listData($model->getJenistarifItems(), 'jenistarif_id', 'jenistarif_nama'),
            array(
                'class' => 'span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                'ajax' => array(
                    'type' => 'POST',
                    'url' => $this->createUrl('/ActionDynamic/GetCaraBayar', array('encode' => false, 'model_nama' => get_class($model))),
                    'update' => "#" . CHtml::activeId($model, 'carabayar_id'),
                ),
                //    'onchange'=>"setClearBidang();setClearKelompok();setClearSubKelompok();setClearSubSubKelompok();",
            )
        ); ?>
        <?php echo $form->dropDownListRow($model, 'carabayar_id', CHtml::listData($model->getCarabayarItems(), 'carabayar_id', 'carabayar_nama'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --',)) ?>
        <?php echo $form->dropDownListRow($model, 'kelompoktindakan_id', CHtml::listData($model->getKelompoktindakanItems(), 'kelompoktindakan_id', 'kelompoktindakan_nama'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --', 'style' => 'width:60px;')); ?>
        <?php echo $form->dropDownListRow($model, 'ruangan_id', CHtml::listData($model->getRuanganItems(), 'ruangan_id', 'ruangan_nama'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --', 'style' => 'width:60px;')); ?>
        <?php echo $form->textFieldRow($model, 'komponenjasa_kode', array('placeholder' => 'Kode Komponen Jasa', 'class' => 'span3', 'maxlength' => 5)); ?>
    </div>
    <div class="col-sm-4">
        <?php echo $form->textFieldRow($model, 'komponenjasa_nama', array('placeholder' => 'Nama Komponen Jasa', 'class' => 'span3', 'maxlength' => 100)); ?>
        <?php echo $form->textFieldRow($model, 'komponenjasa_singkatan', array('placeholder' => 'Singkatan Komponen Jasa', 'class' => 'span3', 'maxlength' => 10)); ?>
        <?php echo $form->textFieldRow($model, 'besaranjasa', array('placeholder' => 'Besaran Jasa', 'class' => 'span3')); ?>
        <?php echo $form->textFieldRow($model, 'potongan', array('placeholder' => 'Potongan', 'class' => 'span3')); ?>
        <?php echo $form->textFieldRow($model, 'jasadireksi', array('placeholder' => 'Jasa Direksi', 'class' => 'span3', 'maxlength' => 50)); ?>
        <?php echo $form->textFieldRow($model, 'kuebesar', array('placeholder' => 'Kue Besar', 'class' => 'span3', 'maxlength' => 50)); ?>
    </div>
    <div class="col-sm-4">
        <?php echo $form->textFieldRow($model, 'jasaparamedis', array('placeholder' => 'Jasa Paramedis', 'class' => 'span3', 'maxlength' => 50)); ?>
        <?php echo $form->textFieldRow($model, 'jasaunit', array('placeholder' => 'Jasa Unit', 'class' => 'span3', 'maxlength' => 50)); ?>
        <?php echo $form->textFieldRow($model, 'jasabalanceins', array('placeholder' => 'Jasa Balanceins', 'class' => 'span3', 'maxlength' => 50)); ?>
        <?php echo $form->textFieldRow($model, 'biayaumum', array('placeholder' => 'Biaya Umum', 'class' => 'span3', 'maxlength' => 50)); ?>
        <?php echo $form->checkBoxRow($model, 'komponenjasa_aktif', array('checked' => 'komponenjasa_aktif')); ?>
    </div>
</div>


<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
</div>

<?php $this->endWidget(); ?>