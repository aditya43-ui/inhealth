<?php 
$i = $i ?? 0;
?>
<tr>
    <td hidden>
        <?php 
            if(!isset($removeButton)){
                $removeButton = false;
            }
            if($removeButton){
                echo CHtml::link("<i class='icon-plus'></i>", '#', array('onclick'=>'addRowTindakan(this);return false;','rel'=>'tooltip','title'=>'Klik untuk menambah tindakan', 'data-placement'=>'right')); 
                echo "<br><br>";
                echo CHtml::link("<i class='icon-minus'></i>", '#', array('onclick'=>'batalTindakan(this);return false;','rel'=>'tooltip','title'=>'Klik untuk membatalkan tindakan', 'data-placement'=>'right'));
            } else {
                echo CHtml::link("<i class='icon-plus'></i>", '#', array('onclick'=>'addRowTindakan(this);return false;','rel'=>'tooltip','title'=>'Klik untuk menambah tindakan', 'data-placement'=>'right'));
            }
        ?>
    </td>
    <td>
    <span hidden>
        <?php echo CHtml::activeTextField($modTindakan, '['.$i.']kategoriTindakanNama', array('readonly'=>true,'class'=>'inputFormTabel')) ?>
        <?php echo CHtml::activeHiddenField($modTindakan, '['.$i.']tindakanpelayanan_id', array('readonly'=>true,'class'=>'inputFormTabel')) ?>
        <?php echo CHtml::activeHiddenField($modTindakan, '['.$i.']masukkamar_id', array('readonly'=>true,'class'=>'inputFormTabel')) ?>
        <?php echo CHtml::activeHiddenField($modTindakan, '['.$i.']ruangan_id', array('readonly'=>true,'class'=>'inputFormTabel ruangantindakan_id')) ?>
        <?php echo CHtml::activeHiddenField($modTindakan, '['.$i.']is_setengah', array('readonly'=>true,'class'=>'inputFormTabel')) ?>
    </span>
        <div class="input-append"><?php 
    // $modTindakan->tgl_tindakan = MyFormatter::formatDateTimeForUser($modTindakan->tgl_tindakan);
    echo CHtml::activeTextField($modTindakan, '['.$i.']tgl_tindakan', array('readonly'=>true,'class'=>'tanggal dtPicker2', 'style'=>'float:left;')); ?><span class="add-on"><i class="entypo-calendar"></i><i class="icon-time"></i></span></div>
    </td>
    <td><?php echo CHtml::activeTextField($modTindakan, '['.$i.']kode_tindakan', array('readonly'=>true,'class'=>'inputFormTabel span2')) ?></td>
    <td><?php echo CHtml::activeHiddenField($modTindakan, '['.$i.']daftartindakan_id', array('readonly'=>true,'class'=>'inputFormTabel daftartindakan_id')) ?>
        <?php $this->widget('MyJuiAutoComplete',array(
                    'model'=>$modTindakan,
                    'attribute'=>'['.$i.']daftartindakanNama',
                    //'name'=>'daftartindakan_nama',
                    'source'=>'js: function(request, response) {
                                   $.ajax({
                                       url: "'.Yii::app()->createUrl('rawatInap/tindakanTRI/DaftarTindakan').'",
                                       dataType: "json",
                                       data: {
                                           term: request.term,
                                           tipepaket_id: $("#RJTindakanPelayananT_0_tipepaket_id").val(),
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
        
        <?php echo CHtml::activeHiddenField($modTindakan, '['.$i.']kelaspelayanan_id', array('readonly'=>true,'class'=>'inputFormTabel')) ?>
        <?php echo CHtml::activeHiddenField($modTindakan, '['.$i.']subsidiasuransi_tindakan', array('readonly'=>true,'class'=>'inputFormTabel integer-decimal')) ?>
        <?php echo CHtml::activeHiddenField($modTindakan, '['.$i.']subsidipemerintah_tindakan', array('readonly'=>true,'class'=>'inputFormTabel integer-decimal')) ?>
        <?php echo CHtml::activeHiddenField($modTindakan, '['.$i.']subsisidirumahsakit_tindakan', array('readonly'=>true,'class'=>'inputFormTabel integer-decimal')) ?>
        <?php echo CHtml::activeHiddenField($modTindakan, '['.$i.']iurbiaya_tindakan', array('readonly'=>true,'class'=>'inputFormTabel integer-decimal')) ?>
		<?php echo CHtml::activeHiddenField($modTindakan, '['.$i.']keltindakanid', array('readonly'=>true,'class'=>'inputFormTabel')) ?>
    </td>
    <td><?php echo CHtml::activeTextField($modTindakan, '['.$i.']qty_tindakan', array('onblur'=>'hitungSubtotal(this)','onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'inputFormTabel span1 integer-decimal numbersOnly')) ?></td>
    <td><?php echo CHtml::activeDropDownList($modTindakan, '['.$i.']satuantindakan', array("HARI"=>"HARI"),array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'inputFormTabel span2')) ?></td>
    <td>
        <?php echo CHtml::textField('ruangan_nama', $modTindakan->ruangan->ruangan_nama ?? "", array('class'=>'span3', 'readonly'=>true)); ?>
    </td>
    <td>
        <?php echo CHtml::textField('tglmasukkamar', MyFormatter::formatDateTimeForUser($modTindakan->tglmasukkamar), array('class'=>'span3', 'readonly'=>true)); ?>
    </td>
    <td>
        <?php echo CHtml::textField('tglkeluarkamar', MyFormatter::formatDateTimeForUser($modTindakan->tglkeluarkamar ?? date('Y-m-d H:i:s')), array('class'=>'span3 '.(empty($modTindakan->tglkeluarkamar) ? "realtime" : ""), 'readonly'=>true)); ?>
    </td>
    <td hidden>
        <?php echo CHtml::activeHiddenField($modTindakan, '['.$i.']persenCyto', array('readonly'=>true,'class'=>'inputFormTabel ineteger-decimal')) ?>
        <?php echo CHtml::activeDropDownList($modTindakan, '['.$i.']cyto_tindakan', array('0'=>'Tidak','1'=>'Ya'), array('onchange'=>'hitungCyto(this)','onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'inputFormTabel span2')) ?>
    </td>
    <td>
      <?php echo CHtml::activeTextField($modTindakan, '['.$i.']tarifcyto_tindakan', array('readonly'=>true,'class'=>'inputFormTabel span2 integer-decimal','style'=>'display: none;')) ?>
      <?php echo CHtml::activeTextField($modTindakan, '['.$i.']tarif_satuan', array('readonly'=>true,'class'=>'inputFormTabel span2 integer-decimal')) ?>
    </td>
    <td> 
      <?php echo CHtml::activeTextField($modTindakan, '['.$i.']tarif_tindakan', array('readonly'=>true,'class'=>'inputFormTabel span2 integer-decimal')) ?>
    </td>
    <td style="text-align: center;" class="row_verif">
        <?php echo CHtml::activeHiddenField($modTindakan, '['.$i.']is_verif', array('class'=>'is_verif')); ?>
        <a href="#" onclick="verifikasiTindkan(this); return false;" class="btn_verif">
            <i class="icon-form-check"></i>
        </a>
    </td>
</tr>
<tr hidden>
    <td></td>
    <td></td>
    <td style="text-align: right;"><b>Pemeriksa :</b></td>
    <td colspan="6">
        <table style="margin:0;" class="list_pegawai_tindakan">
          <tr>
            <td width="20px" style="background-color:transparent;border: 0;">
                <?php echo CHtml::hiddenField('row', 0, array('readonly'=>true, 'class'=>'span1')); ?>
                <?php echo CHtml::link("<i class='icon-edit' title='Klik untuk merubah dokter / perawat / bidan'></i>", '#', array('id'=>'btnAddDokter_0','onclick'=>'addDokterLengkap(this);return false;')); ?>
            </td>
            <td style="background-color:transparent;border: 0;" width="250px"><div id="tampilanDokterPemeriksa_0"><?php echo (empty($modTindakan->dokterpemeriksa1_id)) ? "" : "Dokter Pemeriksa : ".$modTindakan->dokterpemeriksa1Nama ?></div></td>
            <td style="background-color:transparent;border: 0;"><?php echo CHtml::activeTextField($modTindakan, '['.$i.']keterangantindakan', array('readonly'=>false,'class'=>'inputFormTabel span3','placeholder'=>'Keterangan Tindakan')) ?></td> 
          </tr>
          <tr>
                <td></td>
                <td style="background-color:transparent;border: 0;" width="250px"><div id="tampilanDokterPemeriksa2_0"><?php echo (empty($modTindakan->dokterpemeriksa2_id)) ? "" : "Dokter Pemeriksa 2 : ".$modTindakan->dokterpemeriksa2Nama ?></div></td>
          </tr>
          <tr style="display:none";>
              <td></td>
              <td style="background-color:transparent;border: 0;"><div id="tampilanDokterDelegasi_0"></div></td>
          </tr>
          <tr style="display:none";>
              <td></td>
              <td style="background-color:transparent;border: 0;"><div id="tampilanDokterPendamping_0"></div></td>
          </tr>
          <tr style="display:none";>
              <td></td>
              <td style="background-color:transparent;border: 0;"><div id="tampilanDokterAnastesi_0"></div></td>
          </tr>
          <tr style="display:none";>
              <td></td>
              <td style="background-color:transparent;border: 0;"><div id="dokter6_0"></div></td>
          </tr>
          <tr style="display:none";>
              <td></td>
              <td style="background-color:transparent;border: 0;"><div id="dokter7_0"></div></td>
          </tr>
          <tr style="display:none";>
              <td></td>
              <td style="background-color:transparent;border: 0;"><div id="dokter8_0"></div></td>
          </tr>
          <tr style="display:none";>
              <td></td>
              <td style="background-color:transparent;border: 0;"><div id="dokter9_0"></div></td>
          </tr>
          <tr style="display:none";>
              <td></td>
              <td style="background-color:transparent;border: 0;"><div id="dokter10_0"></div></td>
          </tr>
          <tr style="display:none";>
              <td></td>
			  <td style="background-color:transparent;border: 0;"><div id="tampilanPerawat_0"></div></td>
          </tr>
          <tr style="display:none";>
              <td></td>
			  <td style="background-color:transparent;border: 0;"><div id="tampilanPerawat2_0"></div></td>
          </tr>
          <tr style="display:none";>
              <td></td>
			  <td style="background-color:transparent;border: 0;"><div id="tampilanBidan_0"></div></td>
          </tr>
          <tr style="display:none";>
              <td></td>
			  <td style="background-color:transparent;border: 0;"><div id="tampilanBidan2_0"></div></td>
          </tr>
          <tr style="display:none";>
              <td></td>
			  <td style="background-color:transparent;border: 0;"><div id="tampilanBidan3_0"></div></td>
          </tr>
          <tr style="display:none";>
              <td></td>
			  <td style="background-color:transparent;border: 0;"><div id="tampilanSuster_0"></div></td>
          </tr>
		  <tr style="display:none";>
              <td></td>
			  <td style="background-color:transparent;border: 0;"><div id="tampilanSupir_0"></div></td>
          </tr>
        </table>
			
            <?php echo CHtml::activeHiddenField($modTindakan, '['.$i.']dokterpemeriksa1_id', array('readonly'=>true,'class'=>'inputFormTabel')) ?>
            <?php echo CHtml::activeHiddenField($modTindakan, '['.$i.']dokterpemeriksa2_id', array('readonly'=>true,'class'=>'inputFormTabel')) ?>
            <?php echo CHtml::activeHiddenField($modTindakan, '['.$i.']dokterpendamping_id', array('readonly'=>true,'class'=>'inputFormTabel')) ?>
            <?php echo CHtml::activeHiddenField($modTindakan, '['.$i.']dokteranastesi_id', array('readonly'=>true,'class'=>'inputFormTabel')) ?>

            <?php echo CHtml::activeHiddenField($modTindakan, '['.$i.']dokter6_id', array('readonly'=>true,'class'=>'inputFormTabel')) ?>
            <?php echo CHtml::activeHiddenField($modTindakan, '['.$i.']dokter7_id', array('readonly'=>true,'class'=>'inputFormTabel')) ?>
            <?php echo CHtml::activeHiddenField($modTindakan, '['.$i.']dokter8_id', array('readonly'=>true,'class'=>'inputFormTabel')) ?>
            <?php echo CHtml::activeHiddenField($modTindakan, '['.$i.']dokter9_id', array('readonly'=>true,'class'=>'inputFormTabel')) ?>
            <?php echo CHtml::activeHiddenField($modTindakan, '['.$i.']dokter10_id', array('readonly'=>true,'class'=>'inputFormTabel')) ?>

            <?php echo CHtml::activeHiddenField($modTindakan, '['.$i.']dokterdelegasi_id', array('readonly'=>true,'class'=>'inputFormTabel')) ?>
            <?php echo CHtml::activeHiddenField($modTindakan, '['.$i.']bidan_id', array('readonly'=>true,'class'=>'inputFormTabel')) ?>
            <?php echo CHtml::activeHiddenField($modTindakan, '['.$i.']bidan2_id', array('readonly'=>true,'class'=>'inputFormTabel')) ?>
            <?php echo CHtml::activeHiddenField($modTindakan, '['.$i.']bidan3_id', array('readonly'=>true,'class'=>'inputFormTabel')) ?>
            <?php echo CHtml::activeHiddenField($modTindakan, '['.$i.']suster_id', array('readonly'=>true,'class'=>'inputFormTabel')) ?>
            <?php echo CHtml::activeHiddenField($modTindakan, '['.$i.']perawat_id', array('readonly'=>true,'class'=>'inputFormTabel')) ?>
            <?php echo CHtml::activeHiddenField($modTindakan, '['.$i.']perawat2_id', array('readonly'=>true,'class'=>'inputFormTabel')) ?>
			<?php echo CHtml::activeHiddenField($modTindakan, '['.$i.']supir_id', array('readonly'=>true,'class'=>'inputFormTabel')) ?>
    </td>
</tr>
