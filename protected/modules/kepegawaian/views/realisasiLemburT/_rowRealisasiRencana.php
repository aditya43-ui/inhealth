<?php 

$listLembur = BiayalemburM::model()->findAll(array(
	'order'=>'biayalembur_id',
));

//check pegawai login berdasarkan jabatan_id
$checkLoginPegawai = false;
$modePgLogin = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
if(isset($modePgLogin)){
    if($modePgLogin->jabatan_id == 71 || $modePgLogin->jabatan_id == 131 || $modePgLogin->jabatan_id == 97){
        $checkLoginPegawai = true;
    }
}

foreach ($listLembur as $item) {
	$option[$item->biayalembur_id] = array(
		'data-biasa'=>$item->biayalembur_nilai,
		'data-libur'=>$item->biayalembur_nilailibur,
	);
}

$listDataLembur = CHtml::listData($listLembur, 'biayalembur_id', 'biayalembur_nama');

foreach ($modRencanaLemburDetail as $i => $detail){ 
	$modRealisasiLemburDetail->biayalembur_id = $detail->biayalembur_id;
    $option = array();
    $cr = new CDbCriteria();
    $cr->join = 'join komponengaji_m k on k.komponengaji_id = t.komponengaji_id';
    $cr->compare('t.pegawai_id', $detail->pegawai_id);
    $cr->compare('k.komponengaji_kode', array('GP', 'TF', 'TJ','TK'));
    $kom = KomponengajipegawaiM::model()->findAll($cr);

    $kom_total = 0;
    $modRealisasiLemburDetail->upah_bulanan = 0;
    foreach ($kom as $item) {
        $kom_total += $item->nilaigaji;
    }

    $modRealisasiLemburDetail->upah_bulanan = MyFormatter::formatNumberForPrint($kom_total);
	?>
<tr>
	<td width="3%" style="text-align: center">
		<?php 			
			$modRealisasiLemburDetail->nourut = $i+1;
			echo CHtml::activeTextField($modRealisasiLemburDetail,'[detail]['.$i.']nourut',array('readonly'=>true,'class'=>'span1 integer nourut', 'style'=>'width:20px;')); 
		?>
	</td>
	<td width="15%">
		<?php echo CHtml::activeHiddenField($modRealisasiLemburDetail, '[detail]['.$i.']pegawai_id', array('readonly'=>true,'class'=>'integer pegawai_id','value'=>isset($detail->pegawai_id) ? $detail->pegawai_id : "",)); ?>
		<?php echo CHtml::activeHiddenField($modRealisasiLemburDetail, '[detail]['.$i.']rencanalemburdet_id', array('readonly'=>true,'class'=>'integer rencanalemburdet_id','value'=>isset($detail->rencanalemburdet_id) ? $detail->rencanalemburdet_id : "",)); ?>
		<?php $this->widget('MyJuiAutoComplete', array(
							'model'=>$modRealisasiLemburDetail,
							'attribute'=>'[detail]['.$i.']nomorindukpegawai',
							'source'=>'js: function(request, response) {
										   $.ajax({
											   url: "'.$this->createUrl('GetPegawai').'",
											   dataType: "json",
											   data: {
												   term_nip: request.term,
											   },
											   success: function (data) {
													   response(data);
											   }
										   })
										}',
							 'options'=>array(
								   'minLength' => 2,
									'focus'=> 'js:function( event, ui ) {
										 $(this).val( "");
										 return false;
									 }',
								   'select'=>'js:function( event, ui ) {
										$(this).val( ui.item.value);
										setPegawaiAuto(ui.item.pegawai_id,"1",$(this).parents("tr"));
										return false;
									}',
							),
							'tombolDialog'=>array('idDialog'=>'dialogPasienBadak','jsFunction'=>"setDialogPegawai(this);"),
							'htmlOptions'=>array('value'=>isset($detail->pegawai) ? $detail->pegawai->nomorindukpegawai : "",'placeholder'=>'NIP','rel'=>'tooltip','title'=>'Ketik NIP untuk mencari pasien',
								'onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'nip'),
						)); 
		?>
	</td>
	<td width="15%">
		<?php $this->widget('MyJuiAutoComplete', array(
							'model'=>$modPegawai,
							'attribute'=>'['.$i.']nama_pegawai',
							'source'=>'js: function(request, response) {
										   $.ajax({
											   url: "'.$this->createUrl('GetPegawai').'",
											   dataType: "json",
											   data: {
												   term_nama: request.term,
											   },
											   success: function (data) {
													   response(data);
											   }
										   })
										}',
							 'options'=>array(
								   'minLength' => 2,
									'focus'=> 'js:function( event, ui ) {
										 $(this).val( "");
										 return false;
									 }',
								   'select'=>'js:function( event, ui ) {
										$(this).val( ui.item.value);
										setPegawaiAuto(ui.item.pegawai_id,"1",$(this).parents("tr"));
										return false;
									}',
							),
							'tombolDialog'=>array('idDialog'=>'dialogPasienBadak','jsFunction'=>"setDialogPegawai(this);"),
							'htmlOptions'=>array('value'=>isset($detail->pegawai) ? $detail->pegawai->nama_pegawai : "",'placeholder'=>'Nama Pegawai','rel'=>'tooltip','title'=>'Ketik Nama Pegawai untuk mencari pasien',
								'onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'nama_pegawai'),
						)); 
		?>
	</td>
	<td nowrap><?php echo $this->renderPartial($this->path_view.'_jam', array('idx'=>$i, 'jam'=>'mulai', 'value'=>isset($detail->tglmulai) ? substr($detail->tglmulai, 11,8)  : ""), true); ?></td>
	<td nowrap><?php echo $this->renderPartial($this->path_view.'_jam', array('idx'=>$i, 'jam'=>'selesai', 'value'=>isset($detail->tglselesai) ? substr($detail->tglselesai, 11,8)  : ""), true); ?></td>
	<td width="12%" hidden><?php echo CHtml::activeDropDownList($modRealisasiLemburDetail,'[detail]['.$i.']biayalembur_id', $listDataLembur, array('value'=>$detail->biayalembur_id,'options'=>$option,'class'=>'span2 biayalembur_id','readonly'=>true, 'maxLength'=>5,'onkeypress'=>"return $(this).focusNextInputField(event)", 'onchange'=>'setNilaiLembur();')); ?></td>
	<td width="6%"><?php echo CHtml::activetextField($modRealisasiLemburDetail,'[detail]['.$i.']totalJam',array('value'=>"",'class'=>'span1 totalJam','readonly'=>true, 'maxLength'=>5,'onkeypress'=>"return $(this).focusNextInputField(event)", 'style'=>'text-align: right;')); ?></td>
	<td width="6%"><?php echo CHtml::activeDropDownList($modRealisasiLemburDetail,'[detail]['.$i.']total_jam_normal', [5 => "5", 7 => "7", 8 => "8"], array('value'=>"",'class'=>'span1 total_jam_normal','readonly'=>false, 'maxLength'=>5,'onkeypress'=>"return $(this).focusNextInputField(event)", 'style'=>'text-align: right;', 'onchange'=>'setNilaiLembur();')); ?></td>
        <td width="6%"><?php echo ($checkLoginPegawai==true)?CHtml::activetextField($modRealisasiLemburDetail,'[detail]['.$i.']upahsejamlembur',array('value'=>"",'class'=>'span2 upahsejamlembur','readonly'=>true, 'maxLength'=>5,'onkeypress'=>"return $(this).focusNextInputField(event)", 'style'=>'text-align: right;')):CHtml::activePasswordField($modRealisasiLemburDetail,'[detail]['.$i.']upahsejamlembur',array('value'=>"",'class'=>'span2 upahsejamlembur','readonly'=>true, 'maxLength'=>5,'onkeypress'=>"return $(this).focusNextInputField(event)", 'style'=>'text-align: right;')); ?></td>
        <td width="6%"><?php echo ($checkLoginPegawai==true)?CHtml::activetextField($modRealisasiLemburDetail,'[detail]['.$i.']upah_bulanan',array('style'=>'text-align: right;', 'class'=>'span2 upah_bulanan','readonly'=>true, 'maxLength'=>5,'onkeypress'=>"return $(this).focusNextInputField(event)")):CHtml::activePasswordField($modRealisasiLemburDetail,'[detail]['.$i.']upah_bulanan',array('style'=>'text-align: right;', 'class'=>'span2 upah_bulanan','readonly'=>true, 'maxLength'=>5,'onkeypress'=>"return $(this).focusNextInputField(event)")); ?></td>
        <td width="6%"><?php echo ($checkLoginPegawai==true)?CHtml::activetextField($modRealisasiLemburDetail,'[detail]['.$i.']upah_lembur_jam1',array('style'=>'text-align: right;', 'value'=>"",'class'=>'span2 upah_lembur_jam1','readonly'=>true, 'maxLength'=>5,'onkeypress'=>"return $(this).focusNextInputField(event)")):CHtml::activePasswordField($modRealisasiLemburDetail,'[detail]['.$i.']upah_lembur_jam1',array('style'=>'text-align: right;', 'value'=>"",'class'=>'span2 upah_lembur_jam1','readonly'=>true, 'maxLength'=>5,'onkeypress'=>"return $(this).focusNextInputField(event)")); ?></td>
	<td width="6%"><?php echo ($checkLoginPegawai==true)?CHtml::activetextField($modRealisasiLemburDetail,'[detail]['.$i.']upah_lembur_jam2',array('style'=>'text-align: right;', 'value'=>"",'class'=>'span2 upah_lembur_jam2','readonly'=>true, 'maxLength'=>5,'onkeypress'=>"return $(this).focusNextInputField(event)")):CHtml::activePasswordField($modRealisasiLemburDetail,'[detail]['.$i.']upah_lembur_jam2',array('style'=>'text-align: right;', 'value'=>"",'class'=>'span2 upah_lembur_jam2','readonly'=>true, 'maxLength'=>5,'onkeypress'=>"return $(this).focusNextInputField(event)")); ?></td>
	<td width="6%"><?php echo ($checkLoginPegawai==true)?CHtml::activetextField($modRealisasiLemburDetail,'[detail]['.$i.']upah_lembur_jam3',array('style'=>'text-align: right;', 'value'=>"",'class'=>'span2 upah_lembur_jam3','readonly'=>true, 'maxLength'=>5,'onkeypress'=>"return $(this).focusNextInputField(event)")):CHtml::activePasswordField($modRealisasiLemburDetail,'[detail]['.$i.']upah_lembur_jam3',array('style'=>'text-align: right;', 'value'=>"",'class'=>'span2 upah_lembur_jam3','readonly'=>true, 'maxLength'=>5,'onkeypress'=>"return $(this).focusNextInputField(event)")); ?></td>
	<td width="6%"><?php echo ($checkLoginPegawai==true)?CHtml::activetextField($modRealisasiLemburDetail,'[detail]['.$i.']totalNilai',array('value'=>"",'class'=>'span2 totalNilai','readonly'=>true, 'maxLength'=>5,'onkeypress'=>"return $(this).focusNextInputField(event)", 'style'=>'text-align: right;')):CHtml::activePasswordField($modRealisasiLemburDetail,'[detail]['.$i.']totalNilai',array('value'=>"",'class'=>'span2 totalNilai','readonly'=>true, 'maxLength'=>5,'onkeypress'=>"return $(this).focusNextInputField(event)", 'style'=>'text-align: right;')); ?></td>
    <td><?php echo CHtml::textArea('RealisasilemburdetT[detail]['.$i.'][alasanLembur]',isset($detail->alasanlembur) ? $detail->alasanlembur  : "",array('id'=>'RealisasilemburT_'.$i.'_alasanlembur','class'=>'span3 alasanLembur', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength'=>499,'readonly'=>false)); ?></td>
    <td width="6%" style="text-align: center;">
        <?php echo CHtml::link("<i class='entypo-cancel-circled'></i>", '#', array('onclick'=>'cancelRow(this);return false;')); ?>
    </td>
</tr>
<?php } ?>
