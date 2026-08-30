
<tr class="rows">
<td>
    <?php echo(CHtml::checkBox("pilih_keluar[". $data->tandabuktikeluar_id ."]", true, array("onchange"=>"hitungTransaksi()",'class'=>'cekcheckbox'))); ?>
    <?php // echo(CHtml::hiddenField("is_pelayanan[". $data->nobuktibayar ."]", (is_null($data->pembayaranpelayanan_id) ? 'xxx' : $data->pembayaranpelayanan_id))); ?>
    <?php
        echo(CHtml::hiddenField("is_deposit[". $no_bayar ."]",  'xxx'));
        echo(CHtml::hiddenField("is_tunai[". $no_bayar ."]", ""));
        echo(CHtml::hiddenField("totaliurbiaya[". $no_bayar ."]", 0));
    ?>
    <?php echo CHtml::hiddenField("BKClosingkasirT[nobuktikeluar][$i]", "", array('readonly'=>true,'class'=>'inputFormTabel')); ?>
    <?php echo CHtml::hiddenField("BKClosingkasirT[tandabuktikeluar_id][$i]", $data->tandabuktikeluar_id, array('readonly'=>true,'class'=>'inputFormTabel')); ?>
</td>
<td style="text-align: right;"><?php echo $i + 1; ?></td>
<td>
    <?php echo "" ?>
</td>
<td><?php 
$tgl_bayar = empty($tgl_bayar) ? $data->tglkaskeluar : $tgl_bayar;
$no_bayar = empty($no_bayar) ? $data->nobuktikeluar : $no_bayar;
// var_dump($no_bayar);

echo MyFormatter::formatDateTimeForUser($tgl_bayar); ?></td>
<td class="nobuktibayar">
    <?php 
    if (!empty($data->returbayarpelayanan_id)) {
        echo CHtml::link('<u>'.$no_bayar.'</u>', Yii::app()->controller->createUrl("/billingKasir/returTagihanPasien/returTagihan",array("tandabuktibayar_id"=>$data->returbayarpelayanan_id, "frame"=>true)), array(
            'target'=>'iframeRincianTagihan',
            'onclick'=>'$("#dialogRincianTagihan").dialog("open");',
        ));
    } else {
        echo($no_bayar); 
    }
    
    ?>
</td>

<td><?php echo "RETUR"; ?></td>
<td><?php echo $data->namapenerima; ?></td>
<td>
    <?php 
    /*
    if (!empty($penjamin_bayar)) {
        $p = PenjaminpasienM::model()->findByPk($penjamin_bayar);
        echo $p->penjamin_nama;
    }
    */
    ?>
</td>
<td class="carapembayaran" hidden></td>
<td hidden><?php // echo($data->sebagaipembayaran_bkm); ?></td>
<td style="text-align: right;" class="piutang">
    <?php echo MyFormatter::formatNumberForPrint(0, 2); ?>
</td>
<td style="text-align: right;" class="jml_uangmuka">
    <?php echo MyFormatter::formatNumberForPrint(0, 2); ?>
</td>
<td style="text-align: right;" class="jml_tunai">
    <?php echo MyFormatter::formatNumberForPrint(0, 2); ?>
</td>
<td style="text-align: right;" class="jml_nontunai">
    <?php echo MyFormatter::formatNumberForPrint(0, 2); ?>
</td>
<td style="text-align: right;" class="jml_retur">
    <?php echo MyFormatter::formatNumberForPrint($retur, 2); ?>
</td>
<td style="text-align: right;" class="jml_retur_tindakan">
    <?php echo MyFormatter::formatNumberForPrint($retur_tindakan, 2); ?>
</td>
<td style="text-align: right;" class="jml_kredit" hidden>
    <?php echo MyFormatter::formatNumberForPrint(0, 2); ?>
</td>
<td style="text-align: right;" class="jml_debit" hidden>
    <?php echo MyFormatter::formatNumberForPrint(0, 2); ?>
</td>
<td class="jmlpembayaran currency_tbl">
    <?php echo 0 - ($retur + $retur_tindakan); //echo((empty($bayar) || !empty($data->jmlpembayaran)) ? $data->jmlpembayaran : $bayar->totalbiayapelayanan); ?>
</td>
<!--td class="jmlAdministrasi currency_tbl"><?php // echo($data->biayaadministrasi); ?></td>
<td class="currency_tbl"><?php // echo($data->biayamaterai); ?></td-->           
</tr>