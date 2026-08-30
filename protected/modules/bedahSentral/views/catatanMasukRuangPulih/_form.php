<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'pasienruangpulih-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
));
?>

<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                            ?></p>-->

<?php echo $form->errorSummary($model); ?>
<?php echo $form->hiddenField($model, 'pasien_id', array('class' => 'span3 integer', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
<?php echo $form->hiddenField($model, 'pendaftaran_id', array('class' => 'span3 integer', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
<?php echo $form->hiddenField($model, 'pasienadmisi_id', array('class' => 'span3 integer', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
<div class="col-sm-6">
    <div class="control-group">
        <?php echo $form->label($model, 'masukruanganpulih_tanggal', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php

            if (!empty($model->masukkamar_id)) {
                echo $form->textField($model, 'masukruanganpulih_tanggal', array('disabled' => true, 'class' => 'span3'));
            } else {
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'masukruanganpulih_tanggal',
                    'mode' => 'date',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                    ),
                    'htmlOptions' => array(
                        'readonly' => true,
                        'class' => 'span3',
                        'onclick' => "return $(this).focusNextInputField(event)",
                    ),
                ));
            }
            ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo $form->label($model, 'masukruanganpulih_jam', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php

            if (!empty($model->masukkamar_id)) {
                echo $form->textField($model, 'masukruanganpulih_jam', array('disabled' => true, 'class' => 'span3'));
            } else {

                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'masukruanganpulih_jam',
                    'mode' => 'time',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                    ),
                    'htmlOptions' => array(
                        'readonly' => true,
                        'class' => 'span3',
                        'onclick' => "return $(this).focusNextInputField(event)",
                        'disabled' => !empty($model->masukkamar_id),
                    ),
                ));
            }
            ?>
        </div>
    </div>
    <?php
    echo $form->dropDownListRow($model, 'dokteranastesi_id', CHtml::listData($penunjang->getDokterItems(Params::RUANGAN_ID_BEDAH), 'pegawai_id', 'namaLengkap'), array(
        'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
        'class' => 'span3', 'disabled' => !empty($model->masukkamar_id)
    ));
    ?>
    <?php echo $form->dropDownListRow($model, 'perawatanastesi_id', CHtml::listData($penunjang->getParamedisItems(Params::RUANGAN_ID_BEDAH), 'pegawai_id', 'nama_pegawai'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3')); ?>

    <?php echo $form->dropDownListRow($model, 'petugas_saatmasukruangpulih_id', CHtml::listData($penunjang->getParamedisItems(Params::RUANGAN_ID_BEDAH), 'pegawai_id', 'nama_pegawai'), array('empty' => '-- Pilih --', 'class' => 'span3 integer', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
</div>
<div class="col-sm-6">
    <div class="control-group">
        <?php echo $form->labelEx($model, 'ruangan_id', array('class' => 'control-label required', 'label' => 'Ruangan Ruang Pulih <span class="required">*</span>')); ?>
        <div class="controls">
            <?php
            echo $form->dropDownList($pindahkamar, 'ruangan_id', CHtml::listData(RuanganpulihV::model()->findAll(array(
                'order' => 'ruangan_nama'
            )), 'ruangan_id', 'ruangan_nama'), array(
                'empty' => '-- Pilih --',
                'class' => 'span3',
                'onkeyup' => "return $(this).focusNextInputField(event);",
                'onChange' => 'updateKamarRuangan($(this).val());',
                'disabled' => !empty($model->masukkamar_id),
            ));
            ?>
        </div>
    </div>
    <?php
    $kamarList = array();
    if (!empty($pindahkamar->ruangan_id)) {
        $kamarList = CHtml::listData(KamarruanganM::model()->findAllByAttributes(array(
            'ruangan_id' => $pindahkamar->ruangan_id,
        )), 'kamarruangan_id', 'KamarDanTempatTidur');
    }
    ?>
    <div class="control-group">
        <?php echo $form->labelEx($model, 'kamarruangan_id', array('class' => 'control-label required', 'label' => 'Kamar Ruangan/No. Bed <span class="required">*</span>')); ?>
        <div class="controls">
            <?php
            echo $form->dropDownList($pindahkamar, 'kamarruangan_id', $kamarList, array(
                'empty' => '-- Pilih --',
                'class' => 'span3',
                'onkeyup' => "return $(this).focusNextInputField(event);",
                'disabled' => !empty($model->masukkamar_id),
            ));
            ?>
        </div>
    </div>

</div>
<div class="clear"></div>

<div class="col-sm-6">
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">Skor Aldrette</div>
        </div>
        <div class="panel-body">
            <?php echo $this->renderPartial("_skor", array(
                'form' => $form,
                'model' => $model,
            )); ?>
        </div>
    </div>
</div>
<div class="col-sm-6">
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                <i class="glyphicon glyphicon-briefcase"></i> Penatalaksaan Nyeri Pasca Bedah
            </div>
        </div>
        <div class="panel-body">
            <?php echo $this->renderPartial("_tataLaksana", array(
                'form' => $form,
                'model' => $model,
            )); ?>
        </div>
    </div>
</div>
<div class="clear"></div>

<?php /*
  <div class="row">

  <div class="col-sm-4">
  <?php echo $form->hiddenField($model,'asesmentnyeri_id',array('class'=>'span3 integer', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
  <?php echo $form->hiddenField($model,'masukkamar_id',array('class'=>'span3 integer', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
  <?php echo $form->textFieldRow($model,'tindaklanjutpasien_masukkamar_id',array('class'=>'span3 integer', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
  <?php echo $form->textFieldRow($model,'totalskor_aldrettemasukrpulih',array('class'=>'span3 integer', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
  <?php echo $form->checkBoxRow($model,'isdisposableinfuspump', array('onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
  <?php echo $form->textFieldRow($model,'disposableinfuspump_ket',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>200)); ?>
  <?php echo $form->checkBoxRow($model,'ismelaluicathepidural', array('onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
  <?php echo $form->textFieldRow($model,'melaluicathepidural_ket',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>200)); ?>
  <?php echo $form->checkBoxRow($model,'istatalaksananyerilainnya', array('onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
  <?php echo $form->textFieldRow($model,'istatalaksananyerilainnya_ket',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>200)); ?>
  <?php echo $form->textFieldRow($model,'keluarruanganpulih_tanggal',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
  <?php echo $form->textFieldRow($model,'keluarruanganpulih_jam',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
  <?php echo $form->textFieldRow($model,'petugas_saatkeluarruangpulih_id',array('class'=>'span3 integer', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
  </div>
  <div class="col-sm-4">
  <?php echo $form->textFieldRow($model,'score_skalanyeri',array('class'=>'span3 integer', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
  <?php echo $form->textFieldRow($model,'keteranganskala_nyeri',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
  <?php echo $form->textFieldRow($model,'totalskor_aldrettekeluarrpulih',array('class'=>'span3 integer', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
  <?php echo $form->textAreaRow($model,'instruksi_bilanyeri',array('rows'=>6, 'cols'=>50, 'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
  <?php echo $form->textAreaRow($model,'intruksi_mualmuntah',array('rows'=>6, 'cols'=>50, 'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
  <?php echo $form->textAreaRow($model,'instruksi_infus',array('rows'=>6, 'cols'=>50, 'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
  <?php echo $form->textAreaRow($model,'instruksi_makanminum',array('rows'=>6, 'cols'=>50, 'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
  <?php echo $form->textAreaRow($model,'instruksi_obat',array('rows'=>6, 'cols'=>50, 'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
  <?php echo $form->textFieldRow($model,'tindaklanjutpasien',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
  <?php echo $form->textFieldRow($model,'tindaklanjutpasien_ruanganrawat_id',array('class'=>'span3 integer', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
  <?php echo $form->textFieldRow($model,'tindaklanjutpasien_kamarruangan_id',array('class'=>'span3 integer', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
  <?php echo $form->textFieldRow($model,'create_time',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
  <?php echo $form->textFieldRow($model,'update_time',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
  <?php echo $form->textFieldRow($model,'create_loginpemakai_id',array('class'=>'span3 integer', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
  <?php echo $form->textFieldRow($model,'update_loginpemakai_id',array('class'=>'span3 integer', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
  <?php echo $form->textFieldRow($model,'create_ruangan',array('class'=>'span3 integer', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
  </div>
  <div class="col-sm-4">

  </div>
  </div>
 * 
 */ ?>

<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')); ?>
    <?php
    echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl('create', array('pasienmasukpenunjang_id' => $model->pasienmasukpenunjang_id)),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'return refreshForm(this);'
        )
    );
    ?>
    <?php // echo CHtml::link(Yii::t('mds', '{icon} Pengaturan PasienruangpulihT', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')), $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',)); 
    ?>
    <?php $this->widget('UserTips', array('content' => '')); ?>
</div>

<?php $this->endWidget(); ?>

<script>
    function updateKamarRuangan(ruangan_id) {
        var idRuangan = ruangan_id
        jQuery.ajax({
            'type': 'POST',
            'url': '<?php echo $this->createUrl('getKamarKosong', array('encode' => false, 'namaModel' => 'PindahkamarT')); ?>',
            'cache': false,
            'data': {
                ruangan_id: idRuangan,
                all_kamar: true
            },
            'success': function(html) {
                jQuery("#PindahkamarT_kamarruangan_id").html(html);
            }
        });
    }
</script>