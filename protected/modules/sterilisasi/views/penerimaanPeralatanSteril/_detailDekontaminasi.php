<?php

/**
 * - digunakan sebagai Detail Dekontaminasi
 * @author : Elham Budianto
 * @email : elhambudianto1@gmail.com
 * @wiki : ..
 **/
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Detail <b>Dekontaminasi</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        Yii::app()->clientScript->registerScript('search', "
        $('#pencarian-form').submit(function(){
            $('#penerimaansterilisasi-grid').addClass('animation-loading');
            $.fn.yiiGridView.update('penerimaansterilisasi-grid', {
                data: $(this).serialize()
            });
            return false;
        });
        ");
        ?>
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'dekontaminasi-t-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onSubmit' => 'return requiredCheck(this);'),
        )); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-briefcase"></i> Penerimaan
                </div>
            </div>
            <div class="panel-body">
                <table id="tabel-penerimaansterilisasi" class="items table table-striped table-condensed">
                    <thead>
                        <tr>
                            <th>Tanggal Penerimaan/<br>No. Penerimaan Sterilisasi</th>
                            <th>Ruangan Asal</th>
                            <th>Nama Peralatan</th>
                            <th>Jumlah</th>
                            <th>Bahan yang digunakan</th>
                            <th>Lama Dekontaminasi</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <span><?php echo (!empty($penerimaan->penerimaansterilisasi_tgl) ? MyFormatter::formatDateTimeForUser($penerimaan->penerimaansterilisasi_tgl) : "") ?>/<br><?php echo (!empty($penerimaan->penerimaansterilisasi_no) ? $penerimaan->penerimaansterilisasi_no : "") ?></span>
                            </td>
                            <td>
                                <span><?php echo (!empty($penerimaan->ruangan_nama) ? $penerimaan->ruangan_nama : "") ?></span>
                            </td>
                            <td>
                                <span><?php echo (!empty($penerimaan->peralatansterilisasi_nama) ? $penerimaan->peralatansterilisasi_nama : "") ?></span>
                            </td>
                            <td>
                                <?php echo CHtml::activeTextField($modDekontaminasiDetail, 'dekontaminasidetail_jml', array('readonly' => true, 'class' => 'span2 integer', 'style' => 'width:45px;', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                            </td>
                            <td>
                                <ol type="1">
                                    <?php
                                    $modDekontaminasiBahan = STDekontaminasibahanT::model()->findAllByAttributes(array('dekontaminasidetail_id' => $modDekontaminasiDetail->dekontaminasidetail_id));
                                    foreach ($modDekontaminasiBahan as $a => $bahan) { ?>
                                        <li><?php echo $bahan->bahansterilisasi->bahansterilisasi_nama; ?></li>
                                    <?php } ?>
                                </ol>
                            </td>
                            <td>
                                <?php echo CHtml::activeTextField($modDekontaminasiDetail, 'dekontaminasidetail_lama', array('class' => 'span2', 'readonly' => true)); ?>
                            </td>
                            <td>
                                <?php echo CHtml::activeTextField($modDekontaminasiDetail, 'dekontaminasidetail_ket', array('class' => 'span2', 'readonly' => true)); ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Data <b>Dekontaminasi</b>
                </div>
            </div>
            <div class="panel-body">
                <div class="col-sm-6">
                    <div class="control-group">
                        <?php echo $form->labelEx($modDekontaminasi, 'dekontaminasi_tgl', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->textField($modDekontaminasi, 'dekontaminasi_tgl', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>

                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($modDekontaminasi, 'dekontaminasi_no', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            echo $form->textField($modDekontaminasi, 'dekontaminasi_no', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 20, 'readonly' => true));
                            ?>

                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="control-group">
                        <?php echo $form->labelEx($modDekontaminasi, 'pegpetugas_id', array('class' => 'control-label', 'label' => 'Petugas')); ?>
                        <div class="controls">
                            <?php echo $form->textField($modDekontaminasi, 'pegpetugas_nama', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>

                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($modDekontaminasi, 'dekontaminasi_ket', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            echo $form->textArea($modDekontaminasi, 'dekontaminasi_ket', array('readonly' => true, 'rows' => 3, 'cols' => 50, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'placeholder' => 'Keterangan Dekontaminasi'));
                            ?>

                        </div>
                    </div>

                </div>
                <div class="clear"></div>
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>