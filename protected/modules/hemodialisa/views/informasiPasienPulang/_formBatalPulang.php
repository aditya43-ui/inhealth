<?php  ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'batalrawatinap-t-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        'focus'=>'#',
));
$this->widget('bootstrap.widgets.BootAlert'); 
echo $form->errorSummary(array($modPasienBatalPulang)); ?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-user"></i> Data <b>Pasien</b>
        </div>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-6">
                <?php echo CHtml::hiddenField('pendaftaran_id', $modPendaftaran->pendaftaran_id); ?>
                <?php echo CHtml::activeLabel($modPendaftaran, 'tgl_pendaftaran', array('class' => 'control-label')); ?>
                <?php echo CHtml::activeTextField($modPendaftaran, 'tgl_pendaftaran', array('readonly' => true)); ?>
                <?php echo CHtml::activeLabel($modPendaftaran, 'no_pendaftaran', array('class' => 'control-label')) ?>
                <?php echo CHtml::activeTextField($modPendaftaran, 'no_pendaftaran', array('readonly' => true)); ?>
                <?php echo CHtml::activeLabel($modPendaftaran, 'umur', array('class' => 'control-label')); ?>
                <?php echo CHtml::activeTextField($modPendaftaran, 'umur', array('readonly' => true)); ?>
                <?php echo CHtml::label('Jenis Kasus Penyakit', 'jeniskasuspenyakit_nama', array('class' => 'control-label')); ?>
                <?php echo CHtml::activeTextField($modPendaftaran, 'jeniskasuspenyakit_nama', array('readonly' => true)); ?>
            </div>
            <div class="col-sm-6">
                <?php echo CHtml::activeLabel($modPasien, 'no_rekam_medik', array('class' => 'control-label')); ?>
                <?php echo CHtml::activeTextField($modPasien, 'no_rekam_medik') ?>
                <?php echo CHtml::activeLabel($modPasien, 'jeniskelamin', array('class' => 'control-label')); ?>
                <?php echo CHtml::activeTextField($modPasien, 'jeniskelamin', array('readonly' => true)); ?>
                <?php echo CHtml::activeLabel($modPasien, 'nama_pasien', array('class' => 'control-label')); ?>
                <?php echo CHtml::activeTextField($modPasien, 'nama_pasien', array('readonly' => true)); ?>
                <?php echo CHtml::activeLabel($modPasien, 'nama_bin', array('class' => 'control-label')); ?>
                <?php echo CHtml::activeTextField($modPasien, 'nama_bin', array('readonly' => true)); ?>
            </div>
        </div>
    </div>
</div>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Alasan Pembatalan Pulang Pasien
        </div>
    </div>
    <div class="panel-body">
        <div class="control-group">
            <?php echo $form->labelEx($modPasienBatalPulang, 'tglpembatalan', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $modPasienBatalPulang,
                    'attribute' => 'tglpembatalan',
                    'mode' => 'datetime',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                        'timeFormat' =>  Params::TIME_FORMAT,
                    ),
                    'htmlOptions' => array(
                        'readonly' => true,
                        'class' => 'span3 dtPicker3',
                        'onkeypress' => "return $(this).focusNextInputField(event);",
                    ),
                )); ?>
            </div>
        </div>
        <?php echo $form->textAreaRow($modPasienBatalPulang, 'alasanpembatalan', array('placeholder' => 'Alasan Pembatalan',)); ?>
        <?php //echo CHtml::hiddenField('pasien_id', $modPasienAdmisi->pasien_id); 
        ?>
        <?php echo CHtml::hiddenField('pasien_id', $modPendaftaran->pasien_id); ?>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        $modPasienBatalPulang->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
    ); ?>
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        array('class' => 'btn btn-default', 'onclick' => 'konfirmasi()')
    );
    ?>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        // Notifikasi Pasien
        <?php 
            if(isset($smspasien)){
                if($smspasien==0){
        ?>
            var params = [];
            params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Yii::app()->session['modul_id']; ?>, judulnotifikasi:'GAGAL KIRIM SMS PASIEN', isinotifikasi:'Pasien <?php echo $modPasien->nama_pasien; ?> tidak memiliki nomor mobile'}; // 16 
            simpanNotifikasi(params);
        <?php            
                }
            }
        ?>
    })
</script>

<?php
$this->endWidget();
if($tersimpan=='Ya'){
?>
<script>
parent.location.reload();
</script>
<?php
}
?>