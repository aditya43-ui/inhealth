<table class="table table-bordered table-striped table-condensed">
    <thead>
        <th>Pilih <?php echo CHtml::checkBox('is_pilihsemuaoa',true,array('onchange'=>'setPilihOaChecked();','rel'=>'tooltip','title'=>'Centang untuk pilih semua obat dan alkes','onkeyup'=>"return $(this).focusNextInputField(event);")) ?></th>
        <th>Tanggal</th>
        <th width="50%">Deskripsi Obat & Alkes</th>
        <th>Jumlah</th>
        <th>Harga Satuan <br>(Rp.)</th>
        <!-- <th>PPN <br>(Rp.)</th> -->
        <th>Tarif Cyto <br>(Rp.)</th>
        <th>Keringanan <br>(Rp.)</th>
        <th hidden>Biaya Admin <br>(Rp.)</th>
        <th>Subsidi Asuransi <br>(Rp.)</th>
        <th>Subsidi Rumah Sakit <br>(Rp.)</th>
        <th>Subsidi Pemerintah <br>(Rp.)</th>
        <th>Tanggungan Pasien <br>(Rp.)</th><!-- Tanggungan Pasien = Iur Biaya -->
        <th>Jumlah Yang Harus Dibayar <br>(Rp.)</th>
    </thead>
    <tbody>
        <?php
        $format = new MyFormatter();
        $tot_hargajual_oa = 0;
        $tot_tarifcyto = 0;
        $tot_discount = 0;
        $tot_biayalain = 0;
        $tot_subsidiasuransi = 0;
        $tot_subsidipemerintah = 0;
        $tot_subsidirs = 0;
        $tot_iurbiaya = 0;
        $tot_ppn = 0;
        $total_oa = 0;
        $subtotaloa = 0;


        $subsidiasuransitind = 0;
        $subsidipemerintahtind = 0;
        $subsidirstind = 0;
        if(!empty($modTanggungan->tanggunganpenjamin_id)){
            $subsidiasuransitind = $modTanggungan->subsidiasuransioa;
            $subsidipemerintahtind = $modTanggungan->subsidipemerintahoa;
            $subsidirstind = $modTanggungan->subsidirumahsakitoa;
        } else {
            if (count((array)$dataOas) > 0) {
                if(isset($penjamin_id) && !empty($penjamin_id)){
                    $penjamin = PenjaminpasienM::model()->findByPk($penjamin_id);
                    $cb = CarabayarM::model()->findByPk($penjamin->carabayar_id);

                    if ($cb->issubsidiasuransi) $subsidiasuransitind = 100;
                    if ($cb->issubsidipemerintah) $subsidipemerintahtind = 100;
                    if ($cb->issubsidirs) $subsidirstind = 100;
                }
            }
        }

        if (count((array)$dataOas) > 0){
            foreach($dataOas AS $i =>$obatalkes){

                if ($obatalkes->qty_oa == 0) continue;

                // $obatalkes->hargasatuan_oa = ($obatalkes->hargasatuan_oa);
                $obatalkes->jumlahppn = ($obatalkes->jumlahppn / $obatalkes->qty_oa);
                $obatalkes->hargasatuan_oa = ($obatalkes->hargasatuan_oa + $obatalkes->biayaadministrasi + $obatalkes->jumlahppn);

                $tarif = $obatalkes->qty_oa*$obatalkes->hargasatuan_oa;
                $obatalkes->is_pilihoa = true;
                $obatalkes->tglpelayanan = $format->formatDateTimeForUser($obatalkes->tglpelayanan);
                $obatalkes->biayalain = $obatalkes->biayaservice + $obatalkes->biayakonseling + $obatalkes->biayakemasan + $obatalkes->biayaadministrasi;
                $subsidi = $obatalkes->subsidiasuransi+$obatalkes->subsidirs;
                $obatalkes->subtotaloa = ($obatalkes->qty_oa*$obatalkes->hargasatuan_oa)+$obatalkes->tarifcyto-$obatalkes->discount+$obatalkes->biayalain-$subsidi;

                $verifikasi = VerifikasitagihanT::model()->findByPk($obatalkes->verifikasitagihan_id);

                if (!empty($verifikasi)) {
                    $sub_asuransi = $obatalkes->subsidiasuransi;
                    $sub_pemerintah = $obatalkes->subsidipemerintah;
                    $sub_rs = $obatalkes->subsidirs;

                    if ($sub_rs > $tarif) $sub_rs = $tarif;
                    if ($sub_asuransi + $sub_rs > $tarif) $sub_asuransi = $tarif - $sub_rs;
                    if ($sub_pemerintah > $tarif) $sub_pemerintah = $tarif;
                } else {
                    $sub_asuransi = $obatalkes->getSubsidiPenjamin('subsidiasuransioa', true);
                    $sub_pemerintah = $obatalkes->getSubsidiPenjamin('subsidipemerintahoa', true);
                    $sub_rs = $obatalkes->getSubsidiPenjamin('subsidirumahsakitoa', true);
                }
                $obatalkes->subsidiasuransi = $sub_asuransi; // : ($tarif * $subsidiasuransitind / 100); //$tindakan->getSubsidiPenjamin('subsidiasuransitind');
                $obatalkes->subsidipemerintah = $sub_pemerintah; // : ($tarif * $subsidipemerintahtind / 100); // $tindakan->getSubsidiPenjamin('subsidipemerintahtind');
                $obatalkes->subsidirs = $sub_rs; // : ($tarif * $subsidirstind / 100); // $this->periksaTanggunganPasien($tindakan);
                $diskon = $obatalkes->discount;



                // $obatalkes->subsidiasuransi = $tarif * $subsidiasuransitind / 100; // $obatalkes->getSubsidiPenjamin('subsidirumahsakitoa');//($obatalkes->qty_oa*$obatalkes->hargasatuan_oa);
                // $obatalkes->subsidipemerintah = $tarif * $subsidipemerintahtind / 100; // $obatalkes->getSubsidiPenjamin('subsidipemerintahoa');//($obatalkes->qty_oa*$obatalkes->hargasatuan_oa);
                // $obatalkes->subsidirs = $tarif * $subsidirstind / 100; // $this->periksaTanggunganOAPasien($obatalkes);


                $tot_hargajual_oa += ($obatalkes->qty_oa*$obatalkes->hargasatuan_oa);
                $tot_tarifcyto += $obatalkes->tarifcyto;
                $tot_discount += $diskon; //$obatalkes->discount;
                $tot_biayalain += $obatalkes->biayalain;
                $tot_subsidiasuransi += $obatalkes->subsidiasuransi;
                $tot_subsidipemerintah += $obatalkes->subsidipemerintah;
                $tot_subsidirs += $obatalkes->subsidirs;
                $tot_iurbiaya += $obatalkes->iurbiaya;

                $total_oa += $obatalkes->subtotaloa;
                // $obatalkes->qty_oa = str_replace(".", ",", $obatalkes->qty_oa); //$format->formatNumberForPrint($obatalkes->qty_oa);
                $obatalkes->qty_oa = $format->formatNumberForPrint($obatalkes->qty_oa, 2);
                $obatalkes->hargasatuan_oa = $format->formatNumberForPrint($obatalkes->hargasatuan_oa, 2);
                $obatalkes->tarifcyto = $format->formatNumberForPrint($obatalkes->tarifcyto, 2);
                $obatalkes->discount = $format->formatNumberForPrint($diskon, 2); //$obatalkes->discount);
                $obatalkes->biayalain = $format->formatNumberForPrint($obatalkes->biayalain, 2);
                $obatalkes->subsidiasuransi = $format->formatNumberForPrint($obatalkes->subsidiasuransi, 2);
                // $obatalkes->subsidipemerintah = $format->formatNumberForPrint($obatalkes->subsidipemerintah);
                $obatalkes->subsidirs = $format->formatNumberForPrint($obatalkes->subsidirs, 2);
////                  DISAMAKAN DENGAN subtotaloa >>  $obatalkes->iurbiaya = $format->formatNumberForPrint($obatalkes->iurbiaya);
                $obatalkes->iurbiaya = $format->formatNumberForPrint($obatalkes->subtotaloa, 2);
                $obatalkes->subtotaloa = $format->formatNumberForPrint($obatalkes->subtotaloa, 2);
                $obatalkes->jasapelayanan_farmasi = $format->formatNumberForPrint($obatalkes->jasapelayanan_farmasi, 2);
                $htmlpenjamin = "";
                
                // $obatalkes->jumlahppn = $format->formatNumberForPrint($jmlppn,2);
                echo '<tr>'
                        .'<td>'.CHtml::activeCheckBox($obatalkes, '['.$i.']is_pilihoa',array('onchange'=>'hitungTotalOa();','onkeyup'=>"return $(this).focusNextInputField(event);"))
                        .CHtml::activeHiddenField($obatalkes, '['.$i.']obatalkespasien_id',array('readonly'=>true, 'class'=>'span1'))
                        .CHtml::activeHiddenField($obatalkes, '['.$i.']obatalkes_id',array('readonly'=>true, 'class'=>'span1'))
                        .'</td>'
                        .'<td>'.CHtml::activeTextField($obatalkes, '['.$i.']tglpelayanan',array('readonly'=>true,'class'=>'inputFormTabel lebar4', 'onkeyup'=>"return $(this).focusNextInputField(event);")).'</td>'
                        .'<td>'.$obatalkes->obatalkes->obatalkes_kode.'-'.$obatalkes->obatalkes->obatalkes_nama.'</td>'
                        .'<td>'.CHtml::activeTextField($obatalkes, '['.$i.']qty_oa',array('readonly'=>true,'class'=>'inputFormTabel span1 integer2', 'onkeyup'=>"return $(this).focusNextInputField(event);")).'</td>'
                        .'<td>'.CHtml::activeTextField($obatalkes, '['.$i.']hargasatuan_oa',array('readonly'=>true,'class'=>'inputFormTabel span2 integer-decimal', 'onkeyup'=>"return $(this).focusNextInputField(event);")).'</td>'
                        // .'<td>'.CHtml::activeTextField($obatalkes, '['.$i.']jumlahppn',array('readonly'=>true,'class'=>'inputFormTabel span2 integer2', 'onkeyup'=>"return $(this).focusNextInputField(event);")).'</td>'
                        .'<td>'.CHtml::activeTextField($obatalkes, '['.$i.']tarifcyto',array('readonly'=>true,'class'=>'inputFormTabel span2 integer-decimal', 'onkeyup'=>"return $(this).focusNextInputField(event);")).'</td>'
                        .'<td>'.CHtml::activeTextField($obatalkes, '['.$i.']discount',array('onblur'=>'hitungTotalOa();','class'=>'inputFormTabel span2 integer-decimal', 'onkeyup'=>"return $(this).focusNextInputField(event);")).'</td>'
                        .'<td hidden>'.CHtml::activeTextField($obatalkes, '['.$i.']biayalain',array('onblur'=>'hitungTotalOa();','class'=>'inputFormTabel span2 integer-decimal', 'onkeyup'=>"return $(this).focusNextInputField(event);")).'</td>'
                        .'<td>'.CHtml::activeTextField($obatalkes, '['.$i.']subsidiasuransi',array('onblur'=>'hitungTotalOa();','class'=>'inputFormTabel span2 integer-decimal', 'onkeyup'=>"return $(this).focusNextInputField(event);")).'</td>'
                        .'<td>'.CHtml::activeTextField($obatalkes, '['.$i.']subsidirs',array('onblur'=>'hitungTotalOa();','class'=>'inputFormTabel span2 integer-decimal', 'onkeyup'=>"return $(this).focusNextInputField(event);")).'</td>'
                        .'<td>'.CHtml::activeTextField($obatalkes, '['.$i.']subsidipemerintah',array('onblur'=>'hitungTotalOa();','class'=>'inputFormTabel span2 integer-decimal', 'onkeyup'=>"return $(this).focusNextInputField(event);")).'</td>'
                        .'<td>'.CHtml::activeTextField($obatalkes, '['.$i.']iurbiaya',array('readonly'=>true,'class'=>'inputFormTabel span2 integer-decimal', 'onkeyup'=>"return $(this).focusNextInputField(event);")).'</td>'
                        .'<td>'
                        .CHtml::activeTextField($obatalkes, '['.$i.']subtotaloa',array('readonly'=>true,'class'=>'inputFormTabel span2 integer-decimal', 'onkeyup'=>"return $(this).focusNextInputField(event);"))
                        .CHtml::activeHiddenField($obatalkes, '['.$i.']jmlbayar_oa',array('readonly'=>true,'class'=>'inputFormTabel span2 integer-decimal', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'style'=>'width:100px;'))
                        .CHtml::activeHiddenField($obatalkes, '['.$i.']jmlselisihbpjs',array('readonly'=>true,'class'=>'inputFormTabel span2 integer-decimal', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'style'=>'width:100px;'))
                        .'</td>'
                    .'</tr>';
            }
        }
        ?>
    </tbody>
    <tfoot>
        <?php
        //formatting total
        $tot_hargajual_oa = $format->formatNumberForPrint($tot_hargajual_oa,2);
        $tot_tarifcyto = $format->formatNumberForPrint($tot_tarifcyto,2);
        $tot_discount = $format->formatNumberForPrint($tot_discount,2);
        $tot_biayalain = $format->formatNumberForPrint($tot_biayalain,2);
        $tot_subsidiasuransi = $format->formatNumberForPrint($tot_subsidiasuransi,2);
        $tot_subsidipemerintah = $format->formatNumberForPrint($tot_subsidipemerintah,2);
        $tot_subsidirs = $format->formatNumberForPrint($tot_subsidirs,2);
        $tot_iurbiaya = $format->formatNumberForPrint($tot_iurbiaya,2);
        $total_oa = $format->formatNumberForPrint($total_oa,2);

        //var_dump($tot_subsidipemerintah); die;

        ?>
        <td colspan="5" style="text-align: right; font-weight: bold;"><?php //echo CHtml::checkBox('is_proporsioa',false,array('onchange'=>'setProporsiOa();','rel'=>'tooltip','title'=>'Centang untuk masukan proporsi dari total obat alkes','onkeyup'=>"return $(this).focusNextInputField(event);")) ?> Total Tagihan Obat & Alkes</td>
        <td hidden><?php echo CHtml::textField('tot_hargajual_oa',$tot_hargajual_oa,array('readonly'=>true,'class'=>'inputFormTabel span2 integer-decimal','onkeyup'=>"return $(this).focusNextInputField(event);")) ?></td>
        <td hidden><?php echo CHtml::textField('tot_ppn',$tot_ppn,array('readonly'=>true,'class'=>'inputFormTabel span2 integer-decimal','onkeyup'=>"return $(this).focusNextInputField(event);")) ?></td>
        <td><?php echo CHtml::textField('tot_tarifcyto',$tot_tarifcyto,array('readonly'=>true,'class'=>'inputFormTabel span2 integer-decimal','onkeyup'=>"return $(this).focusNextInputField(event);")) ?></td>
        <td><?php echo CHtml::textField('tot_discount',$tot_discount,array('onblur'=>'proporsiDiskonOa();','readonly'=>true,'class'=>'inputFormTabel span2 integer-decimal','onkeyup'=>"return $(this).focusNextInputField(event);")) ?></td>
        <td hidden><?php echo CHtml::textField('tot_biayalain',$tot_biayalain,array('onblur'=>'proporsiBiayaAdminOa();','readonly'=>true,'class'=>'inputFormTabel span2 integer-decimal','onkeyup'=>"return $(this).focusNextInputField(event);")) ?></td>
        <td><?php echo CHtml::textField('tot_subsidiasuransi',$tot_subsidiasuransi,array('onblur'=>'proporsiSubsidiAsuransiOa();','readonly'=>true,'class'=>'inputFormTabel span2 integer-decimal','onkeyup'=>"return $(this).focusNextInputField(event);")) ?></td>
        <td><?php echo CHtml::textField('tot_subsidirs',$tot_subsidirs,array('onblur'=>'proporsiSubsidiRsOa();','readonly'=>true,'class'=>'inputFormTabel span2 integer-decimal','onkeyup'=>"return $(this).focusNextInputField(event);")) ?></td>
        <td><?php echo CHtml::textField('tot_subsidipemerintah',$tot_subsidipemerintah,array('onblur'=>'proporsiSubsidiPemerintahOa();','readonly'=>true,'class'=>'inputFormTabel span2 integer-decimal','onkeyup'=>"return $(this).focusNextInputField(event);")) ?></td>
        <td><?php echo CHtml::textField('tot_iurbiaya',$tot_iurbiaya,array('readonly'=>true,'class'=>'inputFormTabel span2 integer-decimal','onkeyup'=>"return $(this).focusNextInputField(event);")) ?></td>
        <td><?php echo CHtml::textField('total_oa',$total_oa,array('readonly'=>true,'class'=>'inputFormTabel span2 integer-decimal','onkeyup'=>"return $(this).focusNextInputField(event);")) ?></td>
    </tfoot>
</table>
