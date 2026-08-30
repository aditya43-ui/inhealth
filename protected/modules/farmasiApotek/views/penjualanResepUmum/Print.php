<?php
if (isset($caraPrint)){
    if($caraPrint=='EXCEL')
    {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$judul_print.'-'.date("Y/m/d").'.xls"');
        header('Cache-Control: max-age=0');
    }
}
?>
<?php
echo CHtml::css('.control-label{
        float:left;
        text-align: right;
        width:50%;
        color:black;
        padding-right:10px;
        font-size:8pt;
    }
    body{
        font-size:8pt;
    }
    td .uang{
        text-align:right;
    }
    .border th, .border td{
        border:1px solid #000;
        padding:2px;
    }
');
?>
<?php
$format = new MyFormatter;
if (!isset($_GET['frame'])){
    echo $this->renderPartial($this->path_view.'_headerPrint');
}
?>
    <table width="74%" style="margin:0px;" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center" valig="middle" colspan="3">
                <b><?php echo $judul_print ?></b>
            </td>
        </tr>
        <tr>
            <td>No. Resep</td>
            <td>:</td>
            <td><?php echo $modPenjualan->noresep; ?></td>

            <td>Jenis Penjualan</td>
            <td>:</td>
            <td><?php echo $modPenjualan->jenispenjualan; ?></td>
        </tr>
        <tr>
            <td>Tanggal Resep</td>
            <td>:</td>
            <td><?php echo $format->formatDateTimeForUser($modPenjualan->tglresep); ?></td>

            <td>Tanggal Penjualan</td>
            <td>:</td>
            <td><?php echo $format->formatDateTimeForUser($modPenjualan->tglpenjualan); ?></td>
        </tr>
        <tr>
            <td>Nama Dokter</td>
            <td>:</td>
            <td><?php echo isset($modPenjualan->pegawai->NamaLengkap) ? $modPenjualan->pegawai->NamaLengkap : ""; ?></td>
        </tr>
    </table><br/>
    <table width="100%" style='margin-left:auto; margin-right:auto;' class="border">
        <thead class="border">
            <th style="text-align: center;">No.</th>
            <th style="text-align: center;">No. Antrian</th>
            <th style="text-align: center;">Resep.</th>
            <th style="text-align: center;">R Ke</th>
            <th style="text-align: center;">Kode / Nama Obat</th>
			<th style="text-align: center;">Etiket</th>
            <th style="text-align: center;">Signa</th>
            <th style="text-align: center;">Satuan Kecil</th>
            <th style="text-align: center;">Jumlah</th>
            <th style="text-align: center;">Harga Satuan</th>
            <th style="text-align: center;">PPN (%)</th>
            <th style="text-align: center;">PPN (Rp.)</th>
            <!--<th style="text-align: center;">Diskon (%)</th>-->
            <th style="text-align: center;">Sub Total</th>
        </thead>
        <?php
        $total = 0;
        $subtotal = 0;
        foreach ($modPenjualanDetail as $i=>$modObat){
          $jumlhqty = ($modObat->hargasatuan_oa * $modObat->qty_oa);
          $ppnpersen = round($modObat->jumlahppn/$jumlhqty * 100,0);
        ?>
            <tr>
                <td align="center"><?php echo ($i+1); ?></td>
                <td align="center"><?php echo isset($modObat->penjualanresep->antrianfarmasi_id) ? $modObat->penjualanresep->antrianfarmasi->noantrian: "-"; ?></td>
                <td align="center"><?php echo $modObat->r; ?></td>
                <td align="center"><?php echo $modObat->rke; ?></td>
                <td><?php echo (!empty($modObat->obatalkes->obatalkes_kode) ? $modObat->obatalkes->obatalkes_kode."/ " : "") ."". $modObat->obatalkes->obatalkes_nama; ?></td>
				<td><?php echo (!empty($modObat->etiket) ? $modObat->etiket : ""); ?></td>
                <td><?php echo (!empty($modObat->signa_oa) ? $modObat->signa_oa : ""); ?></td>
                <td><?php echo $modObat->satuankecil->satuankecil_nama; ?></td>
                <td align="right"><?php echo $modObat->qty_oa; ?></td>
                <td align="right"><?php echo $format->formatUang($modObat->hargasatuan_oa); ?></td>
                <td align="right"><?php echo $ppnpersen; ?></td>
                <td align="right"><?php echo $format->formatUang($modObat->jumlahppn); ?></td>
                <!--<td align="right"><?php //echo $modObat->discount; ?></td>-->
                <td align="right"><?php
                    // $discount = (($modObat->hargasatuan_oa * $modObat->qty_oa) * ($modObat->discount/100));
                    // $subtotal = (($modObat->hargasatuan_oa * $modObat->qty_oa) - $discount);
                    $subtotal = $modObat->hargajual_oa;
                    if($subtotal <=0 ){
                        $subtotal = 0;
                    }
                    $total += $subtotal;
                    echo $format->formatUang($subtotal); ?>
                </td>
            </tr>
        <?php } ?>
        <tfoot class="border">
            <tr>
                <td colspan="12" align="center"><strong>Total</strong></td>
                <td align="right"><?php echo $format->formatUang($total); ?></td>
            </tr>
        </tfoot>
    </table>
<?php
if (isset($_GET['frame'])){
    echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="entypo-print"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('PRINT')"));
    echo CHtml::link(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('EXCEL')"));
?>
    <script type='text/javascript'>
    /**
     * print
     */
    function print(caraPrint){
        penjualanresep_id = '<?php echo isset($modPenjualan->penjualanresep_id) ? $modPenjualan->penjualanresep_id : ''; ?>';
        window.open('<?php echo $this->createUrl('print'); ?>&penjualanresep_id='+penjualanresep_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
    }
    </script>
<?php
}else{ ?>
    <table width="100%" style="margin-top:20px;">
    <tr>
        <td></td>
        <td></td>
        <td width="30%" align="center" align="top">
            <div><?php echo Yii::app()->user->getState("kabupaten_nama").", ".MyFormatter::formatDateTimeId(date('Y-m-d')); ?></div>
            <div>Operator</div>
            <div style="margin-top:60px;"><?php echo Yii::app()->user->getState('nama_pegawai'); ?></div>
        </td>
    </tr>
    </table>
<?php } ?>
