<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'kppresensi-t-search',
    'type' => 'horizontal',
    'focus' => '#' . CHtml::activeId($model, 'no_fingerprint'),
)); ?>
<?php //echo $form->textFieldRow($model,'presensi_id',array('class'=>'span5')); 
?>
<?php //echo $form->textFieldRow($model,'statuskehadiran_id',array('class'=>'span5')); 
?>
<?php //echo $form->textFieldRow($model,'pegawai_id',array('class'=>'span5')); 
?>
<?php //echo $form->textFieldRow($model,'statusscan_id',array('class'=>'span5')); 
?>
<?php //echo $form->textFieldRow($model,'tglpresensi',array('class'=>'span4')); 
?>
<div class="row">
    <div class="col-sm-12">
        <div class="control-group">
            <?php echo CHtml::label("Tgl. Presensi", 'tglpresensi', array('class' => 'control-label')) ?>
            <div class="controls">
                <div class="daterange daterange-inline input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tglpresensi)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tglpresensi_akhir)) ?>">
                    <i class="entypo-calendar"></i>
                    <span><?php echo date('d M Y', strtotime($model->tglpresensi)) ?> - <?php echo date('d M Y', strtotime($model->tglpresensi_akhir)) ?></span>
                    <?php echo $form->hiddenField($model, 'tglpresensi', array('class' => 'start')) ?>
                    <?php echo $form->hiddenField($model, 'tglpresensi_akhir', array('class' => 'end')) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'no_fingerprint', array('placeholder' => 'No Finger Print', 'class' => 'span4', 'maxlength' => 30)); ?>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'kelompok_pegawai', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'kelompokpegawai_id', CHtml::listData(
                    KelompokpegawaiM::model()->getNonDokter(),
                    'kelompokpegawai_id',
                    'kelompokpegawai_nama'
                ), array(
                    'empty' => '-- Pilih --',
                    'class' => 'span4',
                )); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'jabatan', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'jabatan_id', CHtml::listData(
                    JabatanM::model()->findAllByAttributes(array(
                        'jabatan_aktif' => true,
                    ), array(
                        'order' => 'jabatan_nama',
                    )),
                    'jabatan_id',
                    'jabatan_nama'
                ), array(
                    'empty' => '-- Pilih --',
                    'class' => 'span4',
                )); ?>
            </div>
        </div>
        <?php echo $form->textFieldRow($model, 'nomorindukpegawai', array('placeholder' => 'NIP', 'class' => 'span4', 'maxlength' => 30)); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'nama_pegawai', array('placeholder' => 'Nama Pegawai', 'class' => 'span4', 'maxlength' => 30)); ?>
        <div class="control-group">
            <?php echo CHtml::label("Shift", 'shift_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'shift_id', CHtml::listData(
                    ShiftM::model()->findAllByAttributes(array(
                        'shift_aktif' => true,
                    ), array(
                        'order' => 'shift_nama',
                    )),
                    'shift_id',
                    'shiftJam'
                ), array(
                    'empty' => '-- Pilih --',
                    'class' => 'span4',
                )); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Status Kehadiran", 'shift_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'statuskehadiran_id', CHtml::listData(
                    StatuskehadiranM::model()->findAllByAttributes(array(
                        'statuskehadiran_aktif' => true,
                    ), array(
                        'order' => 'statuskehadiran_nama',
                    )),
                    'statuskehadiran_id',
                    'statuskehadiran_nama'
                ), array(
                    'empty' => '-- Pilih --',
                    'class' => 'span4',
                )); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Status Scan", 'shift_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'statusscan', Params::getDropStatusScan(), array(
                    'empty' => '-- Pilih --',
                    'class' => 'span4',
                )); ?>
            </div>
        </div>
    </div>
</div>
<?php
//            $format = new MyFormatter();
//            $model->tglpresensi  = $format->formatDateTimeForUser($model->tglpresensi);
//            $model->tglpresensi_akhir  = $format->formatDateTimeForUser($model->tglpresensi_akhir);
?>
<?php //echo $form->textFieldRow($model,'tglpresensi_akhir',array('class'=>'span4')); 
?>
<?php //echo $form->checkBoxRow($model,'verifikasi'); 
?>
<?php //echo $form->textAreaRow($model,'keterangan',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); 
?>
<?php //echo $form->textFieldRow($model,'jamkerjamasuk',array('class'=>'span5')); 
?>
<?php //echo $form->textFieldRow($model,'jamkerjapulang',array('class'=>'span5')); 
?>
<?php //echo $form->textFieldRow($model,'terlambat_mnt',array('class'=>'span5')); 
?>
<?php //echo $form->textFieldRow($model,'pulangawal_mnt',array('class'=>'span5')); 
?>
<?php //echo $form->textFieldRow($model,'create_time',array('class'=>'span5')); 
?>
<?php //echo $form->textFieldRow($model,'update_time',array('class'=>'span5')); 
?>
<?php //echo $form->textFieldRow($model,'create_loginpemakai_id',array('class'=>'span5')); 
?>
<?php //echo $form->textFieldRow($model,'update_loginpemakai_id',array('class'=>'span5')); 
?>
<?php //echo $form->textFieldRow($model,'create_ruangan',array('class'=>'span5')); 
?>
<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl('PresensiT/InformasiPresensi'),
        array(
            'title' => 'Ulang', 'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php
    echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
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
<?php
$urlPrint = $this->createUrl('printInformasi');
$jsx = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}&"+$('#kppresensi-t-search :not(input[name="r"])').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px, scrollbars=yes');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print', $jsx, CClientScript::POS_HEAD);
?>