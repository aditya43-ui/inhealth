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
    .border{
        border:1px solid;
    }
');
?>  
<?php
$format = new MyFormatter;
if (!isset($_GET['frame'])){
    echo $this->renderPartial($this->path_view.'_headerPrint'); 
}
?>
    <table width="74%" style="margin: 0;" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center" valig="middle" colspan="3">
                <b><?php echo $judul_print ?></b>
            </td>
        </tr>
        <tr>
            <td>No. Permohonan</td>
            <td>:</td>
            <td><?php echo $modPermohonanOa->permohonanoa_nomor; ?></td>
        </tr>
        <tr>
            <td>Tanggal Permohonan</td>
            <td>:</td>
            <td><?php echo $format->formatDateTimeForUser($modPermohonanOa->permohonanoa_tgl); ?></td>
        </tr>
        <tr>
            <td>Pegawai Mengetahui</td>
            <td>:</td>
            <td><?php echo (isset($modPermohonanOa->pegawaimengetahui->NamaLengkap) ? $modPermohonanOa->pegawaimengetahui->NamaLengkap : ""); ?></td>
        </tr>
        <tr>
            <td>Pegawai Menyetujui</td>
            <td>:</td>
            <td><?php echo (isset($modPermohonanOa->pegawaimenyetujui->NamaLengkap) ? $modPermohonanOa->pegawaimenyetujui->NamaLengkap : ""); ?></td>
        </tr>
    </table><br>
    <table width="100%" style='margin-left:auto; margin-right:auto;'>
        <thead class="border">
            <th>No.</th>
            <th>Asal Barang</th>
            <th>Kategori / Nama Obat</th>
            <th>Jumlah Permohonan (Satuan)</th>
            <th>Harga Netto</th>
            <th>Minimal Stok</th>
            <th>Sub Total</th>
        </thead>
        <?php 
        $total = 0;
        $subtotal = 0;
        foreach ($modPermohonanOaDetail as $i=>$modObat){ 
        ?>
            <tr>
                <td><?php echo ($i+1)."."; ?></td>
                <td><?php echo $modObat->obatalkes->sumberdana->sumberdana_nama; ?></td>
                <td><?php echo (!empty($modObat->obatalkes->obatalkes_kategori) ? $modObat->obatalkes->obatalkes_kategori."/ " : "") . $modObat->obatalkes->obatalkes_nama; ?></td>
                <td style="text-align: center;"><?php echo $modObat->permohonanoadetail_qty." ".(!empty($modObat->satuankecil_id) ? $modObat->satuankecil->satuankecil_nama : "") ; ?></td>
                <td><?php echo $format->formatUang($modObat->obatalkes->harganetto); ?></td>
                <td style="text-align: center;"><?php echo $modObat->obatalkes->minimalstok; ?></td>
                <td><?php 
                    $subtotal = ($modObat->obatalkes->harganetto * $modObat->permohonanoadetail_qty);
                    $total += $subtotal;
                    echo $format->formatUang($subtotal); ?>
                </td>
            </tr>
        <?php } ?>
        <tr>
            <td colspan="6" align="center"><b>Total</b></td>
            <td><?php echo $format->formatUang($total); ?></td>
        </tr>
    </table>
<?php
if (isset($_GET['frame'])){
    echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="entypo-print"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('PRINT')"));
    echo CHtml::link(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('EXCEL')")); 
?>
    <script type='text/javascript'>
    /**
     * print
     */    
    function print(caraPrint){
        permohonanoa_id = '<?php echo isset($modPermohonanOa->permohonanoa_id) ? $modPermohonanOa->permohonanoa_id : ''; ?>';
        window.open('<?php echo $this->createUrl('print'); ?>&permohonanoa_id='+permohonanoa_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
    }
    </script>
<?php
}else{ ?>
    <table width="100%" style="margin-top:20px;">
    <tr>
        <td width="100%" align="left" align="top">
            <table style="width: 100%; border: none;">
                <tr>
                    <td width="35%" align="center">
                        <div>Pegawai Mengetahui</div>
                        <div style="margin-top:60px;"><?php echo isset($modPermohonanOa->pegawaimengetahui->NamaLengkap) ? $modPermohonanOa->pegawaimengetahui->NamaLengkap : "" ?></div>
                    </td>
                    <td width="35%" align="center">
                        <div><?php echo Yii::app()->user->getState("kabupaten_nama").", ".MyFormatter::formatDateTimeId(date('Y-m-d')); ?></div>
                        <div>Pegawai Menyetujui</div>
                        <div style="margin-top:60px;"><?php echo isset($modPermohonanOa->pegawaimenyetujui->NamaLengkap) ? $modPermohonanOa->pegawaimenyetujui->NamaLengkap : "" ?></div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    </table>
<?php } ?>
