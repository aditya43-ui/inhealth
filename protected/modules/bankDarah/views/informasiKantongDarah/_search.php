<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
    'action'=>Yii::app()->createUrl($this->route),
    'method'=>'get',
    'id'=>'kantongdarah-r-search',
    'type'=>'horizontal',
    'focus'=>'#'.CHtml::activeId($model,'nama_pegawai'),
)); 
$format = new MyFormatter();
?>

<?php //echo $form->textFieldRow($model,'pelamar_id',array('class'=>'span5')); ?>

<div class="row-fluid">
    <div class="col-sm-6">
        <div class="control-group">		
            <?php echo CHtml::label("Waktu Penerimaan Kantong Darah",'dari_tanggal', array('class' => 'control-label')) ?>
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
            <?php echo Chtml::label("No Kantong Utama",'no_kantongdarah', array('class'=>'control-label')) ?>
            <div class = "controls">
                <?php echo $form->textField($model,'nomorbarcode_utama',array('class'=>'custom-only span3','placeholder'=>'Ketik Nomor Kantong Utama')) ?>
            </div>
        </div>
        <div class = "control-group">
            <?php echo Chtml::label("No Kantong Darah",'no_kantongdarah', array('class'=>'control-label')) ?>
            <div class = "controls">
                <?php echo $form->textField($model,'no_kantongdarah',array('class'=>'custom-only span3','placeholder'=>'Ketik Nomor Kantong Darah')) ?>
            </div>
        </div>
        <div class = "control-group">
            <?php echo Chtml::label("Golongan Darah",'jeniskantongdarah_id', array('class'=>'control-label')) ?>
            <div class = "controls">
                <?php echo $form->dropDownList($model, 'gol_darah', LookupM::getItems('golongandarah'), array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span3')); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class = "control-group">
            <?php echo Chtml::label("Rhesus",'rhesus', array('class'=>'control-label')) ?>
            <div class = "controls">
                <?php echo $form->dropDownList($model, 'rhesus', array('Positif'=>'Positif', 'Negatif'=>'Negatif'), array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span3')); ?>
            </div>
        </div>
        <div class = "control-group">
            <?php echo Chtml::label("Jenis Kantong",'jeniskantongdarah_id', array('class'=>'control-label')) ?>
            <div class = "controls">
                <?php echo $form->dropDownList($model,'jeniskantongdarah_id', CHtml::listData(JeniskantongdarahM::model()->findAll(), 'jeniskantongdarah_id', 'nama_jenis'),array('class' => 'span3', 'empty'=>'-- Pilih --')) ?>
            </div>
        </div>
        <div class = "control-group">
            <?php echo Chtml::label("Status Pelulusan",'statuspelulusan', array('class'=>'control-label')) ?>
            <div class = "controls">
                <?php echo $form->dropDownList($model, 'statuspelulusan', LookupM::getItems('statuspelulusan'), array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span3')); ?>
            </div>
        </div>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="entypo-search"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
        $this->createUrl($this->id.'/indexPribadi'), 
        array('class'=>'btn btn-danger',
            'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
    <?php
        $tips = array(
            '0' => 'tanggal',
            '1' => 'cari',
            '2' => 'ulang'
        );
        $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips',array('tips'=>$tips),true);
        $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
    ?>
</div>

<?php $this->endWidget(); ?>
