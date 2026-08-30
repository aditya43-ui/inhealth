<p style="margin: 0; text-align: center;">
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
    .kertas{
     width:20cm;
     height:12cm;
    }
');
?>  
<?php
if(!$modRencanaDetailKeb){
    echo "Data tidak ditemukan."; exit;
}
echo $this->renderPartial('application.views.headerReport.headerRincian');
$format = new MyFormatter;
$modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); 
$tglrencana = substr($modRencanaKebFarmasi->tglperencanaan,0,-8);
?>
<body class="kertas">
    <table width="100%" style="margin: 0;" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center" valig="middle" colspan="2">
                <b><u><h5><?php echo $judul_print.'<br></u>Tanggal : '.
                        $format->formatDateTimeForUser($tglrencana); ?></h4></b>
            </td>
        </tr>
        <tr>
            <td><h4>No. <?php echo $modRencanaKebFarmasi->noperencnaan; ?></h4></td>
            <td></td>
        </tr>
        
    </table><br>
    <table width="100%" style='margin-left:auto; margin-right:auto;'>
        <thead class="border">
            <th>No.</th>
            <th>Asal Barang</th>
            <th width="200" style="text-align: center;">Kategori / Nama Obat</th>
            <th>Jumlah Kemasan<br> (Satuan) </th>
            <th>Jumlah Permintaan</th>
            <th width="75" style="text-align: center;">Harga Netto</th>
            <th>Buffer Stok</th>
            <th>Stok Akhir</th>
            <th>Minimal Stok</th>
            <th>Persen ABC</th>
            <th>VEN</th>
            <th>Kategori ABC</th>
            <th width="75" style="text-align: center;">Sub Total</th>
        </thead>
        <?php 
        $total = 0;
        $subtotal = 0;
        foreach ($modRencanaDetailKeb as $i=>$modObat){ 
			$modLookup = GFLookupM::model()->findByAttributes(array('lookup_value'=>$modObat->obatalkes->ven));
        ?>
            <tr>
                <td style="text-align: center;"><?php echo ($i+1)."."; ?></td>
                <td><?php echo $modObat->sumberdana->sumberdana_nama; ?></td>
                <td align="center"><?php echo (!empty($modObat->obatalkes->obatalkes_kategori) ? $modObat->obatalkes->obatalkes_kategori."/ " : "") . $modObat->obatalkes->obatalkes_nama; ?></td>
                <td style="text-align: center;"><?php echo $modObat->kemasanbesar; ?></td>
                <td style="text-align: center;"><?php echo $modObat->jmlpermintaan; ?></td>
                <td style="text-align: right;"><?php echo $format->formatUang($modObat->harganettorenc); ?></td>
                <td style="text-align: center;"><?php echo $modObat->buffer_stok; ?></td>
                <td style="text-align: center;"><?php echo $modObat->stokakhir; ?></td>
                <td style="text-align: center;"><?php echo $modObat->minimalstok; ?></td>
                <td style="text-align: center;"><?php echo $modObat->persen_abc; ?> %</td>
                <td style="text-align: center;"><?php echo isset($modLookup->lookup_name) ? $modLookup->lookup_name : "-"; ?></td>
                <td style="text-align: center;"><?php echo $modObat->kategori_abc; ?></td>
                <td style="text-align: right;"><?php 
                    $subtotal = ($modObat->harganettorenc * $modObat->jmlpermintaan);
                    $total += $subtotal;
                    echo $format->formatUang($subtotal); ?>
                </td>
            </tr>
        <?php } ?>
        <tr>
            <td colspan="8" align="center"><b>Total</b></td>
            <td style="text-align: right;"><?php echo $format->formatUang($total); ?></td>
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
        rencanakebfarmasi_id = '<?php echo isset($modRencanaKebFarmasi->rencanakebfarmasi_id) ? $modRencanaKebFarmasi->rencanakebfarmasi_id : ''; ?>';
        window.open('<?php echo $this->createUrl('print'); ?>&rencanakebfarmasi_id='+rencanakebfarmasi_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
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
                        <div>Mengetahui<br>Ka. Instalasi Farmasi</div>
                        <div style="margin-top:60px;"><?php echo isset($modRencanaKebFarmasi->pegawaimenyetujui_id) ? $modRencanaKebFarmasi->pegawaimenyetujui->NamaLengkap : "" ?></div>
                    </td>
                    <td width="35%" align="center">
                    </td>
                    <td width="35%" align="center">
                        <div>Dibuat Oleh :</div>
                        <div style="margin-top:60px;"><?php echo isset($modRencanaKebFarmasi->pegawai_id) ? $modRencanaKebFarmasi->pegawai->NamaLengkap : "" ?></div>
                        <div>(Petugas Gudang Farmasi)</div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    </table>
</body>
<?php } ?>
