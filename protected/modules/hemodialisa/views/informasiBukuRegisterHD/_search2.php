
 <div class="panel panel-success"> 
        <div class="panel-heading">
                       <div class="panel-title">Pencarian Berdasarkan Kunjungan</div>
        </div>
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
    <div class="panel-body">
	<div class="row-fluid">
		<div class="span6">
			<div class="control-group">
			<?php echo CHtml::hiddenField('type', ''); ?>
			<?php //echo CHtml::hiddenField('src', ''); ?>
			<div class = 'control-label'>Tanggal Kunjungan</div>
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
			</div>
			
			<div id='searching'>
				<fieldset>
					<?php $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
						'id'=>'big',
//                                    'parent'=>false,
//                                    'disabled'=>true,
//                                    'accordion'=>false, //default
						'content'=>array(
						'content1'=>array(
							'header'=>'Berdasarkan Wilayah',
							'isi'=>'<table><tr><td>'.CHtml::hiddenField('filter', 'wilayah').'<label>Propinsi</label></td><td>'.$form->dropDownList($model, 'propinsi_id', CHtml::listData($modPasien->getPropinsiItems(), 'propinsi_id', 'propinsi_nama'), array('empty' => '-- Pilih --',
											'ajax' => array('type' => 'POST',
												'url' => $this->createUrl('SetDropdownKabupaten', array('encode' => false, 'model_nama' => $model->getNamaModel($modPasien))),
												'update' => '#'.CHtml::activeId($model, 'kabupaten_id')),
											'onkeypress' => "return $(this).focusNextInputField(event)",
											'onchange'=>"setClearDropdownKelurahan();setClearDropdownKecamatan();"
										)).'</td></tr><tr><td><label>Kabupaten</label></td><td>'.
										$form->dropDownList($model, 'kabupaten_id', CHtml::listData($modPasien->getKabupatenItems($model->propinsi_id), 'kabupaten_id', 'kabupaten_nama'), array('empty' => '-- Pilih --',
											'ajax' => array('type' => 'POST',
											'url' => $this->createUrl('SetDropdownKecamatan', array('encode' => false, 'model_nama' => $model->getNamaModel($modPasien))),
											'update' => '#'.CHtml::activeId($model, 'kecamatan_id').''),
											'onkeypress' => "return $(this).focusNextInputField(event)",
//															'onchange'=>"setClearDropdownKelurahan();"
										)).'</td></tr><tr><td><label>Kecamatan</label></td><td>'
										.$form->dropDownList($model, 'kecamatan_id', CHtml::listData($modPasien->getKecamatanItems($model->kabupaten_id),'kecamatan_id','kecamatan_nama'), array('empty' => '-- Pilih --',
											'ajax' => array('type' => 'POST',
												'url' => $this->createUrl('SetDropdownKelurahan', array('encode' => false, 'model_nama' => $model->getNamaModel($modPasien))),
												'update' => '#'.CHtml::activeId($model, 'kelurahan_id').''),
											'onkeypress' => "return $(this).focusNextInputField(event)"
										)).'</td></tr><tr><td><label>Kelurahan</label></td><td>'.
										$form->dropDownList($model, 'kelurahan_id',CHtml::listData($modPasien->getKelurahanItems($model->kecamatan_id), 'kelurahan_id', 'kelurahan_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)")).'</td></tr></table>',
							'active'=>true,
							), ),
					)); ?>      
			</fieldset>
		</div>
		</div>
		<div class="span6">
			<div class="control-group">
				<?php echo CHtml::label(' Sampai dengan', ' s/d', array('class' => 'control-label')) ?>
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
			</div>
			<fieldset>
                <?php $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
					'id'=>'kunjungan',
					'slide'=>true,
					'content'=>array(
						'content2'=>array(
							'header'=>'Berdasarkan Jenis Penjamin',
							'isi'=>'<table><tr>
										<td>'.CHtml::hiddenField('filter', 'carabayar', array('disabled'=>'disabled')).'<label>Jenis Penjamin</label></td>
										<td>'.$form->dropDownList($model, 'carabayar_id', CHtml::listData($model->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
											'ajax' => array('type' => 'POST',
												'url' => Yii::app()->createUrl('ActionDynamic/GetPenjaminPasien', array('encode' => false, 'namaModel' => ''.$model->getNamaModel().'')),
												'update' => '#'.CHtml::activeId($model, 'penjamin_id').'',  //selector to update
											),
										)).'</td>
											</tr><tr>
										<td><label>Penjamin</label></td><td>'.
										$form->dropDownList($model, 'penjamin_id', CHtml::listData($model->getPenjaminItems(), 'penjamin_id', 'penjamin_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",)).'</td></tr></table>',            
								'active'=>false,
							),
					),
//                                    'htmlOptions'=>array('class'=>'aw',)
				)); ?>
			</fieldset>
		</div>
	</div>
    <div class="form-actions">
        <?php
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'id' => 'btn_simpan',
            'ajax' => array(
                 'type' => 'GET', 
                 'url' => array("/".$this->route), 
                 'update' => '#tableLaporan',
                 'beforeSend' => 'function(){
                                      $("#tableLaporan").addClass("animation-loading");
                                  }',
                 'complete' => 'function(){
                                      $("#tableLaporan").removeClass("animation-loading");
                                  }',
             ))); 
        ?>
        <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
				Yii::app()->createUrl($this->module->id.'/'.Yii::app()->controller->id.'/'.Yii::app()->controller->action->id.''), 
					array('class'=>'btn btn-danger',
						'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
    </div>
</div>  
</div>
<?php
$this->endWidget();
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrintLembarPoli = Yii::app()->createUrl('print/lembarPoliRJ', array('pendaftaran_id' => ''));
?>
<script type="text/javascript">	
/** bersihkan dropdown kecamatan */
function setClearDropdownKecamatan()
{
    $("#<?php echo CHtml::activeId($model,"kecamatan_id");?>").find('option').remove().end().append('<option value="">-- Pilih --</option>').val('');
}
/** bersihkan dropdown kelurahan */
function setClearDropdownKelurahan()
{
    $("#<?php echo CHtml::activeId($model,"kelurahan_id");?>").find('option').remove().end().append('<option value="">-- Pilih --</option>').val('');
}
</script>


