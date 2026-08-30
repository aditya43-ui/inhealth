<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'jenisbarangrek-m-search',
    'type' => 'horizontal',
)); ?>

<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Jenis Barang', '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                echo CHtml::activeDropDownList($model, 'jenisbarang_id', CHtml::listData(
                    JenisbarangM::model()->findAll('jenisbarang_aktif = true order by jenisbarang_nama'),
                    'jenisbarang_id',
                    'jenisbarang_nama'
                ), array('empty' => '-- Pilih --'))
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Saldo Normal', '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                echo CHtml::activeDropDownList($model, 'debitkredit', ['D' => 'Debit', 'K' => 'Kredit'], array(
                    'empty' => '-- Pilih --',
                ))
                ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label("", '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'ispenerimaan', array('onkeypress' => "return $(this).focusNextInputField(event);", 'checked' => '')) . ' <label for="JenisbarangrekM_ispenerimaan">Penerimaan Faktur</label>'; ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("", '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'isreturpenerimaan', array('onkeypress' => "return $(this).focusNextInputField(event);", 'checked' => '')) . ' <label for="JenisbarangrekM_isreturpenerimaan">Retur Penerimaan Faktur</label>'; ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("", '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'isstokopname', array('onkeypress' => "return $(this).focusNextInputField(event);", 'checked' => '')) . ' <label for="JenisbarangrekM_isstokopname">Inventarisasi Stok Awal</label>'; ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("", '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'isstokopnameberkurang', array('onkeypress' => "return $(this).focusNextInputField(event);", 'checked' => '')) . ' <label for="JenisbarangrekM_isstokopnameberkurang">Inventarisasi Penyesuaian Berkurang</label>'; ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("", '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'isstokopnamebertambah', array('onkeypress' => "return $(this).focusNextInputField(event);", 'checked' => '')) . ' <label for="JenisbarangrekM_isstokopnamebertambah">Inventarisasi Penyesuaian Bertambah</label>'; ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("", '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'ismutasi', array('onkeypress' => "return $(this).focusNextInputField(event);", 'checked' => '')) . ' <label for="JenisbarangrekM_ismutasi">Mutasi</label>'; ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("", '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'ispemakaian', array('onkeypress' => "return $(this).focusNextInputField(event);", 'checked' => '')) . ' <label for="JenisbarangrekM_ispemakaian">Pemakaian Ruangan</label>'; ?>
            </div>
        </div>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
<?php echo CHtml::link(
    Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
    Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''),
    array(
        'title' => 'Ulang',
        'class' => 'btn btn-default',
        'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
    )
); ?>
</div>

<?php $this->endWidget(); ?>