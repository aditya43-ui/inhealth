<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'mcukaryawan-info-search',
    'type' => 'horizontal',
)); ?>

<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label("Periode MCU", '', array('class' => 'control-label')) ?>
            <div class="controls">
            <?php echo $form->dropDownList($model, 'periodemcu', CustomFunction::getTahun(null, null), array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'empty' => '-- Pilih --',)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('No Register', ' ', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'nomorindukpegawai', array('class' => 'span3')); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Nama Karyawan', ' ', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'nama_pegawai', array('class' => 'span3')); ?>
            </div>
        </div> 
        <div class="control-group">
            <?php echo CHtml::label('Status MCU', ' ', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'statuspemeriksaan', LookupM::getItems('statusmcu'), array('empty' => '-- Pilih --', 'class' => 'span3')); ?>
            </div>
        </div>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Cari', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
    ); ?>
    <?php
    echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        Yii::app()->createUrl($this->module->id . '/InformasiMcuKaryawan/index'),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    );
    ?>
    <?php
    $tips = array(
        '0' => 'tanggal',
        '1' => 'detail',
        '2' => 'batal',
        '3' => 'cari',
        '4' => 'ulang2'
    );
    $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips' => $tips), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>