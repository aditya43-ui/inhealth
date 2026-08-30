<center>
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
        border:1px solid black;
    }
    .border th{
        border:1px solid black;
    }
    .kertas{
        width: 100%;
    }
    .table {
        border: 1px solid black;
        box-shadow: none;
    }
    .table td {
        border: 1px solid black;
    }
');
?>  
<?php
if(!$modRencanaDetailKeb){
    echo "Data tidak ditemukan"; exit;
}
echo $this->renderPartial('application.views.headerReport.headerRincian');
$format = new MyFormatter;
$modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); 
$tglrencana = substr($modRencanaKebFarmasi->tglperencanaan,0,-8);
?>
<body class="kertas">
    <table width="100%" style="margin:0px;" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center" valig="middle" colspan="2">
                <h4><?php echo $judul_print;?></h4>
            </td>
        </tr>
    </table>
    <br>
    <table width="100%" style="margin:0px;" cellpadding="0" cellspacing="0">
        <tr>
            <td style="width:150px"><h4>No. Rencana</h4></td>
            <td style="width:10px"><h4>:</h4></td>
            <td><h4><?php echo $modRencanaKebFarmasi->noperencnaan; ?></h4></td>
            
            <td style="width:150px"><h4>Sumber Dana</h4></td>
            <td style="width:10px"><h4>:</h4></td>
            <td><h4><?php echo (!empty($modRencanaKebFarmasi->sumberdana_id)?$modRencanaKebFarmasi->sumberdana->sumberdana_nama:""); ?></h4></td>
        </tr>
        <tr>
            <td><h4>Tanggal Rencana : </h4></td>
             <td><h4>:</h4></td>
            <td><h4><?php echo $format->formatDateTimeForUser($tglrencana); ?></h4></td>
        </tr>
        
    </table><br/>
    <table width="100%" style='margin-left:auto; margin-right:auto;' class="table">
        <thead class="border">
            <th style="text-align: center;">No.</th>
            <th style="text-align: center;">Supplier</th>
            <th style="text-align: center;">Jenis</th>
            <th width="200" style="text-align: center;">Nama Obat</th>
            <th style="text-align: center;">Tgl Kadaluarsa</th>
            <th style="text-align: center;">Jumlah yang Harus Diorder</th>
            <th style="text-align: center;">Stok Akhir</th>
            <th style="text-align: center;">Jumlah Kemasan<br/> (Satuan) </th>
            <th style="text-align: center;">Jumlah Kebutuhan</th>
            <th width="75" style="text-align: center;">Harga Satuan</th>
            <th width="75" style="text-align: center;">PPN (%)</th>
            <th width="75" style="text-align: center;">PPN (Rp)</th>
            <th width="75" style="text-align: center;">HPP</th>
            <th style="text-align: center;">VEN</th>
            <th style="text-align: center;">ABC</th>
            <th width="75" style="text-align: center;">Sub Total</th>
        </thead>
        <?php 
        $total = 0;
        $subtotal = 0;
        foreach ($modRencanaDetailKeb as $i=>$modObat){ 
            $oa = ObatalkesM::model()->findByPk($modObat->obatalkes_id);
            $modSupplier = ObatalkesV::model()->findByAttributes(array(
                'obatalkes_id'=>$modObat->obatalkes_id));
            $sat = !empty($modObat->satuankecil_id)?$modObat->satuankecil->satuankecil_nama:$modObat->satuanbesar->satuanbesar_nama;
            $kecil = $oa->satuankecil->satuankecil_nama;
            $modLookup = ADLookupM::model()->findByAttributes(array('lookup_value'=>$modObat->obatalkes->ven));
        ?>
            <tr>
                <td style="text-align: center;"><?php echo ($i+1)."."; ?></td>
                <td style="text-align: center;"><?php echo $modSupplier->supplier_nama; ?></td>
                <td><?php echo empty($oa->jenisobatalkes_id)?"-":$oa->jenisobatalkes->jenisobatalkes_nama; ?></td>
                <td align="center"><?php echo $modObat->obatalkes->obatalkes_nama; ?></td>
                <td style="text-align: right;" nowrap><?php echo empty($oa->tglkadaluarsa) ? "-" : MyFormatter::formatDateTimeForUser($oa->tglkadaluarsa); ?></td>
                <td style="text-align: right;" nowrap><?php echo $modObat->jmlharusorder." ".$kecil; ?></td>
                <td style="text-align: right;" hidden><?php echo $modObat->maksimalstok." ".$kecil; ?></td>
                <td style="text-align: right;" nowrap><?php echo $modObat->stokakhir." ".$kecil; ?></td>
                <td style="text-align: right;" nowrap><?php echo $modObat->kemasanbesar." ".$kecil; ?></td>
                <td style="text-align: right;" nowrap><?php echo number_format($modObat->jmlpermintaan,2,",",".")." ".$sat; ?></td>
                <td style="text-align: right;"><?php echo (Params::cekHiddenHargaGudangFarmasi()==true)?"Rp. ".$format->formatNumberForPrint($modObat->harganettorenc, 2):"Hidden"; ?></td>
                <td style="text-align: right;"><?php echo (Params::cekHiddenHargaGudangFarmasi()==true)?($modObat->persenppn):"Hidden"; ?></td>
                <td style="text-align: right;"><?php echo (Params::cekHiddenHargaGudangFarmasi()==true)?"Rp. ".$format->formatNumberForPrint($modObat->ppn, 2):"Hidden"; ?></td>
                <td style="text-align: right;"><?php echo (Params::cekHiddenHargaGudangFarmasi()==true)?"Rp. ".$format->formatNumberForPrint($modObat->hpp, 2):"Hidden"; ?></td>
                <?php /* <td style="text-align: center;"><?php echo $modObat->buffer_stok." ".$kecil; ?></td> 
                <td style="text-align: center;"><?php echo $modObat->persen_abc; ?> %</td> */ ?>
                <td style="text-align: center;"><?php echo isset($modLookup->lookup_name) ? $modLookup->lookup_name : "-"; ?></td>
                <td style="text-align: center;"><?php echo $modObat->kategori_abc; ?></td>
                <td style="text-align: right;"><?php 
//                    if (!empty($modObat->satuankecil_id)) {
//                        $subtotal = ($modObat->hpp * $modObat->jmlpermintaan);
//                    } else {
//                        $subtotal = ($modObat->hpp * $modObat->jmlpermintaan * $modObat->kemasanbesar);
//                    }
                    $total += $modObat->hargatotalrenc;
                    echo (Params::cekHiddenHargaGudangFarmasi()==true)?"Rp. ".$format->formatNumberForPrint($modObat->hargatotalrenc, 2):"Hidden"; ?>
                </td>
            </tr>
        <?php } ?>
        <tr>
            <td colspan="15" align="center"><strong>Total</strong></td>
            <td style="text-align: right;"><?php echo (Params::cekHiddenHargaGudangFarmasi()==true)? "Rp. ".$format->formatNumberForPrint($total, 2):"Hidden"; ?></td>
        </tr>
    </table>
<?php
if (isset($_GET['frame'])){
    echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('PRINT')"));
    echo CHtml::link(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('EXCEL')")); 
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
            <table width="100%">
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
