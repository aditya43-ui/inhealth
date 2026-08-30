<?php

/**
 * - digunakan sebagai Informasi Rincian Tagihan Pasien
 * @author : Elham Budianto
 * @email : elhambudianto1@gmail.com
 * @wiki : ..
 **/
?>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-search"></i> Pencarian
        </div>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="control-group">
                    <?php echo CHtml::label("Tgl. Pendaftaran", 'tgl_rekam', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="daterange daterange-inline input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhir)) ?>">
                            <i class="entypo-calendar"></i>
                            <span><?php echo date('d M Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($model->tgl_akhir)) ?></span>
                            <?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
                            <?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo Chtml::label("No. Pendaftaran", 'no_pendaftaran', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'no_pendaftaran', array('class' => 'span4 numbers-only', 'maxlength' => 10, 'placeholder' => 'No. Pendaftaran')); ?>
                    </div>
                </div>
                <?php echo $form->textFieldRow($model, 'no_rekam_medik', array('placeholder' => 'No. Rekam Medik', 'class' => 'span4 numbers-only', 'maxlength' => 8)); ?>
                <?php echo $form->textFieldRow($model, 'nama_pasien', array('placeholder' => 'Nama Pasien', 'class' => 'span4 hurufs-only', 'maxlength' => 50)); ?>
                <?php echo $form->dropDownListRow($model, 'pegawai_id', CHtml::listData(DokterV::model()->findAllByAttributes(array('instalasi_id' => Yii::app()->user->getState('instalasi_id'),), array('order' => 'nama_pegawai asc')), 'pegawai_id', 'namaLengkap'), array('empty' => '-- Pilih --', 'class' => 'span4',)); ?>
            </div>
            <div class="col-sm-6">
                <?php
                $carabayar = CarabayarM::model()->findAll(array(
                    'condition' => 'carabayar_aktif = true',
                    'order' => 'carabayar_nama ASC',
                ));
                foreach ($carabayar as $idx => $item) {
                    $penjamins = PenjaminpasienM::model()->findByAttributes(array(
                        'carabayar_id' => $item->carabayar_id,
                        'penjamin_aktif' => true,
                    ));
                    if (empty($penjamins)) unset($carabayar[$idx]);
                }
                $penjamin = PenjaminpasienM::model()->findAll(array(
                    'condition' => 'penjamin_aktif = true',
                    'order' => 'penjamin_nama',
                ));
                echo $form->dropDownListRow($model, 'carabayar_id', CHtml::listData($carabayar, 'carabayar_id', 'carabayar_nama'), array(
                    'empty' => '-- Pilih --',
                    'class' => 'span4',
                    'ajax' => array(
                        'type' => 'POST',
                        'url' => $this->createUrl('/actionDynamic/getPenjaminPasien', array('encode' => false, 'namaModel' => get_class($model))),
                        'success' => 'function(data){$("#' . CHtml::activeId($model, "penjamin_id") . '").html(data); }',
                    ),
                ));
                ?>
                <?php echo $form->dropDownListRow($model, 'penjamin_id', CHtml::listData($penjamin, 'penjamin_id', 'penjamin_nama'), array('empty' => '-- Pilih --', 'class' => 'span4', 'maxlength' => 50)); ?>
                <?php echo $form->dropDownListRow($model, 'statusperiksa', Params::statusPeriksa(), array('empty' => '-- Pilih --', 'class' => 'span4', 'maxlength' => 50)); ?>
                <?php echo $form->dropDownListRow($model, 'statusBayar', LookupM::getItems('statusbayar'), array('empty' => '-- Pilih --', 'class' => 'span4', 'maxlength' => 20)); ?>
            </div>
        </div>