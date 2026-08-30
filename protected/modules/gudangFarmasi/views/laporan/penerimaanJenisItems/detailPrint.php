<?php
/**
 * digunakan untuk detail print
 * 
 * @author          Yusuf Putra Anugrah <yusufputra@.com>
 * @version         2.0.0
 * @link            .com
 * 
 */
    echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksi',array('judulLaporan'=>$judulLaporan, 
        'periode'=>$periode, 'colspan'=>10));  
?>
<div style='border:1px solid #cccccc; border-radius:2px;padding:10px; width: 15%;float:right;margin-right:30px;margin-top:-80px;text-align:center;'>
                <span style='font-size:9pt;text-align:center;'><B>PURCHASE RECEIVED REPORT</B></span><br></div>
<?php
                $noterima = $model->noterima;
                $tglterima = $model->tglterima;
                $tglfaktur = (isset($model->fakturpembelian->tglfaktur) ? $model->fakturpembelian->tglfaktur : "");
                $nofaktur = (isset($model->fakturpembelian->nofaktur) ? $model->fakturpembelian->nofaktur : "");
                $supplier = $model->supplier_id;
                $penerimaanId = $model->penerimaanbarang_id;
        
            echo "                
                <table width='100%' border='0' style='font-size:small;border-top:1px solid black;border-bottom:1px solid black'>
                    <tr>
                        <td> No. Terima </td>
                        <td> Tanggal </td>
                        <td> No. Faktur </td>
                        <td> Tanggal Faktur </td>
                        <td> Supplier</td>
                    </tr>
                    <tr style='border-top:1px solid black;background-color:#C0C0C0;'>
                        <td> $noterima </td>
                        <td> $tglterima </td>
                        <td> $nofaktur </td>
                        <td> $tglfaktur </td>
                        <td> $supplier </td>
                    </tr>
                    </table></br>";
                echo "<table width='100%' border='1'>
                            <tr style='font-weight:bold;'>
                                <td align='center'>Kode</td>
                                <td align='center'>Barang</td>
                                <td align='center'>Satuan</td>
                                <td align='center'>Jumlah</td>
                                <td align='center'>Harga</td>
                                <td align='center'>Bruto</td>
                                <td align='center'>Disc (%)</td>
                                <td align='center'>Ppn (%)</td>
                                <td align='center'>Pph</td>
                                <td align='center'>Tot HPP / Netto</td>
                            </tr>";

            $totQty = 0;
            $totHarga = 0;
            $totBruto = 0;
            $totDiscount = 0;
            $totPpn = 0;
            $totPph = 0;
            $totHppNetto = 0;
            
            foreach($modDetail as $key=>$details){
                    $qty = $details->jmlterima;
                    $harga = $details->harganettoper;
                    $discount = $details->persendiscount;
                    $ppn = $details->persenppn;
                    $pph = $details->persenpph;
                    $bruto = $details->harganettoper * $details->jmlterima;
                    $hppNetto = (($details->harganettoper * $details->jmlterima) - (($details->harganettoper * $details->jmlterima) * ($details->obatalkes->discount / 100))) + (($details->harganettoper * $details->jmlterima)*($details->obatalkes->ppn_persen / 100));
                    
                    $totQty += $qty;
                    $totHarga += $harga;
                    $totBruto += $bruto;
                    $totDiscount += $discount;
                    $totPpn += $ppn;
                    $totPph += $pph;
                    $totHppNetto += $hppNetto;

                    echo "<tr>
                      <td width='150px;'>".$details->obatalkes->obatalkes_kode."</td>
                      <td width='280px;'>".$details->obatalkes->obatalkes_nama."</td>
                      <td width='220px;' style='text-align:center'>".$details->obatalkes->satuanbesar->satuanbesar_nama."</td>
                      <td width='70px;' style='text-align:center'>".$qty."</td>
                      <td width='70px;' style='text-align:right'>".number_format($harga)."</td>
                      <td width='70px;' style='text-align:right'>".number_format($bruto)."</td>
                      <td width='70px;' style='text-align:right'>".number_format($discount)."</td>
                      <td width='70px;' style='text-align:right'>".number_format($ppn)."</td>
                      <td width='70px;' style='text-align:right'>".number_format($pph)."</td>
                      <td width='70px;' style='text-align:right'>".number_format($hppNetto)."</td>
                    </tr>";
            }
            
                    echo "<tr style='background-color:#ffffff;'>
                                <td colspan=3 style='text-align:right;font-weight:bold;'>Total : </td>
                                <td width='150px;' style='text-align:center'>".number_format($totQty)."</td>
                                <td width='150px;' style='text-align:right'>".number_format($totHarga)."</td>
                                <td width='150px;' style='text-align:right'>".number_format($totBruto)."</td>
                                <td width='150px;' style='text-align:right'>".number_format($totDiscount)."</td>
                                <td width='150px;' style='text-align:right'>".number_format($totPpn)."</td>
                                <td width='150px;' style='text-align:right'>".number_format($totPph)."</td>
                                <td width='150px;' style='text-align:right'>".number_format($totHppNetto)."</td>
                          </tr>";
                     echo "</table><br>";
            // }

?>