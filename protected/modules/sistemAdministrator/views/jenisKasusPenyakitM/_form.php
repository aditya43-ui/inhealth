<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'sajenis-kasus-penyakit-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#SAJenisKasusPenyakitM_jeniskasuspenyakit_nama',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
));

$cs = Yii::app()->clientScript;
$cs->scriptMap = array(
    'bootstrap-multiselect.js' => false,
);
?>
<!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') 
                            ?></p>-->
<?php echo $form->errorSummary($model); ?>

<div class="row">
    <div class="col-sm-6">
            <?php echo $form->textFieldRow($model, 'jeniskasuspenyakit_nama', array('placeholder' => 'Nama Kasus Penyakit', 'class' => 'span3 form-control hurufs-only', 'onkeyup' => "namaLain(this)", 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
            <?php echo $form->textFieldRow($model, 'jeniskasuspenyakit_namalainnya', array('placeholder' => 'Nama Lainnya', 'class' => 'span3 form-control hurufs-only', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
            <?php echo $form->textFieldRow($model, 'jeniskasuspenyakit_urutan', array('placeholder' => '00', 'style' => 'text-align:right;', 'class' => 'form-control numbers-only', 'onkeypress' => "return $(this).focusNextInputField(event);", 'size' => 4)); ?>
            <div class="control-group">
                <?php echo $form->labelEx($model, 'statusrawat_kemenkes', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->hiddenField($model, 'statusrawat_kemenkes_nama'); ?>
                    <?php echo $form->dropDownList($model, 'statusrawat_kemenkes', array(), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label"></label>
                <div class="controls">
                    <?php echo $form->checkBox($model, 'jeniskasuspenyakit_aktif', array('checked' => 'checked')); ?>
                    <label for="SAJenisKasusPenyakitM_jeniskasuspenyakit_aktif">Aktif</label>
                </div>
            </div>
    </div>
    <div class="col-sm-6">
            <?php echo $form->labelEx($model, 'ruangan_id', array('class' => 'control-label required')); ?>
            <div class="control-group">
                <div class="controls">
                    <?php
                    $arrRuangan = array();
                    if (count((array)$modRuangan) > 0) {
                        foreach ($modRuangan as $Ruangan) {
                            $arrRuangan[] = $Ruangan['ruangan_id'];
                        }
                    }
                    $this->widget(
                        'application.extensions.emultiselect.EMultiSelect',
                        array('sortable' => true, 'searchable' => true)
                    );
                    echo CHtml::dropDownList(
                        'ruangan_id[]',
                        $arrRuangan,
                        CHtml::listData(SARuanganM::model()->findAll("ruangan_aktif = TRUE ORDER BY ruangan_nama ASC"), 'ruangan_id', 'ruangan_nama'),
                        array('multiple' => 'multiple', 'key' => 'ruangan_id', 'class' => 'multiselect', 'style' => 'width:500px;height:150px')
                    );
                    ?>

                </div>
            </div>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl('admin'),
        array(
            'class' => 'btn btn-default', 'title' => 'Ulang',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php
    echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Jenis Kasus Penyakit', array('{icon}' => '<i class="entypo-folder"></i>')),
        $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ) . "&nbsp";
    $content = $this->renderPartial($this->path_view . 'tips.tipsCreateUpdate', array(), true);
    $this->widget('UserTips', array('content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>

<script type="text/javascript">
    function namaLain(nama) {
        document.getElementById('SAJenisKasusPenyakitM_jeniskasuspenyakit_namalainnya').value = nama.value.toUpperCase();
    }

    function changeStatusRawatKemenkes() {
        var statusRawat = $('#<?php echo CHtml::activeId($model, 'statusrawat_kemenkes_nama'); ?>').val();

        $.ajax({
            type: 'GET',
            url: '<?php echo $this->createUrl('SetDropdownStatusRawatKemenkes'); ?>',
            data: {
                statusrawatkemenkes: statusRawat
            },
            dataType: "json",
            success: function(data) {
                $("#<?php echo CHtml::activeId($model, 'statusrawat_kemenkes') ?>").empty();
                $("#<?php echo CHtml::activeId($model, 'statusrawat_kemenkes') ?>").html(data.form);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    $(document).ready(function() {
        changeStatusRawatKemenkes();
    });
</script>