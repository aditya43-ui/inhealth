<?php 
if(!empty($modTindakans)) {
    $this->renderPartial($this->path_view.'_cekvalidTindakanPasien',array('modTindakans'=>$modTindakans,'removeButton'=>true));
} else {
?>
<tr>
    <td style="background-color:transparent;border: 0;" width="250px">
        <div class='tanggal dtPicker2 realtime'>
            <?php 
            // echo MyFormatter::formatDateTimeForUser($modTindakan->tgl_tindakan);
            echo $modTindakan->tgl_tindakan = MyFormatter::formatDateTimeForUser(date('Y-m-d H:i:s'));
            // echo CHtml::activeTextField($modTindakan, '[0]tgl_tindakan', array('readonly'=>true,'class'=>'tanggal dtPicker2 realtime', 'style'=>'float:left;','value'=>  MyFormatter::formatDateTimeForUser(date('Y-m-d H:i:s')))); ?>
        </div>
        <div id="tampilanDokterPemeriksaSementara_0">
            <?php echo (empty($modTindakan->tipepaket_id)) ? "" : $modTindakan->tipepaket->tipepaket_nama ?><br/>
        </div>
        <div id="tampilankategoritindakan_nama_0">
            <?php echo (empty($modTindakan->kategoritindakan_nama)) ? "" : $modTindakan->kategoritindakan_nama ?>
        </div>
        <div id="tampilanDokterPemeriksaSementara_0">
            <?php echo (empty($modTindakan->dokterpemeriksa1_id)) ? "Pemeriksa : " : "Pemeriksa : ".$modTindakan->dokterpemeriksa1Nama. "," ?>
        </div>
        <div id="tampilanDokterPemeriksaSementara2_0">
            <?php echo (empty($modTindakan->dokterpemeriksa2_id)) ? "" : $modTindakan->dokterpemeriksa2Nama ?>
        </div>
        <div id="tampilanDokterDelegasiSementara_0"></div>
        <div id="tampilanDokterPendampingSementara_0"></div>
        <div id="tampilanDokterAnastesiSementara_0"></div>
        <div id="tampilanPerawatSementara_0"></div>
        <div id="tampilanPerawatSementara2_0"></div>
        <div id="tampilanBidanSementara_0"></div>
        <div id="tampilanBidanSementara2_0"></div>
        <div id="tampilanBidanSementara3_0"></div>
        <div id="tampilanSusterSementara_0"></div>
        <div id="tampilanSupirSementara_0"></div>
        <div id="tampilanOkupasiTerapi_0"></div>
        <div id="tampilanTerapiSementara_0"></div>
        <div id="tampilanFisioterapiSementara_0"></div>
    </td>
    <td><?php echo CHtml::activeTextField($modTindakan, '[0]kategoriTindakanNama', array('readonly'=>true,'class'=>'inputFormTabel')) ?></td>
    <td><?php echo CHtml::activeHiddenField($modTindakan, '[0]daftartindakan_id', array('readonly'=>true,'class'=>'inputFormTabel daftartindakan_id')) ?>
        <?php $this->widget('MyJuiAutoComplete',array(
                    'model'=>$modTindakan,
                    'attribute'=>'[0]daftartindakanNama',
                    //'name'=>'daftartindakan_nama',
                    'source'=>'js: function(request, response) {
                                   $.ajax({
                                       url: "'.Yii::app()->createUrl('rawatInap/tindakanTRI/DaftarTindakan').'",
                                       dataType: "json",
                                       data: {
                                           term: request.term,
                                           tipepaket_id: $("#RMTindakanPelayananT_0_tipepaket_id").val(),
                                           kelaspelayanan_id: $("#RJPendaftaranT_kelaspelayanan_id").val(),
                                           penjamin_id: $("#RJPendaftaranT_penjamin_id").val(),
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
                    'htmlOptions'=>array('onkeypress'=>"return $(this).focusNextInputField(event)", ),
        )); ?>
        
        <?php echo CHtml::activeHiddenField($modTindakan, '[0]kelaspelayanan_id', array('readonly'=>true,'class'=>'inputFormTabel')) ?>
        <?php echo CHtml::activeHiddenField($modTindakan, '[0]subsidiasuransi_tindakan', array('readonly'=>true,'class'=>'inputFormTabel integer-decimal')) ?>
        <?php echo CHtml::activeHiddenField($modTindakan, '[0]subsidipemerintah_tindakan', array('readonly'=>true,'class'=>'inputFormTabel integer-decimal')) ?>
        <?php echo CHtml::activeHiddenField($modTindakan, '[0]subsisidirumahsakit_tindakan', array('readonly'=>true,'class'=>'inputFormTabel integer-decimal')) ?>
        <?php echo CHtml::activeHiddenField($modTindakan, '[0]iurbiaya_tindakan', array('readonly'=>true,'class'=>'inputFormTabel integer-decimal')) ?>
		<?php echo CHtml::activeHiddenField($modTindakan, '[0]keltindakanid', array('readonly'=>true,'class'=>'inputFormTabel')) ?>
    </td>
    <td><?php echo CHtml::activeTextField($modTindakan, '[0]qty_tindakan', array('onblur'=>'hitungSubtotal(this)','onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'inputFormTabel span1 integer numbersOnly')) ?></td>
    <td><?php echo CHtml::activeDropDownList($modTindakan, '[0]satuantindakan', LookupM::getItems('satuantindakan'),array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'inputFormTabel span2')) ?></td>
    <td>
        <?php echo CHtml::activeHiddenField($modTindakan, '[0]persenCyto', array('readonly'=>true,'class'=>'inputFormTabel ineteger-decimal')) ?>
        <?php echo CHtml::activeDropDownList($modTindakan, '[0]cyto_tindakan', array('0'=>'Tidak','1'=>'Ya'), array('onchange'=>'hitungCyto(this)','onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'inputFormTabel span2')) ?>
    </td>
    <td>
      <?php echo CHtml::activeTextField($modTindakan, '[0]tarifcyto_tindakan', array('readonly'=>true,'class'=>'inputFormTabel span2 integer-decimal','style'=>'display: none;')) ?>
      <?php echo CHtml::activeTextField($modTindakan, '[0]tarif_satuan', array('readonly'=>true,'class'=>'inputFormTabel span2 integer-decimal')) ?>
    </td>
    <td> 
      <?php echo CHtml::activeTextField($modTindakan, '[0]tarif_tindakan', array('readonly'=>true,'class'=>'inputFormTabel span2 integer-decimal')) ?>
    </td>
</tr>
			
            <?php echo CHtml::activeHiddenField($modTindakan, '[0]dokterpemeriksa1_id', array('readonly'=>true,'class'=>'inputFormTabel')) ?>
            <?php echo CHtml::activeHiddenField($modTindakan, '[0]dokterpemeriksa2_id', array('readonly'=>true,'class'=>'inputFormTabel')) ?>
            <?php echo CHtml::activeHiddenField($modTindakan, '[0]dokterpendamping_id', array('readonly'=>true,'class'=>'inputFormTabel')) ?>
            <?php echo CHtml::activeHiddenField($modTindakan, '[0]dokteranastesi_id', array('readonly'=>true,'class'=>'inputFormTabel')) ?>
            <?php echo CHtml::activeHiddenField($modTindakan, '[0]dokterdelegasi_id', array('readonly'=>true,'class'=>'inputFormTabel')) ?>
            <?php echo CHtml::activeHiddenField($modTindakan, '[0]bidan_id', array('readonly'=>true,'class'=>'inputFormTabel')) ?>
            <?php echo CHtml::activeHiddenField($modTindakan, '[0]bidan2_id', array('readonly'=>true,'class'=>'inputFormTabel')) ?>
            <?php echo CHtml::activeHiddenField($modTindakan, '[0]bidan3_id', array('readonly'=>true,'class'=>'inputFormTabel')) ?>
            <?php echo CHtml::activeHiddenField($modTindakan, '[0]suster_id', array('readonly'=>true,'class'=>'inputFormTabel')) ?>
            <?php echo CHtml::activeHiddenField($modTindakan, '[0]perawat_id', array('readonly'=>true,'class'=>'inputFormTabel')) ?>
            <?php echo CHtml::activeHiddenField($modTindakan, '[0]perawat2_id', array('readonly'=>true,'class'=>'inputFormTabel')) ?>
			<?php echo CHtml::activeHiddenField($modTindakan, '[0]supir_id', array('readonly'=>true,'class'=>'inputFormTabel')) ?>
            <?php echo CHtml::activeHiddenField($modTindakan, '[0]okupasiterapi_id', array('readonly'=>true,'class'=>'inputFormTabel')) ?>
            <?php echo CHtml::activeHiddenField($modTindakan, '[0]terapiwicara_id', array('readonly'=>true,'class'=>'inputFormTabel')) ?>
            <?php echo CHtml::activeHiddenField($modTindakan, '[0]fisioterapi_id', array('readonly'=>true,'class'=>'inputFormTabel')) ?>
<?php } ?>
