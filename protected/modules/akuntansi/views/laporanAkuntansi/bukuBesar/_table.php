<?php
//set_time_limit(0);
//ini_set("memory_limit","-1");
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/prinoutTable.css');


$thead = true;
$tableClass = 'tabel-akun';
$table = 'ext.bootstrap.widgets.HeaderGroupGridView';
$sort = true;
if (isset($caraPrint)) {
    $tableClass = 'tabel-akun';

    if ($caraPrint == 'PDF') {
        $thead = false;
        if ($caraPrint == 'PDF') {
            $table = 'ext.bootstrap.widgets.BootGroupGridViewPDF';
        }

        echo "
        <style>
            .border th, .border td{
                border:1px solid #000;
            }
            .table thead:first-child{
                border-top:1px solid #000;        
            }

            thead th{
                background:none;
                color:#333;
            }

            .border {
                box-shadow:none;
                border-spacing:0px;
                padding:0px;
            }

            .table tbody tr:hover td, .table tbody tr:hover th {
                background-color: none;
            }
        </style>";

        echo "<style>
                .tableRincian thead, th{
                    border: 1px #000 solid;
                }
                 .tableRincian tbody, td{
                    border: 1px #000 solid;
                }
            </style>";
        $tableClass = 'table border';
    }

    $data = $model->searchTable2();
    if ($caraPrint == "EXCEL") {
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
    }
} else {
    $data = $model->searchTable2();
    $template = "{summary}\n{items}\n{pager}";
}


$crdat = new CDbCriteria();
if(!empty($model->rekening5_id)){
    $crdat->addCondition('rekening5_id = '.$model->rekening5_id);
}
$crdat->addCondition('rekening5_aktif = true');
$crdat->order = 'kdrekening5';

$dat = Rekening5M::model()->findAll($crdat);

$com = Yii::app()->db->createCommand(
    "select distinct on (t.rekening5_id) t.rekening5_id, r.rekening5_nb, perideawal, t.saldoawal_id, r.tiperekening_id, "
    . "sum(t.jmlsaldoawald) as jmlsaldoawald, sum(t.jmlsaldoawalk) as jmlsaldoawalk, sum(t.jmlsaldoakhird) as jmlsaldoakhird, sum(t.jmlsaldoakhirk) as jmlsaldoakhirk "
    . "from saldoawal_t t join rekening5_m r on r.rekening5_id = t.rekening5_id "
    . "join rekperiod_m rkp on rkp.rekperiod_id = t.rekperiod_id "
    . "where rkp.perideawal::date between '" . $model->tgl_awal . "'::date and '" . $model->tgl_akhir . "'::date "
    . "or rkp.sampaidgn::date between '" . $model->tgl_awal . "'::date and '" . $model->tgl_akhir . "'::date "
    . "group by t.rekening5_id, t.rekening5_id, r.rekening5_nb, perideawal, t.saldoawal_id, r.tiperekening_id "
    . "order by t.rekening5_id desc"
)->queryAll();


$com_saldo_awal = array();

$dat_saldo_awal = array();


foreach ($com as $item) {
    $sadebit = 0;
    $sakredit = 0;
    $skdebit = 0;
    $skkredit = 0;

    $com_saldo_awal[$item['rekening5_id']] = $item['perideawal'];

    if($item['rekening5_nb'] == 'D'){
        $sadebit = $item['jmlsaldoawald'];
        $sakredit = (0 - $item['jmlsaldoawalk']);

        $skdebit = $item['jmlsaldoakhird'];
        $skkredit = (0 - $item['jmlsaldoakhirk']);
    }else{
        $sadebit = (0 - $item['jmlsaldoawald']);
        $sakredit = $item['jmlsaldoawalk'];

        $skdebit = (0 - $item['jmlsaldoakhird']);
        $skkredit = $item['jmlsaldoakhirk'];
    }

    $dat_saldo_awal[$item['rekening5_id']] = array(
        'saldoawal_id' => $item['saldoawal_id'],
        'saldo_awal_debit' => $sadebit,
        'saldo_awal_kredit' => $sakredit,
        'saldo_akhir_debit' => $skdebit,
        'saldo_akhir_kredit' => $skkredit
    );
}

$res = array();

$cnt = 0;
foreach ($dat as $rekening) {

    $sub = array(
        'nama' => $rekening->nmrekening5,
        'id' => $rekening->rekening5_id,
        'nb' => $rekening->rekening5_nb,
        'saldo_awal_debit' => 0,
        'saldo_awal_kredit' => 0,
        'saldo_akhir_debit' => 0,
        'saldo_akhir_kredit' => 0,
        'data' => array(),
    );

    if (!empty($dat_saldo_awal[$rekening->rekening5_id])) {

        $sub['saldo_awal_debit'] += $dat_saldo_awal[$rekening->rekening5_id]['saldo_awal_debit'];
        $sub['saldo_awal_kredit'] += $dat_saldo_awal[$rekening->rekening5_id]['saldo_awal_kredit'];

        $sub['saldo_akhir_debit'] += $dat_saldo_awal[$rekening->rekening5_id]['saldo_akhir_debit'];
        $sub['saldo_akhir_kredit'] += $dat_saldo_awal[$rekening->rekening5_id]['saldo_akhir_kredit'];

    } else {

        $base_saldo_awal_lama = Yii::app()->db->createCommand(
            "select t.rekening5_id, r.rekening5_nb, "
            . "sum(sl.jmlsaldoawald) as jmlsaldoawald, sum(sl.jmlsaldoawalk) as jmlsaldoawalk, sum(sl.jmlsaldoakhird) as jmlsaldoakhird, sum(sl.jmlsaldoakhirk) as jmlsaldoakhirk "
            . "from protolaporanbukubesar_v t join rekening5_m r on r.rekening5_id = t.rekening5_id "
            . "join periodeposting_m pr on pr.periodeposting_id = t.periodeposting_id "
            . "join rekperiod_m rkp on rkp.rekperiod_id = pr.rekperiode_id "
            . "join saldoawal_t sl on sl.rekening5_id = r.rekening5_id and sl.rekperiod_id = rkp.rekperiod_id "
            . "where t.tglbukubesar::date < '" . $model->tgl_awal . "'::date "
            . "and t.rekening5_id = " . $rekening->rekening5_id . " "
            . "and r.tiperekening_id <> 5 "
            . "group by t.rekening5_id, r.rekening5_nb "
            . "order by t.rekening5_id"
        )->queryRow();

        if (!empty($base_saldo_awal_lama)) {
            $sadebit_lama = 0;
            $sakredit_lama = 0;

            $skdebit_lama = 0;
            $skkredit_lama = 0;

            if($base_saldo_awal_lama['rekening5_nb'] == 'D'){
                $sadebit_lama = $base_saldo_awal_lama['jmlsaldoawald'];
                $sakredit_lama = (0 - $base_saldo_awal_lama['jmlsaldoawalk']);

                $skdebit_lama = $base_saldo_awal_lama['jmlsaldoakhird'];
                $skkredit_lama = (0 - $base_saldo_awal_lama['jmlsaldoakhirk']);
            }else{
                $sadebit_lama = (0 - $base_saldo_awal_lama['jmlsaldoawald']);
                $sakredit_lama = $base_saldo_awal_lama['jmlsaldoawalk'];

                $skdebit_lama = (0 - $base_saldo_awal_lama['jmlsaldoakhird']);
                $skkredit_lama = $base_saldo_awal_lama['jmlsaldoakhirk'];
            }

        }
    }

    if ($sub['saldo_awal_debit'] != 0 || $sub['saldo_awal_kredit'] != 0 || $sub['saldo_akhir_debit'] != 0 || $sub['saldo_akhir_kredit'] != 0) {
        $res[$rekening->kdrekening5] = $sub;
    }
}

$kel = array();
$data->pagination = false;


$ressaldoawal = array();  
foreach ($data->data as $item) {
    $sadebit = 0;
    $sakredit = 0;

    $sadebit_awal = 0;
    $sakredit_awal = 0;

    
    if (!empty($item['saldoawal_id'])) {
        $rek5 = Rekening5M::model()->findByPk($item['rekening5_id']);

        if($rek5->rekening5_nb == 'D'){
            $sadebit_awal = $item['saldodebit'];
            $sakredit_awal = (0 - $item['saldokredit']);
        }else{
            $sadebit_awal = (0 - $item['saldodebit']);
            $sakredit_awal = $item['saldokredit'];
        }

        $ressaldoawal[$item['kdrekening5']]['detail_saldoawal'][] = array(
            'saldodebit'=>$sadebit_awal,
            'saldokredit'=>$sakredit_awal,
            'uraian'=>$item['uraiantransaksi']
        );

        if (!empty($dat_saldo_awal[$item["rekening5_id"]])) {
            continue;
        }
    }

    if (empty($res[$item['kdrekening5']])) {
        $res[$item['kdrekening5']] = array(
            'nama' => $item["nmrekening5"],
            'id' => $item["rekening5_id"],
            'nb' => $item['saldonormal'],
            'saldo_awal_debit' => $sadebit,
            'saldo_awal_kredit' => $sakredit,
            'data' => array(),
            'tiperekening_id' => null,
        );
    }

    
    $res[$item['kdrekening5']]['tiperekening_id'] = $item['tiperekening_id'];
    
    if(!empty($res[$item['kdrekening5']]['data'][$item['kdrekening5'].'_'.date('dmY',strtotime($item['tglbukubesar'])).'_'.$item['noreferensi'].'_'.$item['uraiantransaksi']])){
        $res[$item['kdrekening5']]['data'][$item['kdrekening5'].'_'.date('dmY',strtotime($item['tglbukubesar'])).'_'.$item['noreferensi'].'_'.$item['uraiantransaksi']]['kdrekening5'] = $item['kdrekening5'];
        $res[$item['kdrekening5']]['data'][$item['kdrekening5'].'_'.date('dmY',strtotime($item['tglbukubesar'])).'_'.$item['noreferensi'].'_'.$item['uraiantransaksi']]['kdrekening5'] = $item['kdrekening5'];
        $res[$item['kdrekening5']]['data'][$item['kdrekening5'].'_'.date('dmY',strtotime($item['tglbukubesar'])).'_'.$item['noreferensi'].'_'.$item['uraiantransaksi']]['jeniskode'] = $item['jeniskode'];
        $res[$item['kdrekening5']]['data'][$item['kdrekening5'].'_'.date('dmY',strtotime($item['tglbukubesar'])).'_'.$item['noreferensi'].'_'.$item['uraiantransaksi']]['saldonormal'] = $item['saldonormal'];
        $res[$item['kdrekening5']]['data'][$item['kdrekening5'].'_'.date('dmY',strtotime($item['tglbukubesar'])).'_'.$item['noreferensi'].'_'.$item['uraiantransaksi']]['saldoawal_id'] = $item['saldoawal_id'];
        $res[$item['kdrekening5']]['data'][$item['kdrekening5'].'_'.date('dmY',strtotime($item['tglbukubesar'])).'_'.$item['noreferensi'].'_'.$item['uraiantransaksi']]['periodeposting_id'] = $item['periodeposting_id'];
        $res[$item['kdrekening5']]['data'][$item['kdrekening5'].'_'.date('dmY',strtotime($item['tglbukubesar'])).'_'.$item['noreferensi'].'_'.$item['uraiantransaksi']]['tglperiodeposting_akhir'] = $item['tglperiodeposting_akhir'];
        $res[$item['kdrekening5']]['data'][$item['kdrekening5'].'_'.date('dmY',strtotime($item['tglbukubesar'])).'_'.$item['noreferensi'].'_'.$item['uraiantransaksi']]['noreferensi'] = $item['noreferensi'];
        $res[$item['kdrekening5']]['data'][$item['kdrekening5'].'_'.date('dmY',strtotime($item['tglbukubesar'])).'_'.$item['noreferensi'].'_'.$item['uraiantransaksi']]['uraiantransaksi'] = $item['uraiantransaksi'];
        $res[$item['kdrekening5']]['data'][$item['kdrekening5'].'_'.date('dmY',strtotime($item['tglbukubesar'])).'_'.$item['noreferensi'].'_'.$item['uraiantransaksi']]['tglbuktijurnal'] = $item['tglbuktijurnal'];
        $res[$item['kdrekening5']]['data'][$item['kdrekening5'].'_'.date('dmY',strtotime($item['tglbukubesar'])).'_'.$item['noreferensi'].'_'.$item['uraiantransaksi']]['tglbukubesar'] = $item['tglbukubesar'];
        $res[$item['kdrekening5']]['data'][$item['kdrekening5'].'_'.date('dmY',strtotime($item['tglbukubesar'])).'_'.$item['noreferensi'].'_'.$item['uraiantransaksi']]['saldodebit'] += $item['saldodebit'];
        $res[$item['kdrekening5']]['data'][$item['kdrekening5'].'_'.date('dmY',strtotime($item['tglbukubesar'])).'_'.$item['noreferensi'].'_'.$item['uraiantransaksi']]['saldokredit'] += $item['saldokredit'];
    }   

    if(empty($res[$item['kdrekening5']]['data'][$item['kdrekening5'].'_'.date('dmY',strtotime($item['tglbukubesar'])).'_'.$item['noreferensi'].'_'.$item['uraiantransaksi']])){
        $res[$item['kdrekening5']]['data'][$item['kdrekening5'].'_'.date('dmY',strtotime($item['tglbukubesar'])).'_'.$item['noreferensi'].'_'.$item['uraiantransaksi']]['kdrekening5'] = $item['kdrekening5'];
        $res[$item['kdrekening5']]['data'][$item['kdrekening5'].'_'.date('dmY',strtotime($item['tglbukubesar'])).'_'.$item['noreferensi'].'_'.$item['uraiantransaksi']]['kdrekening5'] = $item['kdrekening5'];
        $res[$item['kdrekening5']]['data'][$item['kdrekening5'].'_'.date('dmY',strtotime($item['tglbukubesar'])).'_'.$item['noreferensi'].'_'.$item['uraiantransaksi']]['jeniskode'] = $item['jeniskode'];
        $res[$item['kdrekening5']]['data'][$item['kdrekening5'].'_'.date('dmY',strtotime($item['tglbukubesar'])).'_'.$item['noreferensi'].'_'.$item['uraiantransaksi']]['saldonormal'] = $item['saldonormal'];
        $res[$item['kdrekening5']]['data'][$item['kdrekening5'].'_'.date('dmY',strtotime($item['tglbukubesar'])).'_'.$item['noreferensi'].'_'.$item['uraiantransaksi']]['saldoawal_id'] = $item['saldoawal_id'];
        $res[$item['kdrekening5']]['data'][$item['kdrekening5'].'_'.date('dmY',strtotime($item['tglbukubesar'])).'_'.$item['noreferensi'].'_'.$item['uraiantransaksi']]['periodeposting_id'] = $item['periodeposting_id'];
        $res[$item['kdrekening5']]['data'][$item['kdrekening5'].'_'.date('dmY',strtotime($item['tglbukubesar'])).'_'.$item['noreferensi'].'_'.$item['uraiantransaksi']]['tglperiodeposting_akhir'] = $item['tglperiodeposting_akhir'];
        $res[$item['kdrekening5']]['data'][$item['kdrekening5'].'_'.date('dmY',strtotime($item['tglbukubesar'])).'_'.$item['noreferensi'].'_'.$item['uraiantransaksi']]['noreferensi'] = $item['noreferensi'];
        $res[$item['kdrekening5']]['data'][$item['kdrekening5'].'_'.date('dmY',strtotime($item['tglbukubesar'])).'_'.$item['noreferensi'].'_'.$item['uraiantransaksi']]['uraiantransaksi'] = $item['uraiantransaksi'];
        $res[$item['kdrekening5']]['data'][$item['kdrekening5'].'_'.date('dmY',strtotime($item['tglbukubesar'])).'_'.$item['noreferensi'].'_'.$item['uraiantransaksi']]['tglbuktijurnal'] = $item['tglbuktijurnal'];
        $res[$item['kdrekening5']]['data'][$item['kdrekening5'].'_'.date('dmY',strtotime($item['tglbukubesar'])).'_'.$item['noreferensi'].'_'.$item['uraiantransaksi']]['tglbukubesar'] = $item['tglbukubesar'];
        $res[$item['kdrekening5']]['data'][$item['kdrekening5'].'_'.date('dmY',strtotime($item['tglbukubesar'])).'_'.$item['noreferensi'].'_'.$item['uraiantransaksi']]['saldodebit'] = $item['saldodebit'];
        $res[$item['kdrekening5']]['data'][$item['kdrekening5'].'_'.date('dmY',strtotime($item['tglbukubesar'])).'_'.$item['noreferensi'].'_'.$item['uraiantransaksi']]['saldokredit'] = $item['saldokredit'];
    } 
}
ksort($res);
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
$totalsaldoawal = 0;
$totalsaldoakhir = 0;
foreach ($res as $kd => $item) :
    $rek5 = Rekening5M::model()->findByPk($item['id']);
    
    $saldoawal = null;
    $sdawald = '';
    $sdawalk = '';
    $totsaldo = 0;
    $tot_sldawal = 0;

    $sdawald = $item['saldo_awal_debit'];
    $sdawalk = $item['saldo_awal_kredit'];


    $totsaldo = $sdawald + $sdawalk;
    $totalsaldoawal = $totsaldo;
    ?>
    <table style="border-collapse: collapse" class="" width="100%">
        <tr class="lap-header-akun">
            <td style="text-align:left;width:100px;"><?php echo $kd; ?></td>
            <td width="20px;">&nbsp;</td>
            <td colspan="6" style="text-align:left;"><b><?php echo $item['nama']; ?></b></td>			
        </tr>
    </table>
    <table class="<?php echo $tableClass ?>" width="100%">					
        <thead>
            <tr>
                <th style="width:85px;"  align='left'>Tanggal</th>
                <th  style="width:40px;"   align='left'>Tp</th>
                <th  align='left' style="width:80px;">No. Ref.</th>
                <th align='left' style="padding-left:10px;">Keterangan</th>
                <th  style="width:55px;" >&nbsp;</th>
                <th align='right' style="text-align:right;width:100px;">Debit</th>
                <th align='right' style="text-align:right;width:100px;">Kredit</th>
                <th align='right' style="text-align:right;width:100px;">Saldo</th>
            </tr>	
        </thead>			
        <tbody>
            <?php //if ($rek5->tiperekening_id <> 5): ?>
            <tr>
                <td colspan="5" style="text-align:left;">Saldo Awal :</td>
                <td align='right' style="text-align:right;"><?php echo (($sdawald != '')) ? MyFormatter::formatNumberForPrint($sdawald, 2) : ''; ?></td><!--debit-->
                <td align='right' style="text-align:right;"><?php echo (($sdawalk != '')) ? MyFormatter::formatNumberForPrint($sdawalk, 2) : '' ?></td><!--kredit-->
                <td align='right' style="text-align:right;">
    <?php
    echo MyFormatter::formatNumberForPrint($totsaldo, 2, true);
    $tot_sldawal = $totalsaldoawal;
    ?>
                </td><!--saldottoal-->
            </tr>
            <?php
                // if(!empty($ressaldoawal[$kd]) && $ressaldoawal[$kd]['detail_saldoawal']){
                //     foreach($ressaldoawal[$kd]['detail_saldoawal'] as $detail_saldoawal){
                //         if($detail_saldoawal['saldodebit'] == 0 && $detail_saldoawal['saldokredit'] == 0){
                //             continue;
                //         }
                //         $tot_sldawal = ($detail_saldoawal['saldodebit'] + $detail_saldoawal['saldokredit']);
                //         $tot_sldawal = ($totalsaldoawal + $tot_sldawal);
                    ?>
                    <!-- <tr>
                            <td colspan="5" style="text-align:left;"><?php //echo $detail_saldoawal['uraian']; ?></td>
                            <td align='right' style="text-align:right;"><?php //echo (($detail_saldoawal['saldodebit'] != 0)) ? MyFormatter::formatNumberForPrint($detail_saldoawal['saldodebit'], 2) : ''; ?></td>
                            <td align='right' style="text-align:right;"><?php //echo (($detail_saldoawal['saldokredit'] != 0)) ? MyFormatter::formatNumberForPrint($detail_saldoawal['saldokredit'], 2) : '' ?></td>
                            <td align='right' style="text-align:right;">
                                <?php
                                //echo MyFormatter::formatNumberForPrint($tot_sldawal, 2, true);
                                ?>
                            </td>
                        </tr> -->
                    <?php
                    // }
                     ?>
                     <!-- <tr><td colspan="8" style="text-align:left; border-bottom: 1px solid black;"></td></tr> -->
                     <?php 
                // }
             ?>
            <?php //endif; ?>
    <?php
    
    $saldo = $tot_sldawal;
    $totalsaldoawal = $saldo;

    $subsaldo = 0;
    $psubsaldo = "0";
    $subdebit = 0;
    $subkredit = 0;
    $saldonormal = '';

 
    ksort($item['data']);
    foreach ($item['data'] as $item2):
        $tp = '';
        if (!empty($item2['jeniskode'])) {
            $tp = $item2['jeniskode'];
        }

            $saldonormal = $item2['saldonormal'];
            if ($item2['saldonormal'] == 'D') {
                $subsaldo += $item2["saldodebit"] - $item2["saldokredit"];
            } elseif ($item2['saldonormal'] == 'K') {
                $subsaldo += $item2["saldokredit"] - $item2["saldodebit"];
            } else {
                $subsaldo += $item2["saldodebit"] - $item2["saldokredit"];
            }

            $subdebit += $item2["saldodebit"];
            $subkredit += $item2["saldokredit"];

            if ($item2['saldonormal'] == 'D') {
                $saldo += $item2["saldodebit"] - $item2["saldokredit"];
            } elseif ($item2['saldonormal'] == 'K') {
                $saldo += $item2["saldokredit"] - $item2["saldodebit"];
            } else {
                $saldo += $item2["saldodebit"] - $item2["saldokredit"];
            }

            $psaldo = MyFormatter::formatNumberForPrint($saldo, 2);
            if ($saldo < 0) {
                $psaldo = "(" . MyFormatter::formatNumberForPrint(abs($saldo), 2) . ")";
            }

            $deb = MyFormatter::formatNumberForPrint($item2["saldodebit"], 2);
            if ($item2["saldodebit"] < 0) {
                $deb = "(" . MyFormatter::formatNumberForPrint(abs($item2["saldodebit"]), 2) . ")";
            } elseif ($item2["saldodebit"] == 0) {
                //$deb = 0;
            }

            $kre = MyFormatter::formatNumberForPrint($item2["saldokredit"], 2);
            if ($item2["saldokredit"] < 0) {
                $kre = "(" . MyFormatter::formatNumberForPrint(abs($item2["saldokredit"]), 2) . ")";
            } elseif ($item2["saldokredit"] == 0) {
                //$kre = 0;
            }
            ?>

                    <tr>
                        <td style="color:#333;vertical-align: top;"><?php
                    $tgl_posting = $item2["tglbuktijurnal"];
                    if (($tgl_posting == null) && !empty($item2["periodeposting_id"])) {
                        $tgl_posting = $item2['tglperiodeposting_akhir'];
                    }

                    echo date("d/m/Y", strtotime(MyFormatter::formatDateTimeForDb($item2['tglbukubesar'])));
                    ?></td>				
                        <td style="vertical-align: top;"><?php echo $tp; ?></td>
                        <td style="color:#333;vertical-align: top;"><?php echo $item2["noreferensi"]; ?></td>
                        <td style="color:#333;padding-left:10px;vertical-align: top;"><?php echo $item2["uraiantransaksi"]; ?></td>
                        <td></td>
                        <td align='right' style="color:#333;vertical-align: top;" class="num"><?php echo $deb; ?></td>
                        <td align='right' style="color:#333;vertical-align: top;" class="num"><?php echo $kre; ?></td>
                        <td align='right' style="color:#333;vertical-align: top;" class="num"><?php echo $psaldo; ?></td>
                    </tr>

            <?php
        // }
    endforeach;

    // $saldoakhir = $totsaldo + $subsaldo;
    $saldoakhir = $tot_sldawal + $subsaldo;
    
    $saldoakh = MyFormatter::formatNumberForPrint($saldoakhir, 2);
    if ($saldoakhir < 0) {
        $saldoakh = "(" . MyFormatter::formatNumberForPrint(abs($saldoakhir), 2) . ")";
    } elseif ($saldoakhir == 0) {
        //$subsaldo = 0;
    }

    // $saldoakh = MyFormatter::formatNumberForPrint($totalsaldoakhir, 2);
    // if ($totalsaldoakhir < 0) {
    //     $saldoakh = "(" . MyFormatter::formatNumberForPrint(abs($totalsaldoakhir), 2) . ")";
    // }

    

    $subsal = MyFormatter::formatNumberForPrint($subsaldo, 2);
    if ($subsaldo < 0) {
        $subsal = "(" . MyFormatter::formatNumberForPrint(abs($subsaldo), 2) . ")";
    } elseif ($subsaldo == 0) {
        //$subsaldo = 0;
    }

    $subkre = MyFormatter::formatNumberForPrint($subkredit, 2);
    if ($subkredit < 0) {
        $subkre = "(" . MyFormatter::formatNumberForPrint(abs($subkredit), 2) . ")";
    } elseif ($subkredit == 0) {
        //$subkredit = 0;
    }

    $subde = MyFormatter::formatNumberForPrint($subdebit, 2);
    if ($subdebit < 0) {
        $subde = "(" . MyFormatter::formatNumberForPrint(abs($subdebit), 2) . ")";
    } elseif ($subdebit == 0) {
        //$subdebit = 0;
    }

    /*
      $totsal = MyFormatter::formatNumberForPrint($totsaldo, 2);
      if ($totsaldo < 0){
      $totsal = "(".MyFormatter::formatNumberForPrint(abs($totsaldo), 2).")";
      }elseif ($totsaldo == 0){
      //$totsaldo = 0;
      }
     * 
     */
    ?>										

            <tr class="lap-bottom-akun">
                <td style="text-align:left;">Saldo Awal :</td>					
                <td colspan="2"  style="text-align:right;"> <?php echo MyFormatter::formatNumberForPrint($totalsaldoawal, 2, true); ?> </td>						
                <td>&nbsp;</td>
                <td style="text-align:left;">Total :</td>
                <td style="text-align:right;">
            <?php
            if ($subdebit != 0) {
                echo $subde;
            }
            ?>
                </td>
                <td style="text-align:right;">
    <?php
    if ($subkredit != 0) {
        echo $subkre;
    }
    ?>
                </td>
                <td></td>
            </tr>
            <tr class="lap-bottom-akun">
                <td style="text-align:left;">Saldo Akhir :</td>					
                <td colspan="2" style="text-align:right;"><?php echo $saldoakh; ?></td>
                <td>&nbsp;</td>						
                <td style="text-align:left;">Mutasi :</td>
                <td style="text-align:right;">
                    <?php
                    echo $subsal;
                    ?>
                </td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>			
    <br/>
                    <?php
                endforeach;
                ?>	