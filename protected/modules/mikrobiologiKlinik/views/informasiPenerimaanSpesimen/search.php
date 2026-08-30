<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
    'action'=>Yii::app()->createUrl($this->route),
    'method'=>'get',
    'id'=>'penerimaanspesimen-r-search',
    'type'=>'horizontal',
)); 
$format = new MyFormatter();
?>
<div class="row-fluid">
    <div class="col-sm-6">
        <div class="control-group">		
            <?php echo CHtml::label("Waktu Penerimaan",'', array('class' => 'control-label')) ?>
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
            <?php echo Chtml::label("No. Penerimaan",'no_terimaspesimen', array('class'=>'control-label')) ?>
            <div class = "controls">
                <?php echo $form->textField($model,'no_terimaspesimen',array('placeholder'=>'Ketik No. Formulir','class'=>'custom-only')) ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class = "control-group">
            <?php echo Chtml::label("Ruangan Penerimaan",'ruangan_id', array('class'=>'control-label')) ?>
            <div class = "controls">
                <?php echo $form->dropDownList($model, 'ruangan_id', CHtml::listData(RuanganM::model()->findAll("ruangan_aktif = TRUE AND ruangan_id =".Yii::app()->user->getState('ruangan_id')."order by ruangan_nama ASC"), 'ruangan_id', 'ruangan_nama'), array('disabled' => true, 'class' => 'span3', 'style'=>'width:200px;','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>				 
            </div>
        </div>
        <div class = "control-group">
            <?php echo Chtml::label("Petugas Penerima",'nama_pegawai', array('class'=>'control-label')) ?>
            <div class = "controls">
                <?php echo $form->textField($model,'nama_pegawai',array('placeholder'=>'Ketik Nama Pegawai Penerima','class'=>'custom-only')) ?>
            </div>
        </div>
    </div>
</div>
<div class="row-fluid">
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
        <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
                            $this->createUrl('index'), 
                                    array(
                                            'class'=>'btn btn-danger',
                                            'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = "'.$this->createUrl('index').'";}); return false;'))."&nbsp;"; 
        ?>
</div>
        

<?php $this->endWidget(); ?>