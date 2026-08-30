<?php

$supplier = SupplierM::model()->findByPk($model->supplier_id);

$program = KegiatanprogramM::model()->findByPk($model->kegiatanprogram_id);
$kegiatan = SubkegiatanprogramM::model()->findByPk($model->subkegiatanprogram_id);
$mapping = MappingrekeninganggaranM::model()->findByPk($model->mappingrekeninganggaran_id); 
$rekening = Rekening5M::model()->findByPk($model->rekening5_id);
$penawaran = PenawaranpenyediaT::model()->findByAttributes(array('persiapanpengadaan_id' => $model->persiapanpengadaan_id)); 
$model->tglsuratperjanjian = MyFormatter::formatDateTimeForUser($model->tglsuratperjanjian);

?>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title"> <b> Surat Perjanjian Kerja </b></div>
    </div>
    <div class="panel-body">
        <div class="col-sm-6">
            <div class="control-group ">
                <?php echo $form->labelEx($model, 'nosuratperjanjiankerja', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'nosuratperjanjiankerja', array(
                        'readonly'=>true, 
                        'class'=>'span4',
                        'onblur'=>'return false;',
                    )); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo $form->labelEx($model, 'tglsuratperjanjian', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'tglsuratperjanjian', array(
                        'readonly'=>true, 
                        'class'=>'span4',
                        'onblur'=>'return false;',
                    )); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo CHtml::label("Nama Penyedia Barang/Jasa","nama_supplier", array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo CHtml::textField('supplier_nama', $supplier->supplier_nama, array(
                    'readonly'=>true, 
                    'class'=>'span4',
                    'onblur'=>'return false;',
                    )); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo CHtml::label("Alamat Perusahaan","alamat_supplier", array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo CHtml::textField('alamat_supplier', $supplier->supplier_alamat, array(
                    'readonly'=>true, 
                    'class'=>'span4',
                    'onblur'=>'return false;',
                    )); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo CHtml::label("Nomor Dokumen Penawaran","nopenawaran", array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo CHtml::textField('no_penawaran', $penawaran->penawaranpenyedia_nomorsurat, array(
                    'readonly'=>true, 
                    'class'=>'span4',
                    'onblur'=>'return false;',
                    )); ?>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="control-group ">
                <?php echo $form->labelEx($model, 'namapekerjaan', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textArea($model, 'namapekerjaan', array(
                    'readonly'=>true, 
                    'class'=>'span4',
                    'onblur'=>'return false;',
                    )); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo CHtml::label("TMT Pekerjaan","tmt_pekerjaan", array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo CHtml::textField("tmt_pekerjaan", MyFormatter::formatDateTimeForUser($model->tglsuratperjanjian), array(
                    'readonly'=>true, 
                    'class'=>'span4',
                    'onblur'=>'return false;',
                    )); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo CHtml::label("Program","program", array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo CHtml::textField("program", $program->kegiatanprogram_kode." - ".$program->kegiatanprogram_nama, array(
                    'readonly'=>true, 
                    'class'=>'span4',
                    'onblur'=>'return false;',
                    )); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo CHtml::label("Kegiatan","kegiataan", array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo CHtml::textField("kegiatan", $kegiatan->subkegiatanprogram_kode." - ".$kegiatan->subkegiatanprogram_nama, array(
                    'readonly'=>true, 
                    'class'=>'span4',
                    'onblur'=>'return false;',
                    )); ?>
                </div>
            </div>
            
            <div class="control-group ">
                <?php echo CHtml::label("Rekening","rekening", array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo CHtml::textField("rekening", !empty($mapping) ? $mapping->kodeanggaran." - ".$mapping->nama_rekeninganggaran5 : "", array(
                    'readonly'=>true, 
                    'class'=>'span4',
                    'onblur'=>'return false;',
                    )); ?>
                </div>
            </div>
            
        </div>
        <div class="clear"></div>
    </div>
</div>