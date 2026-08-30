<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'sahakkewajiban-m-search',
    'type' => 'horizontal',
)); ?>

<div class="row">
    <div class="col-sm-6">
        <?php echo $form->dropDownListRow($model, 'kelompok', LookupM::getItems("kelompokhakpasien"), array('empty' => '-- Pilih --', 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($model, 'hakpasien_nama', array('placeholder' => 'Nama', 'rows' => 6, 'cols' => 50, 'class' => 'span4')); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'hakpasien_urutan', array('placeholder' => '00', 'class' => 'span2 numbers-only')); ?>

        <div class="control-group">
            <label class="control-label"></label>
            <div class="controls">
                <?php echo $form->checkBox($model, 'hakpasien_aktif', array('onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                <label for="HakpasienM_hakpasien_aktif">Aktif</label>
            </div>
        </div>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        array('title' => 'Ulang', 'class' => 'btn btn-default', 'type' => 'reset')
    ); ?>
</div>

<?php $this->endWidget(); ?>