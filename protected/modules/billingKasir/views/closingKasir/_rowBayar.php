
<tr class="rows">
<td>
    <?php echo(CHtml::checkBox("pilih[". $data->tandabuktibayar_id ."]", true, array("onchange"=>"hitungTransaksi()",'class'=>'cekcheckbox'))); ?>
    <?php echo(CHtml::hiddenField("is_pelayanan[". $data->nobuktibayar ."]", (is_null($data->pembayaranpelayanan_id) ? 'xxx' : $data->pembayaranpelayanan_id))); ?>
    <?php
        echo(CHtml::hiddenField("is_deposit[". $data->nobuktibayar ."]", (empty($uangmuka) ? 'xxx' : $uangmuka->bayaruangmuka_id)));
        echo(CHtml::hiddenField("is_tunai[". $data->nobuktibayar ."]", $data->carapembayaran));
        echo(CHtml::hiddenField("totaliurbiaya[". $data->nobuktibayar ."]", $total_bayar));
    ?>
    <?php echo CHtml::hiddenField("BKClosingkasirT[nobuktibayar][$i]", "", array('readonly'=>true,'class'=>'inputFormTabel')); ?>
    <?php echo CHtml::hiddenField("BKClosingkasirT[tandabuktibayar_id][$i]", $data->tandabuktibayar_id, array('readonly'=>true,'class'=>'inputFormTabel')); ?>
</td>
<td style="text-align: right;"><?php echo $i + 1; ?></td>
<td>
    <?php echo $data->loket_nama; ?>
</td>
<td><?php 
$tgl_bayar = empty($tgl_bayar) ? $data->tglbuktibayar : $tgl_bayar;
$no_bayar = empty($no_bayar) ? $data->nobuktibayar : $no_bayar;
// var_dump($no_bayar);

echo MyFormatter::formatDateTimeForUser($tgl_bayar); ?></td>
<td class="nobuktibayar">
    <?php 
    if (!empty($data->pembayaranpelayanan_id)) {
        echo CHtml::link('<u>'.$no_bayar.'</u>', Yii::app()->controller->createUrl("/billingKasir/pembayaranTagihanPasien/printRincianSudahBayar",array("pembayaranpelayanan_id"=>$data->pembayaranpelayanan_id, "frame"=>true)), array(
            'target'=>'iframeRincianTagihan',
            'onclick'=>'$("#dialogRincianTagihan").dialog("open");',
        ));
    } else if (!empty($data->bayaruangmuka_id)) {
        echo CHtml::link('<u>'.$no_bayar.'</u>', Yii::app()->controller->createUrl("/billingKasir/infoBayarUangMuka/detailUangMuka",array("id"=>$data->bayaruangmuka_id, "frame"=>true)), array(
            'target'=>'iframeRincianTagihan',
            'onclick'=>'$("#dialogRincianTagihan").dialog("open");',
        ));
    } else {
        echo($no_bayar); 
    }
    
    ?>
</td>

<td><?php echo($jnspembayar); ?></td>
<td><?php echo($data->darinama_bkm); ?></td>
<td>
    <?php 
    if (!empty($penjamin_bayar)) {
        $p = PenjaminpasienM::model()->findByPk($penjamin_bayar);
        echo $p->penjamin_nama;
    }
    ?>
</td>
<td class="carapembayaran" hidden><?php echo($data->carapembayaran); ?></td>
<td hidden><?php // echo($data->sebagaipembayaran_bkm); ?></td>
<td style="text-align: right;" class="piutang">
    <?php
    // $total_bayar = (empty($bayar) || !empty($data->jmlpembayaran)) ? $data->jmlpembayaran : $total_bayar;
    $piutang = 0;
    $uang_muka = 0;
    if (!empty($bayar)) {
        $piutang += $bayar->total_inacbg + $bayar->totalsubsidiasuransi;
        if ($bayar->tandabuktibayar_id == $data->tandabuktibayar_id && in_array($data->carapembayaran, array(Params::CARAPEMBAYARAN_CICILAN, Params::CARAPEMBAYARAN_HUTANG))) {
            $bayar_angsuran = BayarangsuranpelayananT::model()->findByAttributes(array(
                'tandabuktibayar_id'=>$data->tandabuktibayar_id,
            ));
            if (!empty($bayar_angsuran)) {
                $piutang += $bayar_angsuran->sisaangsuran;
            }
        }
        
        
        $modUangMuka = PemakaianuangmukaT::model()->findByAttributes(array(
            'pembayaranpelayanan_id'=>$bayar->pembayaranpelayanan_id,
        ));
        
        if (!empty($modUangMuka)) {
            $uang_muka = $modUangMuka->pemakaianuangmuka;
        }
        
    } else {
        $piutang = (empty($bayar)) ? 0 : ($bayar->totalsubsidiasuransi + $bayar->totalsubsidirs + $bayar->total_inacbg);
    }
    
    
    
    echo MyFormatter::formatNumberForPrint($piutang, 2); ?>
</td>
<td style="text-align: right;" class="jml_uangmuka">
    <?php echo MyFormatter::formatNumberForPrint($uang_muka, 2); ?>
</td>
<td style="text-align: right;" class="jml_tunai">
    <?php echo MyFormatter::formatNumberForPrint($total_bayar, 2); ?>
</td>
<td style="text-align: right;" class="jml_nontunai">
    <?php echo MyFormatter::formatNumberForPrint($total_nontunai, 2); ?>
</td>
<td style="text-align: right;" class="jml_retur">
    <?php echo MyFormatter::formatNumberForPrint($retur, 2); ?>
</td>
<td style="text-align: right;" class="jml_retur_tindakan">
    <?php echo MyFormatter::formatNumberForPrint($retur_tindakan, 2); ?>
</td>
<td style="text-align: right;" class="jml_kredit" hidden>
    <?php echo MyFormatter::formatNumberForPrint($total_kredit, 2); ?>
</td>
<td style="text-align: right;" class="jml_debit" hidden>
    <?php echo MyFormatter::formatNumberForPrint($total_debit, 2); ?>
</td>
<td class="jmlpembayaran currency_tbl">
    <?php echo $piutang + $total_bayar + $total_nontunai - ($retur + $retur_tindakan); //echo((empty($bayar) || !empty($data->jmlpembayaran)) ? $data->jmlpembayaran : $bayar->totalbiayapelayanan); ?>
</td>
<!--td class="jmlAdministrasi currency_tbl"><?php // echo($data->biayaadministrasi); ?></td>
<td class="currency_tbl"><?php // echo($data->biayamaterai); ?></td-->           
</tr>