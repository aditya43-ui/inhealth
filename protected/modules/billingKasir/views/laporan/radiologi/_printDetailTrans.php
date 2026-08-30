
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

<table width="100%" class="table table-striped table-bordered table-condensed">
    <thead>
        <tr>
            <th width="70">No. Transaksi</th>
            <th width="120">Tanggal Transaksi</th>
            <th width="80">Kode</th>
            <th>Items</th>
            <th width="80">Pasien</th>
            <th width="80">P3</th>
            <th width="80">Lab</th>
            <th width="80">Adm</th>
            <th width="80">Total</th>
        </tr>
    </thead>
<?php
    $cols = '';
    foreach ($row as $val)
    {
        $cols .= '<tr>';
        $cols .= '<td colspan="9">
            <div><label style="margin-right:50px;">No. RM</label> : ('. $val['no_rekam_medik'] .') '. $val['nama'] .'</div>
            <div><label style="margin-right:40px;">Registrasi</label> : '. $val['noreg'] .' ('. $val['tgl_reg'] .')</div>
         </td>';
        $cols .= '</tr>';
        $noreg_jum = 0;
        foreach ($val['transaksi'] as $value)
        {
            $cols .= '<tr>';
            $cols .= '<td>'. $value['no_transaksi'] .'</td>';
            $cols .= '<td>'. date("d/m/Y H:i:s",strtotime($value['tgl_transaksi'])).'</td>';
            $cols .= '<td>'. $value['kode'] .'</td>';
            $cols .= '<td>'. $value['items'] .'</td>';
            $cols .= '<td>'. $value['tarif_pasien'] .'</td>';
            $cols .= '<td>'. $value['penanggung'] .'</td>';
            $cols .= '<td>'. $value['tarif_lab'] .'</td>';
            $cols .= '<td>'. $value['adm'] .'</td>';
            $cols .= '<td>'. $value['total'] .'</td>';
            $cols .= '</tr>';
            $noreg_jum++;
        }
        $cols .= '<tr>';
        $cols .= '<td colspan="9" align="right">Jumlah Transaksi Registrasi '. $val['noreg'] .' : '. $noreg_jum .'</td>';
        $cols .= '</tr>';        
    }
    echo $cols;
?>
</table>