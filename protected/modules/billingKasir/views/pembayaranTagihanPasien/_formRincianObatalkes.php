<style>
    .data{
        background-color: yellow;
    }
</style>
<?php
$max_penjamin = 5;
$cb = new CarabayarM;
$konfigFarmasi = KonfigfarmasiK::model()->findByPk(1);
if (!empty($penjamin_id)) {
    $penjamin = PenjaminpasienM::model()->findByPk($penjamin_id);
    $cb = CarabayarM::model()->findByPk($penjamin->carabayar_id);
}
 ?>

<table class="table table-bordered table-striped table-condensed">
    <thead>
        <th>Pilih <?php echo CHtml::checkBox('is_pilihsemuaoa',true,array('onchange'=>'setPilihOaChecked();','rel'=>'tooltip','title'=>'Centang untuk pilih semua obat dan alkes','onkeyup'=>"return $(this).focusNextInputField(event);")) ?></th>
        <th>Tanggal</th>
        <th width="50%">Deskripsi Obat & Alkes</th>
        <th>Harga Satuan <br>(Rp.)</th>
        <th>Jumlah</th>
        <th hidden>Tarif Cyto <br>(Rp.)</th>
        <th>Keringanan <br>(Rp.)</th>
        <?php for ($ci = 0; $ci < $max_penjamin; $ci++): 
            $col_penjamin_id = null;
            $col_penjamin_nama = "";
            if ($ci == 0) {
                $col_penjamin_id = $penjamin->penjamin_id ?? null;
                $col_penjamin_nama = $penjamin->penjamin_nama ?? null;
            }
        ?>
        <th class="col_th_penjamin col_subsidi_<?php echo $ci; ?>" 
            data-is_umum="<?php echo $ci == 0 ? 1 : 0; ?>" 
            data-penjamin_id="<?php echo $col_penjamin_id; ?>" 
            data-col_index="<?php echo $ci; ?>"
        >Tanggungan<br/>
        <span class="nama_tanggungan"><?php echo $col_penjamin_nama; ?></span></br>
        (Rp.)
        </th>
        <?php endfor; ?>
        <th>Jumlah Yang Harus Dibayar <br>(Rp.)</th>
        <?php /* if(in_array($this->id, array("pembayaranTagihanPasien", "alokasiDana"))){  ?>
        <th>Pilih Penjamin</th>
        <?php } */ ?>
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
        $total_oa = 0;
        $subtotaloa = 0;

        $subsidiasuransitind = 0;
        $subsidipemerintahtind = 0;
        $subsidirstind = 0;
        $total_jmlselisihbpjs = 0;

        // $cb = new CarabayarM;
        // if (!empty($penjamin_id)) {
        //     $penjamin = PenjaminpasienM::model()->findByPk($penjamin_id);
        //     $cb = CarabayarM::model()->findByPk($penjamin->carabayar_id);
        // }

        if(!empty($modTanggungan->tanggunganpenjamin_id)){
            $subsidiasuransitind = $modTanggungan->subsidiasuransitind;
            $subsidipemerintahtind = $modTanggungan->subsidipemerintahtind;
            $subsidirstind = $modTanggungan->subsidirumahsakittind;
        } else {
            if (count((array)$dataOas) > 0 && !empty($cb)) {
                if ($cb->issubsidiasuransi) $subsidiasuransitind = 100;
                if ($cb->issubsidipemerintah) $subsidipemerintahtind = 100;
                if ($cb->issubsidirs) $subsidirstind = 100;
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
                $tarif_kotor = ($obatalkes->qty_oa*$obatalkes->hargasatuan_oa)+$obatalkes->tarifcyto-$obatalkes->discount+$obatalkes->biayalain;
                $obatalkes->subtotaloa = ($obatalkes->qty_oa*$obatalkes->hargasatuan_oa)+$obatalkes->tarifcyto-$obatalkes->discount+$obatalkes->biayalain-$subsidi;


                $subtotal_oa = ($obatalkes->qty_oa*$obatalkes->hargasatuan_oa) - $obatalkes->discount;

                // $verifikasi = VerifikasitagihanT::model()->findByPk($obatalkes->verifikasitagihan_id);

                /*
                if (!empty($verifikasi)) {
                    $sub_asuransi = $obatalkes->subsidiasuransi;
                    $sub_pemerintah = $obatalkes->subsidipemerintah;
                    $sub_rs = $obatalkes->subsidirs;

                    if ($sub_rs > $tarif) $sub_rs = $tarif;
                    if ($sub_asuransi + $sub_rs > $tarif) $sub_asuransi = $tarif - $sub_rs;
                    if ($sub_pemerintah > $tarif) $sub_pemerintah = $tarif;
                } else if (!$obatalkes->is_ditanggungpasien) {
                    $sub_asuransi = $obatalkes->getSubsidiPenjamin('subsidiasuransioa', true);
                    $sub_pemerintah = $obatalkes->getSubsidiPenjamin('subsidipemerintahoa', true);
                    $sub_rs = $obatalkes->getSubsidiPenjamin('subsidirumahsakitoa', true);
                } else {
                    $sub_asuransi = 0;
                    $sub_pemerintah = 0;
                    $sub_rs = 0;
                }
                */

                $obatalkes->subsidiasuransi = 0; //$sub_asuransi; // : ($tarif * $subsidiasuransitind / 100); //$tindakan->getSubsidiPenjamin('subsidiasuransitind');
                $obatalkes->subsidipemerintah = 0; //$sub_pemerintah; // : ($tarif * $subsidipemerintahtind / 100); // $tindakan->getSubsidiPenjamin('subsidipemerintahtind');
                $obatalkes->subsidirs = 0; //$sub_rs; // : ($tarif * $subsidirstind / 100); // $this->periksaTanggunganPasien($tindakan);
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
                /*
                if(in_array($this->id, array("pembayaranTagihanPasien", "alokasiDana"))){ 
                    $htmlpenjamin = '<td id="kolomlistpenjamin_'.$i.'">'.CHtml::activeDropDownList($obatalkes, '['.$i.']penjamin_id', CHtml::listData( $obatalkes->getPenjaminTagihan(), 'penjamin_id', 'penjamin_nama') ,
                            array('onkeypress'=>"return $(this).focusNextInputField(event)",'style'=>'width:120px;','class'=>'penjamin_oa penjamin_'.$obatalkes->penjamin_id,'onchange'=>'hitungMultiPenjamin();'))
                    .'</td>';
                }*/
                // var_dump($obatalkes->subsidiasuransi);die;
                // if($obatalkes->is_ditanggungpasien == "true" || $obatalkes->is_ditanggungpasien == 1){
                    echo '<tr>'
                            .'<td>'.CHtml::activeCheckBox($obatalkes, '['.$i.']is_pilihoa',array('class'=>'pilih_oa','onchange'=>'hitungTotalOa(); ','onkeyup'=>"return $(this).focusNextInputField(event);"))
                            .CHtml::activeHiddenField($obatalkes, '['.$i.']obatalkespasien_id',array('readonly'=>true, 'class'=>'span1'))
                            .CHtml::activeHiddenField($obatalkes, '['.$i.']obatalkes_id',array('readonly'=>true, 'class'=>'span1'))
                            .CHtml::activeHiddenField($obatalkes, '['.$i.']oasudahbayar_id',array('readonly'=>true, 'class'=>'span1'))
                            .CHtml::hiddenField('tarif_kotor', $tarif_kotor, array('class'=>'tarif_kotor'))
                            .'</td>'
                            .'<td>'.CHtml::activeTextField($obatalkes, '['.$i.']tglpelayanan',array('readonly'=>true,'class'=>'inputFormTabel lebar4', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'style'=>'width:150px;')).'</td>'
                            .'<td>'.//$obatalkes->obatalkes->obatalkes_kode.'-'.
                                    $obatalkes->obatalkes->obatalkes_nama.'</td>'
                            .'<td>'.CHtml::activeTextField($obatalkes, '['.$i.']hargasatuan_oa',array('readonly'=>true,'class'=>'inputFormTabel span2 integer-decimal', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'style'=>'width:100px;')).'</td>'
                            // .'<td class="obatalkes">'.$konfig.'</td>'
                            // .'<td>'.CHtml::activeTextField($obatalkes, '['.$i.']obatalkes_biaya_r',array('readonly'=>true,'class'=>'inputFormTabel span1 integer-decimal', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'style'=>'text-align: right;')).'</td>'
                            .'<td>'.CHtml::activeTextField($obatalkes, '['.$i.']qty_oa',array('readonly'=>true,'class'=>'inputFormTabel span1 integer-decimal', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'style'=>'text-align: right;')).'</td>'
                            .'<td hidden>'.CHtml::activeTextField($obatalkes, '['.$i.']tarifcyto',array('readonly'=>true,'class'=>'inputFormTabel span2 integer-decimal', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'style'=>'width:100px;')).'</td>'
                            .'<td>'.CHtml::activeTextField($obatalkes, '['.$i.']discount',array('readonly'=>true,'onblur'=>'hitungTotalOa();','class'=>'inputFormTabel span2 integer-decimal', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'style'=>'width:100px;')).'</td>';
                            
                        for ($ic = 0; $ic < $max_penjamin; $ic++) {

                            $total = 0;
                            if ($ic == 0) {
                                $total = $subtotal_oa;
                            }
        
                            $obatalkes->subsidiasuransi = $total;
                            
                            echo '<td class="col_subsidi_'.$ic.'">';
                            echo CHtml::activeTextField($obatalkes, '['.$i.']subsidiasuransi['.$ic.']',array('readonly'=>false,'class'=>'inputFormTabel span2 input_subsidi subsidiasuransi_oa_'.$ic.' integer-decimal', 'data-input_idx'=>$ic, 'onkeyup'=>"return $(this).focusNextInputField(event);", 'style'=>'width: 100px;', 'onblur'=>'hitungTanggunganOA(this); hitungTotalOa();'));
                            echo '</td>';
                        }


                        echo '<td>'
                            .CHtml::activeTextField($obatalkes, '['.$i.']subtotaloa',array('readonly'=>true,'class'=>'inputFormTabel span2 integer-decimal', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'style'=>'width:100px;'))
                            .CHtml::activeHiddenField($obatalkes, '['.$i.']jmlbayar_oa',array('readonly'=>true,'class'=>'inputFormTabel span2 integer-decimal', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'style'=>'width:100px;'))
                            .CHtml::activeHiddenField($obatalkes, '['.$i.']jasapelayanan_farmasi',array('readonly'=>true,'class'=>'inputFormTabel span2 integer-decimal', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'style'=>'width:100px;'))
                            .'</td>'
                        . $htmlpenjamin
                        .'</tr>';
                /*
                }else{
                    echo '<tr>'
                            .'<td>'.CHtml::activeCheckBox($obatalkes, '['.$i.']is_pilihoa',array('onchange'=>'hitungTotalOa();','onkeyup'=>"return $(this).focusNextInputField(event);", "class"=>"pilih_oa"))
                            .CHtml::activeHiddenField($obatalkes, '['.$i.']obatalkespasien_id',array('readonly'=>true, 'class'=>'span1'))
                            .CHtml::activeHiddenField($obatalkes, '['.$i.']obatalkes_id',array('readonly'=>true, 'class'=>'span1'))
                            .CHtml::activeHiddenField($obatalkes, '['.$i.']oasudahbayar_id',array('readonly'=>true, 'class'=>'span1'))
                            .CHtml::hiddenField('tarif_kotor', $tarif_kotor, array('class'=>'tarif_kotor'))
                            .'</td>'
                            .'<td>'.CHtml::activeTextField($obatalkes, '['.$i.']tglpelayanan',array('readonly'=>true,'class'=>'inputFormTabel lebar4', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'style'=>'width:150px;')).'</td>'
                            .'<td>'.//$obatalkes->obatalkes->obatalkes_kode.'-'.
                                    $obatalkes->obatalkes->obatalkes_nama.'</td>'
                            .'<td>'.CHtml::activeTextField($obatalkes, '['.$i.']hargasatuan_oa',array('readonly'=>true,'class'=>'inputFormTabel span2 integer-decimal', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'style'=>'width:100px;')).'</td>'
                            // .'<td class="obatalkes">'.$konfig.'</td>'
                            // .'<td>'.CHtml::activeTextField($obatalkes, '['.$i.']obatalkes_biaya_r',array('readonly'=>true,'class'=>'inputFormTabel span1 integer-decimal', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'style'=>'text-align: right;')).'</td>'
                            .'<td>'.CHtml::activeTextField($obatalkes, '['.$i.']qty_oa',array('readonly'=>true,'class'=>'inputFormTabel span1 integer-decimal', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'style'=>'text-align: right;')).'</td>'
                            .'<td hidden>'.CHtml::activeTextField($obatalkes, '['.$i.']tarifcyto',array('readonly'=>true,'class'=>'inputFormTabel span2 integer-decimal', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'style'=>'width:100px;')).'</td>'
                            .'<td>'.CHtml::activeTextField($obatalkes, '['.$i.']discount',array('readonly'=>true,'onblur'=>'hitungTotalOa();','class'=>'inputFormTabel span2 integer-decimal', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'style'=>'width:100px;')).'</td>'
                            .'<td hidden>'.CHtml::activeTextField($obatalkes, '['.$i.']biayalain',array('onblur'=>'hitungTotalOa();','class'=>'inputFormTabel span2 integer-decimal', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'style'=>'width:100px;')).'</td>'
                            .'<td>'.CHtml::activeTextField($obatalkes, '['.$i.']subsidiasuransi',array('readonly'=>(($cb->carabayar_id <> Params::CARABAYAR_ID_ASURANSI)), 'onblur'=>'hitungTotalOa();','class'=>'subsidiasuransi_oa inputFormTabel span2 integer-decimal', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'style'=>'width:100px;')).'</td>'
                            .'<td>'.CHtml::activeTextField($obatalkes, '['.$i.']subsidirs',array('onblur'=>'hitungTotalOa();','class'=>'inputFormTabel span2 integer-decimal', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'style'=>'width:100px;')).'</td>'
                            .'<td hidden>'.CHtml::activeTextField($obatalkes, '['.$i.']subsidipemerintah',array('onblur'=>'hitungTotalOa();','class'=>'inputFormTabel span2 integer-decimal', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'style'=>'width:100px;')).'</td>'
                            .'<td>'
                                .CHtml::activeTextField($obatalkes, '['.$i.']iurbiaya',array('readonly'=>true,'class'=>'inputFormTabel span2 integer-decimal iurbiaya', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'style'=>'width:100px;'))
                                .CHtml::activeHiddenField($obatalkes, '['.$i.']iurbiaya_temporary',array('readonly'=>true,'class'=>'inputFormTabel span2 integer-decimal', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'style'=>'width:100px;'))
                            .'</td>'
                            .'<td class="selisibpjsClass">'.CHtml::activeTextField($obatalkes, '['.$i.']jmlselisihbpjs',array('readonly'=>true,'class'=>'inputFormTabel span2 integer-decimal', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'style'=>'width:100px;')).'</td>'
                            .'<td>'
                            .CHtml::activeTextField($obatalkes, '['.$i.']subtotaloa',array('readonly'=>true,'class'=>'inputFormTabel span2 integer-decimal', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'style'=>'width:100px;'))
                            .CHtml::activeHiddenField($obatalkes, '['.$i.']jmlbayar_oa',array('readonly'=>true,'class'=>'inputFormTabel span2 integer-decimal', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'style'=>'width:100px;'))
                            .CHtml::activeHiddenField($obatalkes, '['.$i.']jasapelayanan_farmasi',array('readonly'=>true,'class'=>'inputFormTabel span2 integer-decimal', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'style'=>'width:100px;'))
                            .'</td>'
                        . $htmlpenjamin
                        .'</tr>';  
                }
                */
            }
        }
        ?>
    </tbody>
    <tfoot>
        <?php
        //formatting total
        $tot_hargajual_oa = $format->formatNumberForPrint($tot_hargajual_oa, 2);
        $tot_tarifcyto = $format->formatNumberForPrint($tot_tarifcyto, 2);
        $tot_discount = $format->formatNumberForPrint($tot_discount, 2);
        $tot_biayalain = $format->formatNumberForPrint($tot_biayalain, 2);
        $tot_subsidiasuransi = $format->formatNumberForPrint($tot_subsidiasuransi, 2);
        $tot_subsidipemerintah = $format->formatNumberForPrint($tot_subsidipemerintah, 2);
        $tot_subsidirs = $format->formatNumberForPrint($tot_subsidirs, 2);
        $tot_iurbiaya = $format->formatNumberForPrint($total_oa, 2);
        $total_oa = $format->formatNumberForPrint($total_oa, 2);
        $total_jmlselisihbpjs = $format->formatNumberForPrint($total_jmlselisihbpjs, 2);
        ?>
        <td colspan="4" style="text-align: right; font-weight: bold;"><?php // echo CHtml::checkBox('is_proporsioa',false,array('onchange'=>'setProporsiOa();','rel'=>'tooltip','title'=>'Centang untuk masukan proporsi dari total obat alkes','onkeyup'=>"return $(this).focusNextInputField(event);")) ?> Total Tagihan Obat & Alkes</td>
        <td><span hidden><?php echo CHtml::textField('tot_hargajual_oa',$tot_hargajual_oa,array('readonly'=>true,'class'=>'inputFormTabel span2 integer-decimal','onkeyup'=>"return $(this).focusNextInputField(event);", 'style'=>'width:100px;')) ?></span></td>
        <td hidden><?php echo CHtml::textField('tot_tarifcyto',$tot_tarifcyto,array('readonly'=>true,'class'=>'inputFormTabel span2 integer-decimal','onkeyup'=>"return $(this).focusNextInputField(event);", 'style'=>'width:100px;')) ?></td>
        <td><?php echo CHtml::textField('tot_discount',$tot_discount,array('onblur'=>'proporsiDiskonOa();','readonly'=>true,'class'=>'inputFormTabel span2 integer-decimal','onkeyup'=>"return $(this).focusNextInputField(event);", 'style'=>'width:100px;')) ?></td>
        
        <?php for ($ic = 0; $ic < $max_penjamin; $ic++) {

        echo '<td class="col_subsidi_'.$ic.'">';
        echo CHtml::textField('tot_subsidiasuransi_oa['.$ic.']', 0, array('readonly'=>true,'class'=>'inputFormTabel span2 total_subsidiasuransi_oa total_subsidiasuransi_oa_'.$ic.' integer-decimal', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'style'=>'width: 100px;'));
        echo '</td>';
        
        } ?>
        
        <td><?php echo CHtml::textField('total_oa',$total_oa,array('readonly'=>true,'class'=>'inputFormTabel span2 integer-decimal','onkeyup'=>"return $(this).focusNextInputField(event);", 'style'=>'width:100px;')) ?></td>
    </tfoot>
</table>
