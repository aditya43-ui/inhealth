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

        #penjamin label.checkbox{
            width: 100px;
            display:inline-block;
        }

    </style>
   <div class="row-fluid">
		<div class="col-sm-6">
			<?php //$format = new MyFormatter(); ?>
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
                    'id' => 'statusbayar',
                    'slide' => true,
                    'content' => array(
                        'content2' => array(
                            'multi' => 'multi',
                            'header' => 'Berdasarkan Status Bayar',
                            'isi' => CHtml::hiddenField('filter', 'tindakansudahbayar_id', array('disabled' => 'disabled')) . 
                                '<div class="control-group">
                                    '.CHtml::label('Status Bayar','tindakansudahbayar_id', array('class' => 'control-label')).' 
                                    <div class="controls">
                                        '.$form->dropDownList($model, 'tindakansudahbayar_id', CustomFunction::getStatusBayar(),array(
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
                $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                    'id' => 'dokter',
                    'slide' => true,
                    'content' => array(
                        'content4' => array(
                            'multi' => 'multi',
                            'header' => 'Berdasarkan Dokter',
                            'isi' => CHtml::hiddenField('filter', 'nama_pegawai', array('disabled' => 'disabled')) . 
                                '<div class="control-group">
                                    '.CHtml::label('Dokter','nama_pegawai', array('class' => 'control-label')).' 
                                    <div class="controls">
                                        '.$form->dropDownList($model,'nama_pegawai',  CHtml::listData(DokterV::model()->findAll("pegawai_aktif = TRUE AND ruangan_id = '".Yii::app()->user->getState('ruangan_id')."'  "), 'nama_pegawai', 'namaLengkap'),array(
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
			<?php 
				$this->Widget('ext.bootstrap.widgets.BootAccordion',array(
				'id'=>'grafik',
				'slide'=>false,
				'content'=>array(
					'content5'=>array(
						'header'=>'Data grafik',
						'isi'=> 
							'<table>                                                                               
								<tr>
									<td>'.CHtml::radioButton('tampilGrafik', true, array('name'=>'dataGrafik', 'value' => 'statusbayar')).' <label>Status Bayar</label></td>
									<td>'.CHtml::radioButton('tampilGrafik', false, array('name'=>'dataGrafik', 'value' => 'carabayar')).' <label>Jenis Penjamin</label></td>
								</tr>                                       
								<tr>
									<td>'.CHtml::radioButton('tampilGrafik', false, array('name'=>'dataGrafik', 'value' => 'dokter')).' <label>Dokter</label></td>                                                 
								</tr>
							</table>',          
						'active'=>TRUE,
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
    <?php //$this->widget('UserTips', array('type' => 'create')); ?>    
</div>
<?php
$this->endWidget();
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrintLembarPoli = Yii::app()->createUrl('print/lembarPoliRJ', array('pendaftaran_id' => ''));
?>

<?php Yii::app()->clientScript->registerScript('cekAll','
  $("#big").find("input").attr("checked", "checked");
  $("#kelasPelayanan").find("input").attr("checked", "checked");
',  CClientScript::POS_READY);
?>
<script>
function checkAll() {
    if ($("#checkAllCaraBayar").is(":checked")) {
        $('#penjamin input[name*="penjamin_id"]').each(function(){
           $(this).attr('checked',true);
        })
//        myAlert('Checked');
    } else {
       $('#penjamin input[name*="penjamin_id"]').each(function(){
           $(this).removeAttr('checked');
        })
    }
}   
</script>
<?php $this->renderPartial('_jsFunctions', array('model' => $model)); ?>