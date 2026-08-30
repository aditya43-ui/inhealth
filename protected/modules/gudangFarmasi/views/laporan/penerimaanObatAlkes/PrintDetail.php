<?php
if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
?>
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
    <b>Supplier : <?php echo (empty($model->supplier_id)) ? '-' : $model->supplier->supplier_nama; ?></b><br>
    <b>Periode : <?php echo $periode; ?></b><br>
</div>
<table style="width: 100%; border: none;">
    <thead>
        <th>No.</th>
        <th>No. Penerimaan</th>
        <th>Tanggal Penerimaan</th>
        <th>No. Faktur</th>
        <th>Tanggal Faktur</th>
        <th>Kode</th>
        <th>Nama</th>
        <th>Jumlah</th>
        <th>Satuan</th>
        <th>Harga</th>
        <th>Bruto</th>
        <th>Keringanan (%)</th>
        <th>Ppn (%)</th>
        <th>Netto</th>
    </thead>
    <tbody>
<?php
$i = 0;
$totalBruto=0;
$totalNetto=0;
$tr = null;
foreach($modDetail as $i => $mod){
    $totalBruto += ($mod->hargabelibesar*$mod->jmlterima);
    $hargaDiskon = $mod->hargabelibesar * $mod->persendiscount/100;
    $hargaPPN = ($mod->hargabelibesar - $hargaDiskon) * $mod->HargappnToPersen / 100;
    $totalNetto += ($mod->hargabelibesar - $hargaDiskon + $hargaPPN)*$mod->jmlterima;
    $tr .= "<tr>";
    $tr .= "<td>".($i+1)."</td>";
    $tr .= "<td>".$mod->penerimaanbarang->noterima."</td>";
    $tr .= "<td>".date('d-m-Y',  strtotime($mod->penerimaanbarang->tglterima))."</td>";
    $tr .= "<td>".((empty($mod->penerimaanbarang->fakturpembelian->tglfaktur)) ? "-": $mod->penerimaanbarang->fakturpembelian->nofaktur)."</td>";
    $tr .= "<td>".((empty($mod->penerimaanbarang->fakturpembelian->tglfaktur)) ? "-": date('d-m-Y',  strtotime($mod->penerimaanbarang->fakturpembelian->tglfaktur)))."</td>";
    $tr .= "<td>".$mod->obatalkes->obatalkes_kode."</td>";
    $tr .= "<td>".$mod->obatalkes->obatalkes_nama."</td>";
    $tr .= "<td>".number_format($mod->jmlterima)."</td>";
    $tr .= "<td>".$mod->satuanbesar->satuanbesar_nama."</td>";
    $tr .= "<td style='text-align:right;'>".number_format($mod->hargabelibesar)."</td>";
    $tr .= "<td style='text-align:right;'>".number_format($mod->hargabelibesar*$mod->jmlterima)."</td>";
    $tr .= "<td style='text-align:right;'>".number_format($mod->persendiscount,2,'.',',')."</td>";
    $tr .= "<td style='text-align:right;'>".number_format($mod->HargappnToPersen,2,'.',',')."</td>";
    $tr .= "<td style='text-align:right;'>".number_format(($mod->hargabelibesar - $hargaDiskon + $hargaPPN)*$mod->jmlterima)."</td>";
    $tr .= "</tr>";
}
echo $tr;
?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="10">Total</td>
            <td><?php echo number_format($totalBruto) ?></td>
            <td></td>
            <td></td>
            <td><?php echo number_format($totalNetto) ?></td>
        </tr>
    </tfoot>
</table>
<?php 
if(isset($_GET['caraPrint']))
    $this->renderPartial('mutasiIntern/_tandatangan', array('model'=>$model, 'caraPrint'=>$caraPrint)); 
?>