<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'periksaanlainlain-mcu-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array(
        'onKeyPress' => 'return disableKeyPress(event)',
        'onsubmit' => 'return requiredCheck(this);'
    ),
)); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Detail <b>Pemeriksaan Lain-lain</b>
        </div>
    </div>
    <div class="panel-body">
        <div class="panel-body">
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo CHtml::label('Tgl. Pemeriksaan', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php
                        $modMcuPemeriksaanlainlain->tgl_pemeriksaan = $format->formatDateTimeForUser($modMcuPemeriksaanlainlain->tgl_pemeriksaan);
                        echo CHtml::activeTextField($modMcuPemeriksaanlainlain, 'tgl_pemeriksaan', array('readonly' => true));
                        ?>
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo CHtml::label('Dokter', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::textField('nama_pegawai', $modPegawai->namaLengkap, array('readonly' => true)); ?>
                    </div>
                </div>
            </div>
        </div>
        <?php $this->renderPartial('rawatJalan.views._periksaDataPasien.mcu._formPemeriksaanLainlain', array(
            'form' => $form,
            'modMcuPemeriksaanlainlain' => $modMcuPemeriksaanlainlain,
            'format' => $format,
        )); ?>

    </div>
</div>

<?php $this->endWidget(); ?>
<script>
    $(document).ready(function() {
        $("input, select, textarea").attr("readonly", true);
    });
</script>