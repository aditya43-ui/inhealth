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
<?php
    $table = '<table border="1" width="100%" cellpadding=5>';
    $table .= '<thead>';
    $table .= '<tr>';
    $table .= '<th width="100">No. Transaksi</th>';
    $table .= '<th width="100">Tgl. Transaksi</th>';
    $table .= '<th>Items</th>';
    $table .= '<th width="100">Apotik</th>';
    $table .= '<th width="100">Jumlah</th>';
    $table .= '<th width="100">Pasien</th>';
    $table .= '<th width="100">SubTotal</th>';
    $table .= '<th width="100">Tanggungan P3</th>';
    $table .= '</tr>';
    $table .= '</thead>';
    $table .= '<tbody>';
    $cols = '';
    foreach ($record as $val)
    {
        $cols .= '<tr>';
        $cols .= '<td style="font-weight:bold;" colspan="8">No. RM ('. $val['no_rekam_medik'] .') ' . $val['nama_pasien'] .'</td>';
        $cols .= '</tr>';
        $col = '';
        $pendaftaran = '';
        $idx_rm = 0;
        $idx_reg = 0;
        foreach ($val['data_pendaftaran'] as $vals)
        {
            
            if($vals['no_pendaftaran'] != $pendaftaran)
            {
                $col .= '<tr>';
                $col .= '<td colspan="8"><div style="margin-left:50px;float:left;">&nbsp;</div>No. Registrasi :  '. $vals['no_pendaftaran'] .' (' . $vals['tgl_pendaftaran'] .')</td>';
                $col .= '</tr>';
                $idx_reg = 0;
            }
            $col_val = '';
            foreach ($vals['value'] as $value)
            {
                $col_val .= '<tr>';
                $col_val .= '<td>'. $value['no_transaksi'] .'</td>';
                $col_val .= '<td>'. $value['tgl_transaksi'] .'</td>';
                $col_val .= '<td>'. $value['item'] .'</td>';
                $col_val .= '<td>'. $value['apotik'] .'</td>';
                $col_val .= '<td>'. $value['qty'] .'</td>';
                $col_val .= '<td>'. $value['pasien'] .'</td>';
                $col_val .= '<td>'. $value['sub_total'] .'</td>';
                $col_val .= '<td>'. $value['penanggung'] .'</td>';
                $col_val .= '</tr>';
                $idx_rm++;
                $idx_reg++;
            }
            $col .= $col_val;
            if($vals['no_pendaftaran'] != $pendaftaran)
            {
                $col .= '<tr>';
                $col .= '<td colspan="8"><div style="margin-right:50px;float:right;">Jumlah Transaksi Registrasi <b>'. $vals['no_pendaftaran'] .'</b> = '. $idx_reg .'</div></td>';
                $col .= '</tr>';
            }            
            $pendaftaran = $vals['no_pendaftaran'];
        }
        $cols .= $col;
        $cols .= '<tr>';
        $cols .= '<td align="right" colspan="8">Jumlah Transaksi No. RM <b>'. $val['no_rekam_medik'] .'</b> = '. $idx_rm .'</td>';
        $cols .= '</tr>';
    }
    $table .= $cols;
    $table .= '</table><br>';
    echo($table);
?>
