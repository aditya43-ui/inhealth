<?php

/**
 * - digunakan sebagai Informasi
 * @author  Elham Budianto <elhambudianto1@gmail.com>
 * @website	   <.com>
 **/
?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'pemusnahanrekammedis-search',
    'type' => 'horizontal',
    'focus' => '#' . CHtml::activeId($model, 'nama_pegawai'),
));
$format = new MyFormatter();
?>
<?php //echo $form->textFieldRow($model,'pelamar_id',array('class'=>'span5')); 
?>
<div class="row">
    <div class="col-sm-12">
        <div class="control-group">
            <?php echo CHtml::label("Tgl. Pemusnahan", 'waktu_pemusnahan', array('class' => 'control-label')) ?>
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
            <?php echo Chtml::label("Nomor Rekam Medis", 'no_rekam_medik', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'no_rekam_medik', array('placeholder' => 'Nomor Rekam Medis', 'class' => 'span4 numbers-only', 'maxlength' => 8)) ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo Chtml::label("Nomor Pemusnahan", 'nopemusnahanrekammedis', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'nopemusnahanrekammedis', array('placeholder' => 'Nomor Pemusnahan ', 'class' => 'span4 numbers-only')) ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo Chtml::label("Nama Pasien", 'nama_pasien', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'nama_pasien', array('placeholder' => 'Nama Pasien', 'class' => 'custom-only')) ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo Chtml::label("Jenis Kelamin", 'jeniskelamin', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'jeniskelamin', LookupM::getItems("jeniskelamin"), array('empty' => '-- Pilih --')) ?>
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
        $this->createUrl('InformasiPemusnahanRekamMedis/index'),
        array('title' => 'Ulang', 'class' => 'btn btn-default')
    ); ?>
    <?php
    $tips = array(
        '0' => 'cari',
        '1' => 'ulang',
    );
    $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips' => $tips), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>
<?php $this->endWidget(); ?>