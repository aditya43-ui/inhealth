<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'sakelurahan-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#propinsi',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
));
?>

<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                            ?></p>-->
<?php echo $form->errorSummary($model); ?>
<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Provinsi', 'propinsi', array('class' => "control-label")) ?>
            <div class="controls">
                <?php
                echo CHtml::dropDownList('propinsi', $model->getPropinsiItemsKec($model->kecamatan_id), CHtml::listData($model->PropinsiItems, 'propinsi_id', 'propinsi_nama'), array(
                    'empty' => '-- Pilih --',
                    'class' => 'span3',
                    'onkeypress' => "return $(this).focusNextInputField(event)",
                    'ajax' => array(
                        'type' => 'POST',
                        'url' => Yii::app()->createUrl('sistemAdministrator/kelurahanM/DynamicKabupaten', array('encode' => false, 'namaModel' => '', 'attr' => 'propinsi')),
                        'update' => '#kabupaten',
                    )
                ));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Kabupaten', 'kabupaten', array('class' => "control-label")) ?>
            <div class="controls">
                <?php
                echo CHtml::dropDownList('kabupaten', $model->getKabupatenItemsKec($model->kecamatan_id), CHtml::listData($model->KabupatenItems, 'kabupaten_id', 'kabupaten_nama'), array(
                    'empty' => '-- Pilih --',
                    'class' => 'span3',
                    'onkeypress' => "return $(this).focusNextInputField(event)",
                    'ajax' => array(
                        'type' => 'POST',
                        'url' => Yii::app()->createUrl('sistemAdministrator/kelurahanM/DynamicKecamatan', array('encode' => false, 'namaModel' => '', 'attr' => 'kabupaten')),
                        'update' => '#SAKelurahanM_kecamatan_id',
                    )
                ));
                ?>
            </div>
        </div>

        <?php echo $form->dropDownListRow($model, 'kecamatan_id', CHtml::listData($model->KecamatanItems, 'kecamatan_id', 'kecamatan_nama'), array('class' => 'span3', 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'kelurahan_nama', array('placeholder' => 'Kelurahan', 'class' => 'span3', 'onkeyup' => "namaLain(this)", 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50, 'onkeypress' => "return $(this).focusNextInputField(event)",)); ?>
        <?php echo $form->textFieldRow($model, 'kelurahan_namalainnya', array('placeholder' => 'Nama Lain', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50, 'onkeypress' => "return $(this).focusNextInputField(event)",)); ?>
        <?php echo $form->textFieldRow($model, 'kode_pos', array('placeholder' => 'Kode Pos', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 15, 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
        <div class="control-group">
            <?php echo CHtml::label("", 'kelurahan_aktif', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'kelurahan_aktif'); ?>
                <label for="SAKelurahanM_kelurahan_aktif">Aktif</label>
            </div>
        </div>
    </div>
</div>

<div class="form-actions">
    <?php
    echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)'));
    ?>
    <?php
    echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), Yii::app()->createUrl($this->module->id . '/kelurahanM/admin'), array(
        'class' => 'btn btn-default',
        'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
    ));
    ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Kelurahan', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    );
    ?>
    <?php
    $content = $this->renderPartial($this->path_tips . 'tipsaddedit', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>

<script type="text/javascript">
    function namaLain(nama) {
        document.getElementById('SAKelurahanM_kelurahan_namalainnya').value = nama.value.toUpperCase();
    }
</script>