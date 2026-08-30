<?php

/**
 * @author          Yusuf Putra Anugrah<yusufputra@.com>
 * @version         2.0.0
 * @documentation   http://kbase..com
 * @issue           RSST-2164
 * - Menambahkan Menu Informasi Daftar Rekam Medis Inaktif
 * -  
 */
?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'penerimaankantongdarah-r-search',
    'type' => 'horizontal',
    'focus' => '#' . CHtml::activeId($model, 'nomor'),
));
$format = new MyFormatter();
?>
<?php //echo $form->textFieldRow($model,'pelamar_id',array('class'=>'span5')); 
?>
<div class="row">
    <div class="col-sm-12">
        <div class="control-group">
            <?php echo CHtml::label("Tgl. Monitoring", 'dari_tanggal', array('class' => 'control-label')) ?>
            <div class="controls">
                <div class="daterange daterange-inline input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhir)) ?>">
                    <i class="entypo-calendar"></i>
                    <span><?php echo date('d M Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($model->tgl_akhir)) ?></span>
                    <?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
                    <?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label("No. Retensi", 'noretensiinaktif', array('class' => 'control-label required')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'noretensiinaktif', array('placeholder' => 'No. Retensi', 'class' => 'span4')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("No. Rekam Medis", 'nomor', array('class' => 'control-label required')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'no_rekam_medik', array('placeholder' => 'No. Rekam Medik', 'class' => 'span4 numbers-only')); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label("Nama Pasien", 'nama_pasien', array('class' => 'control-label required')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'nama_pasien', array('placeholder' => 'Nama Pasien', 'class' => 'span4')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Jenis Kelamin", 'Jenis Kelamin', array('class' => 'control-label required')); ?>
            <div class="controls">
                <?php
                echo $form->dropDownList($model, 'jeniskelamin', LookupM::getItems('jeniskelamin'), array(
                    'class' => 'span4', 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
                ));
                ?>
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
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php
    $content = $this->renderPartial('../tips/informasi', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
    <?php
    $tips = array(
        '0' => 'tanggal',
        '1' => 'cari',
        '2' => 'ulang'
    );
    ?>
</div>
<?php $this->endWidget(); ?>