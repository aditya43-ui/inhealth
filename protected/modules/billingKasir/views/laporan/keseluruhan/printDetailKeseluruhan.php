<?php
    if($caraPrint == 'EXCEL')
    {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $data['judulLaporan'] .'-'.date("Y/m/d").'.xls"');
        header('Cache-Control: max-age=0');
    }
    
    echo $this->renderPartial('application.views.headerReport.headerLaporan',
        array(
            'judulLaporan'=>$data['judulLaporan'],
            'periode'=>$data['periode']
        )
    );
?>

<style>

    .tab_detail {
        border-collapse: collapse;
        font-size: 10pt;
    }
    .tab_detail td, .tab_detail th {
    }

    .num {
        text-align: right;
    }

    .tab_detail .field_label {
        padding: 2px;
        width: 100px !important;
        display: inline-block;
    }

    .tab_detail .field_value {
        padding: 2px; 
        display: inline-block;
    }

</style>


<table width="100%" border="1" cellpadding="8" class="tab_detail">
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
    <tbody>
<?php

    $cols = '';
    foreach($row as $val){
        $cols .= '<tr>';
        $cols .= '<td colspan="6" style="background-color:#F0F0F0;">';
        $cols .= '<div><div class="field_label">No. RM</div> <div class="field_value">: '. $val['no_rm'] . ' - ' . $val['no_pendaftaran'] .'</div></div>';
        $cols .= '<div><div class="field_label">Nama Pasien</div> <div class="field_value">: '. $val['nama'] .'</div></div>';
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
            $col .= '<td class="num">'. $values['qty'] .'</td>';
            $col .= '<td class="num">'. MyFormatter::formatNumberForPrint($values['tarif_tindakan'], 2) .'</td>';
            $col .= '<td class="num">'. MyFormatter::formatNumberForPrint($values['total_tarif'], 2) .'</td>';
            $col .= '</tr>';
            $total += $values['total_tarif'];
        }
        $cols .= $col;
        $cols .= '<tr>';
        $cols .= '<td align="right" colspan="5"><b>Jumlah Total</b></td>';
        $cols .= '<td class="num">'. MyFormatter::formatNumberForPrint($total, 2) .'</td>';
        $cols .= '</tr>';
    }
    echo $cols;
?>
    </tbody>
</table>
<br></br>