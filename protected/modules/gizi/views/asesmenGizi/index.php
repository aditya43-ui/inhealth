<?php

$this->widget('bootstrap.widgets.BootAlert');

echo $this->renderPartial($this->path_view . '_listAsesmenGizi', array(
    'pendaftaran_id' => $modPendaftaran->pendaftaran_id,
    'pasienmasukpenunjang_id' => $model->pasienmasukpenunjang_id,
), true);

$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'rjanamnesa-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return cekValidasi()'),
    'focus' => '#',
));
?>

<div class="col-sm-6">
    <div class="control-group">
        <?php echo $form->labelEx($model, 'tgl_konsultasi', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php
            $this->widget('MyDateTimePicker', array(
                'model' => $model,
                'attribute' => 'tgl_konsultasi',
                'mode' => 'datetime',
                'options' => array(
                    'dateFormat' => Params::DATE_FORMAT,
                    'maxDate' => 'd',
                ),
                'htmlOptions' => array(
                    'readonly' => true,
                    'onkeypress' => "return $(this).focusNextInputField(event)"
                ),
            ));
            ?>
        </div>

    </div>
    <div class="control-group">
        <?php /*echo CHtml::label('Ahli Gizi', 'Ahli Gizi', array('class' => 'control-label'))*/ ?>
        <?php echo $form->labelEx($model, 'ahligizi_id', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php
            echo $form->dropDownList(
                $model,
                'ahligizi_id',
                CHtml::listData($model->getAhliGiziItems(), 'pegawai_id', 'namaLengkap'),
                array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'empty' => '-- Pilih --')
            );
            ?>

        </div>
    </div>
</div>
<div class="col-sm-6">

    <?php echo CHtml::label('Diagnosa', 'Diagnosa', array('class' => 'control-label')) ?>
    <div class="controls">
        <?php
        echo $form->textArea($model, 'diagnosa', array('class' => 'span5', 'onkeypress' => "return $(this).focusNextInputField(event);"));
        ?>

    </div>
</div>
<div class="clear"></div>
<hr>
<div class="col-sm-6">
    <div class="control-group">
        <?php echo $form->label($model, 'frekuensi_makan', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo $form->textField($model, 'frekuensi_makan', array('class' => 'span1 numbers-only')) . " " . CHtml::label(" Kali/Hari", ''); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo $form->label($model, 'frekuensi_selingan', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo $form->textField($model, 'frekuensi_selingan', array('class' => 'span1 numbers-only')) . " " . CHtml::label(" Kali/Hari", ''); ?>
        </div>
    </div>
</div>
<div class="col-sm-6">
    <div class="control-group">
        <?php echo $form->label($model, 'alergi_makanan', array('class' => 'control-label')) ?>
        <div class="controls">
            <label class="radio">
                <?php echo $form->radioButton($model, 'alergi_makanan', array('value' => 0)) . CHtml::label(" Tidak", ''); ?>
          </label>
            <label class="radio">
                <?php echo $form->radioButton($model, 'alergi_makanan', array('value' => 1)) . CHtml::label(" Ya, Jenis", ''); ?>
                <?php echo $form->textField($model, 'alergi_makanan_jenis', array('class' => 'span3')); ?>
          </label>
        </div>
    </div>
    <div class="control-group">
        <?php echo $form->label($model, 'pantangan_makanan', array('class' => 'control-label')) ?>
        <div class="controls">
            <label class="radio">
                <?php echo $form->radioButton($model, 'pantangan_makanan', array('value' => 0)) . CHtml::label(" Tidak", ''); ?>
          </label>
            <label class="radio">
                <?php echo $form->radioButton($model, 'pantangan_makanan', array('value' => 1)) . CHtml::label(" Ya, Jenis", ''); ?>
                <?php echo $form->textField($model, 'pantangan_makanan_jenis', array('class' => 'span3')); ?>
          </label>
        </div>
    </div>
</div>
<div class="clear"></div>
<hr>
<div class="col-sm-12">
    <div class="control-group">
        <?php echo $form->label($model, 'kebiasaan_makan_penyakit', array('class' => 'control-label')) ?>
        <div class="controls" style="width: 50%">
            <?php echo $form->textArea($model, 'kebiasaan_makan_penyakit', array('class' => 'span10')); ?>
        </div>
    </div>

</div>
<hr>
<!-- <div class="col-sm-12"> -->

    <?php

    // $det = AsesmengiziitemM::model()->findAllByAttributes(array(
    //     'asesmengiziitem_aktif' => true,
    // ), array(
    //     'order' => 'asesmengiziitem_id'
    // ));

    // foreach ($det as $item) :

    //     $det = new AsesmengizidetT();
    //     $det->asesmengiziitem_id = $item->asesmengiziitem_id;

    ?>
        <!-- <div class="control-group"> -->
            <?php //echo CHtml::label($item->asesmengiziitem_nama, '', array('class' => 'control-label')) ?>
            <!-- <div class="controls" style="width: 50%"> -->
                <?php //echo $form->hiddenField($det, '[' . $det->asesmengiziitem_id . ']asesmengiziitem_id'); ?>
                <?php //echo $form->textArea($det, '[' . $det->asesmengiziitem_id . ']nilai', array('class' => 'span10')); ?>
            <!-- </div> -->
        <!-- </div> -->

    <!-- <?php //endforeach;  ?> -->

<!-- </div>

<hr> -->
<div class="col-sm-6">
    <div class="control-group">
        <?php echo $form->label($model, 'antropometri', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php $this->widget('ext.redactorjs.Redactor', array('model' => $model, 'attribute' => 'antropometri', 'toolbar' => 'mini', 'height' => '200px')) ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo $form->label($model, 'klinik_fisik', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php $this->widget('ext.redactorjs.Redactor', array('model' => $model, 'attribute' => 'klinik_fisik', 'toolbar' => 'mini', 'height' => '200px')) ?>
        </div>
    </div>
</div>
<div class="col-sm-6">
    <div class="control-group">
        <?php echo $form->label($model, 'biokimia', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php $this->widget('ext.redactorjs.Redactor', array('model' => $model, 'attribute' => 'biokimia', 'toolbar' => 'mini', 'height' => '200px')) ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo $form->label($model, 'riwayat_gizi_penyakit', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php $this->widget('ext.redactorjs.Redactor', array('model' => $model, 'attribute' => 'riwayat_gizi_penyakit', 'toolbar' => 'mini', 'height' => '200px')) ?>
        </div>
    </div>
</div>

<div class="clear"></div>
<div class="col-sm-12">
    <div class="control-group">
        <?php echo $form->label($model, 'diagnosis_gizi', array('class' => 'control-label')) ?>
        <div class="controls" style="width: 76%">
            <?php $this->widget('ext.redactorjs.Redactor', array('model' => $model, 'attribute' => 'diagnosis_gizi', 'toolbar' => 'mini', 'height' => '200px')) ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo $form->label($model, 'intervensi_gizi', array('class' => 'control-label')) ?>
        <div class="controls" style="width: 76%">
            <?php $this->widget('ext.redactorjs.Redactor', array('model' => $model, 'attribute' => 'intervensi_gizi', 'toolbar' => 'mini', 'height' => '200px')) ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo $form->label($model, 'monitoringevaluasi_gizi', array('class' => 'control-label')) ?>
        <div class="controls" style="width: 76%">
            <?php $this->widget('ext.redactorjs.Redactor', array('model' => $model, 'attribute' => 'monitoringevaluasi_gizi', 'toolbar' => 'mini', 'height' => '200px')) ?>
        </div>
    </div>
</div>
</div>
</div>

<div class="clear"></div>

<div class="form-actions">
    <?php
    echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'id' => 'btn_simpan'));
    ?>
    <?php
    $tips = array(
        '0' => 'waktutime',
        '1' => 'autocomplete-search',
        '2' => 'simpan'
    );
    $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips' => $tips), true);
    $this->widget('UserTips', array('type' => 'admin', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>