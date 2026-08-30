<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'petunjuktransaksi-m-search',
	'type'=>'horizontal',
)); ?>
<div class="row-fluid">
    <div class="col-md-6">
        <div class="control-group">
            <label class="control-label"> Tipe </label>
            <div class="controls">
                <?php echo $form->dropDownList($model,'petunjuktransaksi_type', CHtml::listData(YKMPetunjuktransaksiM::getAllPetunjuk(), 'petunjuktransaksi_type', 'petunjuktransaksi_type'), array('class'=>'span3','empty'=>'-- Pilih --')); ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label"> Nama </label>
            <div class="controls">
                <?php echo $form->textField($model,'petunjuktransaksi_nama',array('class'=>'span3','maxlength'=>100)); ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label"> Deskripsi </label>
            <div class="controls">
                <?php echo $form->textArea($model,'petunjuktransaksi_deskripsi',array('class'=>'span3','maxlength'=>100)); ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label"> </label>
            <div class="controls">
        	<?php echo $form->checkBox($model,'petunjuktransaksi_aktif', array('checked' => 'checked')); ?> <label> Aktif</label>
            </div>
        </div>

    </div>
    <div class="col-md-6">
        
    </div>
</div>
<div class="row-fluid">
    <div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
	</div>
</div>
      

	

<?php $this->endWidget(); ?>
