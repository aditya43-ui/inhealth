<?php
$form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
    'action'=>Yii::app()->createUrl($this->route),
    'method'=>'get',
    'id'=>'daftarpasien-t-search',
    'type'=>'horizontal',
)); 
?>
<div class="row-fluid">
    <div class="col-sm-6">
        <div class="control-group">		
            <?php echo CHtml::label("Tanggal Masuk Penunjang", 'tgl_pemeriksaan', array('class' => 'control-label')) ?>
            <div class="controls">
                <div class="daterange daterange-inline input-inline" data-format="MMMM D, YYYY" data-start-date="<?php echo date('F d, Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('F d, Y', strtotime($model->tgl_akhir)) ?>">
                    <i class="entypo-calendar"></i>
                    <span ><?php echo date('F d, Y', strtotime($model->tgl_awal)) ?> - <?php echo date('F d, Y', strtotime($model->tgl_akhir)) ?></span>
                    <?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
                    <?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
                </div>
            </div>
        </div>
       
        <div class="control-group">
            <label class="control-label">No. Lab</label>
            <div class="controls">
                <?php echo $form->textField($model, 'no_lab', array('placeholder' => 'Ketik No. Lab', 'class' => 'span3 numbers-only', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 30)); ?>
            </div>
        </div>
        <?php echo $form->textFieldRow($model, 'nama_pasien', array('placeholder' => 'Ketik Nama Pasien', 'class' => 'span3 hurufs-only', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50)); ?>								
        <?php echo $form->textFieldRow($model, 'no_rekam_medik', array('placeholder' => 'Ketik No. Rekam Medik', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50)); ?>								
        <?php echo $form->textFieldRow($model, 'nama_pegawai', array('placeholder' => 'Ketik Nama Pegawai', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50)); ?>								
    
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <label class="control-label"> Jenis Pemeriksaan </label>
            <div class="controls">
            <?php echo $form->textField($model, 'daftartindakan_nama', array('placeholder' => 'Ketik Jenis Pemeriksaan', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50)); ?>								
            </div>
    
        </div>
   
        <div class="control-group">
            <label class="control-label"> Jenis Spesimen </label>
            <div class="controls">
            <?php echo $form->textField($model, 'samplelab_nama', array('placeholder' => 'Ketik Jenis Spesimen', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50)); ?>								
      
            </div> 
        </div>
              <?php echo $form->textFieldRow($model, 'carabayar_nama', array('placeholder' => 'Ketik Carabayar', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50)); ?>								
            
              <div class="control-group">
            <label class="control-label"> Status Kirim </label>
            <div class="controls">
            <?php echo $form->dropDownList($model,
                    'status_kirim',
                    array('Sudah Kirim'=>'Sudah Kirim','Belum Kirim'=>'Belum Kirim'),
                    array('empty'=>'--Pilih--','class' => 'span3')
                );
                ?>
            </div> 
        </div>
         
    
    </div>
    </div>
    
												
<div class="form-actions">

    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="icon-search icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit')); ?>
    <?php
    echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl('index'), array(
        'class' => 'btn btn-danger',
        'onclick' => 'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = "' . $this->createUrl('index') . '";}); return false;')) . "&nbsp;";
  
    ?>
</div>
<?php $this->endWidget(); ?>