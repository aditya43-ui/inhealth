<?php 
$tindakan = new RITindakanPelayananT();
	if(count((array)$modTindakans) > 0){ 
		foreach($modTindakans as $i=>$tindakan){
			$tindakan->kategoriTindakanNama = $tindakan->daftartindakan->kategoritindakan->kategoritindakan_nama;
			$tindakan->tgl_tindakan = MyFormatter::formatDateTimeForUser($tindakan->tgl_tindakan);
			$tindakan->daftartindakanNama = $tindakan->daftartindakan->daftartindakan_nama;
			$tindakan->nama_pegawai = isset($tindakan->dokter1->NamaLengkap) ? $tindakan->dokter1->NamaLengkap : "";
			$tindakan->rencanatindakan_id = !empty($tindakan->rencanatindakan_id) ? $tindakan->rencanatindakan_id : null;
			$tindakan->daftartindakanNama = $tindakan->daftartindakan->daftartindakan_nama;
			$tindakan->kategoriTindakanNama = $tindakan->daftartindakan->kategoritindakan->kategoritindakan_nama;
			$tindakan->tgl_tindakan = MyFormatter::formatDateTimeForUser($tindakan->tgl_tindakan);
			$tindakan->qty_tindakan = $tindakan->qty_tindakan;
			$tindakan->jumlahTarif = MyFormatter::formatNumberForPrint($tindakan->qty_tindakan * $tindakan->tarif_satuan);
			$tindakan->tarif_satuan = MyFormatter::formatNumberForPrint($tindakan->tarif_satuan);
			$tindakan->satuantindakan = $tindakan->satuantindakan;
			$tindakan->cyto_tindakan = $tindakan->cyto_tindakan;
			$tindakan->nama_pegawai = isset($tindakan->dokter1->NamaLengkap) ? $tindakan->dokter1->NamaLengkap : "";
			$tindakan->pegawai_id = $tindakan->dokterpemeriksa1_id;
			$tindakan->daftartindakan_id = $tindakan->daftartindakan_id;
			$tindakan->keterangantindakan = $tindakan->keterangantindakan;
			$tindakan->subsidiasuransi_tindakan = $tindakan->subsidiasuransi_tindakan;
			$tindakan->subsidipemerintah_tindakan = $tindakan->subsidipemerintah_tindakan;
			$tindakan->subsisidirumahsakit_tindakan = $tindakan->subsisidirumahsakit_tindakan;
			$tindakan->iurbiaya_tindakan = $tindakan->iurbiaya_tindakan;
			$tindakan->status = 'Pelayanan';
?>
<tr>
    <td>
		<?php echo CHtml::hiddenField('no_urut',0,array('readonly'=>true,'class'=>'span1 integer2', 'style'=>'width:20px;')); ?>
		<?php echo CHtml::activeTextField($tindakan, '[0]kategoriTindakanNama', array('readonly'=>true,'class'=>'span2')) ?></td>
	<td><div class="input-append"><?php echo CHtml::activeTextField($tindakan, '[0]tgl_tindakan', array('readonly'=>true,'class'=>'tanggal dtPicker2', 'style'=>'float:left;')); ?><span class="add-on"><i class="entypo-calendar"></i><i class="icon-time"></i></span></div></td>
    <td><?php echo CHtml::activeHiddenField($tindakan, '[0]daftartindakan_id', array('readonly'=>true,'class'=>'span1 required')) ?>
        <?php $this->widget('MyJuiAutoComplete',array(
				'model'=>$tindakan,
				'attribute'=>'[0]daftartindakanNama',
				'value'=>$tindakan->daftartindakan->daftartindakan_nama,
				'source'=>'js: function(request, response) {
							   $.ajax({
								   url: "'.$this->createUrl('DaftarTindakan').'",
								   dataType: "json",
								   data: {
									   term: request.term,
									   tipepaket_id: '.Params::TIPEPAKET_ID_NONPAKET.',
									   kelaspelayanan_id: $("#kelaspelayanan_id").val(),
									   penjamin_id: $("#penjamin_id").val(),
								   },
								   success: function (data) {
										   response(data);
								   }
							   })
							}',
				'options'=>array(
				   'showAnim'=>'fold',
				   'minLength' => 2,
				   'focus'=> 'js:function( event, ui ) {
						$(this).val( ui.item.label);
						return false;
					}',
				   'select'=>'js:function( event, ui ) {
						setTindakan($(this), ui.item);
						return false;
					}',

				),
				'tombolDialog'=>array("idDialog"=>'dialogDaftarTindakanPaket','jsFunction'=>"setDialog(this);"),
				'htmlOptions'=>array('onkeypress'=>"return $(this).focusNextInputField(event)"),
        )); ?>
        
        <?php echo CHtml::activeHiddenField($tindakan, '[0]tarif_satuan', array('readonly'=>true,'class'=>'span1 integer2')) ?>
        <?php echo CHtml::activeHiddenField($tindakan, '[0]subsidiasuransi_tindakan', array('readonly'=>true,'class'=>'span1 integer2')) ?>
        <?php echo CHtml::activeHiddenField($tindakan, '[0]subsidipemerintah_tindakan', array('readonly'=>true,'class'=>'span1 integer2')) ?>
        <?php echo CHtml::activeHiddenField($tindakan, '[0]subsisidirumahsakit_tindakan', array('readonly'=>true,'class'=>'span1 integer2')) ?>
        <?php echo CHtml::activeHiddenField($tindakan, '[0]iurbiaya_tindakan', array('readonly'=>true,'class'=>'span1 integer2')) ?>
        <?php echo CHtml::activeHiddenField($tindakan, '[0]rencanatindakan_id', array('readonly'=>true,'class'=>'span1 integer2')) ?>
        <?php echo CHtml::activeHiddenField($tindakan, '[0]status', array('readonly'=>true,'class'=>'span1')) ?>
    </td>
	<td <?php echo Params::HIDDEN_HARGA ?>>
        <?php echo CHtml::activeTextField($tindakan, '[0]tarif_satuan', array('readonly'=>true,'class'=>'span2 integer2')) ?>
        
    </td> 
    <td><?php echo CHtml::activeTextField($tindakan, '[0]qty_tindakan', array('onblur'=>'hitungSubtotal(this)','onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span1 integer2 ')) ?></td>
    <td><?php echo CHtml::activeDropDownList($tindakan, '[0]satuantindakan', LookupM::getItems('satuantindakan'),array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span1','style'=>'width:60px')) ?></td>
    <td>
        <?php echo CHtml::activeHiddenField($tindakan, '[0]persenCyto', array('readonly'=>true,'class'=>'span1')) ?>
        <?php echo CHtml::activeDropDownList($tindakan, '[0]cyto_tindakan', array('0'=>'Tidak','1'=>'Ya'), array('onchange'=>'hitungCyto(this)','onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span1','style'=>'width:60px')) ?>
		<?php echo CHtml::activeHiddenField($tindakan, '[0]tarifcyto_tindakan', array('readonly'=>true,'class'=>'span1 integer2')) ?>
    </td>
    <td <?php echo Params::HIDDEN_HARGA ?>> 
      <?php echo CHtml::activeTextField($tindakan, '[0]jumlahTarif', array('readonly'=>true,'class'=>'span2 integer2')) ?>
    </td>
    <td> 
      <?php echo CHtml::activeHiddenField($tindakan, '[0]pegawai_id', array('readonly'=>true,'class'=>'span1')) ?>
        <?php $this->widget('MyJuiAutoComplete',array(
				'model'=>$tindakan,
				'attribute'=>'[0]nama_pegawai',
				'source'=>'js: function(request, response) {
							   $.ajax({
								   url: "'.$this->createUrl('AutocompleteDokter').'",
								   dataType: "json",
								   data: {
									   term: request.term,
								   },
								   success: function (data) {
										   response(data);
								   }
							   })
							}',
				'options'=>array(
				   'showAnim'=>'fold',
				   'minLength' => 2,
				   'focus'=> 'js:function( event, ui ) {
						$(this).val( ui.item.label);
						return false;
					}',
				   'select'=>'js:function( event, ui ) {
						setTindakan($(this), ui.item);
						return false;
					}',

				),
				'tombolDialog'=>array("idDialog"=>'dialogDaftarDokter','jsFunction'=>"setDialogDokter(this);"),
				'htmlOptions'=>array('onkeypress'=>"return $(this).focusNextInputField(event)", ),
        )); ?>
    </td>
    <td style='text-align: center;'> 
      <?php echo isset($modTindakan->rencanatindakan_id) ? "Telah Di-Verifikasi" : "Telah Di-Verifikasi"; ?>
    </td>
    <td> 
      <?php echo CHtml::activeTextField($tindakan, '[0]keterangantindakan', array('readonly'=>false,'class'=>'span2')) ?>
    </td>
    <!--<td>-->
        <?php 
//            if(!isset($removeButton)){
//                $removeButton = false;
//            }
//            if($removeButton){
//                echo CHtml::link("<i class='icon-plus'></i>", '#', array('onclick'=>'addRowTindakan(this);return false;','rel'=>'tooltip','title'=>'Klik untuk menambah tindakan')); 
//                echo "<br><br>";
//                echo CHtml::link("<i class='icon-form-silang'></i>", '#', 
//					array(
//						'onclick'=>'deleteTindakan(this,'.$tindakan->tindakanpelayanan_id.');return false;',
//						'rel'=>'tooltip','title'=>'Klik untuk menghapus tindakan'
//					)
//				); 
//            } else {
//                echo CHtml::link("<i class='icon-plus'></i>", '#', array('onclick'=>'addRowTindakan(this);return false;','rel'=>'tooltip','title'=>'Klik untuk menambah tindakan'));
//            }
        ?>
    <!--</td>-->
</tr>
<?php } }else{ ?>
<tr class="tindakan-baru">
    <td>
		<?php echo CHtml::hiddenField('no_urut',0,array('readonly'=>true,'class'=>'span1 integer2', 'style'=>'width:20px;')); ?>
		<?php echo CHtml::activeTextField($modTindakan, '[0]kategoriTindakanNama', array('readonly'=>true,'class'=>'span1')) ?></td>
	<td><div class="input-append"><?php echo CHtml::activeTextField($modTindakan, '[0]tgl_tindakan', array('readonly'=>true,'class'=>'tanggal dtPicker2', 'style'=>'float:left;','value'=>date('Y-m-d H:i:s'))); ?><span class="add-on"><i class="entypo-calendar"></i><i class="icon-time"></i></span></div></td>
    <td><?php echo CHtml::activeHiddenField($modTindakan, '[0]daftartindakan_id', array('readonly'=>true,'class'=>'span1 required')) ?>
        <?php $this->widget('MyJuiAutoComplete',array(
				'model'=>$modTindakan,
				'attribute'=>'[0]daftartindakanNama',	
				'source'=>'js: function(request, response) {
							   $.ajax({
								   url: "'.$this->createUrl('DaftarTindakan').'",
								   dataType: "json",
								   data: {
									   term: request.term,
									   tipepaket_id: '.Params::TIPEPAKET_ID_NONPAKET.',
									   kelaspelayanan_id: $("#kelaspelayanan_id").val(),
									   penjamin_id: $("#penjamin_id").val(),
								   },
								   success: function (data) {
										   response(data);
								   }
							   })
							}',
				'options'=>array(
				   'showAnim'=>'fold',
				   'minLength' => 2,
				   'focus'=> 'js:function( event, ui ) {
						$(this).val( ui.item.label);
						return false;
					}',
				   'select'=>'js:function( event, ui ) {
						setTindakan($(this), ui.item);
						return false;
					}',

				),
				'tombolDialog'=>array("idDialog"=>'dialogDaftarTindakanPaket','jsFunction'=>"setDialog(this);"),
				'htmlOptions'=>array('onkeypress'=>"return $(this).focusNextInputField(event)"),
        )); ?>
        
        <?php echo CHtml::activeHiddenField($modTindakan, '[0]tarif_satuan', array('readonly'=>true,'class'=>'span1 integer2')) ?>
        <?php echo CHtml::activeHiddenField($modTindakan, '[0]subsidiasuransi_tindakan', array('readonly'=>true,'class'=>'span1 integer2')) ?>
        <?php echo CHtml::activeHiddenField($modTindakan, '[0]subsidipemerintah_tindakan', array('readonly'=>true,'class'=>'span1 integer2')) ?>
        <?php echo CHtml::activeHiddenField($modTindakan, '[0]subsisidirumahsakit_tindakan', array('readonly'=>true,'class'=>'span1 integer2')) ?>
        <?php echo CHtml::activeHiddenField($modTindakan, '[0]iurbiaya_tindakan', array('readonly'=>true,'class'=>'span1 integer2')) ?>
        <?php echo CHtml::activeHiddenField($modTindakan, '[0]rencanatindakan_id', array('readonly'=>true,'class'=>'span1 integer2')) ?>
		<?php echo CHtml::activeHiddenField($modTindakan, '[0]status', array('readonly'=>true,'class'=>'span1')) ?>
    </td>
 <td>
        <?php echo CHtml::activeTextField($modTindakan, '[0]tarif_satuan', array('readonly'=>true,'class'=>'span1 integer2')) ?>
        
    </td> 
    <td><?php echo CHtml::activeTextField($modTindakan, '[0]qty_tindakan', array('onblur'=>'hitungSubtotal(this)','onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span1 lebar1 integer2 numbersOnly')) ?></td>
    <td><?php echo CHtml::activeDropDownList($modTindakan, '[0]satuantindakan', LookupM::getItems('satuantindakan'),array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span1','style'=>'width:60px')) ?></td>
    <td>
        <?php echo CHtml::activeHiddenField($modTindakan, '[0]persenCyto', array('readonly'=>true,'class'=>'span1')) ?>
        <?php echo CHtml::activeDropDownList($modTindakan, '[0]cyto_tindakan', array('0'=>'Tidak','1'=>'Ya'), array('onchange'=>'hitungCyto(this)','onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span1','style'=>'width:60px')) ?>
		<?php echo CHtml::activeHiddenField($modTindakan, '[0]tarifcyto_tindakan', array('readonly'=>true,'class'=>'span1 integer2')) ?>
    </td>
    <td> 
      <?php echo CHtml::activeTextField($modTindakan, '[0]jumlahTarif', array('readonly'=>true,'class'=>'span1 integer2','style'=>'width:60px')) ?>
    </td>
    <td> 
      <?php echo CHtml::activeHiddenField($modTindakan, '[0]pegawai_id', array('readonly'=>true,'class'=>'span1')) ?>
        <?php $this->widget('MyJuiAutoComplete',array(
				'model'=>$modTindakan,
				'attribute'=>'[0]nama_pegawai',
				'source'=>'js: function(request, response) {
							   $.ajax({
								   url: "'.$this->createUrl('AutocompleteDokter').'",
								   dataType: "json",
								   data: {
									   term: request.term,
								   },
								   success: function (data) {
										   response(data);
								   }
							   })
							}',
				'options'=>array(
				   'showAnim'=>'fold',
				   'minLength' => 2,
				   'focus'=> 'js:function( event, ui ) {
						$(this).val( ui.item.label);
						return false;
					}',
				   'select'=>'js:function( event, ui ) {
						setTindakan($(this), ui.item);
						return false;
					}',

				),
				'tombolDialog'=>array("idDialog"=>'dialogDaftarDokter','jsFunction'=>"setDialogDokter(this);"),
				'htmlOptions'=>array('onkeypress'=>"return $(this).focusNextInputField(event)", ),
        )); ?>
    </td>
    <td> 
      <?php echo isset($modTindakan->rencanatindakan_id) ? "Telah Di-Verifikasi" : "Belum Di-Verifikasi";	 ?>
    </td>
    <td> 
      <?php echo CHtml::activeTextField($modTindakan, '[0]keterangantindakan', array('readonly'=>false,'class'=>'span2')) ?>
    </td>
<!--<td>
        <?php 
//            if(!isset($removeButton)){
//                $removeButton = false;
//            }
//            if($removeButton){
//                echo CHtml::link("<i class='icon-plus'></i>", '#', array('onclick'=>'addRowTindakan(this);return false;','rel'=>'tooltip','title'=>'Klik untuk menambah tindakan')); 
//                echo "<br><br>";
//                echo CHtml::link("<i class='icon-minus'></i>", '#', array('onclick'=>'batalTindakan(this);return false;','rel'=>'tooltip','title'=>'Klik untuk membatalkan tindakan'));
//            } else {
//                echo CHtml::link("<i class='icon-plus'></i>", '#', array('onclick'=>'addRowTindakan(this);return false;','rel'=>'tooltip','title'=>'Klik untuk menambah tindakan'));
//            }
        ?>
    </td>-->
</tr>
<?php } ?>