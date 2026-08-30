<?php
$this->widget('bootstrap.widgets.BootAlert'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
    'id'=>'baserahterima-t-form',
    'enableAjaxValidation'=>false,
    'type'=>'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
    'focus'=>'#',
)); ?>
<div class="panel panel-success">
    <div class="panel panel-heading">
        <div class="panel-title"> <b> Data Pengiriman Spesimen </b> </div>
    </div>
    <div class="panel-body">
        <div class="col-md-6">
            <div class="control-group">
                <?php echo CHtml::label('No. Pengiriman', '', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'no_kirimspesimen', array('class' => 'span4', 'readonly' => true)); ?>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="control-group">
                <?php echo CHtml::label('Instalasi', '', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'instalasikirim_nama', array('class' => 'span4', 'readonly' => true)); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label('Ruangan', '', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'ruangankirim_nama', array('class' => 'span4', 'readonly' => true)); ?>
                </div>
            </div>
        </div>
        <div class="clear"> </div>
        <?php echo CHtml::css('#table-detailspesimen thead tr th{vertical-align:middle;}'); ?>

        <table class="table table-bordered table-striped table-condensed" id="table-detailspesimen">
            <thead>
                <tr>                  
                    <th>No</th>
                    <th>Spesimen ID</th>  
                    <th>Nama Pasien</th>
                    <th>No. Rekam Medik</th>
                    <th>Waktu Pengambilan Spesimen</th>            
                    <th>Jenis Spesimen</th>
                    <th>Jenis Pemeriksaan</th>
                    <th>Status</th>           
                </tr>
            </thead>
            <tbody>
                <?php
                    $modDetail = PengirimanspesimendetT::model()->findAllByAttributes(array('pengirimanspesimen_id' => $model->pengirimanspesimen_id));
                    $no = 1;
                    foreach($modDetail as $det){
                        $modKirim = PengirimanspesimendetT::model()->findByPk($det->pengirimanspesimendet_id);
                ?> 
                <tr>
                    <td> <?php echo $no++; ?> </td>
                    <td> <?php echo $modKirim->spesimen->no_spesimen; ?> </td>
                    <td> <?php echo $modKirim->pasien->nama_pasien; ?> </td>
                    <td> <?php echo $modKirim->pasien->no_rekam_medik; ?> </td>
                    <td> <?php echo MyFormatter::formatDateTimeForUser($modKirim->spesimen->waktu_pengambilan_spesimen); ?> </td>
                    <td> <?php echo $modKirim->samplelab->samplelab_nama; ?></td>
                    <td> <?php echo $modKirim->spesimen->tindakanpelayanan->daftartindakan->daftartindakan_nama; ?></td>
                    <td> <?php echo $modKirim->spesimen->status; ?> </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <div class="clear"> </div>
        <div class="col-sm-6">
            <div class="control-group ">
                <?php echo CHtml::label('Tanggal Pengiriman', '', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php $model->tglkirimspesimen = MyFormatter::formatDateTimeForUser($model->tglkirimspesimen); ?>
                    <?php echo $form->textField($model, 'tglkirimspesimen', array('readonly' => true, 'empty' => '-- Pilih --', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo CHtml::label('Petugas Transporter', '', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($model->petugaskirim, 'namaLengkap', array('readonly' => true, 'empty' => '-- Pilih --', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="control-group ">
                <?php echo CHtml::label('Ruangan Tujuan', '', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($model->ruangantujuan, 'ruangan_nama', array('readonly' => true, 'empty' => '-- Pilih --', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label('Keterangan', '', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textArea($model, 'keterangan_pengiriman', array('readonly' => true, 'rows' => 3, 'class' => 'span4', 'placeholder' => 'Keterangan Pengiriman')); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>