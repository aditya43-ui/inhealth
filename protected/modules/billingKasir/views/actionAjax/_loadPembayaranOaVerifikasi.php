<?php $totQtyOa = 0; $totHargaSatuan = 0; $totCytoOa = 0; $totSubAsuransiOa = 0; $totSubPemerintahOa = 0; $totSubRsOa = 0; $totIurOa = 0; 
      $totPembebasanTarif = 0; $totDiscount_tindakan = 0; $totDiscount_oa = 0; $totalbayarOa=0; $temp=0;
      
      $cnt = 1;
      
      ?>
<?php foreach($modObatalkes as $i=>$obatAlkes) {
//          if (!$tindakanAktif){
          // $jualResep = (isset($obatAlkes->penjualanresep_id)) ? $obatAlkes->penjualanresep_id : "null";
          // if ($temp !== $jualResep){
          //    if (!empty($obatAlkes->penjualanresep_id)){
          //      echo '<tr class="nomor_resep" style="background-color:#f5f5f5;"><td style="display:none;">'.CHtml::checkBox("cekParent[obatalkespasien_id]", false, array('onchange'=>'cekParentValue('.$obatAlkes->penjualanresep_id.',this)')).'</td><td colspan=11 style="font-weight:bold;">'.$obatAlkes->penjualanresep->noresep.'</td><tr>';
          //    }else{
          //      echo '<tr class="nomor_resep" style="background-color:#f5f5f5;"><td style="display:none;">'.CHtml::checkBox("cekParent[obatalkespasien_id]", false, array('onchange'=>'cekParentValue(\'kosong\',this)')).'</td><td colspan=11 style="font-weight:bold;">Tanpa Nomor Resep</td><tr>';  
          //    }
          //    $temp = $jualResep;
          // }
          $disc = ($obatAlkes->discount > 0) ? $obatAlkes->discount : 0;
          $discount_oa = $disc; //($disc*$obatAlkes->qty_oa*$obatAlkes->hargasatuan_oa);
          $totDiscount_oa += $disc;

          $diskon = $obatAlkes->discount; // /100 * $obatAlkes->hargajual_oa;
          $subsidiasuransi = $obatAlkes->subsidiasuransi;
          $subsidirs = $obatAlkes->subsidirs;

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
              $oaSubsidiasuransi = $subsidiOa['asuransi']; 
              $oaSubsidipemerintah = $subsidiOa['pemerintah']; 
              $oaSubsidirs = $subsidiOa['rumahsakit']; 
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
              
              // var_dump($subsidiOa); die;
              
              $oaSubsidiasuransi = $subsidiOa['asuransi']; 
              $oaSubsidipemerintah = $subsidiOa['pemerintah']; 
              $oaSubsidirs = $subsidiOa['rumahsakit']; 

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
        <td><?php echo $cnt++; ?></td>
        <td><?php echo CHtml::checkBox("pembayaranAlkes[$i][checked]", (!empty($obatAlkes->verifikasitagihan_id) && $is_batal != 1), array('onchange'=>'simpanCeklisVerifikasiOA(this); hitungTotalSemuaOa();')) ?></td>
        <td hidden><?php // echo $obatAlkes->tglpelayanan ?></td>
        <td>
            <?php //echo $obatAlkes->daftartindakan->daftartindakan_nama ?>
            <?php echo (isset($obatAlkes->obatalkes->obatalkes_nama) ? $obatAlkes->obatalkes->obatalkes_nama : '') ?>
            <?php 
            if (!empty($instalasi_id)) {
                echo CHtml::hiddenField("pembayaranAlkes[$i][instalasi_id]" ,$instalasi_id, array('readonly'=>true,'class'=>'inputFormTabel span2')); 
            }
            ?>
            <?php echo CHtml::hiddenField("pembayaranAlkes[$i][obatalkespasien_id]" ,$obatAlkes->obatalkespasien_id, array('readonly'=>true,'class'=>'obatalkespasien_id')); ?>
            <?php echo CHtml::hiddenField("pembayaranAlkes[$i][obatalkes_id]" ,$obatAlkes->obatalkes_id, array('readonly'=>true,'class'=>'inputFormTabel span2')); ?>
            <?php echo CHtml::hiddenField("pembayaranAlkes[$i][carabayar_id]",$obatAlkes->carabayar_id, array('readonly'=>true)); ?>
            <?php echo CHtml::hiddenField("pembayaranAlkes[$i][penjamin_id]",$obatAlkes->penjamin_id, array('readonly'=>true)); ?>
        </td>
        <td>
            <?php echo CHtml::hiddenField("pembayaranAlkes[$i][hargajual_oa]", $obatAlkes->hargajual_oa, array('readonly'=>true, 'class'=>'hargajual_oa', 'style'=>'width: 100px;')); ?>
            <?php echo CHtml::textField("pembayaranAlkes[$i][hargasatuan]",MyFormatter::formatNumberForPrint($obatAlkes->hargasatuan_oa), array('onblur'=>'hitungTarifObat($(this).parents("tr").find(".qty_oa"),'.$obatAlkes->obatalkespasien_id.'); hitungTotalSemuaOa();','readonly'=>true,'class'=>'inputFormTabel integer2 span2 hargasatuan_oa', 'style'=>'width: 100px;')); ?>
            <br>
            <?php /*
              $modObatalkesKomp = ObatalkeskomponenT::model()->findAllByAttributes(array('obatalkespasien_id'=>$obatAlkes->obatalkespasien_id));
              foreach ($modObatalkesKomp as $key => $komp) {
                $obatalkespasien_id = $komp->obatalkespasien_id;
                echo CHtml::textField("komponen[$key][$obatalkespasien_id]", $komp->hargasatuankomponen, array('readonly'=>false,'onblur'=>'hitungTarifObat(this,'.$obatalkespasien_id.');','class'=>'inputFormTabel integer2 span2 tarif '.$obatalkespasien_id.''));
              }
             * 
             */
            ?>
        </td>
        <td>
            <?php echo CHtml::textField("pembayaranAlkes[$i][qty_oa]", str_replace(".", ",", $obatAlkes->qty_oa), array('readonly'=>true,'onblur'=>'hitungTotalSemuaOa()','class'=>'inputFormTabel number span1 integer2 qty_oa')); ?>
            <?php // echo CHtml::hiddenField("pembayaranAlkes[$i][qty_oa_old]", $obatAlkes->qty_oa); ?>
            <br>
            <?php /*
              $modObatalkesKomp = ObatalkeskomponenT::model()->findAllByAttributes(array('obatalkespasien_id'=>$obatAlkes->obatalkespasien_id));
              foreach ($modObatalkesKomp as $key => $komp) {
                echo $komp->komponentarif->komponentarif_nama.":<br>";
              } */
            ?>
        </td>
        <td style="display: none;">
            <?php echo CHtml::textField("pembayaranAlkes[$i][discount]",MyFormatter::formatNumberForPrint($diskon), array('readonly'=>true,'onblur'=>'hitungTotalSemuaOa();','class'=>'inputFormTabel integer2 span2','onkeypress'=>"return $(this).focusNextInputField(event)", 'style'=>'width: 100px;')); ?>
        </td>
        <td hidden>
            <?php echo CHtml::textField("pembayaranAlkes[$i][tarifcyto]", $oaCyto, array('readonly'=>true,'onblur'=>'hitungTagihan(this);','class'=>'inputFormTabel integer2 span2','onkeypress'=>"return $(this).focusNextInputField(event)", 'style'=>'width: 100px;')); ?>
        </td>
        <td>
            <?php echo CHtml::textField("pembayaranAlkes[$i][subsidiasuransi]", MyFormatter::formatNumberForPrint($oaSubsidiasuransi), array('readonly'=>true,'onblur'=>'hitungTotalSemuaOa();','class'=>'inputFormTabel integer2 span2','onkeypress'=>"return $(this).focusNextInputField(event)", 'style'=>'width: 100px;')); ?>
        </td>
        <!--DI JK INI DIHIDE-->
        <td style="display:none;">
            <?php echo CHtml::textField("pembayaranAlkes[$i][subsidipemerintah]", MyFormatter::formatNumberForPrint($oaSubsidipemerintah), array('readonly'=>true,'class'=>'inputFormTabel integer2 span2','onkeypress'=>"return $(this).focusNextInputField(event)", 'style'=>'width: 100px;')); ?>
        </td>
        <td style="display: none;">
            <?php echo CHtml::textField("pembayaranAlkes[$i][subsidirs]", MyFormatter::formatNumberForPrint($oaSubsidirs), array('readonly'=>true,'onblur'=>'hitungTotalSemuaOa();','class'=>'inputFormTabel integer2 span2','onkeypress'=>"return $(this).focusNextInputField(event)", 'style'=>'width: 100px;')); ?>
        </td>
        <td>
            <?php echo CHtml::textField("pembayaranAlkes[$i][iurbiaya]", MyFormatter::formatNumberForPrint($oaIurbiaya), array('readonly'=>true,'onblur'=>'hitungTotalSemuaOa();','class'=>'inputFormTabel integer2 span2 input_iurbiaya', 'style'=>'width: 100px;')); ?>
        </td>
        <td>
            <?php //echo $obatAlkes->daftartindakan_id ?>
            <?php echo CHtml::textField("pembayaranAlkes[$i][sub_total]", 0, array('readonly'=>true,'class'=>'inputFormTabel integer2 span2', 'style'=>'width: 100px;')); ?>
        </td>
    </tr>
<?php 

              } ?>
    <tr class="trfooter">
        <td style="display:none;">
            <?php echo CHtml::checkBox('inputTotalOa',false, array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'checkbox-column','onclick'=>'cekInputTotal(this)', 'style'=>'width: 100px;')) ?>
        </td>
        <td colspan="2">Input Total <?php //echo $subsidiOa['max']; ?></td>

        <td></td>
        <!--td></td-->
        <td>
            <span hidden><?php echo CHtml::textField("totalqty_oa", $totQtyOa, array('readonly'=>true,'class'=>'inputFormTabel number span1 integer2', 'style'=>'width: 100px;')); ?></span>
        </td>
        <td>
            <span hidden><?php echo CHtml::textField("totalbiaya_oa", $totHargaSatuan, array('readonly'=>true,'class'=>'inputFormTabel integer2 span2', 'style'=>'width: 100px;')); ?></span>
        </td>
        <td style="display: none;">
                    <?php echo CHtml::textField("totaldiscount_oa", $totDiscount_oa, array('readonly'=>true,'class'=>'inputFormTabel integer2 span2', 'style'=>'width: 100px;')); ?>
        </td>
        <td hidden>
            <?php echo CHtml::textField("totalcyto_oa", $totCytoOa, array('readonly'=>true,'class'=>'inputFormTabel integer2 span2', 'style'=>'width: 100px;')); ?>
        </td>
        <td>
            <?php echo CHtml::textField("totalsubsidiasuransi_oa", $totSubAsuransiOa, array('readonly'=>true,'onblur'=>'proporsiSubAsuransiOa();','class'=>'inputFormTabel integer2 span2','onkeypress'=>"return $(this).focusNextInputField(event)", 'style'=>'width: 100px;')); ?>
        </td>
        <td style="display: none;">
            <?php echo CHtml::textField("totalsubsidipemerintah_oa", $totSubPemerintahOa, array('readonly'=>true,'class'=>'inputFormTabel integer2 span2', 'style'=>'width: 100px;')); ?>
        </td>
        <td style="display: none;">
            <?php echo CHtml::textField("totalsubsidirs_oa", $totSubRsOa, array('readonly'=>true,'onblur'=>'proporsiSubRsOa();','class'=>'inputFormTabel integer2 span2','onkeypress'=>"return $(this).focusNextInputField(event)", 'style'=>'width: 100px;')); ?>
        </td>
        <td>
            <?php echo CHtml::textField("totaliurbiaya_oa", $totIurOa, array('readonly'=>true,'class'=>'inputFormTabel integer2 span2', 'style'=>'width: 100px;')); ?>
        </td>
        <td>
            <?php echo CHtml::textField("totalbayar_oa", $totalbayarOa, array('readonly'=>true,'class'=>'inputFormTabel integer2 span2', 'style'=>'width: 100px;')); ?>
        </td>
    </tr>
