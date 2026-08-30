<table class="table table-bordered table-striped table-condensed">
    <thead>
        <th>Pilih <?php echo CHtml::checkBox('is_pilihsemuatindakan', true, array('onchange' => 'setPilihTindakanChecked();', 'rel' => 'tooltip', 'title' => 'Centang untuk pilih semua tindakan', 'onkeyup' => "return $(this).focusNextInputField(event);")) ?></th>
        <th>Tanggal</th>
        <th width="50%">Deskripsi Tindakan</th>
        <th>Tarif Satuan <br>(Rp)</th>
        <th>Jumlah</th>
        <th hidden>Tarif Cyto <br>(Rp)</th>
        <th>Keringanan <br>(Rp)</th>
        <th>Pembebasan <br>(Rp)</th>
        <th>Total INACBG / Tanggungan Asuransi <br>(Rp)</th>
        <th>Tanggungan Rumah Sakit <br>(Rp)</th>
        <th hidden>Tanggungan Pemerintah <br>(Rp)</th>
        <th>Tanggungan Pasien <br>(Rp)</th>
        <!--Tanggungan Pasien = Iur Biaya-->
        <th>Jumlah Yang Harus Dibayar <br>(Rp)</th>
        <th>Pilih Penjamin</th>
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
        $cb = new CarabayarM;
        if (!empty($penjamin_id)) {
            $penjamin = PenjaminpasienM::model()->findByPk($penjamin_id);
            $cb = CarabayarM::model()->findByPk($penjamin->carabayar_id);
        }
        $subsidiasuransitind = 0;
        if (!empty($modTanggungan->tanggunganpenjamin_id)) {
            $penjamin = PenjaminpasienM::model()->findByPk($modTanggungan->penjamin_id);
            $subsidiasuransitind = (in_array($penjamin->carabayar_id, array(Params::CARABAYAR_ID_BPJS, Params::CARABAYAR_ID_BPJS_TENAGAKERJA))) ? 0 : $modTanggungan->subsidiasuransitind;
            $subsidipemerintahtind = $modTanggungan->subsidipemerintahtind;
            $subsidirstind = $modTanggungan->subsidirumahsakittind;
        } else {
            if (count((array)$dataTindakanPenunjangs) > 0) {
                $penjamin = PenjaminpasienM::model()->findByPk($penjamin_id);
                $cb = CarabayarM::model()->findByPk($penjamin->carabayar_id);
                if ($cb->issubsidiasuransi && !in_array($cb->carabayar_id, array(Params::CARABAYAR_ID_BPJS, Params::CARABAYAR_ID_BPJS_TENAGAKERJA))) $subsidiasuransitind = 100;
                if ($cb->issubsidipemerintah) $subsidipemerintahtind = 100;
                if ($cb->issubsidirs) $subsidirstind = 100;
            }
        }
        if (count((array)$dataTindakanPenunjangs) > 0) {
            foreach ($dataTindakanPenunjangs as $i => $dataTindakans) {
                echo '<tr>'
                    . '<td colspan="13" style="font-weight:bold;">'
                    . 'Tindakan ' . $dataPenunjangs[$i]['ruangan_nama'] . ' - ' . $dataPenunjangs[$i]['no_masukpenunjang'] . " - " . $dataPenunjangs[$i]['tglmasukpenunjang'] . " - " . $dataPenunjangs[$i]['jeniskasuspenyakit_nama'] . " - " . $dataPenunjangs[$i]['kelaspelayanan_nama']
                    . '</td></tr>';
                foreach ($dataTindakans as $ii => $tindakan) {
                    if ($tindakan->qty_tindakan == 0) continue;
                    $tindakan->is_pilihtindakan = true;
                    $tindakan->tgl_tindakan = $format->formatDateTimeForUser($tindakan->tgl_tindakan);
                    $subsidi = $tindakan->subsidiasuransi_tindakan + $tindakan->subsisidirumahsakit_tindakan;
                    $tarif = $tindakan->qty_tindakan * $tindakan->tarif_satuan;
                    $tindakan->subtotal = $tarif + $tindakan->tarifcyto_tindakan - $tindakan->discount_tindakan - $tindakan->pembebasan_tindakan - $subsidi;
                    $verifikasi = VerifikasitagihantindakanR::model()->findByAttributes(array(
                        'tindakanpelayanan_id' => $tindakan->tindakanpelayanan_id,
                    ), array(
                        'order' => 'verifikasitagihantindakan_id desc',
                    ));
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
                    // var_dump($tindakan->subsidiasuransi_tindakan); die;
                    $tindakan->subsidipemerintah_tindakan = $tindakan->getSubsidiPenjamin('subsidipemerintahtind');
                    $tindakan->subtotal = $tindakan->subtotal - $tindakan->subsidiasuransi_tindakan;
                    $tot_tarif_tindakan += ($tindakan->qty_tindakan * $tindakan->tarif_satuan);
                    $tot_tarifcyto_tindakan += $tindakan->tarifcyto_tindakan;
                    $tot_discount_tindakan += $diskon; //$tindakan->discount_tindakan;
                    $tot_pembebasan_tindakan += $tindakan->pembebasan_tindakan;
                    $tot_subsidiasuransi_tindakan += $tot_tarif_tindakan * ($subsidiasuransitind / 100);
                    $tot_subsisidirumahsakit_tindakan += $tindakan->subsisidirumahsakit_tindakan;
                    $tot_subsidipemerintah_tindakan += $tindakan->subsidipemerintah_tindakan;
                    $tot_iurbiaya_tindakan += $tindakan->iurbiaya_tindakan;
                    $total_tindakan += $tindakan->subtotal;
                    $tindakan->qty_tindakan = $format->formatNumberForPrint($tindakan->qty_tindakan);
                    $tindakan->tarif_satuan = $format->formatNumberForPrint($tindakan->tarif_satuan, 2);
                    $tindakan->tarifcyto_tindakan = $format->formatNumberForPrint($tindakan->tarifcyto_tindakan, 2);
                    $tindakan->discount_tindakan = $format->formatNumberForPrint($tindakan->discount_tindakan, 2);
                    $tindakan->pembebasan_tindakan = $format->formatNumberForPrint($tindakan->pembebasan_tindakan, 2);
                    $tindakan->subsidiasuransi_tindakan = $format->formatNumberForPrint($tindakan->subsidiasuransi_tindakan, 2);
                    $tindakan->subsisidirumahsakit_tindakan = $format->formatNumberForPrint($tindakan->subsisidirumahsakit_tindakan, 2);
                    $tindakan->subsidipemerintah_tindakan = $format->formatNumberForPrint($tindakan->subsidipemerintah_tindakan, 2);
                    //                  DISAMAKAN DENGAN subtotal >>  $tindakan->iurbiaya_tindakan = $format->formatNumberForPrint($tindakan->iurbiaya_tindakan);
                    $tindakan->iurbiaya_tindakan = $format->formatNumberForPrint($tindakan->subtotal, 2);
                    $tindakan->subtotal = $format->formatNumberForPrint($tindakan->subtotal, 2);
                    echo '<tr>'
                        . '<td>' . CHtml::activeCheckBox($tindakan, '[' . $i . '][' . $ii . ']is_pilihtindakan', array('onchange' => 'hitungTotalTindakan();', 'onkeyup' => "return $(this).focusNextInputField(event);"))
                        . CHtml::activeHiddenField($tindakan, '[' . $i . '][' . $ii . ']tindakanpelayanan_id', array('readonly' => true, 'class' => 'span1'))
                        . CHtml::activeHiddenField($tindakan, '[' . $i . '][' . $ii . ']daftartindakan_id', array('readonly' => true, 'class' => 'span1'))
                        . CHtml::activeHiddenField($tindakan, '[' . $i . '][' . $ii . ']tindakansudahbayar_id', array('readonly' => true, 'class' => 'span1'))
                        . '</td>'
                        . '<td>' . CHtml::activeTextField($tindakan, '[' . $i . '][' . $ii . ']tgl_tindakan', array('readonly' => true, 'class' => 'inputFormTabel lebar4', 'onkeyup' => "return $(this).focusNextInputField(event);", 'style' => 'width: 150px;')) . '</td>'
                        . '<td>' . $tindakan->daftartindakan->daftartindakan_kode . '-' . $tindakan->daftartindakan->daftartindakan_nama . '</td>'
                        . '<td>' . CHtml::activeTextField($tindakan, '[' . $i . '][' . $ii . ']tarif_satuan', array('readonly' => true, 'class' => 'inputFormTabel span2 integer-decimal', 'onkeyup' => "return $(this).focusNextInputField(event);", 'style' => 'width: 100px;')) . '</td>'
                        . '<td>' . CHtml::activeTextField($tindakan, '[' . $i . '][' . $ii . ']qty_tindakan', array('readonly' => true, 'class' => 'inputFormTabel span1 integer2', 'onkeyup' => "return $(this).focusNextInputField(event);")) . '</td>'
                        . '<td hidden>' . CHtml::activeTextField($tindakan, '[' . $i . '][' . $ii . ']tarifcyto_tindakan', array('readonly' => true, 'class' => 'inputFormTabel span2 integer-decimal', 'onkeyup' => "return $(this).focusNextInputField(event);", 'style' => 'width: 100px;')) . '</td>'
                        . '<td>' . CHtml::activeTextField($tindakan, '[' . $i . '][' . $ii . ']discount_tindakan', array('onblur' => 'hitungTotalTindakan();', 'class' => 'inputFormTabel span2 integer-decimal', 'onkeyup' => "return $(this).focusNextInputField(event);", 'style' => 'width: 100px;')) . '</td>'
                        . '<td>' . CHtml::activeTextField($tindakan, '[' . $i . '][' . $ii . ']pembebasan_tindakan', array('onblur' => 'hitungTotalTindakan();', 'class' => 'inputFormTabel span2 integer-decimal', 'onkeyup' => "return $(this).focusNextInputField(event);", 'style' => 'width: 100px;')) . '</td>'
                        . '<td>' . CHtml::activeTextField($tindakan, '[' . $i . '][' . $ii . ']subsidiasuransi_tindakan', array('onblur' => 'hitungTotalTindakan();', 'class' => 'inputFormTabel span2 integer-decimal', 'onkeyup' => "return $(this).focusNextInputField(event);", 'style' => 'width: 100px;')) . '</td>'
                        . '<td>' . CHtml::activeTextField($tindakan, '[' . $i . '][' . $ii . ']subsisidirumahsakit_tindakan', array('onblur' => 'hitungTotalTindakan();', 'class' => 'inputFormTabel span2 integer-decimal', 'onkeyup' => "return $(this).focusNextInputField(event);", 'style' => 'width: 100px;')) . '</td>'
                        . '<td hidden>' . CHtml::activeTextField($tindakan, '[' . $i . '][' . $ii . ']subsidipemerintah_tindakan', array('onblur' => 'hitungTotalTindakan();', 'class' => 'inputFormTabel span2 integer-decimal', 'onkeyup' => "return $(this).focusNextInputField(event);", 'style' => 'width: 100px;')) . '</td>'
                        . '<td>'
                        . CHtml::activeTextField($tindakan, '[' . $i . '][' . $ii . ']iurbiaya_tindakan', array('readonly' => true, 'class' => 'inputFormTabel span2 integer-decimal', 'onkeyup' => "return $(this).focusNextInputField(event);", 'style' => 'width: 100px;'))
                        . CHtml::activeHiddenField($tindakan, '[' . $i . '][' . $ii . ']iurbiaya_tindakan_temporary', array('readonly' => true, 'class' => 'inputFormTabel span2 integer-decimal', 'onkeyup' => "return $(this).focusNextInputField(event);", 'style' => 'width: 100px;'))
                        . CHtml::activeHiddenField($tindakan, '[' . $i . '][' . $ii . ']jmlselisihbpjs', array('readonly' => true, 'class' => 'inputFormTabel span2 integer-decimal', 'onkeyup' => "return $(this).focusNextInputField(event);", 'style' => 'width: 100px;'))
                        . '</td>'
                        . '<td>'
                        . CHtml::activeTextField($tindakan, '[' . $i . '][' . $ii . ']subtotal', array('readonly' => true, 'class' => 'inputFormTabel span2 integer-decimal', 'onkeyup' => "return $(this).focusNextInputField(event);", 'style' => 'width: 100px;'))
                        . CHtml::activeHiddenField($tindakan, '[' . $i . '][' . $ii . ']jmlbayar_iurtindakan', array('readonly' => true, 'class' => 'inputFormTabel span2 integer-decimal', 'onkeyup' => "return $(this).focusNextInputField(event);", 'style' => 'width: 100px;'))
                        . '</td>'
                        .'<td id="kolomlistpenjamin_'.$i.'">'.CHtml::activeDropDownList($tindakan, '[' . $i . '][' . $ii . ']penjamin_id', CHtml::listData($tindakan->getPenjaminTagihan(), 'penjamin_id', 'penjamin_nama') ,
                            array('onkeypress'=>"return $(this).focusNextInputField(event)",'style'=>'width:120px;','class'=>'penjamin_'.$tindakan->penjamin_id,'onchange'=>'hitungMultiPenjamin();'))
                        .'</td>'
                        . '</tr>';
                }
            }
        }
        ?>
    </tbody>
    <tfoot>
        <?php
        //formatting total
        $tot_tarif_tindakan = $format->formatNumberForPrint($tot_tarif_tindakan, 2);
        $tot_tarifcyto_tindakan = $format->formatNumberForPrint($tot_tarifcyto_tindakan, 2);
        $tot_discount_tindakan = $format->formatNumberForPrint($tot_discount_tindakan, 2);
        $tot_pembebasan_tindakan = $format->formatNumberForPrint($tot_pembebasan_tindakan, 2);
        $tot_subsidiasuransi_tindakan = $format->formatNumberForPrint($tot_subsidiasuransi_tindakan, 2);
        $tot_subsisidirumahsakit_tindakan = $format->formatNumberForPrint($tot_subsisidirumahsakit_tindakan, 2);
        $tot_subsidipemerintah_tindakan = $format->formatNumberForPrint($tot_subsidipemerintah_tindakan, 2);
        $tot_iurbiaya_tindakan = $format->formatNumberForPrint($total_tindakan, 2);
        $total_tindakan = $format->formatNumberForPrint($total_tindakan, 2);
        $total_jmlselisihbpjs_tindakan = 0;
        ?>
        <?php // echo CHtml::checkBox('is_proporsitindakan',false,array('onchange'=>'setProporsiTindakan();','rel'=>'tooltip','title'=>'Centang untuk masukan proporsi dari total tindakan','onkeyup'=>"return $(this).focusNextInputField(event);")) 
        ?>
        <td colspan="3" style="text-align: right; font-weight: bold;"> Total Tagihan Tindakan</td>
        <td><?php echo CHtml::textField('tot_tarif_tindakan', $tot_tarif_tindakan, array('readonly' => true, 'class' => 'inputFormTabel span2 integer-decimal', 'onkeyup' => "return $(this).focusNextInputField(event);", 'style' => 'width: 100px;')) ?></td>
        <td></td>
        <td hidden><?php echo CHtml::textField('tot_tarifcyto_tindakan', $tot_tarifcyto_tindakan, array('readonly' => true, 'class' => 'inputFormTabel span2 integer-decimal', 'onkeyup' => "return $(this).focusNextInputField(event);", 'style' => 'width: 100px;')) ?></td>
        <td><?php echo CHtml::textField('tot_discount_tindakan', $tot_discount_tindakan, array('onblur' => 'proporsiDiskonTindakan();', 'readonly' => true, 'class' => 'inputFormTabel span2 integer-decimal', 'onkeyup' => "return $(this).focusNextInputField(event);", 'style' => 'width: 100px;')) ?></td>
        <td><?php echo CHtml::textField('tot_pembebasan_tindakan', $tot_pembebasan_tindakan, array('onblur' => 'proporsiPembebasanTindakan();', 'readonly' => true, 'class' => 'inputFormTabel span2 integer-decimal', 'onkeyup' => "return $(this).focusNextInputField(event);", 'style' => 'width: 100px;')) ?></td>
        <td><?php echo CHtml::textField('tot_subsidiasuransi_tindakan', $tot_subsidiasuransi_tindakan, array('onblur' => 'proporsiSubsidiAsuransiTindakan();', 'readonly' => true, 'class' => 'inputFormTabel span2 integer-decimal', 'onkeyup' => "return $(this).focusNextInputField(event);", 'style' => 'width: 100px;')) ?></td>
        <td><?php echo CHtml::textField('tot_subsisidirumahsakit_tindakan', $tot_subsisidirumahsakit_tindakan, array('onblur' => 'proporsiSubsidiRsTindakan();', 'readonly' => true, 'class' => 'inputFormTabel span2 integer-decimal', 'onkeyup' => "return $(this).focusNextInputField(event);", 'style' => 'width: 100px;')) ?></td>
        <td hidden><?php echo CHtml::textField('tot_subsidipemerintah_tindakan', $tot_subsidipemerintah_tindakan, array('onblur' => 'proporsiSubsidiPemerintahTindakan();', 'readonly' => true, 'class' => 'inputFormTabel span2 integer-decimal', 'onkeyup' => "return $(this).focusNextInputField(event);", 'style' => 'width: 100px;')) ?></td>
        <td hidden><?php echo CHtml::textField('tot_jmlselisihbpjs_tindakan', $total_jmlselisihbpjs_tindakan, array('readonly' => true, 'class' => 'inputFormTabel span2 integer-decimal', 'onkeyup' => "return $(this).focusNextInputField(event);", 'style' => 'width: 100px;')) ?></td>
        <td><?php echo CHtml::textField('tot_iurbiaya_tindakan', $tot_iurbiaya_tindakan, array('readonly' => true, 'class' => 'inputFormTabel span2 integer-decimal', 'onkeyup' => "return $(this).focusNextInputField(event);", 'style' => 'width: 100px;')) ?></td>
        <td><?php echo CHtml::textField('total_tindakan', $total_tindakan, array('readonly' => true, 'class' => 'inputFormTabel span2 integer-decimal', 'onkeyup' => "return $(this).focusNextInputField(event);", 'style' => 'width: 100px;')) ?></td>
    </tfoot>
</table>