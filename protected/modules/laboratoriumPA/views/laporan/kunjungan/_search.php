<div class="search-form" style="">
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'type' => 'horizontal',
        'id' => 'searchLaporan',
        'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
            ));
    
    $format = new MyFormatter;
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
    </div>
	<div class="row-fluid">
		<div class="col-sm-6">
			<?php
				$this->Widget('ext.bootstrap.widgets.BootAccordion', array(
					'id' => 'wilayah',
					'slide' => true,
					'content' => array(
						'content2' => array(
							'multi' => 'multi',
							'header' => 'Berdasarkan Wilayah',
							'isi' => CHtml::hiddenField('filter', 'propinsi_id', array('disabled' => 'disabled')) . 
								'<div class="control-group">
									'.CHtml::label('Propinsi','propinsi_id', array('class' => 'control-label')).' 
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
		</div>
		<div class="col-sm-6">
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
		</div>
	</div>
	<div class="row-fluid">
		<div class="col-sm-6">
			<?php
				//$model->kunjungan = array('KUNJUNGAN BARU','KUNJUNGAN ULANG');
                $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                    'id' => 'kunjungan',
                    'slide' => true,
                    'content' => array(
                        'content4' => array(
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
		</div>
		<div class="col-sm-6">			
			<?php $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
				'id'=>'grafik',
				'slide'=>false,
				'content'=>array(
					'content5'=>array(
						'header'=>'Data grafik',
						'isi'=> 
							'<table>
								<tr>
									<td>'.CHtml::radioButton('tampilGrafik', true, array('name'=>'dataGrafik', 'value' => 'wilayah')).' <label>Wilayah</label></td>                                               
									<td>'.CHtml::radioButton('tampilGrafik', false, array('name'=>'dataGrafik', 'value' => 'carabayar')).' <label>Jenis Penjamin</label></td>                                                                                           
								</tr>                                                                                    
								<tr>
									<td>'.CHtml::radioButton('tampilGrafik', false, array('name'=>'dataGrafik', 'value' => 'instalasiasal')).' <label>Instalasi asal</label></td>
									<td>'.CHtml::radioButton('tampilGrafik', false, array('name'=>'dataGrafik', 'value' => 'ruanganasal')).' <label>Ruangan Asal</label></td>
								</tr>
								<tr>
									<td>'.CHtml::radioButton('tampilGrafik', true, array('name'=>'dataGrafik', 'value' => 'kunjungan')).' <label>Kunjungan</label></td>
								</tr>                                                                                    
							</table>',          
						'active'=>TRUE,
					),
				),    
			)); ?>	
		</div>
	</div>
	<div class="row-fluid">
		<div class="col-sm-6">
			<?php
				$this->Widget('ext.bootstrap.widgets.BootAccordion', array(
					'id' => 'instalasi',
					'slide' => true,
					'content' => array(
						'content4' => array(
							'multi' => 'multi',
							'header' => 'Berdasarkan Instalasi dan Ruangan',
							'isi' => CHtml::hiddenField('filter', 'carabayar', array('disabled' => 'disabled')) . 
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
										'.$form->dropDownList($model,'ruanganasal_id', array(),									
											array('class'=>'form-control', 'multiple'=>'multiple')).' 													
									</div>
								</div>',
							'active' => true,
						),
					),
				));
			?>
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
<?php $this->renderPartial('_jsFunctions', array('model' => $model)); ?>