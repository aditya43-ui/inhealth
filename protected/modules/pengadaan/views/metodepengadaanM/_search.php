<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'metodepengadaan-m-search',
	'type'=>'horizontal',
)); ?>
    
<div class="row-fluid">
    <div class="col-sm-6">
        <div class = "control-group">
            <?php echo Chtml::label("Nama Metode Pengadaan",'', array('class'=>'control-label')) ?>
            <div class = "controls">
                <?php echo $form->textField($model,'metodepengadaan_nama',array()) ?>
            </div>
        </div>        
	<?php echo $form->textFieldRow($model,'metodepengadaan_namalain',array('class'=>'span3','maxlength'=>100)); ?>
	
        <?php echo $form->checkBoxRow($model,'metodepengadaan_aktif', array('checked' => 'checked')); ?>
    </div>
    <div class="col-sm-6">
	<?php echo $form->textAreaRow($model,'metodepengadaan_ket',array('rows'=>6, 'cols'=>50, 'class'=>'span3')); ?>
        
	<?php echo $form->textFieldRow($model,'metodepengadaan_urutan',array('class'=>'span3 numbers-only')); ?>
    </div>
</div>





	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="entypo-search"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
                <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
                            $this->createUrl('index'), 
                                    array(
                                            'class'=>'btn btn-danger',
                                            'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = "'.$this->createUrl('admin').'";}); return false;'))."&nbsp;";
                
                ?>
        </div>

<?php $this->endWidget(); ?>
