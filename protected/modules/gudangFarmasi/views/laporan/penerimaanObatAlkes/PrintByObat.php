<style>
    th{
        border-top: 1px #000 solid;
        border-bottom: 1px #000 solid;
    }
    tfoot td{
        border-top: 1px #000 solid;
        border-bottom: 1px #000 solid;
        text-align: right;
        font-weight: bold;
    }
</style>
<div style="text-align: center;">
    <h2><?php echo $judulLaporan; ?></h2>
    <b>(Group Berdasarkan Obat Akes)</b><br>
    <b>Supplier : <?php echo (empty($model->supplier_id)) ? '-' : $model->supplier->supplier_nama; ?></b><br>
    <?php echo (!empty($noTerima)) ? "<b>No. Penerimaan : ".$noTerima."</b><br>" : ""; ?>
    <b>Periode : <?php echo $periode; ?></b><br>
</div>
<table style="width: 100%; border: none;">
    <thead>
        <th>No.</th>
        <th>Kode</th>
        <th>Nama</th>
        <th>Jumlah</th>
        <th>Satuan</th>
        <th>Bruto</th>
        <th>Keringanan </th>
        <th>Ppn </th>
        <th>Netto</th>
    </thead>
    <tbody>
<?php
$i = 0;
$totalBruto=0;
$totalNetto=0;
$totalDiskon=0;
$totalPPN=0;
$tr = null;
foreach($modDetail as $i => $mod){
    $totalBruto += $mod->hargabelibruto;
    $totalNetto += $mod->hargabelibruto - $mod->mergediskon + $mod->mergeppn;
    $totalDiskon += $mod->mergediskon;
    $totalPPN += $mod->mergeppn;
    $tr .= "<tr>";
    $tr .= "<td>".($i+1)."</td>";
    $tr .= "<td>".$mod->obatalkes->obatalkes_kode."</td>";
    $tr .= "<td>".$mod->obatalkes->obatalkes_nama."</td>";
    $tr .= "<td style='text-align:right;'>".number_format($mod->jmlterima)."</td>";
    $tr .= "<td>".(isset($mod->satuanbesar)?$mod->satuanbesar->satuanbesar_nama:"")."</td>";
    $tr .= "<td style='text-align:right;'>".number_format($mod->hargabelibruto)."</td>";
    $tr .= "<td style='text-align:right;'>".number_format($mod->mergediskon)."</td>";
    $tr .= "<td style='text-align:right;'>".number_format($mod->mergeppn)."</td>";
    $tr .= "<td style='text-align:right;'>".number_format($mod->hargabelibruto - $mod->mergediskon + $mod->mergeppn)."</td>";
    $tr .= "</tr>";
}
echo $tr;
?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="5">Total</td>
            <td><?php echo number_format($totalBruto) ?></td>
            <td><?php echo number_format($totalDiskon) ?></td>
            <td><?php echo number_format($totalPPN) ?></td>
            <td><?php echo number_format($totalNetto) ?></td>
        </tr>
    </tfoot>
</table>
<?php 
if(isset($_GET['caraPrint']))
    $this->renderPartial('mutasiIntern/_tandatangan', array('model'=>$model, 'caraPrint'=>$caraPrint)); 
?>