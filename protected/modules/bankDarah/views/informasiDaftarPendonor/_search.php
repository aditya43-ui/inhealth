<?php
/**
* Digunakan sebagai Informasi Daftar Pendonor
* @author  Elham Budianto <elhambudianto1@gmail.com>
* @author  Andyka Putra <andykaputra@.com>
* @website	   <.com>
**/
?>

<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
    'action'=>Yii::app()->createUrl($this->route),
    'method'=>'get',
    'id'=>'daftarpendonor-search',
    'type'=>'horizontal',
    'focus'=>'#'.CHtml::activeId($model,'nama_pegawai'),
)); 
$format = new MyFormatter();
?>

<?php //echo $form->textFieldRow($model,'pelamar_id',array('class'=>'span5')); ?>
<style>
    .form-horizontal .control-label{
        width: 150px;
    }
</style>
<div class="row-fluid">
    <div class="col-sm-6">
        <div class="control-group">		
            <?php echo CHtml::label("Tanggal Pendaftaran",'waktu_pendaftaran', array('class' => 'control-label')) ?>
            <div class="controls">
                <div class="daterange daterange-inline input-inline" data-format="MMMM D, YYYY" data-start-date="<?php echo date('F d, Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('F d, Y', strtotime($model->tgl_akhir)) ?>">
                    <i class="entypo-calendar"></i>
                    <span ><?php echo date('F d, Y', strtotime($model->tgl_awal)) ?> - <?php echo date('F d, Y', strtotime($model->tgl_akhir)) ?></span>
                    <?php echo $form->hiddenField($model,'tgl_awal', array('class' => 'start')) ?>
                    <?php echo $form->hiddenField($model,'tgl_akhir', array('class' => 'end')) ?>
                </div>
            </div>
        </div>
        <div class = "control-group">
            <?php echo Chtml::label("No. Formulir",'no_formulir', array('class'=>'control-label')) ?>
            <div class = "controls">
                <?php echo $form->textField($model,'no_formulir',array('placeholder'=>'Ketik No. Formulir','class'=>'custom-only')) ?>
            </div>
        </div>
        <div class = "control-group">
            <?php echo Chtml::label("No. Registrasi Donor Darah", 'no_pendonor', array('class' => 'control-label')) ?>
            <div class = "controls">
                <?php echo $form->textField($model, 'no_pendonor', array('class' => 'custom-only', 'placeholder' => 'Ketik No. Registrasi Donor Darah')) ?>
            </div>
        </div>
        <div class = "control-group">
            <?php echo Chtml::label("Nomor Identitas",'no_identitas', array('class'=>'control-label')) ?>
            <div class = "controls">
                <?php echo $form->textField($model,'no_identitas',array('placeholder'=>'Ketik Nomor Identitas Pendonor','class'=>'custom-only')) ?>
            </div>
        </div>
        <div class = "control-group">
            <?php echo Chtml::label("Nama Donor",'nama_lengkap', array('class'=>'control-label')) ?>
            <div class = "controls">
                <?php echo $form->textField($model,'nama_lengkap',array('placeholder'=>'Ketik Nama Pendonor','class'=>'custom-only')) ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class = "control-group">
            <?php echo Chtml::label("Golongan Darah",'gol_darah', array('class'=>'control-label')) ?>
            <div class = "controls">
                <?php echo $form->dropDownList($model,'gol_darah', LookupM::getItems('golongandarah'),array('empty'=>'-- Pilih --')) ?>
            </div>
        </div>
        <div class = "control-group">
            <?php echo Chtml::label("Rhesus",'rhesus', array('class'=>'control-label')) ?>
            <div class = "controls">
                <?php echo $form->dropDownList($model,'rhesus', array('Positif'=>'Positif', 'Negatif'=>'Negatif'),array('empty'=>'-- Pilih --')) ?>
            </div>
        </div>
        <div class = "control-group">
            <?php echo Chtml::label("Status Donor",'status', array('class'=>'control-label')) ?>
            <div class = "controls">
                <?php echo $form->dropDownList($model,'status', array('ANTRIAN'=>'ANTRIAN','SELEKSI'=>'SELEKSI','OBSERVASI'=>'OBSERVASI','SELESAI'=>'SELESAI'),array('empty'=>'-- Pilih --')) ?>
            </div>
        </div>
        <div class = "control-group">
            <?php echo Chtml::label("Jenis Kelamin",'jeniskelamin', array('class'=>'control-label')) ?>
            <div class = "controls">
                <?php echo $form->dropDownList($model,'jeniskelamin',LookupM::getItems("jeniskelamin"),array('empty'=>'-- Pilih --')) ?>
            </div>
        </div>
        
    </div>	
</div>
<div class="clear"></div>
<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="entypo-search"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
    <?php echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), $this->createUrl('InformasiDaftarPendonor/index'), array('class'=>'btn btn-danger')); ?>

</div>

<?php $this->endWidget(); ?>
