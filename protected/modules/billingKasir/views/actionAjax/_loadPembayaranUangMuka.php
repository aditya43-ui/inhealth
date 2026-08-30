
<?php $totQty = 0; $totTarif = 0; $totCyto = 0; $totSubAsuransi = 0; $totSubPemerintah = 0; $totSubRs = 0; $totIur = 0; 
      $totPembebasanTarif = 0; $totDiscount_tindakan = 0; $totalbayartindakan = 0; ?>
<?php foreach($modTindakan as $i=>$tindakan) { ?>
    <tr>
        <td>
            <?php echo CHtml::checkBox("pembayaran[$i][tindakanpelayanan_id]", true, array('onchange'=>'hitungTotalSemuaTind();','value'=>$tindakan->tindakanpelayanan_id,'uncheckValue'=>'0', 'class'=>'pilihan')) ?>
            <?php $subsidi = $this->cekSubsidi($tindakan);?>
        </td>
        <td>
            <?php echo $tindakan->tgl_tindakan ?>
            <?php 
                  $pembebasanTarif = PembebasantarifT::model()->findAllByAttributes(array('tindakanpelayanan_id'=>$tindakan->tindakanpelayanan_id));
                  $tarifBebas = 0; 
                  foreach ($pembebasanTarif as $i => $pembebasan) {
                      $tarifBebas = $tarifBebas + $pembebasan->jmlpembebasan;
                  }
                  $totPembebasanTarif = $totPembebasanTarif + $tarifBebas;
                  $disc = ($tindakan->discount_tindakan > 0) ? $tindakan->discount_tindakan/100 : 0;
                  $discountTindakan = ($disc*$tindakan->tarif_satuan*$tindakan->qty_tindakan);
                  $totDiscount_tindakan += $discountTindakan ;
            
                  $qtyTindakan = $tindakan->qty_tindakan; $totQty = $totQty + $qtyTindakan; 
                  $tarifSatuan = $tindakan->tarif_satuan;
                  $tarifTindakan = $tindakan->tarif_tindakan; $totTarif = $totTarif + $tarifTindakan; 
                  $tarifCyto = $tindakan->tarifcyto_tindakan; $totCyto = $totCyto + $tarifCyto; 
                  if(!empty($subsidi['max'])){
                      $subsidiAsuransi = round($tarifTindakan/$totalPembagi * $subsidi['max']); 
                      $subsidiPemerintah = 0; 
                      $subsidiRumahSakit = 0; 

                      $totSubAsuransi = $totSubAsuransi + $subsidiAsuransi;
                      $totSubPemerintah = $totSubPemerintah + $subsidiPemerintah; 
                      $totSubRs = $totSubRs + $subsidiRumahSakit; 
                      $iurBiaya = round(($tarifSatuan + $tarifCyto));
                      $totIur = $totIur + $iurBiaya; 
                      $subTotal = round($iurBiaya * $qtyTindakan) - $subsidiAsuransi; 
                      $subTotal = ($subTotal > 0) ? $subTotal : 0;
                      $totalbayartindakan = $totalbayartindakan + $subTotal; 
                  } else {
                      $subsidiAsuransi = $subsidi['asuransi'];  
                      $subsidiPemerintah = $subsidi['pemerintah']; 
                      $subsidiRumahSakit = $subsidi['rumahsakit']; 

                      $totSubAsuransi = $totSubAsuransi + $subsidiAsuransi;
                      $totSubPemerintah = $totSubPemerintah + $subsidiPemerintah; 
                      $totSubRs = $totSubRs + $subsidiRumahSakit; 
                      $iurBiaya = round(($tarifSatuan + $tarifCyto) - ($subsidiAsuransi + $subsidiPemerintah + $subsidiRumahSakit)); 
                      $totIur = $totIur + $iurBiaya; 
                      $subTotal = ($iurBiaya * $qtyTindakan); 
                      $totalbayartindakan = $totalbayartindakan + $subTotal; 
                  }
            ?>
            
            <?php echo CHtml::hiddenField("pembayaran[$i][tgl_tindakan]",$tindakan->tgl_tindakan, array('readonly'=>true,'class'=>'inputFormTabel span2')); ?>
            <?php echo CHtml::hiddenField("pembayaran[$i][carabayar_id]",$tindakan->carabayar_id, array('readonly'=>true)); ?>
            <?php echo CHtml::hiddenField("pembayaran[$i][penjamin_id]",$tindakan->penjamin_id, array('readonly'=>true)); ?>
            <?php echo CHtml::hiddenField("pembayaran[$i][discount_tindakan]",$tindakan->discount_tindakan, array('readonly'=>true)); ?>
            <?php echo CHtml::hiddenField("pembayaran[$i][pembebasan_tarif]",$tarifBebas, array('readonly'=>true)); ?>
        </td>
        <td>
            <?php echo (isset($tindakan->tipepaket->tipepaket_nama) ? $tindakan->tipepaket->tipepaket_nama : '') .' - ' . (isset($tindakan->daftartindakan->daftartindakan_nama) ? $tindakan->daftartindakan->daftartindakan_nama : '') ; ?>
            <?php echo CHtml::hiddenField("pembayaran[$i][daftartindakan_id]", $tindakan->daftartindakan_id, array('readonly'=>true,'class'=>'inputFormTabel lebar2')); ?>
        </td>
        <td>
            <?php echo CHtml::textField("pembayaran[$i][qty_tindakan]", $tindakan->qty_tindakan, array('readonly'=>false,'onblur'=>'hitungTotalSemuaTind();','class'=>'inputFormTabel number lebar2')); ?>
        </td>
        <td>
            <?php echo CHtml::textField("pembayaran[$i][tarif_satuan]", $tindakan->tarif_satuan, array('readonly'=>false,'onblur'=>'hitungTotalSemuaTind();','class'=>'inputFormTabel currency lebar3')); ?>
            <?php echo CHtml::hiddenField("pembayaran[$i][tarif_tindakan]", $tindakan->tarif_tindakan, array('readonly'=>true,'class'=>'inputFormTabel currency lebar3')); ?>
        </td>
        <td>
            <?php echo CHtml::textField("pembayaran[$i][tarifcyto_tindakan]", $tindakan->tarifcyto_tindakan, array('readonly'=>true,'class'=>'inputFormTabel currency lebar3')); ?>
        </td>
        <td>
            <?php echo CHtml::textField("pembayaran[$i][discount_tindakan]",$discountTindakan, array('readonly'=>true, 'class'=>'inputFormTabel currency lebar3')); ?>
        </td>
        <td>
            <?php echo CHtml::textField("pembayaran[$i][subsidiasuransi_tindakan]", $subsidiAsuransi, array('readonly'=>false,'onblur'=>'hitungTotalSemuaTind();','class'=>'inputFormTabel currency lebar3')); ?>
        </td>
        <td>
            <?php echo CHtml::textField("pembayaran[$i][subsidipemerintah_tindakan]", $subsidiPemerintah, array('readonly'=>true,'class'=>'inputFormTabel currency lebar3')); ?>
        </td>
        <td>
            <?php echo CHtml::textField("pembayaran[$i][subsisidirumahsakit_tindakan]", $subsidiRumahSakit, array('readonly'=>true,'onblur'=>'hitungTotalSemuaTind();','class'=>'inputFormTabel currency lebar3')); ?>
        </td>
        <td>
            <?php echo CHtml::textField("pembayaran[$i][iurbiaya_tindakan]", $iurBiaya, array('readonly'=>true,'class'=>'inputFormTabel currency lebar3')); ?>
        </td>
        <td>
            <?php echo CHtml::textField("pembayaran[$i][sub_total]", $subTotal, array('readonly'=>true,'class'=>'inputFormTabel currency lebar3')); ?>
            <?php //echo $tindakan->daftartindakan_id; ?>
        </td>
    </tr>
<?php } ?>
    <tr class="trfooter">
        <td colspan="3">Total <?php //echo $subsidi['max']; ?></td>
        <td>
            <?php echo CHtml::textField("totalqtytindakan", $totQty, array('readonly'=>true,'class'=>'inputFormTabel number lebar2')); ?>
        </td>
        <td>
            <?php echo CHtml::textField("totalbiayatindakan", $totTarif, array('readonly'=>true,'class'=>'inputFormTabel currency lebar3')); ?>
        </td>
        <td>
            <?php echo CHtml::textField("totalcyto", $totCyto, array('readonly'=>true,'class'=>'inputFormTabel currency lebar3')); ?>
        </td>
        <td>
            <?php echo CHtml::textField("totaldiscount_tindakan", $totDiscount_tindakan, array('readonly'=>true,'class'=>'inputFormTabel currency lebar3')); ?>
        </td>
        <td>
            <?php echo CHtml::textField("totalsubsidiasuransi", $totSubAsuransi, array('readonly'=>true,'class'=>'inputFormTabel currency lebar3')); ?>
        </td>
        <td>
            <?php echo CHtml::textField("totalsubsidipemerintah", $totSubPemerintah, array('readonly'=>true,'class'=>'inputFormTabel currency lebar3')); ?>
        </td>
        <td>
            <?php echo CHtml::textField("totalsubsidirs", $totSubRs, array('readonly'=>true,'class'=>'inputFormTabel currency lebar3')); ?>
        </td>
        <td>
            <?php echo CHtml::textField("totaliurbiaya", $totIur, array('readonly'=>true,'class'=>'inputFormTabel currency lebar3')); ?>
        </td>
        <td>
            <?php echo CHtml::textField("totalbayartindakan", $totalbayartindakan, array('readonly'=>true,'class'=>'inputFormTabel currency lebar3')); ?>
            <?php echo CHtml::hiddenField("totalpembebasan", $totPembebasanTarif, array('readonly'=>true,'class'=>'inputFormTabel currency lebar3')); ?>
            <?php //echo CHtml::hiddenField("totaldiscount_tindakan", $totDiscount_tindakan, array('readonly'=>true,'class'=>'inputFormTabel currency lebar3')); ?>
        </td>
    </tr>
    