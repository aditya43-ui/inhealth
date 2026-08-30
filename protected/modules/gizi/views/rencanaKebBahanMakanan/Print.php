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
    .border th, .border td{
        border:1px solid #000;
    }
    .table thead:first-child{
        border-top:1px solid #000;        
    }

    thead th{
        background:none;
        color:#333;
    }

    .border {
        box-shadow:none;
    }

    .table tbody tr:hover td, .table tbody tr:hover th {
        background-color: none;
    }
	td {
		vertical-align: top;
	}
    .kertas{
     width:100%;
     height:12cm;
    }
');
?>  
<?php
if(!$modRencanaKebBarangDetail){
    echo "Data tidak ditemukan."; exit;
}
echo $this->renderPartial('application.views.headerReport.headerDefaultNew');
$format = new MyFormatter;
$modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); 
$tglrencana = MyFormatter::formatDateTimeForUser($modRencanaKebBarang->renkebbahanmakanan_tgl);
?>
<body class="kertas">
    <table width="100%" style="margin: 0;" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center" valig="middle" colspan="2">
                <b><h3><?php echo $judul_print; ?></h3></b>
            </td>
        </tr>
        
    </table>
    <br>
    <table width="100%" style="margin: 0;" cellpadding="0" cellspacing="0">
        <tr>
            <td style="width:150px"><h4>No. Rencana</h4></td>
            <td style="width:10px"><h4>:</h4></td>
            <td><h4><?php echo $modRencanaKebBarang->renkebbahanmakanan_no; ?></h4></td>
            
            <td style="width:150px"><h4>Sumber Dana</h4></td>
            <td style="width:10px"><h4>:</h4></td>
            <td><h4><?php echo (!empty($modRencanaKebBarang->sumberdana_id)?$modRencanaKebBarang->sumberdana->sumberdana_nama:""); ?></h4></td>
        </tr>
        <tr>
            <td><h4>Tanggal Rencana : </h4></td>
             <td><h4>:</h4></td>
            <td><h4><?php echo $format->formatDateTimeForUser($tglrencana); ?></h4></td>
        </tr>
    </table><br>
    <table width="100%" style='margin-left:auto; margin-right:auto;' class="border">
        <thead class="border">
            <th>No.</th>
            <th>Golongan</th>
            <th>Jenis</th>
            <th>Kelompok</th>
            <th>Nama Bahan Makanan</th>
            <th>Satuan </th>
            <th>Stok Akhir</th>
            <th>Minimal Stok</th>
            <th>Maksimal Stok</th>
            <th>Jumlah Kebutuhan</th>
            <th width="75" style="text-align: center;">Harga</th>
            <th>PPN (%)</th>
            <th>PPN (Rp)</th>
            <th width="75" style="text-align: center;">Sub Total</th>
        </thead>
        <?php 
        $total = 0;
        $subtotal = 0;
        foreach ($modRencanaKebBarangDetail as $i=>$modBarang){ 
			$barang = BahanmakananM::model()->findByPk($modBarang->bahanmakanan_id);
            $gol_nama = "";
            if (!empty($barang->golbahanmakanan_id)) {
                $gol = GolbahanmakananM::model()->findByPk($barang->golbahanmakanan_id);
                if (!empty($gol)) {
                    $gol_nama = $gol->golbahanmakanan_nama;
                }
            }
            $jmlTotal = ($modBarang->harga_barangdet * $modBarang->jmlpermintaandet);
            $jmlppn = (($jmlTotal * $modBarang->persen_ppn)/100);
            $subtotal = ($jmlTotal + $jmlppn);
            $total += $subtotal;
			
        ?>
            <tr>
                <td style="text-align: center;"><?php echo ($i+1)."."; ?></td>
                <td><?php echo $gol_nama; ?></td>
                <td><?php echo $barang->jenisbahanmakanan; ?></td>
                <td><?php echo $barang->kelbahanmakanan; ?></td>
                <td><?php echo (!empty($modBarang->bahanmakanan_id)) ? $barang->namabahanmakanan : ""; ?></td>
                <td style="text-align: center;"><?php echo $modBarang->satuanbahan; ?></td>
                <td style="text-align: center;" nowrap><?php echo $modBarang->stokakhir_bahanmakanan; ?></td>
                <td style="text-align: center;" nowrap><?php echo $modBarang->minstok_bahanmakanan; ?></td>
                <td style="text-align: center;" nowrap><?php echo $modBarang->makstok_bahanmakanan; ?></td>
                <td style="text-align: center;"><?php echo number_format($modBarang->jmlpermintaandet,2,",","."); ?></td>
                <td style="text-align: right;" nowrap><?php echo "Rp ".number_format($modBarang->harga_barangdet,2,",","."); ?></td>
                <td style="text-align: center;"><?php echo $modBarang->persen_ppn; ?></td>
                <td style="text-align: right;" nowrap><?php echo "Rp ".number_format($jmlppn,2,",","."); ?></td>
                <td style="text-align: right;" nowrap><?php 
                    echo "Rp ".number_format($subtotal,2,",","."); ?>
                </td>
            </tr>
        <?php } ?>
        <tr>
            <td colspan="13" style="text-align:right;"><b>Total</b></td>
            <td style="text-align: right;"><?php echo"Rp ".number_format($total,2,",","."); ?></td>
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
        renkebbahanmakanan_id = '<?php echo isset($modRencanaKebBarang->renkebbahanmakanan_id) ? $modRencanaBarang->renkebbahanmakanan_id : ''; ?>';
        window.open('<?php echo $this->createUrl('print'); ?>&renkebbahanmakanan_id='+renkebbahanmakanan_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
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
                        <div>Mengetahui</div>
                        <div style="margin-top:60px;"><?php echo isset($modRencanaKebBarang->pegmenyetujui_id) ? $modRencanaKebBarang->pegawaimenyetujui->NamaLengkap : "" ?></div>
                        <div>(Kepala Intansi Gizi)</div>
                    </td>
                    <td width="35%" align="center">
                    </td>
                    <td width="35%" align="center">
                        <div>Dibuat Oleh :</div>
                        <div style="margin-top:60px;"><?php echo !empty($modRencanaKebBarang->pegawai_id) ? $modRencanaKebBarang->pegawai->NamaLengkap : "" ?></div>
                        <div>(Petugas Gudang Umum)</div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    </table>
</body>
<?php } ?>
<div>
<br>
<?php echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>
</div>

