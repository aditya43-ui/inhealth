<?php

/**
 * - digunakan sebagai Detail Sterilisasi
 * @author : Elham Budianto
 * @email : elhambudianto1@gmail.com
 * @wiki : ..
 **/
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Detail <b>Sterilisasi</b>
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
                            <th>Ruangan Asal</th>
                            <th>No. Penerimaan</th>
                            <!--<th>Keadaan Peralatan</th>-->
                            <th>Nama Peralatan dan Linen</th>
                            <th>Jumlah</th>
                            <th>Keterangan</th>
                            <th>Jenis Sterilisasi</th>
                            <th>Alat Sterilisasi</th>
                            <th>Bahan yang Digunakan</th>
                            <th>Kemasan yang Digunakan</th>
                            <th>Waktu Kedaluwarsa</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <span>
                                    <?php
                                    if (!empty($penerimaan->pengajuansterlilisasi_id)) {
                                        $modPengajuan = STPengajuansterlilisasiT::model()->findByPk($penerimaan->pengajuansterlilisasi_id);
                                        echo isset($modPengajuan->ruangan_id) ? $modPengajuan->ruangan->ruangan_nama : '-';
                                    }
                                    ?>
                                </span>
                            </td>
                            <td>
                                <span><?php echo (!empty($penerimaan->penerimaansterilisasi_tgl) ? MyFormatter::formatDateTimeForUser($penerimaan->penerimaansterilisasi_tgl) : "") ?>/<br><?php echo (!empty($penerimaan->penerimaansterilisasi_no) ? $penerimaan->penerimaansterilisasi_no : "") ?></span>
                            </td>
                            <td>
                                <?php //echo (!empty($penerimaan->barang_nama) ? $penerimaan->barang_nama : "") 
                                ?>
                                <span><?php
                                        if (!empty($penerimaan->peralatansterilisasi_id)) {
                                            $alat = PeralatansterilisasiM::model()->findByPk($penerimaan->peralatansterilisasi_id);
                                            echo $alat->peralatansterilisasi_nama;
                                        } else {
                                            echo '-';
                                        }
                                        ?></span>
                            </td>
                            <td>
                                <?php echo CHtml::activeTextField($modSterilisasiDetail, 'sterilisasidetail_jml', array('readonly' => true, 'class' => 'span2 integer', 'style' => 'width:45px;', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                            </td>
                            <td>
                                <?php echo CHtml::activeTextArea($modSterilisasiDetail, 'sterilisasidetail_ket', array('readonly' => true, 'class' => 'span2', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                            </td>
                            <td>
                                <?php echo CHtml::activeDropDownList($modSterilisasiDetail, 'jenissterilisasi_id', CHtml::listData(STJenissterilisasiM::model()->findAll(), 'jenissterilisasi_id', 'jenissterilisasi_nama'), array('readonly' => true, 'disabled' => true, 'style' => 'width:80px;')); ?>
                            </td>
                            <td>
                                <?php echo CHtml::activeDropDownList($modSterilisasiDetail, 'alatmedis_id', CHtml::listData(STAlatmedisM::model()->findAll(), 'alatmedis_id', 'alatmedis_nama'), array('readonly' => true, 'disabled' => true, 'style' => 'width:80px;')); ?>
                                <?php //echo CHtml::activeDropDownList($penerimaan, '[ii]alatmedis_id', CHtml::listData(STAlatmedisM::model()->findAllByAttributes(array('instalasi_id'=>$instalasi_id)),'alatmedis_id','alatmedis_nama'),array('style'=>'width:80px;')); 
                                ?>
                            </td>
                            <td>
                                <ol type="1">
                                    <?php
                                    $modSterilisasiBahan = STSterilisasibahanT::model()->findAllByAttributes(array('sterilisasidetail_id' => $modSterilisasiDetail->sterilisasidetail_id));
                                    foreach ($modSterilisasiBahan as $a => $bahan) { ?>
                                        <li><?php echo $bahan->bahansterilisasi->bahansterilisasi_nama; ?></li>
                                    <?php } ?>
                                </ol>
                            </td>
                            <td>
                                <?php //echo CHtml::activeTextField($penerimaan, '[ii]kemasanygdigunakan',array('class'=>'span2')); 
                                ?>
                                <?php echo CHtml::activeTextField($modSterilisasiDetail, 'kemasanygdigunakan', array('readonly' => true, 'style' => 'float:left;')); ?>
                            </td>
                            <td>
                                <div class="input-append">
                                    <?php
                                    ?>
                                    <?php echo CHtml::activeTextField($modSterilisasiDetail, 'waktukadaluarsa', array('readonly' => true, 'style' => 'float:left;')); ?>
                                    <span class="add-on"><i class="entypo-calendar"></i></span>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Data <b>Sterilisasi</b>
                </div>
            </div>
            <div class="panel-body">
                <div class="col-sm-6">
                    <div class="control-group">
                        <?php echo $form->labelEx($modSterilisasi, 'sterilisasi_tgl', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            echo $form->textField($modSterilisasi, 'sterilisasi_tgl', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 20, 'readonly' => true));
                            ?>
                        </div>
                    </div>
                    <?php
                    echo $form->textFieldRow($modSterilisasi, 'sterilisasi_no', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 20, 'readonly' => true));
                    ?>
                    <div class="control-group">
                        <?php echo Chtml::label('Status Sterilisasi', 'sterilisasi_status', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            echo $form->textField($modSterilisasi, 'sterilisasi_status', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 20, 'readonly' => true));
                            ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Status Proses', 'status_proses', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            echo $form->textField($modSterilisasi, 'status_proses', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 20, 'readonly' => true));
                            ?>
                        </div>
                    </div>
                    <?php echo $form->textAreaRow($modSterilisasi, 'sterilisasi_ket', array('readonly' => true, 'placeholder' => 'keterangan', 'rows' => 3, 'cols' => 50, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'placeholder' => 'Keterangan Sterilisasi')); ?>
                </div>
                <div class="col-sm-6">
                    <div class="control-group">
                        <?php echo $form->labelEx($modSterilisasi, 'pegsterilisasi_id', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php
                            echo $form->textField($modSterilisasi, 'pegsterilisasi_nama', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 20, 'readonly' => true));
                            ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($modSterilisasi, 'pegmengetahui_id', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php
                            echo $form->textField($modSterilisasi, 'pegmengetahui_nama', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 20, 'readonly' => true));
                            ?>
                        </div>
                    </div>
                    <?php
                    echo $form->textFieldRow($modSterilisasi, 'sterilisasi_siklus', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 20));
                    ?>
                </div>
                <div class="clear"></div>
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>