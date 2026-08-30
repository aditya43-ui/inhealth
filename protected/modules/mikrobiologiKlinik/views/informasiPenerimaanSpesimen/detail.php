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
        <div class="panel-title"> <b> Data Penerimaan Spesimen </b></div>
    </div>
    <div class="panel-body">
        <div class="row-fluid">
            <div class="col-md-6">
                <div class="control-group">
                    <?php echo CHtml::label('Waktu Penerimaan', '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'tglterimaspesimen', array('readonly' => true, 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('No Penerimaan', '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'no_terimaspesimen', array('readonly' => true, 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="control-group">
                    <?php echo CHtml::label('Ruangan Penerimaan', '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'ruangan_nama', array('readonly' => true, 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Pegawai Penerimaan', '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'nama_pegawai', array('readonly' => true, 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="panel panel-success">
    <div class="panel panel-heading">
        <div class="panel-title"> <b> Detail Penerimaan Spesimen </b> </div>
    </div>
    <div class="panel-body">
        <table class="table table-bordered table-striped table-condensed">
            <thead>
                <tr>
                    <th> No. </th>
                    <th> Spesimen ID </th>
                    <th> Nama Pasien </th>
                    <th> No. Rekam Medik </th>
                    <th> Waktu Pengambilan Spesimen </th>
                    <th> Jenis Spesimen </th>
                    <th> Jenis Pemeriksaan </th>
                    <th> Status </th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $no = 1;
                    foreach ($modDetail as $mod){
                        $modTerima = PenerimaanspesimenT::model()->findByPk($mod->penerimaanspesimen_id);
                        $modKirim = PengirimanspesimendetT::model()->findByAttributes(array('penerimaanspesimendet_id' => $mod->penerimaanspesimendet_id));
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
    </div>
</div>
<?php $this->endWidget(); ?>