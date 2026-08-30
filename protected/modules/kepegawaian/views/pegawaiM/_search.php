<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'sapegawai-m-search',
    'type' => 'horizontal',
)); ?>
<div class="row">
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'nofingerprint', array('placeholder' => 'No. Fingerprint', 'class' => 'span3', 'maxlength' => 50)); ?>
        <?php echo $form->textFieldRow($model, 'nomorindukpegawai', array('placeholder' => 'NIP', 'class' => 'span3', 'maxlength' => 30)); ?>
        <?php echo $form->textFieldRow($model, 'nama_pegawai', array('placeholder' => 'Nama Pegawai', 'class' => 'span3', 'maxlength' => 30)); ?>
        <?php echo $form->dropDownListRow($model, 'jeniskelamin', LookupM::getItems('jeniskelamin'), array('empty' => '-- Pilih --', 'class' => 'span3')); ?>
        <?php echo $form->dropDownListRow(
            $model,
            'instalasi_id',
            CHtml::listData(InstalasiM::model()->findAll("instalasi_aktif = TRUE ORDER BY instalasi_nama ASC"), 'instalasi_id', 'instalasi_nama'),
            array(
                'class' => 'span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                'ajax' => array(
                    'type' => 'POST',
                    'url' => $this->createUrl('/ActionDynamic/GetRuanganDariInstalasi', array('encode' => false, 'namaModel' => get_class($model))),
                    'update' => "#" . CHtml::activeId($model, 'ruangan_id'),
                )
            )
        );
        ?>
        <?php echo $form->dropDownListRow($model, 'ruangan_id', array(), array('class' => 'span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->dropDownListRow($model, 'pegawai_aktif', array(true => 'Aktif', false => 'Tidak Aktif'), array('class' => 'span3', 'empty' => '-- Pilih --', 'onchange' => 'changePegawaiAktif(this)')); ?>
        <div class="control-group" id="tglberhentidiv" style="display: none">
            <?php echo CHtml::label("Tgl. Berhenti", '', array('class' => 'control-label')) ?>
            <div class="controls">
                <div class="daterange daterange-inline input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tglberhenti_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tglberhenti_akhir)) ?>">
                    <i class="entypo-calendar"></i>
                    <span><?php echo date('d M Y', strtotime($model->tglberhenti_awal)) ?> - <?php echo date('d M Y', strtotime($model->tglberhenti_akhir)) ?></span>
                    <?php echo $form->hiddenField($model, 'tglberhenti_awal', array('class' => 'start')) ?>
                    <?php echo $form->hiddenField($model, 'tglberhenti_akhir', array('class' => 'end')) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <?php echo $form->dropDownListRow($model, 'unitkerja_id', $model->getDropUnitKerjaItems(), array('empty' => '-- Pilih --')); ?>
        <?php echo $form->dropDownListRow($model, 'kategoripegawai', LookupM::getItems('kategoripegawai'), array('empty' => '-- Pilih --')); ?>
        <?php echo $form->dropDownListRow($model, 'kelompokpegawai_id', $model->getDropKelompokPegItems(), array('empty' => '-- Pilih --')); ?>
        <?php echo $form->dropDownListRow($model, 'agama', LookupM::getItems('agama'), array('empty' => '-- Pilih --')); ?>
        <?php echo $form->dropDownListRow($model, 'statusperkawinan', LookupM::getItems('statusperkawinan'), array('empty' => '-- Pilih --')); ?>
        <?php echo $form->dropDownListRow(
            $model,
            'jabatan_id',
            CHtml::listData($model->getJabatanItems(), 'jabatan_id', 'jabatan_nama'),
            array(
                'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
            )
        ); ?>
    </div>
</div>
<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        Yii::app()->createUrl($this->module->id . '/pegawaiM/informasi'),
        array(
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'disabled' => false, 'type' => 'button', 'onclick' => 'printInfo(\'EXCEL\')'));
    echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel - Pegawai', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'printPegawai(\'EXCEL\')'));
    ?>
    <?php
    $tips = array(
        '0' => 'simpan',
        '1' => 'ulang',
        '2' => 'masterEXCEL',
    );
    $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips' => $tips), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>
<?php $this->endWidget(); ?>
<script type="text/javascript">
    function changePegawaiAktif(obj) {
        if ($(obj).val() === '0') {
            $('#tglberhentidiv').show();
        } else {
            $('#tglberhentidiv').hide();
        }
    }
</script>