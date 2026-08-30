<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'searchLaporan',
    'type' => 'horizontal',
)); 

?>
<div class="row-fluid">
    <div class="col-sm-6">
        <div class="control-group">                
            <?php echo CHtml::label("Tanggal Pembuatan PRB",'tgl_rekam', array('class' => 'control-label')) ?>
            <div class="controls">
                <div class="daterange daterange-inline add-ranges input-inline" data-format="MMMM D, YYYY" data-start-date="<?php echo date('F d, Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('F d, Y', strtotime($model->tgl_akhir)) ?>">
                    <i class="entypo-calendar"></i>
                    <span ><?php echo date('F d, Y', strtotime($model->tgl_awal)) ?> - <?php echo date('F d, Y', strtotime($model->tgl_akhir)) ?></span>
                    <?php echo $form->hiddenField($model,'tgl_awal', array('class' => 'start')) ?>
                    <?php echo $form->hiddenField($model,'tgl_akhir', array('class' => 'end')) ?>
                </div>
            </div>
        </div>	
        
        <div class="control-group">
            <label class="control-label">No. SRB</label>
            <div class="controls">
                <?= $form->textField($model,'nosrb') ?>
            </div>
        </div>
        
        <div class="control-group">
            <label class="control-label">No Pendaftaran</label>
            <div class="controls">
                <?= $form->textField($model,'no_pendaftaran') ?>
            </div>
        </div>
    </div>
    
    <div class="col-sm-6">
       
        <div class="control-group">
            <label class="control-label">No SEP</label>
            <div class="controls">
                <?= $form->textField($model,'nosep') ?>
            </div>
        </div>
        
        <div class="control-group">
            <label class="control-label">Nama Pasien</label>
            <div class="controls">
                <?= $form->textField($model,'nama_pasien') ?>
            </div>
        </div>
        
        <div class="control-group">
            <label class="control-label">No Peserta</label>
            <div class="controls">
                <?= $form->textField($model,'nokartuasuransi') ?>
            </div>
        </div>
        
        <div class="control-group">
            <label class="control-label">No Rekam Medik</label>
            <div class="controls">
                <?= $form->textField($model,'no_rekam_medik') ?>
            </div>
        </div>
    </div>
</div>
<div class="form-actions">
	<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
</div>
<?php $this->endWidget(); ?>