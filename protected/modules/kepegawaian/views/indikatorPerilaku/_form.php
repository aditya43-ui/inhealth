<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'kpindikatorperilaku-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
)); ?>
<div class="row">
    <!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                                ?></p>-->
    <?php echo $form->errorSummary($model); ?>
    <div class="col-sm-6">
        <?php echo $form->dropDownListRow(
            $model,
            'jabatan_id',
            CHtml::listData(KPJabatanM::model()->getJabatanItems(), 'jabatan_id', 'jabatan_nama'),
            array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3')
        ); ?>
        <?php echo $form->dropDownListRow(
            $model,
            'jenispenilaian_id',
            CHtml::listData(KPJenispenilaianM::model()->getJenisPenilaianItems(), 'jenispenilaian_id', 'jenispenilaian_nama'),
            array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3')
        ); ?>
        <?php echo $form->dropDownListRow(
            $model,
            'kompetensi_id',
            CHtml::listData(KPKompetensiM::model()->getKompetensiItems(), 'kompetensi_id', 'kompetensi_nama'),
            array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3')
        ); ?>
        <?php echo $form->textAreaRow($model, 'indikatorperilaku_nama', array('placeholder' => 'Nama Indikator Perilaku', 'rows' => 2, 'cols' => 50, 'class' => 'span3', 'onkeyup' => "namaLain(this)", 'maxlength' => 300)); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textAreaRow($model, 'indikatorperilaku_namalain', array('placeholder' => 'Nama Lain Indikator Perilaku', 'rows' => 2, 'cols' => 50, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 300)); ?>
        <?php echo $form->textFieldRow($model, 'indikatorperilaku_urutan', array('placeholder' => '00', 'class' => 'span1 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 3, 'style' => 'text-align:right;')); ?>
        <div class="control-group">
            <?php echo CHtml::label('Bobot Nilai Indikator (%)', 'bobot_penilaian', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'bobotnilai_indikator', array('placeholder' => '00', 'class' => 'span1 integer', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label"></label>
            <div class="controls">
                <?php echo $form->checkBox($model, 'indikatorperilaku_aktif'); ?>
                <label for="KPIndikatorperilakuM_indikatorperilaku_aktif">Aktif</label>
            </div>
        </div>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl('create'),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'return refreshForm(this);'
        )
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Indikator Perilaku', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php
    $content = $this->renderPartial('kepegawaian.views.tips.tipsaddedit', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>
<script type="text/javascript">
    function namaLain(nama) {
        document.getElementById('KPIndikatorperilakuM_indikatorperilaku_namalain').value = nama.value.toUpperCase();
    }
</script>