<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
    'action'=>Yii::app()->createUrl($this->route),
    'method'=>'get',
    'id'=>'returdarah-r-search',
    'type'=>'horizontal',
)); 
$format = new MyFormatter();
?>

<?php //echo $form->textFieldRow($model,'pelamar_id',array('class'=>'span5')); ?>

<div class="row-fluid">
    <div class="col-sm-6">
        <div class="control-group">		
            <?php echo CHtml::label("Tanggal Penerimaan Darah",'dari_tanggal', array('class' => 'control-label')) ?>
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
            <?php echo Chtml::label("Nama Pasien",'nama_pasien', array('class'=>'control-label')) ?>
            <div class = "controls">
                <?php echo $form->textField($model,'nama_pasien',array('placeholder'=>'Ketik Nama Pasien')) ?>
            </div>
        </div>
        <div class = "control-group">
            <?php echo Chtml::label("No Rekam Medis",'no_rekam_medik', array('class'=>'control-label')) ?>
            <div class = "controls">
                <?php echo $form->textField($model,'no_rekam_medik',array('placeholder'=>'Ketik Nomor Rekam Medis')) ?>
            </div>
        </div>
        <div class = "control-group">
            <?php echo Chtml::label("Ruangan",'ruangan_id', array('class'=>'control-label')) ?>
            <div class = "controls">
                <?php echo $form->dropDownList($model,'ruangan_id', CHtml::listData(RuanganM::model()->findAllByAttributes(array('ruangan_aktif'=>true)), 'ruangan_id', 'ruangan_nama'), array(
				'empty'=>'-- Pilih --',
			 ));
        ?>
            </div>
        </div>
        <div class = "control-group">
            <?php echo Chtml::label("No Kantong",'no_kantongdarah', array('class'=>'control-label')) ?>
            <div class = "controls">
                <?php echo $form->textField($model,'no_kantongdarah',array('placeholder'=>'Ketik Nomor Kantong')) ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class = "control-group">
            <?php echo Chtml::label("Jenis Darah",'jenis_komponen_darah', array('class'=>'control-label')) ?>
            <div class = "controls">
                <?php echo $form->textField($model,'jenis_komponen_darah',array('placeholder'=>'Ketik Jenis Darah')) ?>
            </div>
        </div>
        <div class = "control-group">
            <?php echo Chtml::label("Golongan Darah",'gol_darah', array('class'=>'control-label')) ?>
            <div class = "controls">
                <?php echo $form->textField($model,'gol_darah',array('placeholder'=>'Ketik Golongan Darah')) ?>
            </div>
        </div>
        <div class = "control-group">
            <?php echo Chtml::label("Asal Darah",'asaldarah', array('class'=>'control-label')) ?>
            <div class = "controls">
                <?php echo $form->dropDownList($model,'asaldarah',array(1=>'Ruangan',2=>'BDT',3=>'ITD'),array('empty'=>'-- Pilih --')) ?>
            </div>
        </div>
        <div class = "control-group">
            <?php echo Chtml::label("Petugas Penerima",'petugas_penerima_nama', array('class'=>'control-label')) ?>
            <div class = "controls">
                <?php echo $form->textField($model,'petugas_penerima_nama',array('placeholder'=>'Ketik Nama Petugas')) ?>
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
