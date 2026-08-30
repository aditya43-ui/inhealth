<?php
$this->breadcrumbs = array(
    'Kantong Darah HD',
);

$this->widget('bootstrap.widgets.BootAlert');
?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'kantongdarahhd-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
//        'focus'=>'#namaObatNonRacik',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
        ));
?>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Data Kantong Darah</div>
    </div>
    <div class="panel-body">

        <div class="row-fluid">
            <div class="span12">
                <div class="row-fluid">
                    <div class="span6">
                        <div class="control-group ">
                            <?php echo CHtml::label('Tanggal darah diterima di ruang rawat', 'tanggal', array('class' => 'control-label required')) ?>
                            <div class="controls">
                                <?= $form->textField($model, 'waktu_darah_diterima', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3', 'readonly' => true)); ?> <label>&#8451;</label>

                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Suhu cool box</label>
                            <div class="controls">
                                <?= $form->textField($model, 'suhu_coolbox', array('readonly' => true,'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3 float')); ?> <label>&#8451;</label>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Nama DPJP</label>
                            <div class="controls">
                                <?= $form->hiddenField($model, 'pegawai_id', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3')); ?>
                                <?= $form->textField($model, 'nama_pegawai', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3', 'disabled' => true)); ?>
                            </div>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="control-group ">
                            <?php echo CHtml::label('Obat-obat yang diberikan sebelum transfusi', 'obat-obat', array('class' => 'control-label')) ?>
                            <?php echo CHtml::hiddenField('obat_id', '', array('readonly' => true,)); ?>
                            <div class="controls">
                                <table id="tbl-obat" width="100%">
                            <tbody>
                                <?php if (count($loadObat) > 0) : ?>
                                    <?php foreach ($loadObat as $i => $load) : ?>     
                                        <?= $this->renderPartial('_addObat', ['modObat' => $load, 'key' => $i], true); ?>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                            </div>
                        </div>
                        
                    </div>
                    <div class="span12 overflow-x">
                        <table class="table table-striped" id="tbl-kantongdarah">
                            <tr>
                                <th>No. Kantong Darah</th>
                                <th>Jenis Darah</th>
                                <th>Volume Darah (ml)</th>
                                <th>Petugas Transfusi</th>
                                <th>Petugas Verifikasi</th>
                            </tr>
                            <tbody>
                                <?php if (count($modKantongDarah) > 0) : ?>
                                    <?php foreach ($modKantongDarah as $row => $value) : ?>
                                        <tr class="tr-kantong" baris="<?= $row; ?>">
                                            <td>
                                                <?= CHtml::activeTextField($modDetail, '[' . $row . ']no_kantongdarah', array('readonly' => true, 'class' => 'span3', 'value' => $value->no_kantongdarah)); ?>
                                            </td>
                                            <td>
                                                <?php
                                                $jenisKomponen = JeniskomponendarahM::model()->find("LOWER(jeniskomponenedarah_nama) = LOWER('" . $value->namakomponendrh . "')");
                                                ?>
                                                <?= $form->HiddenField($modDetail, '[' . $row . ']jeniskomponendarah_id', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => '', 'value' => $jenisKomponen->jeniskomponendarah_id)); ?>
                                                <?= CHtml::activeTextField($modDetail, '[' . $row . ']jeniskomponendarah_nama', array('disabled' => true, 'class' => 'span2', 'value' => $jenisKomponen->jeniskomponenedarah_nama)); ?>
                                            </td>
                                            <td>
                                                <?php $volume = $value->volume; ?>
                                                <?= CHtml::activeTextField($modDetail, '[' . $row . ']volume_darah', array('readonly' => true, 'class' => 'span1', 'value' => $value->volume)); ?>
                                            </td>
                                            <td>
                                                <?= $form->HiddenField($modDetail, '[' . $row . ']petugas_transfusi_id', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => '', 'value' => (!empty($value->petugas_transfusi_id)) ? $value->petugas_transfusi_id : "")); ?>
                                                <?= $form->textField($value, '[' . $row . ']petugas_transfusi_nama', array('readonly' => true, 'class' => '')); ?>
                                            </td>
                                            <td>
                                                <?= $form->HiddenField($modDetail, '[' . $row . ']petugas_verifikasi_id', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => '', 'value' => (!empty($value->petugas_verifikasi_id)) ? $value->petugas_verifikasi_id : "")); ?>
                                                <?= $form->textField($value, '[' . $row . ']petugas_verifikasi_nama', array('readonly' => true, 'class' => '')); ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php $this->endWidget(); ?>
