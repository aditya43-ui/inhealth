<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'gradinginsidenrs-t-search',
    'type' => 'horizontal',
        ));
?>
<style>
    .listtanggal{
        float: left;
        width: 125px;
    }
    .listtanggal1{
        padding-left:2px;
        font-size:11.5px;
        float: left;
        font-weight: normal;
        line-height:18px;
    }
</style>

<div class="row">
    <div class="col-sm-6">
        <div class="control-group">	
            <?php echo $form->checkBox($model, 'tipeLapor', array('class' => 'listtanggal', 'rel' => 'tooltip', 'title' => 'Klik/centang untuk filter dengan periode')); ?>
            <?php echo CHtml::label("Tanggal Pelaporan &nbsp;&nbsp;", 'insidenrs_tgllapor', array('class' => 'listtanggal1 ')) ?>
            <div class="controls">
                <div class="daterange daterange-inline input-inline" data-format="MMMM D, YYYY" data-start-date="<?php echo date('F d, Y', strtotime($model->tanggal_awal)) ?>" data-end-date="<?php echo date('F d, Y', strtotime($model->tanggal_akhir)) ?>">
                    <i class="entypo-calendar"></i>
                    <span ><?php echo date('F d, Y', strtotime($model->tanggal_awal)) ?> - <?php echo date('F d, Y', strtotime($model->tanggal_akhir)) ?></span>
                    <?php echo $form->hiddenField($model, 'tanggal_awal', array('class' => 'start')) ?>
                    <?php echo $form->hiddenField($model, 'tanggal_akhir', array('class' => 'end')) ?>
                </div>
            </div>
        </div>
        <div class="control-group">	
            <?php echo $form->checkBox($model, 'tipeInsiden', array('class' => 'listtanggal', 'rel' => 'tooltip', 'title' => 'Klik/centang untuk filter dengan periode')); ?>
            <?php echo CHtml::label("Tanggal Inspeksi &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;", 'insidenrs_tglinsiden', array('class' => 'listtanggal1')); ?>
            <div class="controls">
                <div class="daterange daterange-inline input-inline" data-format="MMMM D, YYYY" data-start-date="<?php echo date('F d, Y', strtotime($model->tanggal_awal2)) ?>" data-end-date="<?php echo date('F d, Y', strtotime($model->tanggal_akhir2)) ?>">
                    <i class="entypo-calendar"></i>
                    <span ><?php echo date('F d, Y', strtotime($model->tanggal_awal2)) ?> - <?php echo date('F d, Y', strtotime($model->tanggal_akhir2)) ?></span>
                    <?php echo $form->hiddenField($model, 'tanggal_awal2', array('class' => 'start')) ?>
                    <?php echo $form->hiddenField($model, 'tanggal_akhir2', array('class' => 'end')) ?>
                </div>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Nama Pelapor', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'pelapor_nama', array('placeholder' => 'Ketik Nama Pelapor', 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
            </div>
        </div>
    </div>    
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Nama Pelanggar', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'namapelanggar', array('placeholder' => 'Ketik Nama Pelanggar', 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
            </div>
        </div>

        <?php echo $form->dropDownListRow($model, 'tempatkejadian_perkara', LookupM::getItems('kejadianperkara'), array('empty'=>'-- Pilih Tempat Kejadian--', 'class' => 'span4')); ?>

        <div class="control-group">
            <?php echo CHtml::label('Status Verifikasi', 'status_verifikasi', array('class' => 'control-label')) ?>
            <div class="controls"> 
                <?php echo $form->dropDownList($model, 'status_verifikasi', array('Belum' => 'Belum Diverifikasi', 'Sudah' => "Sudah Diverifikasi"), array('class' => 'span4', 'empty' => '-- Pilih --')); ?>
            </div>
        </div>
    </div>
</div>
<br>
<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit')) . "&nbsp"; ?>
    <?php echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl('informasiLaporanInsidenSelainPasien/index'), array('class' => 'btn btn-danger')) . "&nbsp"; ?>

    <?php
    $tips = array(
        '0' => 'tanggal',
        '1' => 'cari',
        '2' => 'ulang'
    );
    $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips' => $tips), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>