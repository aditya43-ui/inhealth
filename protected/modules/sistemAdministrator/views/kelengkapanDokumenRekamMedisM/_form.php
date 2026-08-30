<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'kelengkapandokumen-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
    
)); ?>


<?php echo $form->errorSummary(array($model)); ?>

<div class="row">
    <div class="col-sm-6">
        <?php echo $form->dropDownListRow($model, 'jenisdokumen', LookupM::getItemsUrutan('jenisdokumenkelengkapan_rm'), ['empty' => '--- Pilih ---']) ?>
        <?php echo $form->textFieldRow($model, 'nama_dokumen', array('placeholder' => 'Nama Dokumen', 'class' => 'span4')); ?>
        <?php echo $form->textFieldRow($model, 'urutan_dokumen', array('placeholder' => 'Urutan Dokumen', 'class' => 'span4')); ?>
       
    </div>
    <div class="col-sm-6">
        <?php echo $form->dropDownListRow($model, 'level_dokumen', ['1' => '1', '2' => '2'], ['empty' => '--- Pilih ---', 'onchange' => 'setKelompokDokumen(this)']) ?>
        <?php 
            $listKelompok = [];
            if(!empty($model->kelompok_dokumen)) {
                $kelompoks = KelengkapandokumenRmM::model()->findAll('level_dokumen = 1 and kelengkapandokumen_aktif = true');
                $listKelompok = CHtml::listData($kelompoks, 'nama_dokumen', 'nama_dokumen');
            }
        ?>
        <?php echo $form->dropDownListRow($model, 'kelompok_dokumen', $listKelompok, ['empty' => '--- Pilih ---', 'id' => 'kelompok_dokumen']) ?>
        <?php echo $form->dropDownListRow($model, 'tipe', ['Ada/Tidak Ada' => 'Ada/Tidak Ada', 'Lengkap/Tidak Lengkap' => 'Lengkap/Tidak Lengkap'], ['empty' => '--- Pilih ---']) ?>
        <div class="control-group">
            <label class="control-label">Aktif</label>
            <div class="controls">
                <?php echo $form->checkBox($model, 'kelengkapandokumen_aktif') ?>
            </div>
        </div>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        Yii::app()->createUrl($this->module->id . '/kelengkapanDokumenRekamMedisM/create'),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Kelengkapan Dokumen', array('{icon}' => '<i class="entypo-folder"></i>')),
        $this->createUrl('kelengkapanDokumenRekamMedisM/index', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php
    $content = $this->renderPartial('../tips/tipsaddedit', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>
