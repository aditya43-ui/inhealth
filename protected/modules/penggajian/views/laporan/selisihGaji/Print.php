<style>
    .tab_detail th, .tab_detail td {
        border: 1px solid black;
        padding: 2px;
    }
    
    .num {
        text-align: right;
    }
</style>
<?php 
if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}

$prov_dat = $model->searchLaporanSelisihGaji();
$prov_dat['prov']->pagination = false;

echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksi',array('judulLaporan'=>$judulLaporan, 'periode'=>$periode, 'colspan'=>(1 + (iterator_count((array)$prov_dat['periode']) * (count((array)$prov_dat['komponen']) + 1)))));  

$res = array();

foreach ($prov_dat['prov']->data as $item) {
    if (empty($res[$item->pegawai_id])) {
        $res[$item->pegawai_id] = array(
            'base'=>$item,
            'detail'=>array(),
        );
    }
    $res[$item->pegawai_id]['detail'][MyFormatter::formatMonthForUser($item->periodegaji)] = $item;
}

//var_dump($res); die;

?>


<table class="tab_detail">
    <thead>
        <tr>
            <th rowspan="2">No.</th>
            <th rowspan="2">Nama</th>
            <th rowspan="2">Unit Kerja</th>
            <th rowspan="2">Jabatan</th>
            
            <?php foreach ($prov_dat['periode'] as $item) {
                echo '<th colspan="'.(count((array)$prov_dat['komponen']) + 1).'">'. MyFormatter::formatMonthForUser($item->format("Y-m")) ."</th>";
            } ?>
            
        </tr>
        <tr>
            <?php foreach ($prov_dat['periode'] as $item) {
                foreach ($prov_dat['komponen'] as $item2) {
                    echo '<th>'. MyFormatter::formatMonthForUser($item2->komponengaji_nama) ."</th>";
                    
                }
                echo "<th>Total Gaji</th>";
            } ?>
        </tr>
    </thead>
    <tbody>
        <?php 
        $cnt = 1;
        foreach ($res as $item): 
            $data = $item['base'];
            ?>
        <tr>
            <td><?php echo $cnt++; ?></td>
            <td><?php echo empty($data->pegawai) ? "-" : $data->pegawai->nama_pegawai; ?></td>
            <td><?php echo empty($data->pegawai->unitkerja) ? "-" : $data->pegawai->unitkerja->namaunitkerja; ?></td>
            <td><?php echo empty($data->pegawai->jabatan) ? "-" : $data->pegawai->jabatan->jabatan_nama; ?></td>
            <?php foreach ($prov_dat['periode'] as $item_period) {
                $period = MyFormatter::formatMonthForUser($item_period->format('Y-m'));
                $total = 0;
                foreach ($prov_dat['komponen'] as $komponen) {
                    echo '<td class="num">';
                    if (!empty($item['detail'][$period])) {
                        $nilai = $item['detail'][$period]->data_komponen[$komponen->komponengaji_id]['nilai'];
                    } else {
                        $nilai = 0;
                    }
                    echo MyFormatter::formatNumberForPrint($nilai, 0, false, true);
                    echo '</td>';
                    $total += $nilai;
                }
                ?>
            <td class="num"><?php echo MyFormatter::formatNumberForPrint($total, 0, false, true); ?></td>
            <?php
            } ?>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>