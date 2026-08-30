
<div class="search-form" style="">
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'type' => 'horizontal',
        'id' => 'searchLaporan',
        'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
    ));
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
		<div class="span8">
			<fieldset class="box2">
				<legend class="rim">Berdasarkan Tanggal</legend>
				<?php echo CHtml::hiddenField('type', ''); ?>
				<?php //echo CHtml::hiddenField('src', ''); ?> 
			    <?php echo $form->hiddenField($model, 'pilihan_tab', array('value'=>"report")); ?>
				<div class = 'control-label'>Tanggal Periksa</div>
				<div class="controls">  
					<?php
					$this->widget('MyDateTimePicker', array(
						'model' => $model,
						'attribute' => 'tgl_awal',
						'mode' => 'date',
						'options' => array(
							'dateFormat' => Params::DATE_FORMAT,
							'maxDate'=>'d',
						),
						'htmlOptions' => array('readonly' => true,
							'onkeypress' => "return $(this).focusNextInputField(event)"),
					));
					?>
				</div>
				<?php echo CHtml::label('Sampai dengan', 'Sampai dengan', array('class' => 'control-label')) ?>
				<div class="controls">  
					<?php
					$this->widget('MyDateTimePicker', array(
						'model' => $model,
						'attribute' => 'tgl_akhir',
						'mode' => 'date',
						'options' => array(
							'dateFormat' => Params::DATE_FORMAT,
							'maxDate'=>'d',
						),
						'htmlOptions' => array('readonly' => true,
							'onkeypress' => "return $(this).focusNextInputField(event)"),
					));
					?>
				</div>
			</fieldset>
	</div>   
        
    <div class="span8">
			<fieldset class="box2">
				<legend class="rim">Search</legend>
					<div class="controls">
						<?php echo $form->dropDownListRow($model,'instalasi_id', CHtml::listData($model->getInstalasiItems(),'instalasi_id', 'instalasi_nama'),  
										array('empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span1','style'=>'float:left; width:100px',
					                   'ajax' => array('type' => 'POST',
                                    'url' => $this->createUrl('SetDropdownRuangan', array('encode' => false, 'model_nama' => get_class($model))),
                                    'update' => '#' . CHtml::activeId($model, 'ruangan_id') . ''),)); ?>
                    </div> 
					<div class="controls">
						 <?php echo $form->dropDownListRow($model, 'ruangan_id', CHtml::listData(RuanganM::model()->findAllByAttributes(array('ruangan_aktif' => true)), 'ruangan_id', 'ruangan_nama'), array('empty' => '-- Pilih --', 'class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
					</div> 
			
			</fieldset>
	</div>    
		
	</div>

    <div class="form-actions">
        <?php
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'id' => 'btn_simpan'));
        echo "&nbsp;";
        ?>
<?php
echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''), array('class' => 'btn btn-danger',
    'onclick' => 'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));
?>
    </div> 
</div>    
<?php
$this->endWidget();
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrintLembarPoli = Yii::app()->createUrl('print/lembarPoliRJ', array('pendaftaran_id' => ''));
?>
<?php $this->renderPartial('_jsFunctions', array('model' => $model)); ?> 

