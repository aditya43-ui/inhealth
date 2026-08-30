<?php
$cb = new CarabayarM;
if (!empty($penjamin_id)) {
    $penjamin = PenjaminpasienM::model()->findByPk($penjamin_id);
    $cb = CarabayarM::model()->findByPk($penjamin->carabayar_id);
}

$labelIncbgTot = "INACBG";
if(in_array($cb->carabayar_id, array(Params::CARABAYAR_ID_BPJS, Params::CARABAYAR_ID_BPJS_TENAGAKERJA))){
  $pasienAdms = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
  if(!empty($modTanggungan->tanggunganpenjamin_id)){
    $kelaspelDft = KelaspelayananM::model()->findByPk($modTanggungan->kelaspelayanan_id);
    $asuransiTg = AsuransipasienM::model()->findByPk($modPendaftaran->asuransipasien_id);

    $labelIncbgTot = (isset($kelaspelDft) && !empty($kelaspelDft->kelaspelayanan_id)? "INA ".$kelaspelDft->kelaspelayanan_nama: "INACBG");
  }
}
 ?>

<table style="width:100%" class="table table-bordered table-striped table-condensed">
    <thead>
        <th>Pilih <?php echo CHtml::checkBox('is_pilihsemuatindakan',true,array('onchange'=>'setPilihTindakanChecked();','rel'=>'tooltip','title'=>'Centang untuk pilih semua tindakan','onkeyup'=>"return $(this).focusNextInputField(event);")) ?></th>
        <th>Tanggal</th>
        <th width="50%">Deskripsi Tindakan</th>
        <th>Tarif Satuan <br>(Rp.)</th>
        <th>Jumlah</th>
        <th hidden>Tarif Cyto <br>(Rp.)</th>
        <th>Keringanan <br>(Rp.)</th>
        <th>Pembebasan <br>(Rp.)</th>
        <th>
            Total <?php echo $labelIncbgTot; ?> / Tanggungan Asuransi <br>(Rp.) 
            <?php echo CHtml::htmlButton('<i class="entypo-arrows-ccw"></i>', array('class' => 'btn btn-danger btn-mini', 'onclick' => 'refresh_tagihan("umum");', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk me-refresh rincian tagihan tindakan')); ?>
        </th>
        <th>Tanggungan Rumah Sakit <br>(Rp.)</th>
        <th hidden>Tanggungan Pemerintah <br>(Rp.)</th>
        <th>
            Tanggungan Pasien <br>(Rp.)
            <?php echo CHtml::htmlButton('<i class="entypo-arrows-ccw"></i>', array('class' => 'btn btn-danger btn-mini', 'onclick' => 'refresh_tagihan("asuransi");', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk me-refresh rincian tagihan tindakan')); ?>
        </th><!-- Tanggungan Pasien = Iur Biaya -->
        <th class="selisibpjsClass">Selisih Tanggungan BPJS <br>(Rp.)</th>
        <th>Jumlah Yang Harus Dibayar <br>(Rp.)</th>
        <?php if(in_array($this->id, array("pembayaranTagihanPasien", "alokasiDana"))){  ?>
        <th>Pilih Penjamin</th>
        <?php } ?>
    </thead>
    <tbody>
        <?php
        $format = new MyFormatter();
        $tot_tarif_tindakan = 0;
        $tot_tarifcyto_tindakan = 0;
        $tot_discount_tindakan = 0;
        $tot_pembebasan_tindakan = 0;
        $tot_subsidiasuransi_tindakan = 0;
        $tot_subsisidirumahsakit_tindakan = 0;
        $tot_subsidipemerintah_tindakan = 0;
        $tot_iurbiaya_tindakan = 0;
        $total_tindakan = 0;
        $subtotal = 0;
        $subsidiasuransitind = 0;
        $subsidipemerintahtind = 0;
        $subsidirstind = 0;
        $total_jmlselisihbpjs_tindakan = 0;

        // $cb = new CarabayarM;
        // if (!empty($penjamin_id)) {
        //     $penjamin = PenjaminpasienM::model()->findByPk($penjamin_id);
        //     $cb = CarabayarM::model()->findByPk($penjamin->carabayar_id);
        // }
        if(!empty($modTanggungan->tanggunganpenjamin_id)){
            $penjamin = PenjaminpasienM::model()->findByPk($modTanggungan->penjamin_id);
            $subsidiasuransitind = (in_array($penjamin->carabayar_id, array(Params::CARABAYAR_ID_BPJS, Params::CARABAYAR_ID_BPJS_TENAGAKERJA))) ? 0 : $modTanggungan->subsidiasuransitind;
            $subsidipemerintahtind = $modTanggungan->subsidipemerintahtind;
            $subsidirstind = $modTanggungan->subsidirumahsakittind;
        } else {
            if (count((array)$dataTindakans) > 0) {
                $penjamin = PenjaminpasienM::model()->findByPk($penjamin_id);
                $cb = CarabayarM::model()->findByPk($penjamin->carabayar_id);

                if ($cb->issubsidiasuransi && !in_array($cb->carabayar_id, array(Params::CARABAYAR_ID_BPJS, Params::CARABAYAR_ID_BPJS_TENAGAKERJA))) $subsidiasuransitind = 100;
                if ($cb->issubsidipemerintah) $subsidipemerintahtind = 100;
                if ($cb->issubsidirs) $subsidirstind = 100;
            }
        }


        // var_dump($subsidiasuransitind);
        // var_dump($subsidipemerintahtind);
        // var_dump($subsidirstind);
        // die;

        
        if (count((array)$dataTindakans) > 0){
            foreach($dataTindakans AS $i =>$tindakan){

                if ($tindakan->qty_tindakan == 0) continue;
                $tindakan->tarif_satuan = $tindakan->cyto_tindakan ? ($tindakan->tarifcyto_tindakan) : $tindakan->tarif_satuan;

                $tindakan->is_pilihtindakan = true;
                $tindakan->tgl_tindakan = $format->formatDateTimeForUser($tindakan->tgl_tindakan);
                $subsidi = $tindakan->subsidiasuransi_tindakan+$tindakan->subsisidirumahsakit_tindakan;
                $tarif = $tindakan->tarif_tindakan = $tindakan->qty_tindakan*$tindakan->tarif_satuan;
                
                $tarif_kotor = $tarif+$tindakan->tarifcyto_tindakan-$tindakan->discount_tindakan-$tindakan->pembebasan_tindakan;
                $tindakan->subtotal = $tarif+$tindakan->tarifcyto_tindakan-$tindakan->discount_tindakan-$tindakan->pembebasan_tindakan-$subsidi;


                $verifikasi = null; /* VerifikasitagihantindakanR::model()->findByAttributes(array(
                    'tindakanpelayanan_id'=>$tindakan->tindakanpelayanan_id,
                ), array(
                    'order'=>'verifikasitagihantindakan_id desc',
                )); */

                if (!empty($verifikasi)) {
                    $sub_asuransi = $verifikasi->subsidiasuransi_tindakan_sesudah;
                    $sub_pemerintah = $verifikasi->subsidipemerintah_tindakan_sesudah;
                    $sub_rs = $verifikasi->subsisidirumahsakit_tindakan_sesudah;

                    if ($sub_rs > $tarif) $sub_rs = $tarif;
                    if ($sub_asuransi + $sub_rs > $tarif) $sub_asuransi = $tarif - $sub_rs;
                    if ($sub_pemerintah > $tarif) $sub_pemerintah = $tarif;
                } else {
                    $sub_asuransi = $tindakan->getSubsidiPenjamin('subsidiasuransitind');
                    $sub_pemerintah = $tindakan->getSubsidiPenjamin('subsidipemerintahtind');
                    $sub_rs = $tindakan->getSubsidiPenjamin('subsidirumahsakittind');
                }



                $tindakan->subsidiasuransi_tindakan = $sub_asuransi; // : ($tarif * $subsidiasuransitind / 100); //$tindakan->getSubsidiPenjamin('subsidiasuransitind');
                $tindakan->subsidipemerintah_tindakan = $sub_pemerintah; // : ($tarif * $subsidipemerintahtind / 100); // $tindakan->getSubsidiPenjamin('subsidipemerintahtind');
                $tindakan->subsisidirumahsakit_tindakan = $sub_rs; // : ($tarif * $subsidirstind / 100); // $this->periksaTanggunganPasien($tindakan);
                $diskon = 0;


                $tindakan->subtotal = $tindakan->subtotal - $tindakan->subsidiasuransi_tindakan;
                $tot_tarif_tindakan += ($tindakan->qty_tindakan*$tindakan->tarif_satuan);
                $tot_tarifcyto_tindakan += $tindakan->tarifcyto_tindakan;
                $tot_discount_tindakan += $tindakan->discount_tindakan;
                $tot_pembebasan_tindakan += $tindakan->pembebasan_tindakan;
                $tot_subsidiasuransi_tindakan += $tot_tarif_tindakan * ($subsidiasuransitind/100);
                $tot_subsisidirumahsakit_tindakan += $tindakan->subsisidirumahsakit_tindakan;
                $tot_subsidipemerintah_tindakan += $tindakan->subsidipemerintah_tindakan;
                $tot_iurbiaya_tindakan += $tindakan->iurbiaya_tindakan;
                $total_tindakan += $tindakan->subtotal;
                $tindakan->qty_tindakan = $tindakan->qty_tindakan;
                $tindakan->tarif_satuan = $tindakan->tarif_satuan;
                $tindakan->tarifcyto_tindakan = $tindakan->tarifcyto_tindakan;
                $tindakan->discount_tindakan = $tindakan->discount_tindakan;
                $tindakan->pembebasan_tindakan = $tindakan->pembebasan_tindakan;
                $tindakan->subsidiasuransi_tindakan = $tindakan->subsidiasuransi_tindakan;
                $tindakan->subsisidirumahsakit_tindakan = $tindakan->subsisidirumahsakit_tindakan;
//                      DISAMAKAN DENGAN subtotal >>  $tindakan->iurbiaya_tindakan = $format->formatNumberForPrint($tindakan->iurbiaya_tindakan);
                $tindakan->iurbiaya_tindakan = $tindakan->subtotal;
                $tindakan->subtotal = $tindakan->subtotal;
                $htmlpenjamin = "";
                if(in_array($this->id, array("pembayaranTagihanPasien", "alokasiDana"))){ 
                    $htmlpenjamin = '<td id="kolomlistpenjamin_'.$i.'">'.CHtml::activeDropDownList($tindakan, '['.$i.']penjamin_id', CHtml::listData($tindakan->getPenjaminTagihan(), 'penjamin_id', 'penjamin_nama') ,
                            array('onkeypress'=>"return $(this).focusNextInputField(event)",'style'=>'width:120px;','class'=>'penjamin_tindakan penjamin_'.$tindakan->penjamin_id,'onchange'=>'hitungMultiPenjamin();'))
                        .'</td>';
                }

                echo '<tr>'
                        .'<td>'.CHtml::activeCheckBox($tindakan, '['.$i.']is_pilihtindakan',array('class'=>'pilih_tindakan', 'onchange'=>'hitungTotalTindakan(); '.($this->id == "alokasiDana" ? "setProporsionalMultiPenjaminDana();" : ""),'onkeyup'=>"return $(this).focusNextInputField(event);"))
                        .CHtml::activeHiddenField($tindakan, '['.$i.']tindakanpelayanan_id',array('readonly'=>true, 'class'=>'span1'))
                        .CHtml::activeHiddenField($tindakan, '['.$i.']tindakansudahbayar_id',array('readonly'=>true, 'class'=>'span1'))
                        .CHtml::activeHiddenField($tindakan, '['.$i.']daftartindakan_id',array('readonly'=>true, 'class'=>'span1'))
                        .CHtml::activeHiddenField($tindakan, '['.$i.']kelastanggungan_id',array('readonly'=>true, 'class'=>'span1'))
                        .CHtml::hiddenField('tarif_kotor', $tarif_kotor, array('class'=>'tarif_kotor'))
                        .'</td>'
                        .'<td>'.CHtml::activeTextField($tindakan, '['.$i.']tgl_tindakan',array('readonly'=>true,'class'=>'inputFormTabel lebar4', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'style'=>'width: 150px;')).'</td>'
                        .'<td>'.//$tindakan->daftartindakan->daftartindakan_kode.
                                $tindakan->daftartindakan->daftartindakan_nama." (".$tindakan->tindakanluar_nama.") ".'</td>'
                        .'<td>'.CHtml::activeTextField($tindakan, '['.$i.']tarif_satuan',array('readonly'=>true,'class'=>'inputFormTabel span2 integer-decimal', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'style'=>'width: 100px;')).'</td>'
                        .'<td>'.CHtml::activeTextField($tindakan, '['.$i.']qty_tindakan',array('readonly'=>true,'class'=>'inputFormTabel span1 integer-decimal', 'onkeyup'=>"return $(this).focusNextInputField(event);")).'</td>'
                        .'<td hidden>'.CHtml::activeTextField($tindakan, '['.$i.']tarifcyto_tindakan',array('readonly'=>true,'class'=>'inputFormTabel span2 integer-decimal', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'style'=>'width: 100px;')).'</td>'
                        .'<td>'.CHtml::activeTextField($tindakan, '['.$i.']discount_tindakan',array('readonly'=>true,'onblur'=>'hitungTotalTindakan();','class'=>'inputFormTabel span2 integer-decimal', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'style'=>'width: 100px;')).'</td>'
                        .'<td>'.CHtml::activeTextField($tindakan, '['.$i.']pembebasan_tindakan',array('readonly'=>true,'onblur'=>'hitungTotalTindakan();','class'=>'inputFormTabel span2 integer-decimal', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'style'=>'width: 100px;')).'</td>'
                        .'<td>'.CHtml::activeTextField($tindakan, '['.$i.']subsidiasuransi_tindakan',array('readonly'=>true, 'onblur'=>'hitungTotalTindakan();','class'=>'inputFormTabel span2 integer-decimal subsidiasuransi_tindakan', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'style'=>'width: 100px;')).'</td>'
                        .'<td>'.CHtml::activeTextField($tindakan, '['.$i.']subsisidirumahsakit_tindakan',array('onblur'=>'hitungTotalTindakan();','class'=>'inputFormTabel span2 integer-decimal', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'style'=>'width: 100px;')).'</td>'
                        .'<td hidden>'.CHtml::activeTextField($tindakan, '['.$i.']subsidipemerintah_tindakan',array('onblur'=>'hitungTotalTindakan();','class'=>'inputFormTabel span2 integer-decimal', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'style'=>'width: 100px;')).'</td>'
                        .'<td>'
                            .CHtml::activeTextField($tindakan, '['.$i.']iurbiaya_tindakan',array('readonly'=>true,'class'=>'inputFormTabel span2 integer-decimal iurbiaya', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'style'=>'width: 100px;'))
                            .CHtml::activeHiddenField($tindakan, '['.$i.']iurbiaya_tindakan_temporary',array('readonly'=>true,'class'=>'inputFormTabel span2 integer-decimal', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'style'=>'width: 100px;'))
                        .'</td>'
                        .'<td class="selisibpjsClass">'.CHtml::activeTextField($tindakan, '['.$i.']jmlselisihbpjs',array('readonly'=>true,'class'=>'inputFormTabel span2 integer-decimal', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'style'=>'width: 100px;')).'</td>'
                        .'<td>'
                          .CHtml::activeTextField($tindakan, '['.$i.']subtotal',array('readonly'=>true,'class'=>'inputFormTabel span2 integer-decimal', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'style'=>'width: 100px;'))
                          .CHtml::activeHiddenField($tindakan, '['.$i.']jmlbayar_iurtindakan',array('readonly'=>true,'class'=>'inputFormTabel span2 integer-decimal', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'style'=>'width: 100px;'))
                          .'</td>'
                          .$htmlpenjamin
                    .'</tr>';
            }
        }
        ?>
    </tbody>
    <tfoot>
        <?php
        //formatting total
        $tot_tarif_tindakan = $tot_tarif_tindakan;
        $tot_tarifcyto_tindakan = $tot_tarifcyto_tindakan;
        $tot_discount_tindakan = $tot_discount_tindakan;
        $tot_pembebasan_tindakan = $tot_pembebasan_tindakan;
        $tot_subsidiasuransi_tindakan = $tot_subsidiasuransi_tindakan;
        $tot_subsidipemerintah_tindakan = $tot_subsidipemerintah_tindakan;
        $tot_subsisidirumahsakit_tindakan = $tot_subsisidirumahsakit_tindakan;
        $tot_iurbiaya_tindakan = $total_tindakan;
        $total_jmlselisihbpjs_tindakan = $total_jmlselisihbpjs_tindakan;
        $total_tindakan = $total_tindakan;
        ?>
        <td colspan="4" style="text-align: right; font-weight: bold;"><?php // echo CHtml::checkBox('is_proporsitindakan',false,array('onchange'=>'setProporsiTindakan();','rel'=>'tooltip','title'=>'Centang untuk masukan proporsi dari total tindakan','onkeyup'=>"return $(this).focusNextInputField(event);")) ?> Total Tagihan Tindakan</td>
        <td><span hidden><?php echo CHtml::textField('tot_tarif_tindakan',$tot_tarif_tindakan,array('readonly'=>true,'class'=>'inputFormTabel span2 integer-decimal','onkeyup'=>"return $(this).focusNextInputField(event);", 'style'=>'width: 100px;')) ?></span></td>
        <td hidden><?php echo CHtml::textField('tot_tarifcyto_tindakan',$tot_tarifcyto_tindakan,array('readonly'=>true,'class'=>'inputFormTabel span2 integer-decimal','onkeyup'=>"return $(this).focusNextInputField(event);", 'style'=>'width: 100px;')) ?></td>
        <td><?php echo CHtml::textField('tot_discount_tindakan',$tot_discount_tindakan,array('onblur'=>'proporsiDiskonTindakan();','readonly'=>true,'class'=>'inputFormTabel span2 integer-decimal','onkeyup'=>"return $(this).focusNextInputField(event);", 'style'=>'width: 100px;')) ?></td>
        <td><?php echo CHtml::textField('tot_pembebasan_tindakan',$tot_pembebasan_tindakan,array('onblur'=>'proporsiPembebasanTindakan();','readonly'=>true,'class'=>'inputFormTabel span2 integer-decimal','onkeyup'=>"return $(this).focusNextInputField(event);", 'style'=>'width: 100px;')) ?></td>
        <td><?php echo CHtml::textField('tot_subsidiasuransi_tindakan',$tot_subsidiasuransi_tindakan,array('onblur'=>'proporsiSubsidiAsuransiTindakan();','readonly'=>true,'class'=>'inputFormTabel span2 integer-decimal','onkeyup'=>"return $(this).focusNextInputField(event);", 'style'=>'width: 100px;')) ?></td>
        <td><?php echo CHtml::textField('tot_subsisidirumahsakit_tindakan',$tot_subsisidirumahsakit_tindakan,array('onblur'=>'proporsiSubsidiRsTindakan();','readonly'=>true,'class'=>'inputFormTabel span2 integer-decimal','onkeyup'=>"return $(this).focusNextInputField(event);", 'style'=>'width: 100px;')) ?></td>
        <td hidden><?php echo CHtml::textField('tot_subsidipemerintah_tindakan',$tot_subsidipemerintah_tindakan,array('onblur'=>'proporsiSubsidiPemerintahTindakan();','readonly'=>true,'class'=>'inputFormTabel span2 integer-decimal','onkeyup'=>"return $(this).focusNextInputField(event);", 'style'=>'width: 100px;')) ?></td>
        <td><?php echo CHtml::textField('tot_iurbiaya_tindakan',$tot_iurbiaya_tindakan,array('readonly'=>true,'class'=>'inputFormTabel span2 integer-decimal','onkeyup'=>"return $(this).focusNextInputField(event);", 'style'=>'width: 100px;')) ?></td>
        <td class="selisibpjsClass"><?php echo CHtml::textField('tot_jmlselisihbpjs_tindakan',$total_jmlselisihbpjs_tindakan,array('readonly'=>true,'class'=>'inputFormTabel span2 integer-decimal','onkeyup'=>"return $(this).focusNextInputField(event);", 'style'=>'width: 100px;')) ?></td>
        <td><?php echo CHtml::textField('total_tindakan',$total_tindakan,array('readonly'=>true,'class'=>'inputFormTabel span2 integer-decimal','onkeyup'=>"return $(this).focusNextInputField(event);", 'style'=>'width: 100px;')) ?></td>
        <td></td>
    </tfoot>
</table>
