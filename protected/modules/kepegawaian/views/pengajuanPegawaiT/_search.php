<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'kpinfopengajuanpegawai-v-search',
    'type' => 'horizontal',
    'focus' => '#' . CHtml::activeId($model, 'nopengajuan'),
));
$format = new MyFormatter();
?>

<div class="row">
    <div class="col-sm-6">
        <?php //echo  $form->textFieldRow($model,'tgl_pendaftaran');  
        ?>
        <div class="control-group">
            <?php echo CHtml::label('Tgl. Pengajuan', 'tglmutasibrg', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $model->tgl_awal = $format->formatDateTimeForUser($model->tgl_awal);
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'tgl_awal',
                    'mode' => 'date',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                        'maxDate' => 'd',
                    ),
                    'htmlOptions' => array('readonly' => true, 'class' => 'span3 dtPicker3'),
                ));
                $model->tgl_awal = $format->formatDateTimeForDb($model->tgl_awal);
                ?> </div>
        </div>
        <div class="control-group">
            <label for="namaPasien" class="control-label">
                Sampai dengan
          </label>
            <div class="controls">
                <?php
                $model->tgl_akhir = $format->formatDateTimeForUser($model->tgl_akhir);
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'tgl_akhir',
                    'mode' => 'date',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                        'maxDate' => 'd',
                    ),
                    'htmlOptions' => array('readonly' => true, 'class' => 'span3 dtPicker3'),
                ));
                $model->tgl_akhir = $format->formatDateTimeForDb($model->tgl_akhir);
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::activeLabel($model, 'nopengajuan', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'nopengajuan', array('placeholder' => 'No. Pengajuan', 'class' => 'span4', 'maxlength' => 50)); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::activeLabel($model, 'id_pegmengajukan', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'id_pegmengajukan', CHtml::listData($model->getPegawaiRuangan(), 'pegawai_id', 'namaLengkap'), array('empty' => '-- Pilih --', 'class' => 'span4', 'maxlength' => 20)); ?>
            </div>
        </div>

        <div class="control-group">
            <?php echo CHtml::activeLabel($model, 'id_pegmengetahui', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'id_pegmengetahui', CHtml::listData($model->getPegawaiRuangan(), 'pegawai_id', 'namaLengkap'), array('empty' => '-- Pilih --', 'class' => 'span4', 'maxlength' => 20)); ?>
            </div>
        </div>
        <?php //echo $form->dropDownListRow($model,'sumberdanabhn', LookupM::getItems('sumberdanabahan'),array('empty'=>'-- Pilih --'));  
        ?>
    </div>
</div>

<?php echo CHtml::htmlButton(
    Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
    array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
); ?>
<?php
echo CHtml::link(
    Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
    $this->createUrl($this->id . '/index'),
    array(
        'title' => 'Ulang',
        'class' => 'btn btn-default',
        'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
    )
);
?>
<?php
$content = $this->renderPartial('kepegawaian.views.tips.informasi_presensi', array(), true);
$this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
?>

<?php $this->endWidget(); ?>

<script>
    function refresh() {
        location.reload();
    }
</script>