<div class="row">
    <div class="col-sm-4">
        <div class="control-group">
            <?php echo CHtml::label('Periode Anggaran <span class="required">*</span>', '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo CHtml::dropDownList('konfiganggaran_id', 'konfiganggaran_id', CHtml::listData(AGKonfiganggaranK::model()->findAll(), 'konfiganggaran_id', 'deskripsiperiode'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="control-group">
            <?php echo CHtml::label('Unit Anggaran <span class="required">*</span>', '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo CHtml::dropDownList('unitkerja_id', 'unitkerja_id', CHtml::listData(AGUnitkerjaM::model()->findAll('unitkerja_aktif = TRUE'), 'unitkerja_id', 'namaunitkerja'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="control-group">
            <?php echo CHtml::label('Anggaran <span class="required">*</span>', '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php $anggaran = array('Rencana Anggaran Pengeluaran', 'Anggaran Pengeluaran'); ?>
                <?php echo CHtml::dropDownList('anggaran_id', 'anggaran_id', $anggaran, array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'loadRowDetail()')
    ); ?>
</div>