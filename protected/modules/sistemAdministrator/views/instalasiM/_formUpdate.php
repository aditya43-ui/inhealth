<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'sainstalasi-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#SAInstalasiM_instalasi_nama',
    'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
)); ?>

<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                            ?></p>-->

<?php echo $form->errorSummary($model); ?>

<div class="row">
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'instalasi_nama', array('placeholder' => 'Nama Instalasi', 'class' => 'span4', 'onkeyup' => "namaLain(this)", 'onkeypress' => "return nextFocus(this,event,'SAInstalasiM_instalasi_namalainnya','')", 'maxlength' => 50)); ?>
        <?php echo $form->textFieldRow($model, 'instalasi_namalainnya', array('placeholder' => 'Nama Lainnya', 'class' => 'span4', 'onkeypress' => "return nextFocus(this,event,'SAInstalasiM_instalasi_singkatan','SAInstalasiM_instalasi_nama')", 'maxlength' => 50)); ?>
        <?php echo $form->textFieldRow($model, 'instalasi_singkatan', array('placeholder' => 'Singkatan', 'class' => 'span4', 'onkeypress' => "return nextFocus(this,event,'SAInstalasiM_instalasi_lokasi','SAInstalasiM_instalasi_namalainnya')", 'maxlength' => 2)); ?>
        <?php echo $form->textFieldRow($model, 'instalasi_lokasi', array('placeholder' => 'Lokasi Instalasi', 'class' => 'span4', 'onkeypress' => "return nextFocus(this,event,'btn_simpan','SAInstalasiM_instalasi_singkatan')", 'maxlength' => 50)); ?>
        <?php echo $form->textAreaRow($modRiwayatRuanganR, 'tentangpenetapan', array('placeholder' => 'Tentang Penetapan', 'rows' => 6, 'cols' => 50, 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Pusat Pendapatan', 'revenuecenter', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->radioButton($model, 'revenuecenter', array('value' => 1, 'uncheckValue' => null)) . ' Ya &nbsp;&nbsp;'; ?>
                <?php echo $form->radioButton($model, 'revenuecenter', array('value' => 0, 'uncheckValue' => null)) . ' Tidak'; ?>
            </div>
        </div>
        <?php //echo $form->textFieldRow($model,'instalasirujukaninternal',array('class'=>'span3', 'onkeypress'=>"return nextFocus(this,event,'SAInstalasiM_instalasi_namalainnya','')", 'maxlength'=>50)); 
        ?>
        <div class="control-group">
            <?php echo CHtml::label('Rujukan Internal', 'instalasirujukaninternal', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->radioButton($model, 'instalasirujukaninternal', array('value' => 1, 'uncheckValue' => null)) . ' Ya &nbsp;&nbsp;'; ?>
                <?php echo $form->radioButton($model, 'instalasirujukaninternal', array('value' => 0, 'uncheckValue' => null)) . ' Tidak'; ?>
            </div>
        </div>
        <?php //echo $form->textFieldRow($model,'instalasirujukaninternal',array('class'=>'span3', 'onkeypress'=>"return nextFocus(this,event,'SAInstalasiM_instalasi_namalainnya','')", 'maxlength'=>50)); 
        ?>
        <?php echo $form->dropDownListRow($model, 'instalasi_adakamar', array('' => '-- Pilih --', 1 => 'Ya', 0 => 'Tidak'), array('class' => 'span3', 'onkeypress' => "return nextFocus(this,event,'SAInstalasiM_instalasi_singkatan','SAInstalasiM_instalasi_nama')", 'maxlength' => 50)); ?>
        <div class="control-group">
            <?php echo $form->labelEx($modRiwayatRuanganR, 'tglpenetapanruangan', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $modRiwayatRuanganR,
                    'attribute' => 'tglpenetapanruangan',
                    'mode' => 'date',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                        'maxDate' => 'd',
                        'yearRange' => "-60:+0",
                    ),
                    'htmlOptions' => array(
                        'readonly' => true, 'class' => 'span3 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                    ),
                )); ?>
                <?php echo $form->error($modRiwayatRuanganR, 'tglpenetapanruangan'); ?>
            </div>
        </div>
        <?php echo $form->textFieldRow($modRiwayatRuanganR, 'nopenetapanruangan', array('placeholder' => 'No. Penetapan', 'class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'instalasi_image', array('class' => 'control-label', 'onkeypress' => "return nextFocus(this,event,'SAProfilRumahSakitM_tgl_suratizin','SAProfilRumahSakitM_visi')")) ?>
            <div class="controls">
                <img src="<?php echo Params::urlInstalasiTumbsDirectory() . 'kecil_' . $model->instalasi_image ?> "><br>
                <?php echo Chtml::activeFileField($model, 'instalasi_image', array('maxlength' => 254, 'hint' => 'Isi Jika Akan Menambahkan Logo')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("", 'instalasi_aktif', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'instalasi_aktif', array('checked' => 'checked')); ?>
                <label for="SAInstalasiM_instalasi_aktif">Aktif</label>
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
        Yii::app()->createUrl($this->module->id . '/instalasiM/admin'),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Instalasi', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('instalasiM/admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php
    $content = $this->renderPartial('../tips/tipsaddedit', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>

<script type="text/javascript">
    function namaLain(nama) {
        document.getElementById('SAInstalasiM_instalasi_namalainnya').value = nama.value.toUpperCase();
    }
</script>