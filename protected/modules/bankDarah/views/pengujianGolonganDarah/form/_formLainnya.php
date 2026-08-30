<?php

/**
 * @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @digunakan   - digunakan sebagai form inputan lainnya seperti tangal pengujian, petugas tombol submit dan lainnya
 */
?>
<div class="clear"></div>
<div class="col-sm-6">
    <div class="control-group">
        <label class="control-label">Waktu Pemeriksaan <span class="required">*</span></label>
        <div class="controls">
            <?php
            $this->widget('MyDateTimePicker', array(
                'model' => $model,
                'attribute' => 'tglujidarahpasien',
                'mode' => 'datetime',
                'options' => array(
                    'dateFormat' => Params::DATE_FORMAT,
                    'maxDate' => 'd',
                ),
                'htmlOptions' => array(
                    'readonly' => true, 'class' => 'dtPicker3 readonly', 'onkeypress' => "return $(this).focusNextInputField(event)", 'style' => 'width:150px;'
                ),
            ));
            ?>
        </div>
    </div>

    <?= $form->radioButtonListInlineRow($modHasilUjiCocok, 'dinas', [
        'Pagi' => 'Pagi',
        'Siang' => 'Siang',
        'Sore' => 'Sore'
    ]) ?>
    
</div>

<div class="col-sm-6">
    <?php 
        $dataPegawai = PegawairuanganV::model()->findAll('pegawai_aktif is true and ruangan_id =' . Params::RUANGAN_ID_BANK_DARAH);
    ?>
    <div class="control-group">
        <label class="control-label">Pemeriksa I</label>
        <div class="controls">
            <?php
                echo $form->DropDownList($modHasilUjiCocok, 'peg_pemeriksa1_id', CHtml::listData($dataPegawai, 'pegawai_id', 'namaLengkap'), ['empty' => '-- Pilih --', 'class' => 'dropdownpencarian']);
            ?>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">Pemeriksa II</label>
        <div class="controls">
            <?php
                echo $form->DropDownList($modHasilUjiCocok, 'peg_pemeriksa2_id', CHtml::listData($dataPegawai, 'pegawai_id', 'namaLengkap') , ['empty' => '-- Pilih --', 'class' => 'dropdownpencarian']);
            ?>
        </div>
    </div>
</div>
<div class="clear"></div>
<div class="form-actions">
    <?php
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai

    if (!isset($_GET['sukses']) && empty($modRiwayatGolDar)) {
        echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="' . MyIcon::getIcons('simpan') . '"></i>')) :
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array(
            'class' => (!isset($_GET['sukses'])) ? 'btn btn-danger' : 'btn btn-danger submit', 'title' => 'Simpan', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)'
        ));

    } else {
        echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="' . MyIcon::getIcons('simpan') . '"></i>')) :
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array(
            'class' => (isset($_GET['sukses'])) ? 'btn btn-primary' : 'btn btn-primary', 'title' => 'Simpan', 'type' => 'button', 'onKeypress' => 'return formSubmit(this,event)', 'disabled' => true
        ));

        echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Tombol akan aktif setelah data tersimpan', 'class' => 'btn btn-info', 'onclick' => "alert('segera hadir')"));
    }
    ?>
    <?php
    echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), Yii::app()->createUrl($module . '/' . $controller . '/index', array('pendaftaran_id' => $modPendaftaran->pendaftaran_id)), array(
        'title' => 'Ulang',
        'class' => 'btn btn-default',
        'onclick' => 'if(!confirm("Apakah Anda yakin ingin mengulang ini?")) return false;'
    ));
    ?>
    <?php
    $content = $this->renderPartial('rawatJalan.views.tips.tips', array(), true);
    $this->widget('UserTips', array('type' => 'admin', 'content' => $content));
    ?>
</div>