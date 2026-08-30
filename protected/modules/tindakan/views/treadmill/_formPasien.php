<?php echo CHtml::activeHiddenField($modTreadmill, 'treadmill_id', array('readonly'=>true)); ?>
<?php echo CHtml::activeHiddenField($modTreadmill, 'pasien_id', array('readonly'=>true)); ?>
<?php echo CHtml::activeHiddenField($modTreadmill, 'pendaftaran_id', array('readonly'=>true)); ?>
<table style="width: 100%; border: none;">
	<tr>
		<td width="50%">
			<div class="control-group">
				<?php echo CHtml::label('Tgl. Pendaftaran','tglpendaftaran', array('class'=>'control-label')) ?>
				<div class="controls">
					: <span id="tglpendaftaran"></span>
				</div>
			</div>
			<div class="control-group">
				<?php echo CHtml::label('No. Pendaftaran','nopendaftaran', array('class'=>'control-label')) ?>
				<div class="controls">
					: <span id="nopendaftaran"></span>
				</div>
			</div>
			<div class="control-group">
				<?php echo CHtml::label('Tgl. Lahir / Umur','tgllahirumur', array('class'=>'control-label')) ?>
				<div class="controls">
					: <span id="tgllahirumur"></span>
				</div>
			</div>
			<div class="control-group">
				<?php echo CHtml::label('Kasus Penyakit','jeniskasuspenyakit', array('class'=>'control-label')) ?>
				<div class="controls">
					: <span id="jeniskasuspenyakit"></span>
				</div>
			</div>
			<div class="control-group">
				<?php echo CHtml::label('Golongan Darah','goldarah', array('class'=>'control-label')) ?>
				<div class="controls">
					: <span id="goldarah"></span>
				</div>
			</div>
		</td>
		<td width="50%">
			<div class="control-group">
				<?php echo CHtml::label('No. Rekam Medik','noRekamMedik', array('class'=>'control-label')) ?>
				<div class="controls">
					<?php $this->widget('MyJuiAutoComplete',array(
						'name'=>'noRekamMedik',
						'value'=>'',
						'options'=>array(
						   'showAnim'=>'fold',
						   'minLength' => 2,
						   'focus'=> 'js:function( event, ui ) {
								$("#noRekamMedik").val( ui.item.value );
								return false;
							}',
						   'select'=>'js:function( event, ui ) {
								ambilOdontogram(ui.item.pasien_id,ui.item.pendaftaran_id);
								$("#tglpendaftaran").text(ui.item.tgl_pendaftaran);
								$("#nopendaftaran").text(ui.item.no_pendaftaran);
								$("#tgllahirumur").text(ui.item.tanggal_lahir+" / "+ui.item.umur);
								$("#jeniskasuspenyakit").text(ui.item.jeniskasuspenyakit_nama);
								$("#goldarah").text(ui.item.golongandarah);
								$("#namapegawai").text(ui.item.nama_pegawai);
								$("#namapasien").text(ui.item.nama_pasien);
								$("#binbinti").text(ui.item.nama_bin);
								$("#jeniskelamin").text(ui.item.jeniskelamin);
								$("#alamat").text(ui.item.alamat_pasien);

								return false;
							}',

						),
						'htmlOptions'=>array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span2 numbersOnly'),
						'tombolDialog'=>array('idDialog'=>'dialogDaftarPasien','idTombol'=>'tombolPasienDialog'),
					)); ?>
				</div>
			</div>
			<div class="control-group">
				<?php echo CHtml::label('Nama Pasien','namapasien', array('class'=>'control-label')) ?>
				<div class="controls">
					: <span id="namapasien"></span>
				</div>
			</div>
			<div class="control-group">
				<?php echo CHtml::label('Nama Panggilan','binbinti', array('class'=>'control-label')) ?>
				<div class="controls">
					: <span id="binbinti"></span>
				</div>
			</div>
			<div class="control-group">
				<?php echo CHtml::label('Jenis Kelamin','jeniskelamin', array('class'=>'control-label')) ?>
				<div class="controls">
					: <span id="jeniskelamin"></span>
				</div>
			</div>
			<div class="control-group">
				<?php echo CHtml::label('Alamat','alamat', array('class'=>'control-label')) ?>
				<div class="controls">
					: <span id="alamat"></span>
				</div>
			</div>
		</td>
	</tr>
</table>

<?php 
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
			'id'=>'dialogDaftarPasien',
			'options'=>array(
				'title'=>'Daftar Pasien',
				'autoOpen'=>false,
				'resizable'=>false,
				'modal'=>true,
				'width'=>900,
				'height'=>600,
				 'close'=>"js:function(){ $.fn.yiiGridView.update('daftarpasien-v-grid', {
						data: $('#RJInfokunjunganrjV_statusperiksa').serialize()
						}); }",

			),
		));
$kunjunganPasien = new RJInfokunjunganrjV('searchKunjunganPasien');
if(isset($_GET['RJInfokunjunganrjV'])){
	$kunjunganPasien->attributes = $_GET['RJInfokunjunganrjV'];
	$format = new MyFormatter();
	$kunjunganPasien->tgl_pendaftaran  = $format->formatDateTimeForDb($_REQUEST['RJInfokunjunganrjV']['tgl_pendaftaran']);
	$kunjunganPasien->statusperiksa  = $_REQUEST['RJInfokunjunganrjV']['statusperiksa'];

}
	$this->widget('ext.bootstrap.widgets.BootGridView',array(
		'id'=>'daftarpasien-v-grid',
		'dataProvider'=>$kunjunganPasien->searchKunjunganPasien(),
		'template'=>"{summary}\n{items}\n{pager}",
		'itemsCssClass'=>'table table-striped table-bordered table-condensed',
		'filter'=>$kunjunganPasien,
		'columns'=>array(	
				array(
					'header'=>'Pilih',
					'type'=>'raw',
					'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
								"id" => "selectPasien",
								"onClick" => "setPasien($data->pasien_id,$data->pendaftaran_id);
											$(\'#dialogDaftarPasien\').dialog(\'close\');
										return false;"))',

				),
				'no_rekam_medik',	
				//tgl_pendaftaran',
				array(
					'name'=>'tgl_pendaftaran',
					'value'=>'$data->tgl_pendaftaran',
					'filter'=>$this->widget('MyDateTimePicker',array(
					'model'=>$kunjunganPasien,
					'attribute'=>'tgl_pendaftaran',
					'mode'=>'date',
					'options'=> array(
						'dateFormat'=>Params::DATE_FORMAT
					),
						'htmlOptions'=>array('readonly'=>false, 'class'=>'dtPicker3','onclick'=>'showDateTime();'),
					),true
					),
					'htmlOptions'=>array('width'=>'80','style'=>'text-align:center'),
				),
				'no_pendaftaran',
				'nama_pasien', 
				'alamat_pasien',
				'penjamin_nama',
				'nama_pegawai',
				'jeniskasuspenyakit_nama',

				array(
					'name'=>'statusperiksa',
					'type'=>'raw',
					'value'=>'$data->statusperiksa',
					'filter' => CHtml::listData(RJInfokunjunganrjV::model()->findAll(),'statusperiksa', 'statusperiksa'),
					// 'filter' =>CHtml::activeDropDownList($kunjunganPasien,'statusperiksa',
					//     LookupM::getItems('statusperiksa'),array('options' => array('ANTRIAN'=>array('selected'=>true)))),
				),
		),
		'afterAjaxUpdate'=>'function(id, data){
			jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});

			jQuery(\'#RJInfokunjunganrjV_tgl_pendaftaran\').datepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional[\'id\'], {\'dateFormat\':\'dd M yy\',\'maxDate\':\'d\',\'timeText\':\'Waktu\',\'hourText\':\'Jam\',\'minuteText\':\'Menit\',
				\'secondText\':\'Detik\',\'showSecond\':true,\'timeOnlyTitle\':\'Pilih Waktu\',\'timeFormat\':\'hh:mms\',
				\'changeYear\':true,\'changeMonth\':true,\'showAnim\':\'fold\',\'yearRange\':\'-80y:+20y\'})); 
		}',

)); 

$this->endWidget('zii.widgets.jui.CJuiDialog');
?>

<script type="text/javascript">

function setPasien(pasien_id,pendaftaran_id)
{
	$('#form-infopasien').addClass('animation-loading');
	$.post('<?php echo $this->createUrl('SetPasien'); ?>', {pasien_id:pasien_id,pendaftaran_id:pendaftaran_id}, function(data){
		$('#<?php echo CHtml::activeId($modTreadmill, 'pasien_id') ?>').val(pasien_id);
		$('#<?php echo CHtml::activeId($modTreadmill, 'pendaftaran_id') ?>').val(pendaftaran_id);
		$('#tglpendaftaran').html(data.modKunjungan.tgl_pendaftaran);
		$('#nopendaftaran').html(data.modKunjungan.no_pendaftaran);
		$('#tgllahirumur').html(data.modKunjungan.tanggal_lahir+' / '+data.modKunjungan.umur);
		$('#jeniskasuspenyakit').html(data.modKunjungan.jeniskasuspenyakit_nama);
		$('#goldarah').html(data.modKunjungan.golongandarah);
		$('#noRekamMedik').val(data.modKunjungan.no_rekam_medik);
		$('#namapasien').html(data.modKunjungan.nama_pasien);
		$('#binbinti').html(data.modKunjungan.nama_bin);
		$('#jeniskelamin').html(data.modKunjungan.jeniskelamin);
		$('#alamat').html(data.modKunjungan.alamat_pasien);
		$('#rowfuild-infopasien').addClass('well');
		$('#form-infopasien').removeClass('animation-loading');
		$('#btn-input').attr('disabled',false);
		
		clearInputanDefault();
		if(data.modTreadmill!=null){
			$('#form-treadmill').addClass('animation-loading');
			setTimeout(function(){
				$('#form-treadmilldetail-mcu > tbody').append(data.form);
				$('#<?php echo CHtml::activeId($modTreadmill, 'treadmill_id') ?>').val(data.modTreadmill.treadmill_id);
				$('#<?php echo CHtml::activeId($modTreadmill,'resttime_menit'); ?>').val(data.modTreadmill.resttime_menit);
				$('#<?php echo CHtml::activeId($modTreadmill,'worktime_menit'); ?>').val(data.modTreadmill.worktime_menit);
				$('#<?php echo CHtml::activeId($modTreadmill,'recoverytime_menit'); ?>').val(data.modTreadmill.recoverytime_menit);
				$('#<?php echo CHtml::activeId($modTreadmill,'totaltime_menit'); ?>').val(data.modTreadmill.totaltime_menit);
				$('#<?php echo CHtml::activeId($modTreadmill,'interpretation_tradmill'); ?>').val(data.modTreadmill.interpretation_tradmill);
				$('#<?php echo CHtml::activeId($modTreadmill,'namapemeriksa_treadmill'); ?>').val(data.modTreadmill.namapemeriksa_treadmill);
				$('#rowfuild-treadmill').addClass('well');
				$('#rowfuild-treadmill2').addClass('well');
				$('#form-treadmill').removeClass('animation-loading');
				
				$('#btn-print .btn').attr('disabled',false);
				$('#btn-print .btn').attr('onclick','print("PRINT",'+data.modTreadmill.treadmill_id+','+data.modTreadmill.pendaftaran_id+')');
				$('#btn-diagram .btn').detach();
				$('#btn-diagram').html('<a class="btn btn-primary" href="<?php echo $this->createUrl($this->id.'/grafik'); ?>&treadmill_id='+data.modTreadmill.treadmill_id+'&pendaftaran_id='+data.modTreadmill.pendaftaran_id+'" onclick="$(\'#dialogGrafik\').dialog(\'open\');" target="frameDiagramTreadmillRJ"><i class="entypo-print"></i> Diagram</a>');
				renameInputRowTreadmill($("#form-treadmilldetail-mcu"));
			},500);
		}
	}, 'json');
}

function clearInputanDefault(){
    $('#form-treadmilldetail-mcu tbody').empty();
	$('#<?php echo CHtml::activeId($modTreadmill,'treadmill_id'); ?>').val('');
	$('#<?php echo CHtml::activeId($modTreadmill,'resttime_menit'); ?>').val('');
	$('#<?php echo CHtml::activeId($modTreadmill,'worktime_menit'); ?>').val('');
	$('#<?php echo CHtml::activeId($modTreadmill,'recoverytime_menit'); ?>').val('');
	$('#<?php echo CHtml::activeId($modTreadmill,'totaltime_menit'); ?>').val('');
	$('#<?php echo CHtml::activeId($modTreadmill,'interpretation_tradmill'); ?>').val('');
	$('#<?php echo CHtml::activeId($modTreadmill,'namapemeriksa_treadmill'); ?>').val('');
	$('#btn-print .btn').attr('disabled',true);
	$('#btn-print .btn').attr('onclick','');
	$('#btn-diagram .btn').detach();
	$('#btn-diagram').html('<button class="btn btn-primary" name="yt3" type="button" disabled="disabled"><i class="entypo-print"></i> Diagram</button>');
}

</script>