<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Detail <b>Rencana Keperawatan</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Pembayaran',
        );
        ?>
        <style>
            .tandagejala label {
                display: flex;
            }

            .intervensi label {
                display: flex;
            }
        </style>
        <?php
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'pembayaran-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'focus' => '#ASPendaftaranT_no_pendaftaran',
            'htmlOptions' => array(
                'onKeyPress' => 'return disableKeyPress(event)',
                'onsubmit' => 'return requiredCheck(this);'
                // 'onsubmit'=>'return cekOtorisasi();'
            ),
        ));
        ?>
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php //echo $form->errorSummary(array($modRetur,$modBuktiKeluar)); 
        ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Data <b>Diagnosa Keperawatan</b>
                </div>
            </div>
            <div class="panel-body form-diagnosis-keperawatan">
                <div class="row">
                    <div class="col-sm-6">

                        <div class="control-group keperawatan">
                            <?php echo CHtml::label('No. Diagnosa Keperawatan', 'no_diagnosisaskep', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php
                                echo CHtml::activeHiddenField($modDiagnosis, 'diagnosisaskep_id', array('class' => 'diagnosisaskep_id'));
                                echo CHtml::activeTextField($modDiagnosis, 'no_diagnosisaskep', array('readonly' => true, 'class' => 'span3'));
                                ?>
                            </div>
                        </div>

                        <div class="control-group">
                            <?php echo $form->labelEx($modDiagnosis, 'diagnosisaskep_tgl', array('class' => 'control-label inline')) ?>
                            <div class="controls">
                                <?php echo CHtml::activeTextField($modDiagnosis, 'diagnosisaskep_tgl', array('readonly' => true, 'class' => 'span3')); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">

                        <div class="control-group">
                            <?php echo CHtml::label('Nama Pegawai', 'nama_pegawai', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->hiddenField($modDiagnosis, 'pegawai_id', array('readonly' => true)) ?>
                                <?php echo CHtml::activeTextField($modDiagnosis, 'nama_pegawai', array('readonly' => true)); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-user"></i> Identitas Pasien
                </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial('_ringkasDataPasien', array('model' => $model, 'modPasien' => $modPasien)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Data <b>Rencana</b>
                </div>
            </div>
            <div class="panel-body">
                <div class="">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="control-group">
                                <?php echo CHtml::activeLabel($model, 'no_rencana', array('class' => 'control-label')); ?>
                                <div class="controls">
                                    <?php echo $form->textField($model, 'no_rencana', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo $form->labelEx($model, 'rencanaaskep_tgl', array('class' => 'control-label inline')) ?>
                                <div class="controls">
                                    <?php echo $form->textField($model, 'rencanaaskep_tgl', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="control-group">
                                <?php echo CHtml::label('Nama Pegawai <span class="required">*</span>', 'nama_pegawai', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php echo $form->hiddenField($model, 'pegawai_id', array('required' => true, 'readonly' => true)) ?>
                                    <?php
                                    $cekPegawai = PegawaiM::model()->findByPk($model->pegawai_id);
                                    echo $form->textField($model, 'nama_pegawai', array('required' => true, 'readonly' => true, 'value' => $cekPegawai->namaLengkap));
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">Rencana Keperawatan</div>
            </div>
            <div class="panel-body">
                <div class="row-fluid block-tabel overflow-x">
                    <table id="table-rencana" class="table table-striped table-bordered table-condensed">
                        <thead>
                            <th style="text-align: center" width="20%">Diagnosa Keperawatan</th>
                            <th style="text-align: center" width="15%">Luaran Keperawatan</th>
                            <th style="text-align: center" width="8%">Tujuan</th>
                            <th style="text-align: center">Kriteria Hasil</th>
                            <th style="text-align: center">Intervensi</th>
                            <th style="text-align: center">Tindakan</th>
                        </thead>
                        <tbody>
                            <?php
                            //                                    $trRencana = $this->renderPartial($this->path_view . '_rowDiagnosaDetail', array('modDetail' => $modDetail,'modPilih'=>  $modPilih), true);
                            //                                    echo $trRencana;
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>
<?php
$this->renderPartial('_jsFunctions', array(
    'model' => $model,
    'modDetail' => $modDetail,
    'modPasien' => $modPasien,
    'modDiagnosis' => $modDiagnosis,
    //	'modPenanggungJawab' => $modPenanggungJawab,
    //	'modRiwayatAnemnesa' => $modRiwayatAnemnesa,
    //	'modRiwayatPeriksaFisik' => $modRiwayatPeriksaFisik,
    'modPengkajian' => $modPengkajian,
    //	'modPenunjang' => $modPenunjang,
    'form' => $form
));
?>