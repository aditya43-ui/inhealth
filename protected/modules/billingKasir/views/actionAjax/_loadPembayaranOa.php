<?php $totQtyOa = 0; $totHargaSatuan = 0; $totCytoOa = 0; $totSubAsuransiOa = 0; $totSubPemerintahOa = 0; $totSubRsOa = 0; $totIurOa = 0; 
      $totPembebasanTarif = 0; $totDiscount_tindakan = 0; $totDiscount_oa = 0; $totalbayarOa=0; $temp=0;?>
<?php foreach($modObatalkes as $i=>$obatAlkes) {
//          if (!$tindakanAktif){
          $jualResep = (isset($obatAlkes->penjualanresep_id)) ? $obatAlkes->penjualanresep_id : "null";
          if ($temp !== $jualResep){
              if (!empty($obatAlkes->penjualanresep_id)){
                echo '<tr class="nomor_resep" style="background-color:#f5f5f5;"><td>'.CHtml::checkBox("cekParent[obatalkespasien_id]", false, array('onchange'=>'cekParentValue('.$obatAlkes->penjualanresep_id.',this)')).'</td><td colspan=11 style="font-weight:bold;">'.$obatAlkes->penjualanresep->noresep.'</td><tr>';
              }else{
                echo '<tr class="nomor_resep" style="background-color:#f5f5f5;"><td>'.CHtml::checkBox("cekParent[obatalkespasien_id]", false, array('onchange'=>'cekParentValue(\'kosong\',this)')).'</td><td colspan=11 style="font-weight:bold;">Tanpa Nomor Resep</td><tr>';  
              }
              $temp = $jualResep;
          }
          $disc = ($obatAlkes->discount > 0) ? $obatAlkes->discount/100 : 0;
          $discount_oa = ($disc*$obatAlkes->qty_oa*$obatAlkes->hargasatuan_oa);
          $totDiscount_oa += $discount_oa;
          $subsidiOa = $this->cekSubsidiOa($obatAlkes);
          $totQtyOa = $totQtyOa + $obatAlkes->qty_oa; 
          $totHargaSatuan = $totHargaSatuan + $obatAlkes->hargasatuan_oa; 
          $oaHargasatuan = $obatAlkes->hargasatuan_oa; 
          if($obatAlkes->obatalkes->obatalkes_kategori == "GENERIK" OR $obatAlkes->obatalkes->jenisobatalkes_id == 3){
            $biayaServiceResep = 0;
          }else{
            $biayaServiceResep = $obatAlkes->biayaservice;
          }
          $oaCyto = $obatAlkes->biayaadministrasi + $biayaServiceResep + $obatAlkes->biayakonseling; 
          $totCytoOa = $totCytoOa + $oaCyto; 
          if(!empty($subsidiOa['max'])){
              // $oaSubsidiasuransi = round($oaHargasatuan/$totalPembagi * $subsidiOa['max']); 
              $oaSubsidiasuransi = (isset($obatAlkes->verifikasitagihan_id)) ? $obatAlkes->subsidiasuransi : round($oaHargasatuan/$totalPembagi * $subsidiOa['max']);
              $oaSubsidipemerintah = 0; 
              // $oaSubsidirs = 0; 
              $oaSubsidirs = (isset($obatAlkes->verifikasitagihan_id)) ? $obatAlkes->subsidirs : 0;

              $totSubAsuransiOa = $totSubAsuransiOa + $oaSubsidiasuransi; 
              $totSubPemerintahOa = $totSubPemerintahOa + $oaSubsidipemerintah; 
              $totSubRsOa = $totSubRsOa + $oaSubsidirs; 
//              $oaIurbiaya = round(($oaHargasatuan + $oaCyto)); // iur biaya tanpa $oaCyto
              $oaIurbiaya = round($oaHargaSatuan);
              $obatAlkes->iurbiaya = $oaIurbiaya; 
              $totIurOa = $totIurOa + $oaIurbiaya; 
              $subTotalOa = ($oaIurbiaya * $obatAlkes->qty_oa) - $oaSubsidiasuransi + $oaCyto - $discount_oa; 
              $subTotalOa = ($subTotalOa > 0) ? $subTotalOa : 0;
              $totalbayarOa = $totalbayarOa + $subTotalOa; 
          } else {
              // $oaSubsidiasuransi = $subsidiOa['asuransi']; 
              $oaSubsidiasuransi = (isset($obatAlkes->verifikasitagihan_id)) ? $obatAlkes->subsidiasuransi : $subsidiOa['asuransi']; 
              $oaSubsidipemerintah = $subsidiOa['pemerintah']; 
              // $oaSubsidirs = $subsidiOa['rumahsakit']; 
              $oaSubsidirs = (isset($obatAlkes->verifikasitagihan_id)) ? $obatAlkes->subsidirs : $subsidiOa['rumahsakit'];

              $totSubAsuransiOa = $totSubAsuransiOa + $oaSubsidiasuransi; 
              $totSubPemerintahOa = $totSubPemerintahOa + $oaSubsidipemerintah; 
              $totSubRsOa = $totSubRsOa + $oaSubsidirs; 
//              $oaIurbiaya = round(($oaHargasatuan + $oaCyto) - ($oaSubsidiasuransi + $oaSubsidipemerintah + $oaSubsidirs)); // iur biaya tanpa $oaCyto
              $oaIurbiaya = round(($oaHargasatuan) - ($oaSubsidiasuransi + $oaSubsidipemerintah + $oaSubsidirs)); 
              $obatAlkes->iurbiaya = $oaIurbiaya; 
              $totIurOa = $totIurOa + $oaIurbiaya; 
              $subTotalOa = ($oaIurbiaya * $obatAlkes->qty_oa) + $oaCyto - $discount_oa; 
              $totalbayarOa = $totalbayarOa + $subTotalOa; 
          }
    ?>
    <tr>
        <td><?php echo CHtml::checkBox("pembayaranAlkes[$i][obatalkespasien_id]", false, array('onchange'=>'hitungTotalSemuaOa();','value'=>$obatAlkes->obatalkespasien_id,'uncheckValue'=>'0', 'class'=>'pilihan', 'parent-value'=>((!empty($obatAlkes->penjualanresep_id)) ? $obatAlkes->penjualanresep_id : "kosong"))) ?></td>
        <td><?php echo $obatAlkes->tglpelayanan ?></td>
        <td>
            <?php //echo $obatAlkes->daftartindakan->daftartindakan_nama ?>
            <?php echo (isset($obatAlkes->obatalkes->obatalkes_nama) ? $obatAlkes->obatalkes->obatalkes_nama : '') ?>
            <?php echo CHtml::hiddenField("pembayaranAlkes[$i][obatalkes_id]" ,$obatAlkes->obatalkes_id, array('readonly'=>true,'class'=>'inputFormTabel lebar2')); ?>
            <?php echo CHtml::hiddenField("pembayaranAlkes[$i][carabayar_id]",$obatAlkes->carabayar_id, array('readonly'=>true)); ?>
            <?php echo CHtml::hiddenField("pembayaranAlkes[$i][penjamin_id]",$obatAlkes->penjamin_id, array('readonly'=>true)); ?>
            
        </td>
        <td>
            <?php echo CHtml::textField("pembayaranAlkes[$i][qty_oa]", $obatAlkes->qty_oa, array('onblur'=>'hitungTotalSemuaOa();','readonly'=>false,'class'=>'inputFormTabel number lebar2')); ?>
        </td>
        <td>
            <?php echo CHtml::hiddenField("pembayaranAlkes[$i][hargajual_oa]", $obatAlkes->hargajual_oa, array('readonly'=>true)); ?>
            <?php echo CHtml::textField("pembayaranAlkes[$i][hargasatuan]",$obatAlkes->hargasatuan_oa, array('onblur'=>'hitungTotalSemuaOa();','readonly'=>false,'class'=>'inputFormTabel currency lebar3')); ?>
        </td>
        <td>
            <?php echo CHtml::textField("pembayaranAlkes[$i][discount]",$discount_oa, array('readonly'=>true,'class'=>'inputFormTabel currency lebar3','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
        </td>
        <td>
            <?php echo CHtml::textField("pembayaranAlkes[$i][tarifcyto]", $oaCyto, array('readonly'=>true,'onblur'=>'hitungTagihan(this);','class'=>'inputFormTabel currency lebar3','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
        </td>
        <td>
            <?php echo CHtml::textField("pembayaranAlkes[$i][subsidiasuransi]", $oaSubsidiasuransi, array('readonly'=>true,'class'=>'inputFormTabel currency lebar3','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
        </td>
        <td>
            <?php echo CHtml::textField("pembayaranAlkes[$i][subsidipemerintah]", $oaSubsidipemerintah, array('readonly'=>true,'class'=>'inputFormTabel currency lebar3','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
        </td>
        <td>
            <?php echo CHtml::textField("pembayaranAlkes[$i][subsidirs]", $oaSubsidirs, array('readonly'=>true,'class'=>'inputFormTabel currency lebar3','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
        </td>
        <td>
            <?php echo CHtml::textField("pembayaranAlkes[$i][iurbiaya]", $oaIurbiaya, array('readonly'=>true,'class'=>'inputFormTabel currency lebar3')); ?>
        </td>
        <td>
            <?php //echo $obatAlkes->daftartindakan_id ?>
            <?php echo CHtml::textField("pembayaranAlkes[$i][sub_total]", $subTotalOa, array('readonly'=>true,'class'=>'inputFormTabel currency lebar3')); ?>
        </td>
    </tr>
<?php } ?>
    <tr class="trfooter">
        <td>
            <?php echo CHtml::checkBox('inputTotalOa',false, array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'checkbox-column','onclick'=>'cekInputTotal(this)')) ?>
        </td>
        <td colspan="2">Input Total <?php //echo $subsidiOa['max']; ?></td>
        <td>
            <?php echo CHtml::textField("totalqty_oa", $totQtyOa, array('readonly'=>true,'class'=>'inputFormTabel number lebar2')); ?>
        </td>
        <td>
            <?php echo CHtml::textField("totalbiaya_oa", $totHargaSatuan, array('readonly'=>true,'class'=>'inputFormTabel currency lebar3')); ?>
        </td>
        <td>
            <?php echo CHtml::textField("totaldiscount_oa", $totDiscount_oa, array('readonly'=>true,'class'=>'inputFormTabel currency lebar3')); ?>
        </td>
        <td>
            <?php echo CHtml::textField("totalcyto_oa", $totCytoOa, array('readonly'=>true,'class'=>'inputFormTabel currency lebar3')); ?>
        </td>
        <td>
            <?php echo CHtml::textField("totalsubsidiasuransi_oa", $totSubAsuransiOa, array('readonly'=>true,'onblur'=>'proporsiSubAsuransiOa();','class'=>'inputFormTabel currency lebar3','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
        </td>
        <td>
            <?php echo CHtml::textField("totalsubsidipemerintah_oa", $totSubPemerintahOa, array('readonly'=>true,'class'=>'inputFormTabel currency lebar3')); ?>
        </td>
        <td>
            <?php echo CHtml::textField("totalsubsidirs_oa", $totSubRsOa, array('readonly'=>true,'onblur'=>'proporsiSubRsOa();','class'=>'inputFormTabel currency lebar3','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
        </td>
        <td>
            <?php echo CHtml::textField("totaliurbiaya_oa", $totIurOa, array('readonly'=>true,'class'=>'inputFormTabel currency lebar3')); ?>
        </td>
       <!--<td>
            <?php //echo CHtml::textField("totalbayar_oa", $totalbayarOa, array('readonly'=>true,'class'=>'inputFormTabel currency lebar3')); ?>
        </td>-->
    </tr>
