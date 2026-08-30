<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'pppenjaminpasien-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
    'focus' => '#' . CHtml::activeId($model, 'carabayar_id'),
)); ?>

<?php echo $form->errorSummary($model); ?>

<div class="row">
    <div class="col-sm-6">
        <?php echo $form->dropDownListRow($model, 'carabayar_id',  CHtml::listData($model->CarabayarItems, 'carabayar_id', 'carabayar_nama'), array('class' => 'span3 form-control', 'onkeyup' => "return $(this).focusNextInputField(event);", 'empty' => '-- Pilih --')); ?>
        <?php echo $form->textFieldRow($model, 'penjamin_nama', array('class' => 'span3 form-control hurufs-only', 'onkeyup' => "namaLain(this)", 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
        <?php echo $form->textFieldRow($model, 'penjamin_namalainnya', array('class' => 'span3 form-control hurufs-only', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 70)); ?>
        <?php echo $form->dropDownListRow(
            $model,
            'jenistarif_id',
            CHtml::listData(JenistarifM::model()->findAll('jenistarif_aktif = true order by jenistarif_nama'), 'jenistarif_id', 'jenistarif_nama'),
            array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")
        ); ?>
        <?php echo $form->textFieldRow($model, 'diskon_klaim', array('class' => 'float2 span1', 'style' => 'width: 60px;', 'onblur' => 'cekPersen(this);', 'onkeypress' => "return nextFocus(this,event,'SAPenjaminPasienM_penjamin_aktif','SAPenjaminPasienM_penjamin_nama')", 'maxlength' => 50)); ?>
        <div class="control-group">
            <?php echo CHtml::label("", 'penjamin_aktif', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'penjamin_aktif', array('checked' => 'checked')); ?> <label>Aktif</label>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'lama_tempo', array('class' => 'numbers-only span1', 'style' => 'text-align: right; width: 60px;', 'onkeypress' => "return nextFocus(this,event,'SAPenjaminPasienM_penjamin_aktif','SAPenjaminPasienM_penjamin_nama')", 'maxlength' => 50)); ?>
        <?php echo $form->textFieldRow($model, 'biaya_administrasi', array('class' => 'float2 span1', 'style' => 'width: 60px;', 'onkeypress' => "return nextFocus(this,event,'SAPenjaminPasienM_penjamin_aktif','SAPenjaminPasienM_penjamin_nama')", 'maxlength' => 50)); ?>
        <?php echo $form->textFieldRow($model, 'diskon_rj', array('class' => 'float2 span1', 'style' => 'width: 60px;', 'onblur' => 'cekPersen(this);', 'onkeypress' => "return nextFocus(this,event,'SAPenjaminPasienM_penjamin_aktif','SAPenjaminPasienM_penjamin_nama')", 'maxlength' => 50)); ?>
        <?php echo $form->textFieldRow($model, 'diskon_rd', array('class' => 'float2 span1', 'style' => 'width: 60px;', 'onblur' => 'cekPersen(this);', 'onkeypress' => "return nextFocus(this,event,'SAPenjaminPasienM_penjamin_aktif','SAPenjaminPasienM_penjamin_nama')", 'maxlength' => 50)); ?>
        <?php echo $form->textFieldRow($model, 'diskon_ri', array('class' => 'float2 span1', 'style' => 'width: 60px;', 'onblur' => 'cekPersen(this);', 'onkeypress' => "return nextFocus(this,event,'SAPenjaminPasienM_penjamin_aktif','SAPenjaminPasienM_penjamin_nama')", 'maxlength' => 50)); ?>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        Yii::app()->createUrl($this->module->id . '/penjaminpasienM/admin'),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Penjamin Pasien', array('{icon}' => '<i class="entypo-folder"></i>')),
        $this->createUrl('/pendaftaranPenjadwalan/penjaminpasienM/Admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success')
    ); ?>
    <?php
    $content = $this->renderPartial('../tips/tipsaddedit2b', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>

<script type="text/javascript">
    function namaLain(nama) {
        document.getElementById('PPPenjaminpasienM_penjamin_namalainnya').value = nama.value.toUpperCase();
    }

    function cekPersen(obj) {
        var v = parseFloat(unformatNumber($(obj).val()));
        if (v > 100) {
            $(obj).val('100,00');
            myAlert("Nilai boleh lebih dari 100%");
        }
    }
</script>