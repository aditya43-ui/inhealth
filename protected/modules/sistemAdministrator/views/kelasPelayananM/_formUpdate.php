<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'sakelas-pelayanan-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#',
));

$cs = Yii::app()->clientScript;
$cs->scriptMap = array(
    'bootstrap-multiselect.js' => false,
);
?>

<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                            ?></p>-->

<?php echo $form->errorSummary($model); ?>

<div class="row">
    <div class="col-sm-6">
        <?php echo $form->dropDownListRow($model, 'jeniskelas_id', CHtml::listData($model->JenisKelasItems, 'jeniskelas_id', 'jeniskelas_nama'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
        <?php echo $form->textFieldRow($model, 'kelaspelayanan_nama', array('class' => 'span3', 'onkeyup' => "namaLain(this)", 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50)); ?>
        <?php echo $form->textFieldRow($model, 'kelaspelayanan_namalainnya', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50)); ?>
        <?php echo $form->textFieldRow($model, 'urutankelas', array('class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50)); ?>
        <?php echo $form->textFieldRow($model, 'kelasbpjs_id', array('class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50)); ?>
        <?php echo $form->textFieldRow($model, 'kelasnaikbpjs_id', array('class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50)); ?>
        <div class="control-group">
            <?php echo CHtml::label("", 'kelaspelayanan_aktif', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'kelaspelayanan_aktif'); ?>
                <label for="SAKelasPelayananM_kelaspelayanan_aktif">Aktif</label>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <?php echo $form->labelEx($model, 'Ruangan', array('class' => 'control-label required')); ?>
        <div class="control-group">
            <div class="controls">

                <?php
                $arrRuangan = array();

                foreach ($modRuangan as $Ruangan) {
                    $arrRuangan[] = $Ruangan['ruangan_id'];
                }

                $criInss = new CDbCriteria();
                $criInss->join = " JOIN instalasi_m i ON i.instalasi_id = t.instalasi_id ";
                $criInss->addCondition(" t.ruangan_aktif = TRUE AND i.revenuecenter = TRUE AND i.instalasi_aktif = TRUE ");
                $criInss->order = " t.ruangan_nama ASC ";

                $this->widget(
                    'application.extensions.emultiselect.EMultiSelect',
                    array('sortable' => true, 'searchable' => true)
                );

                echo CHtml::dropDownList(
                    'ruangan_id[]',
                    $arrRuangan,
                    CHtml::listData(SARuanganM::model()->findAll($criInss), 'ruangan_id', 'ruangan_nama'),
                    array('multiple' => 'multiple', 'key' => 'ruangan_id', 'class' => 'multiselect', 'style' => 'width:500px;height:150px')
                );
                ?>

            </div>
        </div>
    </div>
</div>

<div class="form-actions">
    <?php
    echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit'));
    ?>
    <?php
    echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        Yii::app()->createUrl($this->module->id . '/kelasPelayananM/admin'),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    );
    ?>
    <?php
    echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Kelas Pelayanan', array('{icon}' => '<i class="icon-file icon-white"></i>')),
        $this->createUrl(Yii::app()->controller->id . '/admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    );
    $content = $this->renderPartial('../tips/tipsaddedit', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>