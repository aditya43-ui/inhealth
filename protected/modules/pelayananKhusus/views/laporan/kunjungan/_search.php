<?php
/**
 * form pencarian 
 * 
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link    <http://piindonesia.co.id>
 */
?>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title"><i class="entypo-search"></i> Pencarian</div>
    </div>
    <div class="panel-body">
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
             #jeniss label.checkbox, .ruangan span label.checkbox{
                width: 150px;
                display:inline-block;
            }
        </style>
           <div class = "row-fluid">
        <div class="col-sm-6">
			<?php echo CHtml::hiddenField('type', ''); ?>
			<div class="control-group">				
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
	<div class="row-fluid">
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
	<div class="row-fluid">
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
										'.$form->dropDownList($model, 'instalasiasal_id', CHtml::listData(InstalasiM::model()->getDropInsPelayanan(), 'instalasi_id', 'instalasi_nama'),array(
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
	<div class="row-fluid">
		<div class="col-sm-6">
			<?php $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
				'id'=>'grafik',
				'slide'=>false,
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
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'id' => 'btn_simpan'));
            ?>
                    <?php
     echo CHtml::htmlButton(Yii::t('mds','{icon} Ualng',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),
                                                                            array('class'=>'btn btn-danger','onclick'=>'konfirmasi()','onKeypress'=>'return formSubmit(this,event)'));
    ?> 
        </div>
        <?php //$this->widget('UserTips', array('type' => 'create')); ?>    
    </div>    
    </div>
</div>
<?php
$this->endWidget();
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrintLembarPoli = Yii::app()->createUrl('print/lembarPoliRJ', array('pendaftaran_id' => ''));

$this->renderPartial("_jsFunctions",array('model'=>$model));
?>