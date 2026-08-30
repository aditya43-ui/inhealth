<style>
    .grid_table{
        border-collapse: collapse;
        border:1px solid #000;
    }
</style>
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
<table width="100%" cellpadding="3">
    <tr>
        <td width="120">No. Registrasi</td>
        <td width="10">:</td>
        <td><?php echo (isset($data['no_pendaftaran']) ? $data['no_pendaftaran'] : ""); ?></td>
    </tr>
    <tr>
        <td>No. RM</td>
        <td>:</td>
        <td><?php echo($data['no_rm']); ?></td>
    </tr>
    <tr>
        <td>Nama Pasien</td>
        <td>:</td>
        <td><?php echo($data['nama_pasien']); ?></td>
    </tr>
    <tr>
        <td>Alamat</td>
        <td>:</td>
        <td><?php echo($data['alamat']); ?></td>
    </tr>
    <tr>
        <td>Perusahaan P3</td>
        <td>:</td>
        <td><?php echo($data['perusahaan']); ?></td>
    </tr>
    <tr>
        <td colspan="3">&nbsp;</td>
    </tr>    
</table>
<table style="width: 100%; border: none;">
    <?php
        $format = new MyFormatter();
        $cols = '';
        foreach($row as $val)
        {
            $cols .= '<tr>';
            $cols .= '<td>Kelompok '. $val['kelompok'] .'</td>';
            $cols .= '</tr>';
            $cols .= '<tr>';
            $cols .= '<td>';
            $cols .= '<table width="100%" border="1" cellpadding="5" class="grid_table">';
            $cols .= '<tr>';
            $cols .= '<th width="80">No. Transaksi</th>';
            $cols .= '<th width="150">Tanggal</th>';
            $cols .= '<th width="80">No. Resep</th>';
            $cols .= '<th>Nama Items</th>';
            $cols .= '<th width="80">Jumlah</th>';
            $cols .= '<th width="120">Harga</th>';
            $cols .= '<th width="120">Total</th>';
            $cols .= '</tr>';            
            $col = '';
            $total_harga = 0;
            foreach($val['data_transaksi'] as $value)
            {
                $col .= '<tr>';
                $col .= '<td>'. $value['no_transaksi'] .'</td>';
                $col .= '<td>'. (isset($value['tgl_transaksi']) ? $value['tgl_transaksi'] : "") .'</td>';
                $col .= '<td>'. $value['noresep'] .'</td>';
                $col .= '<td>'. $value['nama_item'] .'</td>';
                $col .= '<td style="text-align:center;">'.$value['qty'].'</td>';
                $col .= '<td style="text-align:right;">'.$value['harga'].'</td>';
                $col .= '<td style="text-align:right;">'.(($caraPrint != 'EXCEL')?$format->formatNumberForPrint($value['total']):$format->formatNumberForUser($value['total'])).'</td>';
                $col .= '</tr>';
                $total_harga += $value['total'];
            }
            if(isset($caraPrint) && $caraPrint == "EXCEL"){
                $total_harga = $format->formatNumberForUser($total_harga);
            }else{
                $total_harga = $format->formatNumberForPrint($total_harga);
            }
            $cols .= $col;
            $cols .= '</table>';
            $cols .= '</td>';
            $cols .= '</tr>';
            $cols .= '<tr>';
            $cols .= '<td>';
            $cols .= '<table width="1024" cellpadding="3">';
            $cols .= '<tr>';
            $cols .= '<td align="right">Total Tagihan :</td>';
            $cols .= '<td align="right" width="100">'.$total_harga .'</td>';
            $cols .= '</tr>';
            $cols .= '<tr>';
            $cols .= '<td align="right">Tanggungan Pasien :</td>';
            $cols .= '<td align="right" width="100">'.$total_harga .'</td>';
            $cols .= '</tr>';
            $cols .= '</table>';
            $cols .= '</td>';
            $cols .= '</tr>';
            $cols .= '<tr>';
            $cols .= '<td>&nbsp;</td>';
            $cols .= '</tr>';
            
        }
        echo($cols);
    ?>
</table>