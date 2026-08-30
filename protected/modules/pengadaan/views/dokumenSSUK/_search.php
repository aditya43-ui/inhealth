<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'dokumenpengadaan-m-search',
	'type'=>'horizontal',
)); ?>
<div class="row-fluid">
    <div class="col-sm-6">        
        <div class="control-group">
            <label class="control-label">Nama Dokumen SSUK</label>
            <div class="controls">
                <?php echo $form->textField($model,'lookup_name',array('class'=>'span3','maxlength'=>100)); ?>
            </div>                        
        </div>	        	
        <div class="control-group">
            <label class="control-label"></label>
            <div class="controls">
                <?php echo $form->checkBox($model,'lookup_aktif',array('checked'=>'lookup_aktif','maxlength'=>100)); ?> <label>Aktif</label>
            </div>                        
        </div>	  
    </div>    
</div>
<div class="row-fluid">
    <div class="form-actions">
        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="entypo-search"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
        <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
        $this->createUrl('admin'), 
            array(
                'class'=>'btn btn-danger',
                'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = "'.$this->createUrl('admin').'";}); return false;'
            ))."&nbsp;";
                
        ?>
    </div>
</div>    

<?php $this->endWidget(); ?>
