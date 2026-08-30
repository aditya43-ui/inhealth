<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(	
	'action' => Yii::app()->createUrl($this->route),
	'method' => 'get',
	'type'=>'horizontal',
	'id'=>'search-penunjangrujukan-form',
	'focus'=>'#'.CHtml::activeId($model,'no_pendaftaran'),
	'htmlOptions'=>array(),
)); 
?>
<div class="row-fluid">
	<div class="col-sm-6">
		<div class="control-group">		
            <?php echo CHtml::label("Tanggal Rujukan",'tgl_rekam', array('class' => 'control-label')) ?>
            <div class="controls">
                <div class="daterange daterange-inline input-inline" data-format="MMMM D, YYYY" data-start-date="<?php echo date('F d, Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('F d, Y', strtotime($model->tgl_akhir)) ?>">
                    <i class="entypo-calendar"></i>
                    <span ><?php echo date('F d, Y', strtotime($model->tgl_awal)) ?> - <?php echo date('F d, Y', strtotime($model->tgl_akhir)) ?></span>
                    <?php echo $form->hiddenField($model,'tgl_awal', array('class' => 'start')) ?>
                    <?php echo $form->hiddenField($model,'tgl_akhir', array('class' => 'end')) ?>
                </div>
            </div>
        </div>
		<div class="control-group">
			<?php echo CHtml::label('No. Pendaftaran','no_pendaftaran', array('class'=>'control-label')) ?>                        
			<div class="controls">
				<?php 
					$prefix = array(
						0 => Params::PREFIX_RAWAT_DARURAT,
						1 => Params::PREFIX_RAWAT_INAP,
						2 => Params::PREFIX_RAWAT_JALAN,                                    
					);
					echo $form->dropDownList($model,'prefix_pendaftaran', PendaftaranT::model()->getColumn($prefix),array('class'=>'numbers-only', 'style'=>'width:75px;')); 
				?>
				<?php echo $form->textField($model, 'no_pendaftaran', array('class' => 'span2 numbers-only', 'maxlength' => 10,'placeholder'=>'Ketik No. Pendaftaran')); ?>                                                                
			</div>                                                
		</div>
		<div class="control-group ">
			<label for="noRekamMedik" class="control-label">No. Rekam Medik </label>
			<div class="controls">
				<?php echo CHtml::activeTextField($model,'no_rekam_medik',array('placeholder'=>'Ketik No. Rekam Medik', 'class'=>'numbers-only', 'maxlength'=>8)); ?>
			</div>
		</div>    
		<div class="control-group ">
			<label for="namaPasien" class="control-label">Nama Pasien </label>
			<div class="controls">
				<?php echo CHtml::activeTextField($model,'nama_pasien',array('placeholder'=>'Ketik Nama Pasien', 'class'=>'hurufs-only', )); ?>
			</div>
		</div> 
	</div>
	<div class="col-sm-6">
		<?php 
			$carabayar = CarabayarM::model()->findAll(array(
				'condition'=>'carabayar_aktif = true',
				'order'=>'carabayar_nourut',
			));
			foreach ($carabayar as $idx=>$item) {
				$penjamins = PenjaminpasienM::model()->findByAttributes(array(
					'carabayar_id'=>$item->carabayar_id,
					'penjamin_aktif'=>true,
			   ));
			   if (empty($penjamins)) unset($carabayar[$idx]);
			}
			$penjamin = PenjaminpasienM::model()->findAll(array(
				'condition'=>'penjamin_aktif = true',
				'order'=>'penjamin_nama',
			));
			echo $form->dropDownListRow($model,'carabayar_id', CHtml::listData($carabayar, 'carabayar_id', 'carabayar_nama'), array(
				'empty'=>'-- Pilih --',
				'class'=>'span3', 
				'ajax' => array('type'=>'POST',
					'url'=> $this->createUrl('/actionDynamic/getPenjaminPasien',array('encode'=>false,'namaModel'=>get_class($model))), 
					'success'=>'function(data){$("#'.CHtml::activeId($model, "penjamin_id").'").html(data); }',
				),
			 ));
			echo $form->dropDownListRow($model,'penjamin_id', CHtml::listData($penjamin, 'penjamin_id', 'penjamin_nama'), array('empty'=>'-- Pilih --', 'class'=>'span3', 'maxlength'=>50));
		?>		
		
		<?php
			$instalasi = InstalasiM::model()->findAllByAttributes(array(
				'instalasi_id' => array(2,3,4),
			));
			$ruangan = RuanganM::model()->findAllByAttributes(array(
				'instalasi_id' => array(2,3,4),
				'ruangan_aktif' => true,
			), array(
				'order'=>'instalasi_id, ruangan_nama',
			));
			echo $form->dropDownListRow($model,'instalasiasal_id', CHtml::listData($instalasi, 'instalasi_id', 'instalasi_nama'), array(
				'empty'=>'-- Pilih --',
				'class'=>'span3', 
				'ajax' => array('type'=>'POST',
					'url'=> $this->createUrl('/actionDynamic/getRuanganAsalDariInstalasiAsal',array('encode'=>false,'namaModel'=>get_class($model))), 
					'success'=>'function(data){$("#'.CHtml::activeId($model, "ruanganasal_id").'").html(data); }',
				),
			 ));
			echo $form->dropDownListRow($model,'ruanganasal_id', CHtml::listData($ruangan, 'ruangan_id', 'ruangan_nama'), array('empty'=>'-- Pilih --', 'class'=>'span3', 'maxlength'=>50));

		?>
		
		<div class="control-group">
				<?php echo Chtml::label("Dokter Pengirim",'pegawai_id', array('class' => 'control-label')); ?>
				<div class="controls">
					<?php
					 echo $form->hiddenField($model,'pegawai_id',array('placeholder'=>'Ketik Dokter PJP','class'=>'span3 hurufs-only','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50)); 
						$this->widget('MyJuiAutoComplete',array(
							'attribute'=>'nama_pegawai',    
							'model'=>$model,
							'sourceUrl'=> Yii::app()->createUrl('/ActionAutoComplete/DaftarAllDokter2'),
							'options'=>array(
							   'showAnim'=>'fold',
							   'minLength' => 3,
							   'focus'=> 'js:function( event, ui ) {
									//$(this).val( ui.item.label);
								//	$("#'.CHtml::activeId($model,'pegawai_id').'").val( ui.item.pegawai_id);
								//	$("#'.CHtml::activeId($model,'nama_pegawai').'").val( ui.item.label);
									return false;
								}',
								'select'=>'js:function( event, ui ) {                                     
									$(this).val( ui.item.label);
									$("#'.CHtml::activeId($model,'pegawai_id').'").val( ui.item.pegawai_id);         
									//$("#'.CHtml::activeId($model,'nama_pegawai').'").val( ui.item.label);
								}'

							),
							'tombolDialog'=>array('idDialog'=>'dialogDokter'),
							'htmlOptions'=>array('onblur'=>'cekClear();','placeholder'=>'Ketik Dokter Pengirim','onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'hurufs-only span3'),
						));
					?>
				</div>
			</div>
		
		<div class="control-group">
			<?php echo CHtml::label("Status Periksa",'',array('class' => 'control-label')); ?>
			<div class="controls">
				<?php echo $form->dropDownList($model,'statusperiksa', LookupM::getItems('statusperiksa'),array('class'=>'span3', 'empty'=>'-- Pilih --')); ?>
			</div>
		</div>
	</div>
</div>
<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="'.MyIcon::getIcons('cari').'"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit','name'=>'submitSearch')); ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="'.MyIcon::getIcons('ulang').'"></i>')), 
		$this->createUrl($this->id.'/index'), 
		array('class'=>'btn btn-danger',
//                                      'onclick'=>'if(!confirm("Apakah anda ingin mengulang ini ?")) return false;'));
		'onclick'=>'myConfirm("Apakah anda yakin ingin mengulang data ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));
        echo "&nbsp;"; ?>
    <?php 
		$content = $this->renderPartial('../tips/informasi_pasien_rujukan',array(),true);
		$this->widget('UserTips',array('type'=>'transaksi','content'=>$content));  ?>
</div>
<?php $this->endWidget(); ?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
    'id'=>'dialogDokter',
    'options'=>array(
        'title'=>'Pencarian Dokter Pengirim',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>600,
        'resizable'=>false,
    ),
));

$modDokter = new DokterV('search');
$modDokter->unsetAttributes();
if(isset($_GET['DokterV'])){
    $modDokter->attributes = $_GET['DokterV'];    
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'pegawaiYangMengajukan-m-grid',
    'dataProvider'=>$modDokter->searchAllDokter(),
    'filter'=>$modDokter,
    'template'=>"{summary}\n{items}\n{pager}",
    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
        array(
            'header'=>'Pilih',
            'type'=>'raw',
            'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn_small",
                "id"=>"selectPegawai",
                "onClick"=>"                            
                            $(\"#'.CHtml::activeId($model,'nama_pegawai').'\").val(\"$data->namaLengkap\");                            
                            $(\"#'.CHtml::activeId($model,'pegawai_id').'\").val(\"$data->pegawai_id\");                            
                            $(\"#dialogDokter\").dialog(\"close\");
                            return false;"
                ))'
        ),
        
        //'gelardepan',
        array(
            'header' => 'NIP',
            'value' => '$data->nomorindukpegawai',
            'name' => 'nomorindukpegawai',
            'filter' => Chtml::activeTextField($modDokter, 'nomorindukpegawai', array('class'=>'numbers-only')),
        ),
         array(
            'name'=>'nama_pegawai',
            'header'=>'Nama Dokter',
            'value'=>'$data->namaLengkap',
             'filter' => Chtml::activeTextField($modDokter, 'nama_pegawai', array('class'=>'hurufs-only')),
         ),       
        array(
            'header'=>'Jabatan',            
            'name'=>'jabatan_id',            
            'value' => function($data){
                $j = JabatanM::model()->findByPk($data->jabatan_id);
                
                if (!empty($j)){
                    return $j->jabatan_nama;
                }else{
                    return '-';
                }
            },
            'filter' => Chtml::activeDropDownList($modDokter, 'jabatan_id',  Chtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'),array('empty'=>'-- Pilih --'))
         ),
    ),
    'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});'
    . '$(".numbers-only").keyup(function() {
        setNumbersOnly(this);
        });
        $(".hurufs-only").keyup(function() {
        setHurufsOnly(this);
        });                '
    . '}',
));
        
$this->endWidget();
?>

<script>
    function cekClear(){
        var nama_pegawai = $("#LBPasienKirimKeUnitLainV_nama_pegawai").val();

        if (nama_pegawai == ''){
            $("#LBPasienKirimKeUnitLainV_pegawai_id").val('');
        }
    }
</script>
