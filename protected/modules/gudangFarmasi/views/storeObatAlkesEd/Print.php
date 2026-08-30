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
if(!$modStoreEdDetail){
    echo "Data tidak ditemukan"; exit;
}
$format = new MyFormatter;
$modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
if (!isset($_GET['frame'])){
    echo $this->renderPartial($this->path_view.'_headerPrint'); 
}
?>
<body class="kertas">
    <table width="74%" style="margin:0px;" cellpadding="0" cellspacing="0">
        <tr>
            <td>Tanggal Store Obat Alkes ED</td>
            <td>:</td>
            <td><?php echo isset($modStoreEd->tglstoreed) ? $format->formatDateTimeId($modStoreEd->tglstoreed) : "-"; ?></td>
        </tr>
        <tr>
            <td>No. Store Obat Alkes ED</td>
            <td>:</td>
            <td><?php echo isset($modStoreEd->nostoreed) ? $modStoreEd->nostoreed : "-"; ?></td>
        </tr>
        <tr>
            <td>Ruangan</td>
            <td>:</td>
            <td><?php echo isset($modStoreEd->ruangan_id) ? $modStoreEd->ruangan->ruangan_nama : "-"; ?></td>
        </tr>
    </table><br/><br>
    <table width="100%" style='margin-left:auto; margin-right:auto;'>
        <thead class="border">
            <th>Nama Obat</th>
            <th>Supplier</th>
            <th>Tanggal Kadaluarsa</th>
            <th>Jumlah</th>
            <th>Satuan Kecil</th>
        </thead>
        <?php 
			foreach ($modStoreEdDetail as $i=>$detail){ 
        ?>
            <tr>
                <td><?php echo !empty($detail['obatalkes_id'])?$detail['obatalkes_nama']:null;  ?></td>
                <td><?php echo !empty($detail['obatalkes_id'])? $detail['supplier_nama']:null; ?></td>
				<td><?php echo !empty($detail['tglkadaluarsa'])?$detail['tglkadaluarsa']:null; ?></td>
				<td><?php echo !empty($detail['qtystoked'])?$detail['qtystoked']:null; ?></td>
                <td><?php echo !empty($detail['satuankecil_id'])? $detail['satuankecil_nama']:null; ?></td>
            </tr>
        <?php } ?>
    </table>
</body>
