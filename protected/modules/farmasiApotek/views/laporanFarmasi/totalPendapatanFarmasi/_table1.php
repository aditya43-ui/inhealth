<?php 
$table = 'ext.bootstrap.widgets.HeaderGroupGridViewNonRp';
$data = $model->searchTableTotalPendapatanFarmasi();
$template = "{summary}\n{items}\n{pager}";
$sort = true;
if (isset($caraPrint)){
    $sort = false;
    $data = $model->searchTableTotalPendapatanFarmasi(false);  
    $template = "{items}";
    if ($caraPrint == "EXCEL") {
        echo $caraPrint;
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
    }
}
?> 
<table width="100%" style='margin-left:auto; margin-right:auto;' class='table table-striped table-bordered table-condensed'>
    <p style="margin: 0; text-align: center;">
    <thead>
        <tr>
            <th></th>
            <th></th>
            <p style="margin: 0; text-align: center;"><th colspan=4>Penjualan</th></p>
            <th colspan=4>Retur Penjualan</th>
            <th colspan=2>Jumlah</th>
        </tr>
        <tr>
            <th>id</th>
            <th>Kelompok</td>
            <th>Bruto</th>
            <th>Keringanan</th>
            <th>Ppn</th>
            <th>Netto</th>
            <th>Bruto</th>
            <th>Keringanan</th>
            <th>Ppn</th>
            <th>Netto</th>
            <th>Netto</th>
            <th>HPP</th>
        </tr>
    </thead>
    </p>
    <tbody>
        <?php
        foreach ($models as $i => $datas) 
        {
            
            if (($datas['returresep_id']!=NULL) && ($models[$i]['jenisobatalkes_id'] == $models[$i+1]['jenisobatalkes_id'])){
                $bruto+=$datas['hargajual_oa'];
                $jenis = $datas['jenisobatalkes_nama'];

            }
        }    
            echo "<tr>";
            echo "<td>";
            // echo $bruto;
            echo "</td>";
            echo "<td>";
            echo $jenis;
            echo "</td>";
            echo "<td>";
            echo $bruto;
            echo "</td>";
            echo "</tr>";
        

        //     echo "<tr>";
        //     echo "<td>";
        //     echo $datas['returresep_id'];
        //     echo "</td>";
        //     // if ($models[$i]['jenisobatalkes_id'] == $models[$i-1]['jenisobatalkes_id']){
        //     //     echo "<td></td>";
        //     // }else{
        //     echo "<td>";
        //     echo $datas['jenisobatalkes_nama'];
        //     echo "</td>";
        //     // }
        //     echo "<td>";
        //     echo $datas['hargajual_oa'];
        //     echo "</td>";
        //     echo "<td>";
        //     echo $datas['discount'];
        //     echo "</td>";
        //     echo "<td>";
        //     echo $datas['ppn_persen'];
        //     echo "</td>";
        //     echo "<td>";
        //     echo $datas['harganetto_oa'];
        //     echo "</td>";
        //     if ($datas['returresep_id'] != NULL){
        //         echo "<td>";
        //         echo $datas['hargajual_oa'];
        //         echo "</td>";
        //         echo "<td>";
        //         echo $datas['discount'];
        //         echo "</td>";
        //         echo "<td>";
        //         echo $datas['ppn_persen'];
        //         echo "</td>";
        //         echo "<td>";
        //         echo $datas['harganetto_oa'];
        //         echo "</td>";
        //         $gtbrutorp += $datas['hargajual_oa'];
        //         $discountrp += $datas['discount'];
        //         $ppnrp += $datas['ppn_persen'];
        //         $nettorp += $datas['harganetto_oa'];
        //     }else{
        //         echo "<td>0</td>";
        //         echo "<td>0</td>";
        //         echo "<td>0</td>";
        //         echo "<td>0</td>";
        //     }
        //     if ($datas['returresep_id'] == NULL){
        //         echo "<td>";
        //         echo $datas['harganetto_oa'];
        //         echo "</td>";
        //         echo "<td>";
        //         echo $datas['hpp'];
        //         echo "</td>";
        //         $hpp += $datas['hpp'];
        //         $nettojm += $datas['harganetto_oa'];
        //     }else{
        //         echo "<td>0</td>";
        //         echo "<td>0</td>";
        //     }
        //     echo "</tr>";
        //     $gtbrutop += $datas['hargajual_oa'];
        //     $discountp += $datas['discount'];
        //     $ppnp += $datas['ppn_persen'];
        //     $nettop += $datas['harganetto_oa'];

        // }

        //     //penjualan
        //     $totbrutop = $gtbrutop;
        //     $totdiscountp = $discountp;
        //     $totppnp = $ppnp;
        //     $totnettop = $nettop;
        //     //retur 
        //     $totbrutorp = $gtbrutorp;
        //     $totdiscountrp = $discountrp;
        //     $totppnrp = $ppnrp;
        //     $totnettorp = $nettorp;
        //     //jumlah
        //     $tothpp = $hpp;
        //     $totnettojm = $nettojm;
        //     echo "<tr>";
        //     echo '<td></td>';
        //     echo "<td><b>Grand Total</b></td>";
        //     echo '<td><b>'. $totbrutop .'</b></td>';
        //     echo '<td><b>'. $totdiscountp.'</b></td>';
        //     echo '<td><b>'. $totppnp .'</b></td>';
        //     echo '<td><b>'. $totnettop.'</b></td>';

        //     echo '<td><b>'. $totbrutorp .'</b></td>';
        //     echo '<td><b>'. $totdiscountrp.'</b></td>';
        //     echo '<td><b>'. $totppnrp .'</b></td>';
        //     echo '<td><b>'. $totnettorp.'</b></td>';

        //     echo '<td><b>'. $totnettojm .'</b></td>';
        //     echo '<td><b>'. $tothpp .'</b></td>';
        //     echo "</tr>";
        ?>
    </tbody>    

</table>