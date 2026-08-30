<style>
    th{
        border-top: 1px #000 solid;
        border-bottom: 1px #000 solid;
    }
    tfoot td, .totSup{
        border-top: 1px #000 solid;
        border-bottom: 1px #000 solid;
        text-align: right;
        font-weight: bold;
    }
</style>
<div style="text-align: center;">
    <h2><?php echo $judulLaporan; ?></h2>

    <b>Periode : <?php echo $periode; ?></b><br>
</div>

<table style="width: 100%; border: none;">
    <thead>
        <th>No.</th>
        <th>No. Penerimaan</th>
        <th>Tanggal</th>
        <th>No. Pembelian</th>
        <th>No. Faktur</th>
        <th>Tanggal</th>
        <th>Jatuh Tempo </th>
        <th>Bruto </th>
        <th>Keringanan</th>
        <th>PPN</th>
        <th>Meterai</th>
        <th>Netto</th>
        <th>Bayar</th>
        <th>Sisa</th>
    </thead>
    <tbody>
<?php
$i = 0;
$totalBruto = 0;
$totalDiskon = 0;
$totalPPN = 0;
$totalMaterai = 0;
$totalNetto = 0;
$totalBayar = 0;
$totalSisa = 0;
$totalBrutoSupplier = 0;
$totalDiskonSupplier = 0;
$totalPPNSupplier = 0;
$totalMateraiSupplier = 0;
$totalNettoSupplier = 0;
$totalBayarSupplier = 0;
$totalSisaSupplier = 0;
$tr = null;
foreach($models as $i => $mod){
    $totalBruto += $mod->getTotal('bruto');
    $totalDiskon += $mod->getTotal('diskon');
    $totalPPN += $mod->getTotal('ppn');
    $totalMaterai += (isset($mod->fakturpembelian)?$mod->fakturpembelian->biayamaterai:0);
    $totalNetto += $mod->getTotal('netto');
    $totalBayar += (isset($mod->fakturpembelian->bayarkesupplier)?$mod->fakturpembelian->bayarkesupplier->jmldibayarkan:0);
    $totalSisa += ($mod->getTotal('netto') - (isset($mod->fakturpembelian->bayarkesupplier)?$mod->fakturpembelian->bayarkesupplier->jmldibayarkan:0));
    $totalBrutoSupplier += $mod->getTotal('bruto');
    $totalDiskonSupplier += $mod->getTotal('diskon');
    $totalPPNSupplier += $mod->getTotal('ppn');
    $totalMateraiSupplier += (isset($mod->fakturpembelian)?$mod->fakturpembelian->biayamaterai:0);
    $totalNettoSupplier += $mod->getTotal('netto');
    $totalBayarSupplier += (isset($mod->fakturpembelian->bayarkesupplier)?$mod->fakturpembelian->bayarkesupplier->jmldibayarkan:0);
    $totalSisaSupplier += ($mod->getTotal('netto') - (isset($mod->fakturpembelian->bayarkesupplier)?$mod->fakturpembelian->bayarkesupplier->jmldibayarkan:0));
    //tampilkan keterangan supplier
    if($i == 0 | $models[$i]->supplier_id != $models[$i]->supplier_id){
        $tr .= "<tr><td colspan=2>Nama Supplier </td><td colspan=12>: ".$mod->supplier->supplier_nama."</td></tr>";
        $tr .= "<tr><td colspan=2>Alamat Supplier </td><td colspan=12>: ".((!empty($mod->supplier->supplier_alamat)) ? $mod->supplier->supplier_alamat : "-")."</td></tr>";
    }
    $tr .= "<tr>";
    $tr .= "<td>".($i+1)."</td>";
    $tr .= "<td>".$mod->noterima."</td>";
    $tr .= "<td>".$mod->tglterima."</td>";
    $tr .= "<td>".(empty($mod->permintaanpembelian->nopembelian) ? "-":$mod->permintaanpembelian->nopembelian)."</td>";
    $tr .= "<td>".(empty($mod->fakturpembelian->nofaktur) ? "-":$mod->fakturpembelian->nofaktur)."</td>";
    $tr .= "<td>".(empty($mod->fakturpembelian->tglfaktur) ? "-" : date('d-m-Y H:i:s',  strtotime($mod->fakturpembelian->tglfaktur)))."</td>";
    $tr .= "<td>".(empty($mod->fakturpembelian->tgljatuhtempo) ? "-" : date('d-m-Y H:i:s',  strtotime($mod->fakturpembelian->tgljatuhtempo)))."</td>";
    $tr .= "<td style='text-align:right;'>".number_format($mod->getTotal('bruto'))."</td>";
    $tr .= "<td style='text-align:right;'>".number_format($mod->getTotal('diskon'))."</td>";
    $tr .= "<td style='text-align:right;'>".number_format($mod->getTotal('ppn'),2,'.',',')."</td>";
    $tr .= "<td style='text-align:right;'>".number_format((isset($mod->fakturpembelian)?$mod->fakturpembelian->biayamaterai:0))."</td>";
    $tr .= "<td style='text-align:right;'>".number_format($mod->getTotal('netto'))."</td>";
    $tr .= "<td style='text-align:right;'>".number_format((isset($mod->fakturpembelian->bayarkesupplier)?$mod->fakturpembelian->bayarkesupplier->jmldibayarkan:0))."</td>";
    $tr .= "<td style='text-align:right;'>".number_format($mod->getTotal('netto') - (isset($mod->fakturpembelian->bayarkesupplier)?$mod->fakturpembelian->bayarkesupplier->jmldibayarkan:0))."</td>";
    $tr .= "</tr>";
    //tampilkan total per supplier
    if($models[$i]->supplier_id != $models[$i]->supplier_id){
        $tr .= "<tr class='totSup'>";
        $tr .= "<td colspan=7 style='text-align: right;'>Total Supplier ".$mod->supplier->supplier_nama." :</td>";
        $tr .= "<td class='totSup'>".number_format($totalBrutoSupplier)."</td>";
        $tr .= "<td class='totSup'>".number_format($totalDiskonSupplier)."</td>";
        $tr .= "<td class='totSup'>".number_format($totalPPNSupplier)."</td>";
        $tr .= "<td class='totSup'>".number_format($totalMateraiSupplier)."</td>";
        $tr .= "<td class='totSup'>".number_format($totalNettoSupplier)."</td>";
        $tr .= "<td class='totSup'>".number_format($totalBayarSupplier)."</td>";
        $tr .= "<td class='totSup'>".number_format($totalSisaSupplier)."</td>";
        $tr .= "</tr>";
        //reset total supplier
        $totalBrutoSupplier = 0;
        $totalDiskonSupplier = 0;
        $totalPPNSupplier = 0;
        $totalMateraiSupplier = 0;
        $totalNettoSupplier = 0;
        $totalBayarSupplier = 0;
        $totalSisaSupplier = 0;
    }
}
echo $tr;
?>
        <tr><td>&nbsp;</td></tr>
        <tr><td>&nbsp;</td></tr>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="7">Grand Total:</td>
            <td><?php echo number_format($totalBruto) ?></td>
            <td><?php echo number_format($totalDiskon) ?></td>
            <td><?php echo number_format($totalPPN) ?></td>
            <td><?php echo number_format($totalMaterai) ?></td>
            <td><?php echo number_format($totalNetto) ?></td>
            <td><?php echo number_format($totalBayar) ?></td>
            <td><?php echo number_format($totalSisa) ?></td>
        </tr>
    </tfoot>
</table>
<?php 
if(isset($_GET['caraPrint']))
    $this->renderPartial('mutasiIntern/_tandatangan', array('models'=>$models, 'caraPrint'=>$caraPrint)); 
?>