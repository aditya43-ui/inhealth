<?php
$this->breadcrumbs = array(
    'Mcu',
);
if (isset($_GET['sukses'])) {
    Yii::app()->user->setFlash('success', "Data Pemeriksaan Umum berhasil disimpan");
}
$this->widget('bootstrap.widgets.BootAlert'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'periksaanfisik-mcu-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
)); ?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Detail <b>Pemeriksaan Umum</b>
        </div>
    </div>
    <div class="panel-body">
        <div class="panel-body">
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo CHtml::label('Tgl. Pemeriksaan', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php
                        $modpemeriksaanumum->tgl_pemeriksaan = $format->formatDateTimeForUser($modpemeriksaanumum->tgl_pemeriksaan);
                        $this->widget('MyDateTimePicker', array(
                            'model' => $modpemeriksaanumum,
                            'attribute' => 'tgl_pemeriksaan',
                            'mode' => 'datetime',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,

                            ),
                            'htmlOptions' => array(
                                'readonly' => true, 'class' => 'span2',
                                'onkeypress' => "return $(this).focusNextInputField(event)"
                            ),
                        ));
                        ?>
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo CHtml::label('Dokter', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::textField('nama_lengkap', $modPegawai->namaLengkap, array(
                            'class' => 'span3'
                        )); ?>
                    </div>
                </div>
            </div>
        </div>
        <?php $this->renderPartial($this->path_view . '_formPemeriksaanUmum', array(
            'form' => $form,
            'modpemeriksaanumum' => $modpemeriksaanumum,
            'format' => $format
        )); ?>
        <?php $this->renderPartial($this->path_view . '_formPemeriksaanLab', array(
            'form' => $form,
            'modpemeriksaanumum' => $modpemeriksaanumum,
            'format' => $format
        )); ?>

    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::link('<i class="entypo-back" style="color: white;"></i> Kembali', '#', array('class' => 'btn btn-primary', 'onclick' => 'window.history.back(); return false;', 'style' => 'color: white;')) ?>
</div>

<?php $this->endWidget(); ?>
<script>
    $(document).ready(function() {
        $("input, select, textarea").attr("readonly", true);
    });
</script>