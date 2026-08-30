<?php
	Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/dropCheck.css');               
?>
<div class="search-form">
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'type' => 'horizontal',
        'id' => 'searchLaporan',
        'focus'=>'#'.CHtml::activeId($model,'jns_periode'),
        'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
            ));
    ?>
    <style>
        table{
            margin-bottom: 0;
        }
        .form-actions{
            padding:4px;
            margin-top:5px;
        }
        .nav-tabs>li>a{display:block; cursor:pointer;}
        .nav-tabs > .active a:hover{cursor:pointer;}
    </style>
    <div class="row">
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
					<div class="daterange daterange-inline add-ranges input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhir)) ?>">
						<i class="entypo-calendar"></i>
						<span ><?php echo date('d M Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($model->tgl_akhir)) ?></span>
						<?php echo $form->hiddenField($model,'tgl_awal', array('class' => 'start')) ?>
						<?php echo $form->hiddenField($model,'tgl_akhir', array('class' => 'end')) ?>
					</div>
				</div>
			</div>            
		</div>        
	</div>
	<div class="row">
		<div class="col-sm-6">
			<fieldset>
			<?php
				$this->Widget('ext.bootstrap.widgets.BootAccordion', array(
					'id' => 'wilayah',
					'slide' => true,
					'content' => array(
						'content2' => array(
							'multi' => 'multi',
							'header' => 'Berdasarkan Wilayah',
							'isi' => CHtml::hiddenField('filter', 'wilayah', array('disabled' => 'disabled')) . 
								'<div class="control-group">
									'.CHtml::label('Provinsi','propinsi_id', array('class' => 'control-label')).' 
									<div class="controls">
										'.$form->dropDownList($model, 'propinsi_id', CHtml::listData($model->getPropinsiItems(), 'propinsi_id', 'propinsi_nama'),array(
										'class'=>'form-control', 'multiple'=>'multiple')).'											
									</div>
								</div>
								<div class="control-group">
									'.CHtml::label('Kabupaten','kabupaten_id', array('class' => 'control-label')).' 
									<div class="controls">												 
										'.$form->dropDownList($model,'kabupaten_id',
											array(),
											array('class'=>'form-control', 'multiple'=>'multiple')).' 													
									</div>
								</div>',
							'active' => true,
						),
					),
				));
			?>
			</fieldset>
		</div>
		<div class="col-sm-6">
			<fieldset>
				<?php
				$this->Widget('ext.bootstrap.widgets.BootAccordion', array(
					'id' => 'carabayar',
					'slide' => true,
					'content' => array(
						'content3' => array(
							'multi' => 'multi',
							'header' => 'Berdasarkan Jenis Penjamin',
							'isi' => CHtml::hiddenField('filter', 'carabayar', array('disabled' => 'disabled')) . 
								'<div class="control-group">
									'.CHtml::label('Jenis Penjamin','carabayar_id', array('class' => 'control-label')).' 
									<div class="controls">
										'.$form->dropDownList($model, 'carabayar_id', CHtml::listData($model->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama'),array(
										'class'=>'form-control', 'multiple'=>'multiple')).'											
									</div>
								</div>
								<div class="control-group">
									'.CHtml::label('Penjamin','penjamin_id', array('class' => 'control-label')).' 
									<div class="controls">												 
										'.$form->dropDownList($model,'penjamin_id',
											array(),
											array('class'=>'form-control', 'multiple'=>'multiple')).' 													
									</div>
								</div>',
							'active' => true,
						),
					),
				));
			?>
			</fieldset>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-6">
			<fieldset>
			<?php
				$this->Widget('ext.bootstrap.widgets.BootAccordion', array(
					'id' => 'instalruangan',
					'slide' => true,
					'content' => array(
						'content4' => array(
							'multi' => 'multi',
							'header' => 'Berdasarkan Instalasi dan Ruangan',
							'isi' => CHtml::hiddenField('filter', 'instalasiasal_id', array('disabled' => 'disabled')) . 
								'<div class="control-group">
									'.CHtml::label('Instalasi','instalasiasal_id', array('class' => 'control-label')).' 
									<div class="controls">
										'.$form->dropDownList($model, 'instalasiasal_id', CHtml::listData(InstalasiM::model()->findAll('instalasi_aktif = true ORDER BY instalasi_nama ASC'), 'instalasi_id', 'instalasi_nama'),array(
										'class'=>'form-control', 'multiple'=>'multiple')).'											
									</div>
								</div>
								<div class="control-group">
									'.CHtml::label('Ruangan','ruanganasal_id', array('class' => 'control-label')).' 
									<div class="controls">												 
										'.$form->dropDownList($model,'ruanganasal_id',
											array(),
											array('class'=>'form-control', 'multiple'=>'multiple')).' 													
									</div>
								</div>',
							'active' => true,
						),
					),
				));
			?>
			</fieldset>
		</div>
		<div class="col-sm-6">
			<fieldset>
			<?php
				$this->Widget('ext.bootstrap.widgets.BootAccordion', array(
					'id' => 'kunjungan',
					'slide' => true,
					'content' => array(
						'content5' => array(
							'multi' => 'multi',
							'header' => 'Berdasarkan Kunjungan',
							'isi' => CHtml::hiddenField('filter', 'kunjungan', array('disabled' => 'disabled')) . 
								'<div class="control-group">
									'.CHtml::label('Kunjungan','kunjungan', array('class' => 'control-label')).' 
									<div class="controls">
										'.$form->dropDownList($model, 'kunjungan', LookupM::getItems('kunjungan'),array(
										'class'=>'form-control', 'multiple'=>'multiple')).'											
									</div>
								</div>',
							'active' => true,
						),
					),
				));
			?>
			</fieldset>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-6">
			<?php $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
				'id'=>'grafik',
				'slide' => true,
				'content'=>array(
					'content6'=>array(
						'header'=>'Data grafik',
						'isi'=>  
							'<table>
								<tr>
									<td>'.CHtml::radioButton('tampilGrafik', true, array('name'=>'dataGrafik', 'value' => 'kunjungan')).' <label>Kunjungan</label></td>                                               
									<td>'.CHtml::radioButton('tampilGrafik', false, array('name'=>'dataGrafik', 'value' => 'carabayar')).' <label>Jenis Penjamin</label></td>                                                                                           
								</tr>                                                                                    
								<tr>
									<td>'.CHtml::radioButton('tampilGrafik', false, array('name'=>'dataGrafik', 'value' => 'instalasiasal')).' <label>Instalasi asal</label></td>
									<td>'.CHtml::radioButton('tampilGrafik', false, array('name'=>'dataGrafik', 'value' => 'ruanganasal')).' <label>Ruangan Asal</label></td>
								</tr>
								<tr>
									<td>'.CHtml::radioButton('tampilGrafik', false, array('name'=>'dataGrafik', 'value' => 'wilayah')).' <label>Wilayah</label></td>                                            
								</tr>
							</table>',          
						'active'=>TRUE,
					),
				),
			)); ?>
		</div>
	</div>
    <div class="form-actions">
        <?php
        echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
            array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan')
        );
        ?>
        <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
                    Yii::app()->createUrl($this->module->id.'/'.Yii::app()->controller->id.'/'.Yii::app()->controller->action->id.''), 
                    array('class' => 'btn btn-default',
                          'onclick'=>'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = "'.Yii::app()->createUrl($this->module->id.'/'.Yii::app()->controller->id.'/'.Yii::app()->controller->action->id.'').'";}); return false;')); ?>
    </div>  
</div>    
<?php
$this->endWidget();
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrintLembarPoli = Yii::app()->createUrl('print/lembarPoliRJ', array('pendaftaran_id' => ''));
?>