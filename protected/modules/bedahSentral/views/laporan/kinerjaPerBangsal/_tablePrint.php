<?php
    if($caraPrint=='EXCEL')
    {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
        header('Cache-Control: max-age=0');     
    }
?>
<style>
    th {
        border: 1px solid;        
        background-color: transparent;
    }
    .grid td{
        border: 1px solid;
        background-color: transparent;
    }
    th{
        text-align: center;
        font-size: 14px;
    }
    table{
        width: 100%;
    }
</style>
<?php 
    $format = new MyFormatter();
    
    $criteria2=new CDbCriteria;

    $criteria2->select = "t.daftartindakan_nama,kelompoktindakan_nama,t.ruanganpenunj_id,no_rekam_medik,nama_pasien,tarif_satuan,sum(qty_tindakan) as qty_tindakan";
    $criteria2->group = "t.daftartindakan_nama,kelompoktindakan_nama,t.ruanganpenunj_id,no_rekam_medik,nama_pasien,tarif_satuan";
        if (isset($_GET['BSLaporankinerjapenunjangV']['tgl_awal'])){
            $tgl_awal = $format->formatDateTimeForDb($_GET['BSLaporankinerjapenunjangV']['tgl_awal']);
        }
        if (isset($_GET['BSLaporankinerjapenunjangV']['tgl_akhir'])){
            $tgl_akhir = $format->formatDateTimeForDb($_GET['BSLaporankinerjapenunjangV']['tgl_akhir']);
        }
    $criteria->addBetweenCondition('t.tglmasukpenunjang',$tgl_awal,$tgl_akhir,true);
    $criteria2->addCondition('t.ruanganpenunj_id = '.Yii::app()->user->getState('ruangan_id'));
    $models = BSLaporankinerjapenunjangV::model()->findAll($criteria2);
    $totSub = 0;
    $row = array();
    
    foreach($models as $i=>$val)
    {
        $kelompoktindakan_id = $val->kelompoktindakan_id;
        $row[$kelompoktindakan_id]['nama'] = $val->kelompoktindakan_nama;
        $row[$kelompoktindakan_id]['ruanganpenunj_id'] = $val->ruanganpenunj_id;
        $row[$kelompoktindakan_id]['daftartindakan'][$i]['daftartindakan_nama'] = $val->daftartindakan_nama;
        $row[$kelompoktindakan_id]['daftartindakan'][$i]['nama_pasien'] = $val->nama_pasien;
        $row[$kelompoktindakan_id]['daftartindakan'][$i]['no_rekam_medik'] = $val->no_rekam_medik;
        $row[$kelompoktindakan_id]['daftartindakan'][$i]['tarif'] = $val->tarif_satuan;
        $row[$kelompoktindakan_id]['daftartindakan'][$i]['qty'] = $val->qty_tindakan;
        $row[$kelompoktindakan_id]['daftartindakan'][$i]['total'] = ($row[$kelompoktindakan_id]['daftartindakan'][$i]['tarif'] * $row[$kelompoktindakan_id]['daftartindakan'][$i]['qty']);
//        $tarif = TindakanpelayananT::model()->findAllByPk($val->tindakanpelayanan_id);
    }
?>
<?php 
    $header = '';
    
    $header .='<table width="100%" border = 1 class="grid ">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>No. RM</th>
                            <th>Nama Pasien</th>
                            <th>Uraian Tindakan</th>
                            <th>Tarif</th>
                            <th>Jml</th>
                            <th>Sub Total</th>
                        </tr>
                    </thead>';
?>
    <?php
        $cols = '';
        $totalSub = 0;
        foreach($row as $values)
        {
            $cols .= '<table width="100%" margin-right:auto;" class="grid ">';
            $cols .= '<tr>';
            $cols .= '<td colspan=7 style="font-weight:bold;text-align:center;">'. $values['nama'] .'</td>';
            $cols .= '</tr>';
            $cols .= '</table>';
            $col = '';
            $total = 0;
    ?>
    <?php
            $i = 0;
            foreach($values['daftartindakan'] as $key=>$val)
            {
                $col .= '<tr>';
                $col .= '<td colspan=7> Uraian Tindakan : '.$val['daftartindakan_nama'] .'</td>';
                $col .= '</tr>';
                $col .= '<tr>';
                $col .= '<td>'. ($i+1).'</td>';
                $col .= '<td>'. $val['no_rekam_medik'] .'</td>';
                $col .= '<td>'. $val['nama_pasien'] .'</td>';
                $col .= '<td>'. $val['daftartindakan_nama'] .'</td>';                
                $col .= '<td style="text-align:center;">'. number_format($val['tarif']) .'</td>';
                $col .= '<td style="text-align:center;">'. $val['qty'] .'</td>';
                $col .= '<td style="text-align:right;">'. number_format($val['total']) .'</td>';
                $col .= '</tr>';
                $total += $val['total'];
                $col .= '<tr>';
                $col .= '<td colspan=6 style="text-align:right;">Jumlah Tindakan Pemakaian '.$val['daftartindakan_nama'].' </td>';
                $col .= '<td style="text-align:right;">'. number_format($total) .'</td>';
                $col .= '</tr>';               
                $i++;
            }
            
                $col .= '</table>';
        }
        echo($cols);
        echo($header);        
        echo($col);
    ?>

</table>