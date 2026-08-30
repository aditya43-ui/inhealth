<!--<legend class="rim"><i class="entypo-search"></i> Pencarian</legend>-->
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'penerimaanlinen-info-search',
    'type' => 'horizontal',
    'focus' => '#' . CHtml::activeId($modPesanAlatSteril, 'nopengirimanlinen'),
)); ?>
<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Tgl. Pemesanan', 'pesanperlinensteril_tgl', array('class' => 'control-label')) ?>
            <div class="controls">
                <div class="daterange daterange-inline input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($modPesanAlatSteril->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($modPesanAlatSteril->tgl_akhir)) ?>">
                    <i class="entypo-calendar"></i>
                    <span><?php echo date('d M Y', strtotime($modPesanAlatSteril->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($modPesanAlatSteril->tgl_akhir)) ?></span>
                    <?php echo $form->hiddenField($modPesanAlatSteril, 'tgl_awal', array('class' => 'start')) ?>
                    <?php echo $form->hiddenField($modPesanAlatSteril, 'tgl_akhir', array('class' => 'end')) ?>
                </div>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::activeLabel($modPesanAlatSteril, 'pesanperlinensteril_no', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($modPesanAlatSteril, 'pesanperlinensteril_no', array('placeholder' => 'No. Pemesanan', 'class' => 'span4', 'maxlength' => 20, 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Instalasi', 'Instalasi', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->dropDownList(
                    $modPesanAlatSteril,
                    'instalasi_id',
                    CHtml::listData(InstalasiM::model()->findAll(), 'instalasi_id', 'instalasi_nama'),
                    array(
                        'class' => 'span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                        'ajax' => array(
                            'type' => 'POST',
                            'url' => $this->createUrl('SetDropdownRuangan', array('encode' => false, 'model_nama' => get_class($modPesanAlatSteril))),
                            'update' => "#" . CHtml::activeId($modPesanAlatSteril, 'ruangan_id'),
                        )
                    )
                ); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Ruangan', 'Ruangan', array('class' => 'control-label inline')) ?>
            <div class="controls">
                <?php echo $form->dropDownList($modPesanAlatSteril, 'ruangan_id', CHtml::listData(RuanganM::model()->findAll(), 'ruangan_id', 'ruangan_nama'), array('class' => 'span3 required', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
    </div>
</div>
<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl($this->id . '/index'),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php
    $content = $this->renderPartial('tips/informasi', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>
<?php $this->endWidget(); ?>