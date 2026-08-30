<?php
Yii::app()->clientScript->registerScript('search', "
        $('.search-button').click(function(){
                $('.search-form').toggle();
                return false;
        });
        $('#searchLaporan').submit(function(){
                $('#Grafik').attr('src','').css('height','0px');
                $.fn.yiiGridView.update('tableLaporan', {
                                data: $(this).serialize()
                });
                return false;
        });
");
?>
<?php
$spasi = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
$table = 'ext.bootstrap.widgets.HeaderGroupGridView';
$sort = true;
if (isset($caraPrint)) {
	$template = "{items}";
	$sort = false;
	if ($caraPrint == "EXCEL")
		$table = 'ext.bootstrap.widgets.BootExcelGridView';
} else {
	
}
$dataArray = array();
$header = true;
$format = new MyFormatter();
//$mergeTanggal = array();
//foreach ($models AS $row => $data) {
//	$dataArray["$data->tglperiodeposting_awal"] = $data->tglperiodeposting_awal;
//}
?>

<div id="tableLaporan" style="width: 2500px">
    <table class="table table-striped table-bordered table-condensed">
        <thead>
            <tr>
                <th rowspan="2" style="width: 80px">No. Akun</th>
                <th rowspan="2" style="width: 300px">Akun Beban dan Biaya</th>
                <th colspan="14">Unit Revenue Center</th>
                <th rowspan="2">Total Revenue Center</th>
            </tr>
            <tr>
                <th>RJ</th>
                <th>RI</th>
                <th>RD</th>
                <th>VK</th>
                <th>P. INTENSIF</th>
                <th>HD</th>
                <th>FISIOTERAPI</th>
                <th>MCU</th>
                <th>LAB</th>
                <th>RAD</th>
                <th>IBS</th>
                <th>P. JENAZAH</th>
                <th>BANK DARAH</th>
                <th>APOTEK</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                if(count((array)$models) > 0){
                    $dataArrayRek = array();
                    $res = array();
                    
                    foreach ($models as $data){
                        $dataArrayRek[$data->rekening5_id] = array(
                            'kode'=>$data->kdrekening5,
                            'nama'=>$data->nmrekening5,
                            'idrek'=>$data->rekening5_id,
                            'detail'=>array()
                            );
                    }
                    foreach ($models as $data){
                        $total = ($data->saldo_rj + $data->saldo_ri + $data->saldo_rd + $data->saldo_vk + $data->saldo_pi + $data->saldo_hd + $data->saldo_fisioterpi + $data->saldo_mcu + $data->saldo_lab + $data->saldo_rad + $data->saldo_ibs + $data->saldo_pemulasaran + $data->saldo_bankdrh + $data->saldo_apotek);
                        
                        $dataDetail = array(
                                    'kode'=>$data->kdrekening5,
                                    'nama'=>$data->nmrekening5,
                                    'saldo_rj'=> MyFormatter::formatNumberForPrint($data->saldo_rj, 2),
                                    'saldo_ri'=> MyFormatter::formatNumberForPrint($data->saldo_ri, 2),
                                    'saldo_rd'=> MyFormatter::formatNumberForPrint($data->saldo_rd, 2),
                                    'saldo_vk'=> MyFormatter::formatNumberForPrint($data->saldo_vk, 2),
                                    'saldo_pi'=> MyFormatter::formatNumberForPrint($data->saldo_pi, 2),
                                    'saldo_hd'=> MyFormatter::formatNumberForPrint($data->saldo_hd, 2),
                                    'saldo_fisioterpi'=> MyFormatter::formatNumberForPrint($data->saldo_fisioterpi, 2),
                                    'saldo_mcu'=> MyFormatter::formatNumberForPrint($data->saldo_mcu, 2),
                                    'saldo_lab'=> MyFormatter::formatNumberForPrint($data->saldo_lab, 2),
                                    'saldo_rad'=> MyFormatter::formatNumberForPrint($data->saldo_rad, 2),
                                    'saldo_ibs'=> MyFormatter::formatNumberForPrint($data->saldo_ibs, 2),
                                    'saldo_pemulasaran'=> MyFormatter::formatNumberForPrint($data->saldo_pemulasaran, 2),
                                    'saldo_bankdrh'=> MyFormatter::formatNumberForPrint($data->saldo_bankdrh, 2),
                                    'saldo_apotek'=> MyFormatter::formatNumberForPrint($data->saldo_apotek, 2),
                                    'totalrevenue'=> MyFormatter::formatNumberForPrint($total, 2),
                                );
                        array_push($dataArrayRek[$data->rekening5_id]['detail'], $dataDetail);
                    }
                    if(count((array)$dataArrayRek) > 0){
                        foreach ($dataArrayRek as $dataRek){
                            ?>
                            <tr>
                                <td style="font-weight: bold; text-align: right"><?php echo $dataRek['kode'] ?></td>
                                <td style="font-weight: bold"><?php echo $dataRek['nama'] ?></td>
                                <td style="text-align: right">0</td>
                                <td style="text-align: right">0</td>
                                <td style="text-align: right">0</td>
                                <td style="text-align: right">0</td>
                                <td style="text-align: right">0</td>
                                <td style="text-align: right">0</td>
                                <td style="text-align: right">0</td>
                                <td style="text-align: right">0</td>
                                <td style="text-align: right">0</td>
                                <td style="text-align: right">0</td>
                                <td style="text-align: right">0</td>
                                <td style="text-align: right">0</td>
                                <td style="text-align: right">0</td>
                                <td style="text-align: right">0</td>
                                <td style="text-align: right">0</td>
                            </tr>
                            <?php
                            foreach ($dataRek['detail'] as $detailRek){
                                ?>
                                <tr>
                                    <td style="text-align: right"><?php echo $detailRek['kode'] ?></td>
                                    <td><?php echo $detailRek['nama'] ?></td>
                                    <td style="text-align: right"><?php echo $detailRek['saldo_rj'] ?></td>
                                    <td style="text-align: right"><?php echo $detailRek['saldo_ri'] ?></td>
                                    <td style="text-align: right"><?php echo $detailRek['saldo_rd'] ?></td>
                                    <td style="text-align: right"><?php echo $detailRek['saldo_vk'] ?></td>
                                    <td style="text-align: right"><?php echo $detailRek['saldo_pi'] ?></td>
                                    <td style="text-align: right"><?php echo $detailRek['saldo_hd'] ?></td>
                                    <td style="text-align: right"><?php echo $detailRek['saldo_fisioterpi'] ?></td>
                                    <td style="text-align: right"><?php echo $detailRek['saldo_mcu'] ?></td>
                                    <td style="text-align: right"><?php echo $detailRek['saldo_lab'] ?></td>
                                    <td style="text-align: right"><?php echo $detailRek['saldo_rad'] ?></td>
                                    <td style="text-align: right"><?php echo $detailRek['saldo_ibs'] ?></td>
                                    <td style="text-align: right"><?php echo $detailRek['saldo_pemulasaran'] ?></td>
                                    <td style="text-align: right"><?php echo $detailRek['saldo_bankdrh'] ?></td>
                                    <td style="text-align: right"><?php echo $detailRek['saldo_apotek'] ?></td>
                                    <td style="text-align: right"><?php echo $detailRek['totalrevenue'] ?></td>
                                </tr>
                                <?php
                            }
                        }
                    }
                }else{
                    ?>
                     <tr> 
                         <td colspan="20">Data tidak ditemukan.</td>
                     </tr>
                    <?php
                }
            ?>
        </tbody>
    </table>
</div>
