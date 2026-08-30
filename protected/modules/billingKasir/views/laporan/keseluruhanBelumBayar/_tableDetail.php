<table width="100%" border="1" cellpadding="8">
    <thead>
        <tr>
            <th width="5">No</th>
            <th align="center">Kelompok</th>
            <th align="center">Nama Transaksi</th>
            <th align="center">Harga</th>
            <th align="center">Jumlah</th>
            <th align="center">SubTotal</th>
        </tr>
    </thead>
<?php

    $cols = '';
    foreach($row as $val){
        $cols .= '<tr>';
        $cols .= '<td colspan="6" style="background-color:#F0F0F0;">';
        $cols .= '<div><div style="padding:2px;width:80px;float:left;">No. RM</div> <div style="padding:2px;">: '. $val['no_rm'] . ' - ' . $val['no_pendaftaran'] .'</div></div>';
        $cols .= '<div><div style="padding:2px;width:80px;float:left;">Nama Pasien</div> <div style="padding:2px;">: '. $val['nama'] .'</div></div>';
        $cols .= '</td>';
        $cols .= '</tr>';
        
        $col = '';
        $no = 1;
        $total = 0;
        foreach($val['ruangan'] as $values){
            $col .= '<tr>';
            $col .= '<td>'. $no++ .'</td>';
            $col .= '<td>'. $values['nama'] .'</td>';
            $col .= '<td>'. $values['tindakan'] .'</td>';
            $col .= '<td>'. $values['qty'] .'</td>';
            $col .= '<td>'. $values['tarif_tindakan'] .'</td>';
            $col .= '<td>'. $values['total_tarif'] .'</td>';
            $col .= '</tr>';
            $total += $values['total_tarif'];
        }
        $cols .= $col;
        $cols .= '<tr>';
        $cols .= '<td align="right" colspan="5"><b>Jumlah Total</b></td>';
        $cols .= '<td>'. $total .'</td>';
        $cols .= '</tr>';
    }
    echo $cols;
?>
</table>