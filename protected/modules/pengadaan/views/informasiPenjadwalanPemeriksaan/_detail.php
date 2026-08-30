<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'baserahterima-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
        ));
?>
<div class="panel panel-gradient">
    <div class="panel panel-heading">
        <div class="panel-title"> <b> Jadwal Pemeriksaan Pekerjaan</b> </div>
    </div>
    <div class="panel-body">


        <div class="col-sm-6">
            <div class="control-group">
                <label class="control-label">Nomor Penjadwalan <span class="required">*</span></label>
                <div class="controls">
                    <?php echo CHtml::activeTextField($model, 'pengadaanjadwalpemeriksaan_nomor', array('readonly' => true, 'class' => 'span4')); ?>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Tanggal Penjadwalan <span class="required">*</span></label>
                <div class="controls">
                    <?php
                        echo CHtml::activeTextField($model, 'pengadaanjadwalpemeriksaan_tanggal', array('readonly' => true, 'class' => 'span4',));
                    ?>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Nomor SPK <span class="required">*</span> </label>
                <div class="controls">
                    <?php
                    echo CHtml::activeHiddenField($model, 'suratperjanjiankerja_id', array('readonly' => true, 'class' => 'span4 suratperjanjiankerja_id',));
                    echo CHtml::activeHiddenField($model, 'supplier_id', array('readonly' => true, 'class' => 'span4 supplier_id',));
                    echo CHtml::activeTextField($model, 'nosuratperjanjiankerja', array('readonly' => true, 'class' => 'span4 supplier_id',));
                    ?>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Nama Pekerjaan</label>
                <div class="controls">
                    <?php echo CHtml::activeTextArea($model, 'nama_pekerjaan', array('readonly' => true, 'class' => 'nama_pekerjaan span4 autogrow')); ?>
                </div>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="control-group">
                <label class="control-label">Tanggal Pemeriksaan <span class="required">*</span></label>
                <div class="controls">

                    <?php
                        echo CHtml::activeTextField($model, 'tanggal_pemeriksaan', array('readonly' => true, 'class' => 'span4',));
                    ?>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label required">Pemeriksa <span class="required">*</span></label>
                <div class="controls">
                    <?php
                    $modJadwalDet = PengadaanjadwalpemeriksaandetT::model()->findAllByAttributes(array('pengadaanjadwalpemeriksaan_id' => $model->pengadaanjadwalpemeriksaan_id));
                    if (!empty($modJadwalDet)) {
                        foreach ($modJadwalDet as $key => $value) { ?>
                    <table>
                        <tr>
                            <td> 
                            <?php 
                                echo CHtml::activeTextField($value, '[' . $key . ']pegpemeriksa_nama', array('value' => $value->pegpemeriksa->namaLengkap, 'readonly' => true, 'class' => 'span4', 'style' => 'margin-top: 10px; width:240px'));
                            ?>
                            </td>
                        </tr>
                    </table>
                    <?php }
                }
                ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>