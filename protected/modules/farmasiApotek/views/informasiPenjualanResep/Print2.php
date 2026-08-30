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
<style>

body {
    color: black;
}

.tab_header {
    width: 100%;
}

.tab_detail {
    width:100%;
}

.tab_detail th, .tab_detail td {
    border: 1px solid black;
    padding: 3px;
}

.tab_detail th {
    font-weight: bold;
}

</style>

<?php
$format = new MyFormatter;
if (!isset($_GET['frame'])){
    echo $this->renderPartial($this->path_view.'_headerPrint'); 
}
?>
<table class="tab_header">
<tr>
    <td>Tgl. Penjualan</td>
    <td>:</td>
    <td><?php echo MyFormatter::formatDateTimeForUser($modReseptur->tglpenjualan);?></td>
    <td></td>
    <td>No. Rekam Medik</td>
    <td>:</td>
    <td><?php echo $modReseptur->pasien->no_rekam_medik;?></td>
</tr>
<tr>
    <td>Tgl. Resep</td>
    <td>:</td>
    <td><?php echo MyFormatter::formatDateTimeForUser($modReseptur->tglresep);?></td>
    <td></td>
    <td>Nama Pasien</td>
    <td>:</td>
    <td><?php echo $modReseptur->pasien->nama_pasien;?></td>
</tr>
<tr>
     <td><?php echo ($modReseptur->jenispenjualan == Params::JENISPENJUALAN_BEBAS) ? 'No. Nota' : "No. Resep";?></td>
    <td>:</td>
    <td><?php
                echo $modReseptur->noresep;
         ?></td>
    <td></td>
    <td>Dokter</td>
    <td>:</td>
    <td><?php echo  ($modReseptur->jenispenjualan == Params::JENISPENJUALAN_BEBAS OR  $modReseptur->jenispenjualan == Params::JENISPENJUALAN_RESEP_LUAR) ? '-' : (empty($modReseptur->pegawai_id) ? "-" : $modReseptur->pegawai->namaLengkap);?></td>
</tr>
</table>
<hr/>
<table id="tableObatAlkes" class="tab_detail">
<thead>

    <th>No.Urut</th>
    <th><span hidden>Kategori/&nbsp;&nbsp;&nbsp;&nbsp;<br/></span>  Nama Obat</th>
    <th>Jenis Resep</th>
    <th hidden>Satuan Kecil</th>
    <th>Jumlah</th>
    <th>Harga Satuan</th>
    <th>Keringanan (%)</th>
    <th>Keringanan (Rp)</th>
    <th>PPN (%)</th>
    <th>PPN (Rp)</th>
    <th>SubTotal</th>
    <th>Status Bayar</th>

</thead>
<?php
$no=1;
$subtotals = 0;
$totalSubTotal = 0;
$discount = 0;
    foreach($detailreseptur AS $tampilData):
      // $jumlhqty = ($tampilData->hargasatuan_oa * $tampilData->qty_oa);
      // $ppnpersen = round($tampilData->jumlahppn/$jumlhqty * 100,2);

        // $subTotal = (($tampilData['qty_oa']*$tampilData['hargasatuan_oa']));
        $subTotal = $tampilData->hargajual_oa;
        // $discount = ((($tampilData['hargasatuan_oa']*$tampilData['qty_oa'])*($tampilData['discount']/100)));
        if($tampilData['oasudahbayar_id'] != null){
             $status = 'Sudah Lunas';
        }else{
             $status = 'Belum Lunas';
        }
echo "<tr>
        <td>".$no."</td>
        <td>".//$tampilData->obatalkes->obatalkes_kategori."<br>".
        $tampilData->obatalkes->obatalkes_nama."</td>
        <td>";
        if(!empty($tampilData->racikan_id)){
            $modRacik = RacikanM::model()->findByPk($tampilData->racikan_id);
            echo $modRacik->racikan_nama;
        }
        else{
            echo 'Non-Racikan';
        }
 echo "</td>
        <td hidden>".$tampilData->obatalkes->satuankecil->satuankecil_nama."</td>
        <td style='text-align: right;'>".number_format($tampilData['qty_oa'], 2, ",", "")." ".$tampilData->obatalkes->satuankecil->satuankecil_nama."</td>
        <td style='text-align: right;'>".MyFormatter::formatNumberForPrint($tampilData['hargasatuan_oa'],2)."</td>
        <td style='text-align: right;'>".$tampilData->persen_discount."</td>
        <td style='text-align: right;'>".MyFormatter::formatNumberForPrint($tampilData->discount,2)."</td>
        <td style='text-align: right;'>".$tampilData->persenppnjual."</td>
        <td style='text-align: right;'>".MyFormatter::formatNumberForPrint($tampilData->jumlahppn,2)."</td>
        <td style='text-align: right;'>".MyFormatter::formatNumberForPrint($subTotal,2)."</td>
        <td>".$status."</td>


     </tr>";
    $no++;

    $subtotals += ($subTotal-$discount);
//        $discounts +=$discount;
    $totalSubTotal=$totalSubTotal+$subTotal-$discount;

    endforeach;
echo "<tr hidden>
        <td colspan='7' style='text-align:right;'> Biaya Administrasi</td>

        <td style='text-align: right;'>".MyFormatter::formatNumberForPrint($modReseptur->biayaadministrasi,2)."</td>
        <td></td>
     </tr>";
echo "<tr hidden>
        <td colspan='7' style='text-align:right;'> Biaya Service</td>

        <td style='text-align: right;'>".MyFormatter::formatNumberForPrint($modReseptur->totaltarifservice,2)."</td>
        <td></td>
     </tr>";
echo "<tr hidden>
        <td colspan='7' style='text-align:right;'> Biaya Konseling</td>

        <td style='text-align: right;'>".MyFormatter::formatNumberForPrint($modReseptur->biayakonseling,2)."</td>
        <td></td>
     </tr>";
echo "<tr hidden>
        <td colspan='7' style='text-align:right;'> Jasa Dokter Resep</td>

        <td style='text-align: right;'>".MyFormatter::formatNumberForPrint($modReseptur->jasadokterresep,2)."</td>
        <td></td>
     </tr>";
echo "<tr hidden>
        <td colspan='7' style='text-align:right;'> Keringanan</td>

        <td style='text-align: right;'>".MyFormatter::formatNumberForPrint($modReseptur->discount,2)."</td>
        <td></td>
     </tr>";
 //     echo "<tr>
//            <td colspan='7' style='text-align:right;'> Total</td>
//
//            <td>".number_format((($totalSubTotal) - ($totalSubTotal * ($modReseptur->discount/100))) + $modReseptur->biayaadministrasi+$modReseptur->biayakonseling+$modReseptur->totaltarifservice+$modReseptur->jasadokterresep)."</td>
//            <td></td>
//         </tr>";
//$total = $subtotals+$modReseptur->biayaadministrasi+$modReseptur->totaltarifservice+$modReseptur->biayakonseling;//+$modReseptur->jasadokterresep << SDH TERMASUK DLM HARGA OBAT
$total = $subtotals;
 echo "<tr>
        <td colspan='9' style='text-align:right;'> Total</td>

        <td style='text-align: right;'>".MyFormatter::formatNumberForPrint($total,2)."</td>
        <td></td>
     </tr>";
?>

</table>