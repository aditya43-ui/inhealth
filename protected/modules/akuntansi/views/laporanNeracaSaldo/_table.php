<style>
    .num {
        text-align: right !important;
    }
    
    .row_total td {
        border-top: 1px solid black;
        font-weight: bold;
    }
</style>
<?php
//set_time_limit(0);
//ini_set("memory_limit","-1");
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/prinoutTable.css');

$paramrekening = "";
if(!empty($model->rekening5_id)){
   $paramrekening = ' and rekening5_id = '.$model->rekening5_id;
}

$data_bb = LaporanbukubesarV::model()->findAllByAttributes(array(
    ), array(
    'condition' => "saldoawal_id is null and tglbukubesar::date between '" . $model->tgl_awal . "'::date and '" . $model->tgl_akhir . "'::date ".$paramrekening,
    'order' => 'kdrekening5',
    ));

$thead = true;
$tableClass = 'tabel-akun';
//Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/prinout.css'); 
$table = 'ext.bootstrap.widgets.HeaderGroupGridView';
$sort = true;
if (isset($caraPrint)) {
    $tableClass = 'tabel-akun';

    if ($caraPrint == 'PDF') {
        $thead = false;
    }

    $data = $model->searchTable2();
    if ($caraPrint == "EXCEL")
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
} else {
    $data = $model->searchTable2();
    $template = "{summary}\n{items}\n{pager}";
}

$neraca_criteria = new CDbCriteria();
if(!empty($model->rekening5_id)){
    $neraca_criteria->addCondition('rekening5_id = '.$model->rekening5_id);
}
$neraca_criteria->addCondition('rekening5_aktif = true');
$neraca_criteria->order = 'kdrekening5';
$rekening_neraca = Rekening5M::model()->findAll($neraca_criteria);

// saldo awal pada tgl awal periode
$cr_saldoawal_tgl_awal = new CDbCriteria;
$cr_saldoawal_tgl_awal->addCondition('rekening5_id = :rekening5_id');
$cr_saldoawal_tgl_awal->addCondition("tglbukubesar::date between '".$model->tgl_awal."'::date and '".$model->tgl_akhir."'::date "
            . "and saldoawal_id is not null");


$cr_saldoawal = new CDbCriteria();
$cr_saldoawal->addCondition('rekening5_id = :rekening5_id');
$cr_saldoawal->addCondition('tglbukubesar < :tgl_awal and saldoawal_id is not null');
$cr_saldoawal->order = 'tglbukubesar desc';

$rekening_kriteria = new CDbCriteria();
$rekening_kriteria->addCondition('rekening5_id = :rekening5_id');
$rekening_kriteria->select = "sum(case when saldodebit is null then 0 else saldodebit end) as saldodebit, "
    . "sum(case when saldokredit is null then 0 else saldokredit end) as saldokredit";

$rekening_kriteria_old = clone $rekening_kriteria;
$rekening_kriteria_old->addCondition("tglbukubesar >= date_trunc('month', '".$model->tgl_awal."'::date - interval '1' month)");
	 $rekening_kriteria_old->addCondition("tglbukubesar < date_trunc('month', '".$model->tgl_akhir."'::date)");

$rekening_kriteria->addCondition("tglbukubesar::date between '".$model->tgl_awal."'::date and '".$model->tgl_akhir."'::date "
    . "and saldoawal_id is null");

$res = array();

$com = Yii::app()->db->createCommand(
    "select r.rekening5_id, r.rekening5_nb, 
    sum(t.jmlsaldoawald) as jmlsaldoawald, sum(t.jmlsaldoawalk) as jmlsaldoawalk, sum(t.jmlsaldoakhird) as jmlsaldoakhird, sum(t.jmlsaldoakhirk) as jmlsaldoakhirk 
    from saldoawal_t t join rekening5_m r on r.rekening5_id = t.rekening5_id 
    join rekperiod_m rkp on rkp.rekperiod_id = t.rekperiod_id 
    where (rkp.perideawal::date between '".$model->tgl_awal."'::date and '".$model->tgl_akhir."'::date
    or rkp.sampaidgn::date between '".$model->tgl_awal."'::date and '".$model->tgl_akhir."'::date) 
    group by r.rekening5_id, r.rekening5_nb"
)->queryAll();

$com_saldo_awal = array();

foreach ($com as $item) {
    $sadebit = $item['jmlsaldoawald'];
    $sakredit = $item['jmlsaldoawalk'];
    $skdebit = 0;
    $skkredit = 0;

    $dat_saldo_awal[$item['rekening5_id']] = array(
            'saldo_awal_debit' => $sadebit,
            'saldo_awal_kredit' => $sakredit,
    );
}

$rekcolumn = RekeningcolumnM::model()->findByAttributes(array('table_name'=>Params::REKENINGCOLUMN_TABLE_BUKUBESART,'column_name'=>Params::REKENINGCOLUMN_COLUMN_BUKUBESARLABARUGITAHUNBERJALAN));
$rekeninglabarugi_berjalan_id = ((!empty($rekcolumn)&&!empty($rekcolumn->rekening5_id)) ?$rekcolumn->rekening5_id : Params::REKENING5_ID_LABARUGI_BERJALAN);
$cnt = 0;
foreach ($rekening_neraca as $rekening) {

    $sub = array(
        'nama' => $rekening->nmrekening5,
        'id' => $rekening->rekening5_id,
        'nb' => $rekening->rekening5_nb,
        'saldo_awal' => 0,
        'saldo_debit' => 0,
        'saldo_kredit' => 0,
        'saldo_akhir' => 0,
    );

    $saldodebit = 0;
    $saldokredit = 0;

    if (!empty($dat_saldo_awal[$rekening->rekening5_id])) {
        
            if($rekening->rekening5_nb == 'D'){
                    $dat_saldo_awal[$rekening->rekening5_id]['saldo_awal_kredit'] = (0 - $dat_saldo_awal[$rekening->rekening5_id]['saldo_awal_kredit']);
            }else{
                $dat_saldo_awal[$rekening->rekening5_id]['saldo_awal_debit'] = (0 - $dat_saldo_awal[$rekening->rekening5_id]['saldo_awal_debit']);
            }
       
        $saldodebit += $dat_saldo_awal[$rekening->rekening5_id]['saldo_awal_debit'];
        $saldokredit += $dat_saldo_awal[$rekening->rekening5_id]['saldo_awal_kredit'];
    }

    $saldoawaldebit = $saldodebit;
    $saldoawalkredit = $saldokredit;
    
            if (in_array($rekening->rekening5_id, array($rekeninglabarugi_berjalan_id))) {
            continue;
        }
        $sub['saldo_awal'] = $saldoawaldebit + $saldoawalkredit;
    
    $res[$rekening->kdrekening5] = $sub;
    
}




$kel = array();


foreach ($data_bb as $item) {
    if (in_array($item->rekening5_id, array($rekeninglabarugi_berjalan_id))) {
        continue;
    }

    if (empty($res[$item['kdrekening5']])) {
        $res[$item['kdrekening5']] = array(
            'nama' => $item["nmrekening5"],
            'id' => $item->rekening5_id,
            'nb' => $item->saldonormal,
            'saldo_awal' => 0,
            'saldo_debit' => 0,
            'saldo_kredit' => 0,
            'saldo_akhir' => 0,
        );
    }
    

    $item->saldodebit = $item->saldodebit;
    $item->saldokredit = $item->saldokredit;

    if ($item->saldonormal == 'D') {
        $item->saldokredit = (0 - $item->saldokredit); 
    }else if ($item->saldonormal == 'K') {
        $item->saldodebit = (0 - $item->saldodebit); 
    }
    
    $res[$item['kdrekening5']]['saldo_debit'] += $item->saldodebit;
    $res[$item['kdrekening5']]['saldo_kredit'] += $item->saldokredit;
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

<table class="<?php echo $tableClass ?>" width="100%">					
    <thead>
        <tr>
            <th>No. Akun</th>
            <th>Nama Akun</th>
            <th style="text-align: right;">Saldo Awal</th>
            <th style="text-align: right;">Debit</th>
            <th style="text-align: right;">Kredit</th>
            <th style="text-align: right;">Saldo Akhir</th>
        </tr>	
    </thead>			
    <tbody>
        <?php
        
        $total_awal = 0;
        $total_akhir = 0;
        
        $total_debit = 0;
        $total_kredit = 0;
        
        foreach ($res as $kdrekening5 => $item):
            // if ($item['nb'] == 'D') {
            //     $item['saldo_kredit'] = (0 - $item['saldo_kredit']);
            // }else if ($item['nb'] == 'K') {
            //     $item['saldo_debit'] = (0 - $item['saldo_debit']);
            // }



            

            // $debit_nilai = MyFormatter::formatNumberForPrint($item['saldo_debit'], 2);
            // $kredit_nilai = MyFormatter::formatNumberForPrint($item['saldo_kredit'], 2);

            
           

            // $selisih = $item['saldo_debit'] - $item['saldo_kredit'];

            // if ($item['nb'] == 'D') {
            //     $selisih = $item['saldo_debit'] - $item['saldo_kredit'];

        
            // } elseif ($item['nb'] == 'K') {
            //     $selisih = $item['saldo_kredit'] - $item['saldo_debit'];

            // }

            
            // if ($selisih > 0) {
            //     $item['saldo_debit'] = $selisih;
            //     $item['saldo_kredit'] = 0;
            // } else {
            //     $item['saldo_kredit'] = abs($selisih);
            //     $item['saldo_debit'] = 0;
            // }
            
            if ($item['saldo_debit'] == 0 && $item['saldo_kredit'] == 0 && $item['saldo_awal'] == 0) {
                continue;
            }
            
            
            
            // $saldo_akhir = $item['saldo_awal'];
            // $saldo_selisih = $item['saldo_awal'] + $item['saldo_debit'] - $item['saldo_kredit'];;
            // $saldo_selisih = $item['saldo_awal'] + $item['saldo_debit'] - $item['saldo_kredit'];
            // $saldo_selisih = 0;

            // if ($item['nb'] == 'D') {
            //     $mutasisaldo = $item['saldo_debit'] - $item['saldo_kredit'];
            //     $saldo_selisih = ($item['saldo_awal'] - $mutasisaldo);
            // } else if ($item['nb'] == 'K') {
                $mutasisaldo  = $item['saldo_debit'] + $item['saldo_kredit'];
                $saldo_selisih = ($item['saldo_awal'] + $mutasisaldo);
            // }

            // $saldo_selisih = $item['saldo_awal'];
            // $saldo_selisih = $mutasisaldo;

            

            // if ($item['nb'] == 'D') {
                // $saldo_selisih = ($item['saldo_awal'] + $item['saldo_debit'] + $item['saldo_kredit']);
            // }else if ($item['nb'] == 'K') {
            //     $saldo_selisih = ($item['saldo_awal'] - $item['saldo_debit'] + $item['saldo_kredit']);
            // }
            // $saldo_selisih = ($item['saldo_awal'] + $item['saldo_debit'] + $item['saldo_kredit']);

            // $saldo_selisih = $item['saldo_awal'] + $selisih;
//            if ($item['nb'] == 'D') {
                // $saldo_akhir += $item['saldo_debit'] - $item['saldo_kredit'];
                $total_akhir += $saldo_selisih;
                $total_debit += (($item['saldo_debit'] < 0)? abs($item['saldo_debit']): $item['saldo_debit']);
                $total_kredit += (($item['saldo_kredit'] < 0)? abs($item['saldo_kredit']): $item['saldo_kredit']);
                $total_awal += $item['saldo_awal'];

//            } else {
//                $saldo_akhir += $item['saldo_kredit'] - $item['saldo_debit'];
//            }
            ?>
            <tr>
                <td><?php echo $kdrekening5; ?></td>
                <td><?php echo $item['nama']; ?></td>
                <td class="num"><?php echo MyFormatter::formatNumberForPrint($item['saldo_awal'], 2, true); ?></td>
                <td class="num"><?php echo MyFormatter::formatNumberForPrint($item['saldo_debit'], 2); ?></td>
                <td class="num"><?php echo MyFormatter::formatNumberForPrint($item['saldo_kredit'], 2); ?></td>
                <td class="num"><?php echo MyFormatter::formatNumberForPrint($saldo_selisih, 2, true); ?></td>

            </tr>
        <?php endforeach; ?>
       
            <tr class="row_total">
                <td colspan="2">TOTAL SALDO</td>
                <td class="num"><?php echo MyFormatter::formatNumberForPrint($total_awal, 2, true) ?></td>
                <td class="num"><?php echo MyFormatter::formatNumberForPrint($total_debit, 2) ?></td>
                <td class="num"><?php echo MyFormatter::formatNumberForPrint($total_kredit, 2) ?></td>
                <td class="num"><?php echo MyFormatter::formatNumberForPrint($total_akhir, 2, true) ?></td>
            </tr>
    </tbody>
</table>			