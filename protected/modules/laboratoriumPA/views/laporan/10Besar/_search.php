<div class="search-form" style="">
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'type' => 'horizontal',
        'id' => 'searchLaporan',
        'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
            ));
    $format = new MyFormatter();
    ?>
    <style>
        table{
            margin-bottom: 0px;
        }
        .form-actions{
            padding:4px;
            margin-top:5px;
        }
        .nav-tabs>li>a{display:block; cursor:pointer;}
        .nav-tabs > .active a:hover{cursor:pointer;}
    </style>
    <div class="row-fluid">
		<div class="col-sm-6">
			<?php echo CHtml::hiddenField('type', ''); ?>
			<div class="control-group">
				<?php echo $form->hiddenField($model,'jns_periode', array('class'=>'span2')); ?>
				<?php echo $form->hiddenField($model,'bln_awal', array('class'=>'span2')); ?>
				<?php echo $form->hiddenField($model,'bln_akhir', array('class'=>'span2')); ?>
				<?php echo $form->hiddenField($model,'thn_awal', array('class'=>'span2')); ?>
				<?php echo $form->hiddenField($model,'thn_akhir', array('class'=>'span2')); ?>
				<?php echo CHtml::label("Periode Laporan",'tgl_rekam', array('class' => 'control-label')) ?>
				<div class="controls">
					<div class="daterange daterange-inline add-ranges input-inline" data-format="MMMM D, YYYY" data-start-date="<?php echo date('F d, Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('F d, Y', strtotime($model->tgl_akhir)) ?>">
						<i class="entypo-calendar"></i>
						<span ><?php echo date('F d, Y', strtotime($model->tgl_awal)) ?> - <?php echo date('F d, Y', strtotime($model->tgl_akhir)) ?></span>
						<?php echo $form->hiddenField($model,'tgl_awal', array('class' => 'start')) ?>
						<?php echo $form->hiddenField($model,'tgl_akhir', array('class' => 'end')) ?>
					</div>
				</div>
			</div>			 
		</div> 
		<div class="col-sm-6">			
			<?php echo $form->textFieldRow($model, 'jumlahTampil', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class'=>'span1 numbersOnly')); ?>
		</div>
	</div>     
    <div class="form-actions">
        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')), 
			array('class' => 'btn btn-primary', 'type' => 'submit', 'id' => 'btn_simpan')); ?>
        <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
			$this->createUrl($this->id.'/index'), 
			array('class'=>'btn btn-danger',
			'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
    </div>
</div>    
<?php
$this->endWidget();
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrintLembarPoli = Yii::app()->createUrl('print/lembarPoliRJ', array('pendaftaran_id' => ''));
?>
<?php $this->renderPartial('_jsFunctions', array('model'=>$model));?>

