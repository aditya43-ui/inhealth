<?php $totQty = 0; $totTarif = 0; $totCyto = 0; $totSubAsuransi = 0; $totSubPemerintah = 0; $totSubRs = 0; $totIur = 0; 
      $totPembebasanTarif = 0; $totDiscount_tindakan = 0; $totalbayartindakan = 0;
      
      $cnt = 1;
      
foreach($modTindakan as $i=>$tindakan) { ?>
    <?php 
      $subsidi = $this->cekSubsidi($tindakan);
      $pembebasanTarif = PembebasantarifT::model()->findAllByAttributes(array('tindakanpelayanan_id'=>$tindakan->tindakanpelayanan_id));
      $tarifBebas = 0; 
      foreach ($pembebasanTarif as $i => $pembebasan) {
          $tarifBebas = $tarifBebas + $pembebasan->jmlpembebasan;
      }
      $totPembebasanTarif = $totPembebasanTarif + $tarifBebas;
      $disc = ($tindakan->discount_tindakan > 0) ? $tindakan->discount_tindakan/100 : 0;
      $discountTindakan = ($disc*$tindakan->tarif_satuan*$tindakan->qty_tindakan);
      $totDiscount_tindakan += $discountTindakan ;
      $diskon = $tindakan->discount_tindakan/100 * $tindakan->tarif_tindakan;
      $subsidiasuransi_tindakan = $tindakan->subsidiasuransi_tindakan;
      $subsidirs_tindakan = $tindakan->subsisidirumahsakit_tindakan;

      $qtyTindakan = $tindakan->qty_tindakan; $totQty = $totQty + $qtyTindakan; 
      $tarifSatuan = $tindakan->tarif_satuan;
      $tarifTindakan = $tindakan->tarif_tindakan; $totTarif = $totTarif + $tarifTindakan; 
      $tarifCyto = $tindakan->tarifcyto_tindakan; $totCyto = $totCyto + $tarifCyto; 
      if(!empty($subsidi['max'])){
          $subsidiAsuransi = $subsidi['asuransi'];  
          $subsidiPemerintah = $subsidi['pemerintah']; 
          $subsidiRumahSakit = $subsidi['rumahsakit']; 

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
      
      $daftartindakan = DaftartindakanM::model()->findByPk($tindakan->daftartindakan_id);

      $jeniswaktukerja = "Paruh Waktu";

      $peg = PegawaiM::model()->findByPk($tindakan->dokterpemeriksa1_id);

      if (!empty($peg)) {
        $jeniswaktukerja = $peg->jeniswaktukerja;
      }
      
      $nama_tindakan = $daftartindakan->daftartindakan_nama;
      if ($daftartindakan->daftartindakan_akomodasi) {
          $kelas = KelaspelayananM::model()->findByPk($tindakan->kelaspelayanan_id);
          $nama_tindakan .= " - ".$kelas->kelaspelayanan_nama;
      }

      $tindakan->qty_tindakan = number_format($tindakan->qty_tindakan, 2, ",", "");
?>
    <tr>
        <td>
            <?php echo CHtml::textField('no_urut',0,array('class'=>'un-integer','style'=>'width:30px','readonly'=>true)); ?>
        </td>
        <td>
        <!-- simpanCeklisVerifikasi(this); hitungTotalSemuaTind(); -->
            <?php echo CHtml::checkBox("pembayaran[$i][checked]", (!empty($tindakan->verifikasitagihan_id) && $is_batal != 1), array('onchange'=>'','uncheckValue'=>null, 'class'=>'pilihan pilih-cek')) ?>
        </td>
        <td>
            <?php echo MyFormatter::formatDateTimeForUser($tindakan->tgl_tindakan); ?>
            
            <?php echo CHtml::hiddenField("pembayaran[$i][tgl_tindakan]",$tindakan->tgl_tindakan, array('readonly'=>true,'class'=>'inputFormTabel span2 integer2')); ?>
            <?php echo CHtml::hiddenField("pembayaran[$i][carabayar_id]",$tindakan->carabayar_id, array('readonly'=>true)); ?>
            <?php echo CHtml::hiddenField("pembayaran[$i][tindakanpelayanan_id]",$tindakan->tindakanpelayanan_id, array('readonly'=>true, 'class'=>'tindakanpelayanan_id')); ?>
            <?php echo CHtml::hiddenField("pembayaran[$i][penjamin_id]",$tindakan->penjamin_id, array('readonly'=>true)); ?>
            <?php //echo CHtml::hiddenField("pembayaran[$i][discount_tindakan]",$tindakan->discount_tindakan, array('readonly'=>true)); ?>
            <?php echo CHtml::hiddenField("pembayaran[$i][pembebasan_tarif]",$tarifBebas, array('readonly'=>true)); ?>
        </td>
        <td>
            <?php echo $daftartindakan->daftartindakan_kode; ?>
        </td>
        <td>
            <?php echo $nama_tindakan ; ?>
            <?php echo CHtml::hiddenField("pembayaran[$i][daftartindakan_id]", $tindakan->daftartindakan_id, array('readonly'=>true,'class'=>'inputFormTabel lebar2')); ?>
        </td>
        <td>
            <?php 
            if (!empty($tindakan->nopelayanan)) {
                echo $tindakan->noNota; 
            }
            ?>
        </td>
        <td>
            <?php echo CHtml::textField("pembayaran[$i][tarif_satuan]", MyFormatter::formatNumberForPrint($tindakan->tarif_satuan, 2), array('readonly'=>true,'onblur'=>'hitungTotalSemuaTind();','class'=>'inputFormTabel integer span2 integer2', 'style'=>'width: 100px;')); ?>
        </td>
        <td>
            <?php echo CHtml::textField("pembayaran[$i][qty_tindakan]", $tindakan->qty_tindakan, array('readonly'=>true,'onblur'=>'hitungTarifTindakan(this,'.$tindakan->tindakanpelayanan_id.'); hitungTotalSemuaTind();','class'=>'inputFormTabel integer-decimal span1 qty_tindakan', 'style'=>'text-align: right;')); ?>

        </td>
    </tr>
<?php } ?>
    <tr class="trfooter">
        <td style="display:none;">
            <?php echo CHtml::checkBox('inputTotalTind',false, array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'checkbox-column','onclick'=>'cekInputTotal(this)')) ?>
        </td>
        <td colspan="3">Input Total</td>
        <td></td>
        <td></td>
        <td>
            <?php // echo CHtml::textField("totalqtytindakan", $totQty, array('readonly'=>true,'class'=>'inputFormTabel number lebar2')); ?>
        </td>
        <td>
            <span hidden><?php echo CHtml::textField("totalbiayatindakan", $totTarif, array('readonly'=>true,'class'=>'inputFormTabel integer span2 integer2', 'style'=>'width: 100px;')); ?></span>
        </td>
        <td style="display: none;">
            <?php echo CHtml::textField("totalcyto", $totCyto, array('readonly'=>true,'class'=>'inputFormTabel integer span2 integer2', 'style'=>'width: 100px;')); ?>
        </td>
        <td style="display: none;">
            <?php echo CHtml::textField("totaldiscount_tindakan", $totDiscount_tindakan, array('readonly'=>true,'class'=>'inputFormTabel integer span2 integer2', 'style'=>'width: 100px;')); ?>
        </td>
        <td hidden>
            <?php echo CHtml::textField("totalsubsidiasuransi", $totSubAsuransi, array('readonly'=>true,'onblur'=>'proporsiSubAsuransiTind();','class'=>'inputFormTabel integer span2 integer2','onkeypress'=>"return $(this).focusNextInputField(event)", 'style'=>'width: 100px;')); ?>
        </td>
        <!--DI JK INI DIHIDE-->
        <td style="display: none;">
            <?php echo CHtml::textField("totalsubsidipemerintah", $totSubPemerintah, array('readonly'=>true,'class'=>'inputFormTabel integer span2 integer2', 'style'=>'width: 100px;')); ?>
        </td>
        <td style="display: none;">
            <?php echo CHtml::textField("totalsubsidirs", $totSubRs, array('readonly'=>true,'onblur'=>'proporsiSubRsTind();','class'=>'inputFormTabel integer span2 integer2','onkeypress'=>"return $(this).focusNextInputField(event)", 'style'=>'width: 100px;')); ?>
        </td>
        <td hidden>
            <?php echo CHtml::textField("totaliurbiaya", $totIur, array('readonly'=>true,'class'=>'inputFormTabel integer span2 integer2', 'style'=>'width: 100px;')); ?>
        </td>
        <td hidden>
            <?php echo CHtml::textField("totalbayartindakan", $totalbayartindakan, array('readonly'=>true,'class'=>'inputFormTabel integer span2 integer2', 'style'=>'width: 100px;')); ?>
            <?php echo CHtml::hiddenField("totalpembebasan", $totPembebasanTarif, array('readonly'=>true,'class'=>'inputFormTabel integer span2 integer2', 'style'=>'width: 100px;')); ?>
        </td>
    </tr>
    