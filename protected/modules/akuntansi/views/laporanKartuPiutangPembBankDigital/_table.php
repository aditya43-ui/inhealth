<?php
//set_time_limit(0);
//ini_set("memory_limit","-1");
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/prinoutTable.css');

$thead = true;
$tableclass = 'tabel-akun tabel-akun-2';
//Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/prinout.css');
$table = 'ext.bootstrap.widgets.HeaderGroupGridView';
$sort = true;
$colorheader = 'lap-header-akun-2';
$bghead = '';
if (isset($caraPrint)) {
    $tableclass = 'tabel-akun tabel-akun-2';

    if ($caraPrint == 'PDF') {
        $thead = false;
        $tableclass = 'tabel-akun tabel-akun-2-print';
        $colorheader  = '';
        $bghead = 'background-color:#edeff2;';
    }

    $data = $model->searchTable();
    if ($caraPrint == "EXCEL") {
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
    }
} else {
    $data = $model->searchTable();
    $template = "{summary}\n{items}\n{pager}";
}

//var_dump($tableClass);
?>

<?php
//if(isset($caraPrint)){
$data->pagination = false;

$res = array();
$kel = array();

foreach ($data->data as $item) {
    $res[$item['jnspembayar_id']]['id'] = $item["jnspembayar_id"];
    $res[$item['jnspembayar_id']]['nama'] = $item["jnspembayar_nama"] . ' ' . $item["namabank"];
    $res[$item['jnspembayar_id']]['data'][$item['notransaksi']]['notransaksi'][] = $item->attributes;
}
// echo '<pre>';
// print_r($res);
// exit();
?>
<style>
    .head_rek td {
        font-weight: bold;
    }

    .num {
        text-align: right !important;
    }
</style>

<?php
$i = 1;
$totSeluruhD = 0;
$totSeluruhK = 0;
$totSeluruhS = 0;
foreach ($res as $kd => $item) :

?>

    <table class="<?php echo $tableclass ?>" width="100%">
        <thead>
            <tr>
                <td style="text-align:center;" colspan="13"><span class="lap-akun-r1" style="font-size:12px;"><b><?php echo $item['nama']; ?></b></span></td>
            </tr>
            <tr class='<?php echo $colorheader; ?>'>
                <th align='center' width='80px' style="<?php echo $bghead ?>">Tanggal Transaksi</th>
                <th align='center' width='250px' style='<?php echo $bghead ?>'>Jenis Transaksi</th>
                <th align='center' width='100px' style='<?php echo $bghead ?>'>No. Referensi</th>
                <th align='center' width='80px' style='<?php echo $bghead ?>'>Tgl. Jatuh Tempo</th>
                <th align='center' style="text-align:right;width:100px;<?php echo $bghead ?>">Debit</th>
                <th align='center' style="text-align:right;width:100px;<?php echo $bghead ?>">Kredit</th>
                <th align='center' style="text-align:right;width:100px;<?php echo $bghead ?>">Saldo</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $grandDebit = 0;
            $grandKredit = 0;
            $grandSaldo = 0;
            foreach ($item['data'] as $grup) {

                $notrans = '';
                $totKredit = 0;
                $totDebit = 0;
                $saldo = 0;
                $tempo = 1;
                foreach ($grup['notransaksi'] as $item2) :
                    //	$psaldo = MyFormatter::formatNumberForPrint($saldo, 2);
                    //	if ($saldo < 0){
                    //		$psaldo = "(".MyFormatter::formatNumberForPrint(abs($saldo), 2).")";
                    //	}

                    $deb = '';
                    $kre = '';
                    $totDebit += $item2["saldodebit"];
                    $totKredit += $item2["saldokredit"];

                    // if ($item2['debitkredit'] == 'K'){
                    // 	$kre = $item2['nilaitransaksi'];
                    //
                    // 	$totKredit += $kre;
                    //
                    // 	if ($kre < 0){
                    // 		$kre = "(".MyFormatter::formatNumberForPrint(abs($kre),2).")";
                    // 	}else{
                    // 		$kre = MyFormatter::formatNumberForPrint(($kre),2);
                    // 	}
                    //
                    //
                    //
                    // }elseif ($item2['debitkredit'] == 'D'){
                    // 	$deb = $item2['nilaitransaksi'];
                    //
                    // 	$totDebit += $deb;
                    //
                    // 	if ($deb < 0){
                    // 		$deb = "(".MyFormatter::formatNumberForPrint(abs($deb),2).")";
                    // 	}else{
                    // 		$deb = MyFormatter::formatNumberForPrint(($deb),2);
                    // 	}
                    //
                    $notrans = $item2['notransaksi'];
                    // }

            ?>

                    <tr>
                        <td style="color:#333;"><?php echo date('d/m/Y H:i:s', strtotime($item2["tglpembayaran"])); ?></td>
                        <td><?php echo $item2['jenistransaksi']; ?></td>
                        <td style="color:#333;"><?php echo ($item2["nopembayaran"]); ?></td>
                        <td style="color:#333;"><?php
                                                if (!empty($item2["tgljatuhtempo"])) {
                                                    echo date("d/m/Y H:i:s", strtotime($item2["tgljatuhtempo"]));
                                                }
                                                ?></td>
                        <td align='right' style="color:#333;"><?php echo MyFormatter::formatUang(($item2["saldodebit"]), 'Rp ', 2); ?></td>
                        <td align='right' style="color:#333;"><?php echo MyFormatter::formatUang(($item2["saldokredit"]), 'Rp ', 2); ?></td>
                        <td align='right' style="color:#333;"></td>
                    </tr>

                <?php
                    $tempo++;
                endforeach;
                $grandDebit += $totDebit;
                $grandKredit += $totKredit;
                // $saldo = $totDebit - $totKredit;
                // $grandDebit += $totDebit;
                // $grandKredit += $totKredit;
                //
                //
                // if ($totKredit < 0){
                // 	$totKredit = "(".MyFormatter::formatNumberForPrint(abs($totKredit),2).")";
                // }else{
                // 	$totKredit = MyFormatter::formatNumberForPrint(($totKredit),2);
                // }
                //
                // if ($totDebit < 0){
                // 	$totDebit = "(".MyFormatter::formatNumberForPrint(abs($totDebit),2).")";
                // }else{
                // 	$totDebit = MyFormatter::formatNumberForPrint(($totDebit),2);
                // }
                //
                // if ($saldo < 0){
                // 	$saldo = "(".MyFormatter::formatNumberForPrint(abs($saldo),2).")";
                // }else{
                // 	$saldo = MyFormatter::formatNumberForPrint(($saldo),2);
                // }
                ?>
                <tr>
                    <td style="color:#333;">&nbsp;</td>
                    <td style="color:#333;text-align:left;" colspan="3" class="border-sub-abu"><b>Saldo Piutang Pembayaran <?php echo $notrans; ?></b></td>
                    <td align='right' style="color:#333;" class="border-sub-abu"><b><?php echo MyFormatter::formatUang($totDebit, 'Rp ', 2); ?></b></td>
                    <td align='right' style="color:#333;" class="border-sub-abu"><b><?php echo MyFormatter::formatUang($totKredit, 'Rp ', 2); ?></b></td>
                    <td align='right' style="color:#333;" class="border-sub-abu"><b><?php echo MyFormatter::formatUang(0, 'Rp ', 2); ?></b></td>
                </tr>
                <tr>
                    <td colspan="7"></td>
                </tr>
            <?php
            }
            $grandSaldo = $grandDebit - $grandKredit;
            $totSeluruhD += $grandDebit;
            $totSeluruhK += $grandKredit;

            if ($grandDebit < 0) {
                $grandDebit = "(" . MyFormatter::formatUang(abs($grandDebit), 'Rp ', 2) . ")";
            } else {
                $grandDebit = MyFormatter::formatUang(($grandDebit), 'Rp ', 2);
            }

            if ($grandKredit < 0) {
                $grandKredit = "(" . MyFormatter::formatUang(abs($grandKredit), 'Rp ', 2) . ")";
            } else {
                $grandKredit = MyFormatter::formatUang(($grandKredit), 'Rp ', 2);
            }

            if ($grandSaldo < 0) {
                $grandSaldo = "(" . MyFormatter::formatUang(abs($grandSaldo), 'Rp ', 2) . ")";
            } else {
                $grandSaldo = MyFormatter::formatUang(($grandSaldo), 'Rp ', 2);
            }
            ?>

            <tr class="lap-bottom-akun-2">
                <td style="text-align:left;" colspan="4"><b>Saldo Piutang <?php echo $item['nama'] ?></td>
                <td style="text-align:right"><b><?php echo $grandDebit; ?></b></td>
                <td style="text-align:right"><b><?php echo $grandKredit; ?></b></td>
                <td style="text-align:right"><b><?php echo $grandSaldo; ?></b></td>
            </tr>

            <?php

            if (count((array)$res) == $i) {
                $totSeluruhS = $totSeluruhD - $totSeluruhK;

                if ($totSeluruhD < 0) {
                    $totSeluruhD = "(" . MyFormatter::formatUang(abs($totSeluruhD), 'Rp ', 2) . ")";
                } else {
                    $totSeluruhD = MyFormatter::formatUang(($totSeluruhD), 'Rp ', 2);
                }

                if ($totSeluruhK < 0) {
                    $totSeluruhK = "(" . MyFormatter::formatUang(abs($totSeluruhK), 'Rp ', 2) . ")";
                } else {
                    $totSeluruhK = MyFormatter::formatUang(($totSeluruhK), 'Rp ', 2);
                }

                if ($totSeluruhS < 0) {
                    $totSeluruhS = "(" . MyFormatter::formatUang(abs($totSeluruhS), 'Rp ', 2) . ")";
                } else {
                    $totSeluruhS = MyFormatter::formatUang(($totSeluruhS), 'Rp ', 2);
                }
            ?>
                <tr>
                    <td colspan="13"></td>
                </tr>
                <tr class="lap-bottom-akun-2">
                    <td style="text-align:left;" colspan="4"><b>Total Seluruh Jenis Pembayaran</b></td>
                    <td style="text-align:right"><b><?php echo $totSeluruhD; ?></b></td>
                    <td style="text-align:right"><b><?php echo $totSeluruhK; ?></b></td>
                    <td style="text-align:right"><b><?php echo $totSeluruhS; ?></b></td>
                </tr>
            <?php
            }

            ?>
        </tbody>

    </table>
<?php
    $i++;
endforeach;
?>