<?php


?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'saalatmedis-m-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
	
)); ?>
<div class="panel panel-primary panel-success">
	<div class="panel-heading">
            <div class="panel-title">Informasi Penerimaan Distribusi Darah</div>
	</div>
	<div class="panel-body">
            <?php  echo CHtml::beginForm(); ?>
		<div class="row-fluid">
    <div class="col-sm-6">
        <div class="row-fluid">
            <div class="control-group">
       
                <?php echo CHtml::label("Tanggal Penerimaan",'dari_tanggal', array('class' => 'control-label')) ?>
             
                <div class="controls">
                    <?php echo $form->textField($model,'tgl_terima',array('readonly'=>true,'placeholder'=>'')) ?>
                </div>
            </div>
        </div>    
        <div class="row-fluid">
            <div class = "control-group">
               
                <?php echo Chtml::label("Nomor Penerimaan",'nomor_terima', array('class'=>'control-label')) ?>
               
                <div class = "controls">
                    <?php echo $form->textField($model,'nomor_terima',array('readonly'=>true,'placeholder'=>'Ketik Nomor Penerimaan')) ?>
                </div>
            </div>
        </div>    
    </div>
    <div class="col-sm-6">
        <div class="row-fluid">
            <div class = "control-group">
           
                <?php echo Chtml::label("Petugas Distribusi Pelayanan Darah",'petugasdistribusi_pelayanandarah', array('class'=>'control-label')) ?>
               
                <div class = "controls">
                    <?php echo $form->textField($model,'petugasdistribusi_pelayanandarah',array('readonly'=>true,'placeholder'=>'Ketik Petugas')) ?>
                </div>
            </div>
        </div>
        
    </div>
</div>
                        </div>
		</div>
<div class="panel panel-primary panel-success">
	<div class="panel-heading">
            <div class="panel-title">Detail Penerimaan Distribusi Darah</div>
	</div>
	<div class="panel-body">
				
		<div class="panel panel-primary panel-success">
			<div class="panel-body table-responsive">
				<?php $this->renderPartial('_tableDetailPenerimaanKantongDarah', array('modDistribusiDetail'=>$modDistribusiDetail)); ?>
			</div>
		</div>
	</div>
</div>

<?php $this->endWidget(); ?>
