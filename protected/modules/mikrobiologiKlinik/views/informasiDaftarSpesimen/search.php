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
            <?php echo CHtml::label("Tanggal Terima",'', array('class' => 'control-label')) ?>
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
            <?php echo Chtml::label("Spesimen ID",'no_spesimen', array('class'=>'control-label')) ?>
            <div class = "controls">
                <?php echo $form->textField($model,'no_spesimen',array('placeholder'=>'Ketik Spesimen ID','class'=>'')) ?>
            </div>
        </div>
        <div class = "control-group">
            <?php echo Chtml::label("Jenis Spesimen",'samplelab_nama', array('class'=>'control-label')) ?>
            <div class = "controls">
                <?php echo $form->textField($model,'samplelab_nama',array('placeholder'=>'Ketik Jenis Spesimen','class'=>'')) ?>			 
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class = "control-group">
            <?php echo Chtml::label("Jenis Pemeriksaan",'jenispemeriksaan_nama', array('class'=>'control-label')) ?>
            <div class = "controls">
                <?php echo $form->textField($model,'jenispemeriksaan_nama',array('placeholder'=>'Ketik Jenis Pemeriksaan','class'=>'')) ?>			 
            </div>
        </div>
        
    </div>
    <div class="col-sm-6">
        <div class = "control-group">
            <?php echo Chtml::label("Status Spesimen",'status', array('class'=>'control-label')) ?>
            <div class = "controls">
                <?php echo $form->textField($model,'status',array('placeholder'=>'Ketik Status Spesimen','class'=>'')) ?>			 
            </div>
        </div>
        
    </div>
    <div class="col-sm-6">
        <div class = "control-group">
            <?php echo Chtml::label("Status Pemeriksaan Terakhir",'status_pemeriksaan', array('class'=>'control-label')) ?>
            <div class = "controls">
                <?php // echo $form->textField($model,'status_pemeriksaan',array('placeholder'=>'Ketik Status Pemeriksaan','class'=>'')) ?>			 
                <?php echo $form->dropDownList($model, 'status_pemeriksaan', array("-"=>"BELUM DIPERIKSA", "STAINING"=>"STAINING", "CULTURE"=>"CULTURE", "ID / AST"=>"ID / AST", "SELESAI"=>"SELESAI"), array('empty'=>'-- PILIH --','class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
        
    </div>
</div>
<div class="row-fluid">
    <?php
     $tips = array(
            '0' => 'tanggal',
            '1' => 'cari',
            '2' => 'ulang'
        );
    ?>
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
        <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
                            $this->createUrl('index'), 
                                    array(
                                            'class'=>'btn btn-danger',
                                            'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = "'.$this->createUrl('index').'";}); return false;'))."&nbsp;"; 
        $content = $this->renderPartial('mikrobiologiKlinik.views.tips.informasi_pencarian',array('tips'=>$tips),true);
        $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
        ?>
</div>
        

<?php $this->endWidget(); ?>