<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'kpindikatorperilaku-m-search',
    'type' => 'horizontal',
)); ?>
<div class="row">
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
        <div class="control-group">
            <?php echo CHtml::label("", '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'indikatorperilaku_aktif', array('checked' => true)); ?>
                <label for="KPIndikatorperilakuM_indikatorperilaku_aktif">Status Aktif</label>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <?php echo $form->dropDownListRow(
            $model,
            'kompetensi_id',
            CHtml::listData(KPKompetensiM::model()->getKompetensiItems(), 'kompetensi_id', 'kompetensi_nama'),
            array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3')
        ); ?>
        <div class="control-group">
            <?php echo CHtml::label('Nama Indikator Perilaku', 'indikatorperilaku_nama', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textArea($model, 'indikatorperilaku_nama', array('placeholder' => 'Nama Indikator Perilaku', 'rows' => 2, 'cols' => 50, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 300)); ?>
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