<style>
 @page {
/*        margin-top: 12mm;*/
    }
    
    @media print {
        #headers {
            position: fixed;
            top: 0;
        }
        
        body {                        
            display:table;
            table-layout:fixed;
/*            padding-top:4cm;
            padding-left: 1mm;*/
            height:auto;
			width:100%;
        }
    }

	.lap-akun-grandtotal{
		font-weight: bold !important;
		color: dodgerblue !important;
	}

	.lap-akun-r1, .lap-akun-r4, .lap-akun-subtotal{
		font-weight: bold !important;
		 color: dodgerblue !important;
	}

	.border-sub{
		font-weight: bold !important;
		 color: black !important;
		 border-bottom: 1px solid black !important;
	}

</style>

<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/prinoutTable.css');

Yii::app()->clientScript->registerScript('search', "
		$('.search-button').click(function(){
			$('.search-form').toggle();
			return false;
		});
		$('#searchLaporan').submit(function(){
            /*
			$('#Grafik').attr('src','').css('height','0px');
			$.fn.yiiGridView.update('tableLaporan', {
					data: $(this).serialize()
			});
            */
			return true;
		});
	");


$turunan1 = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
$turunan2 = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
$turunan3 = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
$turunan4 = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';

$dataArray = array();
$dataID = array();
$header = true;
$format = new MyFormatter();
$mergeTanggal = array();


$rekening5data = Rekening5M::model()->findAllByAttributes(array('rekening5_aktif'=>true,'tiperekening_id'=>4));

$rekeningFilter5 = array();
// $last = Yii::app()->user->getState('levelrekeninglast');
$last = 4;
if(!empty($rekening5data)){
	foreach($rekening5data as $rek){
		// echo 'sss '.Yii::app()->user->getState('levelrekeninglast');
		if($last == $rek->levelrek){
			$banch = array();
			// echo 'sss';
			$rekeningFilter5[$rek->rekening5_id] = buildTree($rek->rekening5_id, $banch); 
		}
	}
}

function buildTree($rek_id, $branch) {
    $rek = Rekening5M::model()->findByPk($rek_id);
    
    if(!empty($rek)){
        $branch['rek_'.$rek->levelrek]['rekening_id'] = $rek->rekening5_id;
        $branch['rek_'.$rek->levelrek]['rekening_nama'] = $rek->nmrekening5;
        $branch['rek_'.$rek->levelrek]['rekening_kode'] = $rek->kdrekening5;
				$branch['rek_'.$rek->levelrek]['rekening_nb'] = $rek->rekening5_nb;
				$branch['rek_'.$rek->levelrek]['kelrekening_id'] = $rek->kelrekening_id;

        if(!empty($rek->parent_id)){
            $branch = buildTree($rek->parent_id, $branch);
        }
    }
    return $branch;
}




foreach ($models AS $row => $data) {
	array_push($dataID, $data->periodeposting_id);
}
        
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

						$com = Yii::app()->db->createCommand(
							"select r.rekening5_id, r.rekening5_nb, 
							sum(t.jmlsaldoawald) as jmlsaldoawald, sum(t.jmlsaldoawalk) as jmlsaldoawalk, sum(t.jmlsaldoakhird) as jmlsaldoakhird, sum(t.jmlsaldoakhirk) as jmlsaldoakhirk 
							from saldoawal_t t join rekening5_m r on r.rekening5_id = t.rekening5_id 
							join rekperiod_m rkp on rkp.rekperiod_id = t.rekperiod_id 
							where (rkp.perideawal::date between '".$model->tgl_awal."'::date and '".$model->tgl_akhir."'::date
							or rkp.sampaidgn::date between '".$model->tgl_awal."'::date and '".$model->tgl_akhir."'::date) 
							group by r.rekening5_id, r.rekening5_nb"
					)->queryAll();
        
        
        $dat = array();
				$com_saldo_awal = array();

				foreach ($com as $item) {
					$sadebit = 0;
					$sakredit = 0;
					$skdebit = 0;
					$skkredit = 0;
			
					if($item['rekening5_nb'] == 'D'){
							$sadebit = $item['jmlsaldoawald'];
							$sakredit = (0 - $item['jmlsaldoawalk']);
					}else{
							$sadebit = (0 - $item['jmlsaldoawald']);
							$sakredit = $item['jmlsaldoawalk'];
					}
			
					$dat_saldo_awal[$item['rekening5_id']] = array(
							'saldo_awal_debit' => $sadebit,
							'saldo_awal_kredit' => $sakredit,
					);
			}

			
$dat = array();

$laporankeu = LaporankeuanganK::model()->findByAttributes(array('menu_url'=>$this->module->id . '/' . ucfirst(Yii::app()->controller->id) . '/' . Yii::app()->controller->action->id));

$rekaa = array();
if(!empty($laporankeu)){
	$levelRekLaporan = array(1, 2, 3, 4); //explode(',',$laporankeu->levelrek);
	if(!empty($levelRekLaporan)){
		sort($levelRekLaporan);

		foreach($rekeningFilter5 as $itemRek){
			$level1 = (!empty($levelRekLaporan[0])? $levelRekLaporan[0] : null);
            if(empty($level1)) continue;
            $level2 = (!empty($levelRekLaporan[1])? $levelRekLaporan[1] : null);
            if(empty($level2)) continue;
            $level4 = (!empty($levelRekLaporan[2])? $levelRekLaporan[2] : null);
            if(empty($level4)) continue;
			$level5 = (!empty($levelRekLaporan[3])? $levelRekLaporan[3] : null);
            if(empty($level5)) continue;

			$itemRekening = array();
			$itemRekening['rekening1_id'] = $itemRek['rek_'.$level1]['rekening_id'];
			$itemRekening['rekening1_kode'] = $itemRek['rek_'.$level1]['rekening_kode'];
			$itemRekening['rekening1_nama'] = $itemRek['rek_'.$level1]['rekening_nama'];
			$itemRekening['rekening1_nb'] = $itemRek['rek_'.$level1]['rekening_nb'];
			$itemRekening['kelrekening1_id'] = $itemRek['rek_'.$level1]['kelrekening_id'];

			$itemRekening['rekening2_id'] = $itemRek['rek_'.$level2]['rekening_id'];
			$itemRekening['rekening2_kode'] = $itemRek['rek_'.$level2]['rekening_kode'];
			$itemRekening['rekening2_nama'] = $itemRek['rek_'.$level2]['rekening_nama'];
			$itemRekening['rekening2_nb'] = $itemRek['rek_'.$level2]['rekening_nb'];
			$itemRekening['kelrekening2_id'] = $itemRek['rek_'.$level1]['kelrekening_id'];

			$itemRekening['rekening4_id'] = $itemRek['rek_'.$level4]['rekening_id'];
			$itemRekening['rekening4_kode'] = $itemRek['rek_'.$level4]['rekening_kode'];
			$itemRekening['rekening4_nama'] = $itemRek['rek_'.$level4]['rekening_nama'];
			$itemRekening['rekening4_nb'] = $itemRek['rek_'.$level4]['rekening_nb'];

			$itemRekening['rekening5_id'] = $itemRek['rek_'.$level5]['rekening_id'];
			$itemRekening['rekening5_kode'] = $itemRek['rek_'.$level5]['rekening_kode'];
			$itemRekening['rekening5_nama'] = $itemRek['rek_'.$level5]['rekening_nama'];
			$itemRekening['rekening5_nb'] = $itemRek['rek_'.$level5]['rekening_nb'];

			$itemRekening['saldodebit'] = 0;
			$itemRekening['saldokredit'] = 0;


			$rekening_kriteria->params = array(
				':rekening5_id'=>$itemRekening['rekening5_id'],
			);

			$rekening_data = LaporanbukubesarV::model()->find($rekening_kriteria);

			if($itemRekening['rekening5_nb'] == 'D'){
				$rekening_data->saldokredit = (0 - $rekening_data->saldokredit);
			}else if($itemRekening['rekening5_nb'] == 'K'){
				$rekening_data->saldodebit = (0 - $rekening_data->saldodebit);
			}

			$itemRekening['saldodebit'] += $rekening_data->saldodebit;
			$itemRekening['saldokredit'] += $rekening_data->saldokredit;

			if (!empty($dat_saldo_awal[$itemRekening['rekening5_id']])) {
				$itemRekening['saldodebit'] += $dat_saldo_awal[$itemRekening['rekening5_id']]['saldo_awal_debit'];
				$itemRekening['saldokredit'] += $dat_saldo_awal[$itemRekening['rekening5_id']]['saldo_awal_kredit'];

			}

			$dat[] = $itemRekening;

		}
	}
}

// var_dump($dat); die;

foreach ($dat as $item) {
	$saldo = $item['saldodebit'] + $item['saldokredit'];
	$tipe = $item['rekening1_id'];
	

	if (empty($detail[$tipe]['det'][$item['rekening4_id']])) {
		$detail[$tipe]['det'][$item['rekening4_id']] = array(
		'nama'=> ucwords(strtolower($item['rekening4_nama'])),
		'kode'=>$item['rekening4_kode'],
		'total' => 0,
		'det'=>array(),
		);
	}

	if (empty($detail[$tipe]['det'][$item['rekening4_id']]['det'][$item['rekening5_id']])) {
		$detail[$tipe]['det'][$item['rekening4_id']]['det'][$item['rekening5_id']] = array(
		'nama'=>ucwords(strtolower($item['rekening5_nama'])),
		'kode'=>$item['rekening5_kode'],
		'total'=>0,
		);
	}

	$detail[$tipe]['det'][$item['rekening4_id']]['det'][$item['rekening5_id']]['total'] += $saldo;
	$detail[$tipe]['det'][$item['rekening4_id']]['total'] += $saldo;
	if (!empty($detail[$tipe]['total'])){
		$detail[$tipe]['total'] += $saldo;			
	}else{
		$detail[$tipe]['total'] = $saldo;			
	}
		$detail[$tipe]['nama'] = ucwords(strtolower($item['rekening1_nama']));
		$detail[$tipe]['id'] = $item['rekening1_id'];
	}

?>



<?php
if (isset($caraPrint)) {
	$style = "";
	$segmen_1 = isset($segmen[0]) ? $segmen[0] : null;
	$segmen_2 = isset($segmen[1]) ? $segmen[1] : null;
	$segmen_3 = isset($segmen[2]) ? $segmen[2] : null;
	$segmen_4 = isset($segmen[3]) ? $segmen[3] : null;
	$segmen_5 = isset($segmen[4]) ? $segmen[4] : null;
	$template = "{items}";
	$sort = false;
	if ($caraPrint == "EXCEL")
		$table = 'ext.bootstrap.widgets.BootExcelGridView';
} else {
	$segmen = '';
}

$table = "table table-striped table-bordered table-condensed";
if (isset($caraPrint)){
		$layout = '';
		$table = 'table table-condensed';
        $template = "{items}";
        $sort = false;
} else{
		$layout = 'max-width:1250px;overflow-x:scroll;';
}

?>

<?php if (isset($_GET['caraPrint'])): 	
	
	if ($_GET['caraPrint'] == 'EXCEL'){
		echo $this->renderPartial('_tableBaruPrint', array('detail'=>$detail, 'table'=>$table, 'caraPrint'=>$_GET['caraPrint'], 'turunan1'=>$turunan1, 'turunan2'=>$turunan2, 'turunan3'=>$turunan3,'turunan4'=>$turunan4), true);
	}else{
		echo $this->renderPartial('_tableBaruPrint', array('detail'=>$detail, 'table'=>$table, 'caraPrint'=>$_GET['caraPrint'], 'turunan1'=>$turunan1, 'turunan2'=>$turunan2, 'turunan3'=>$turunan3,'turunan4'=>$turunan4), true);
	}
else :

if (!empty($detail)){

	// var_dump($detail);

	?>


<table class="tabel-akun">	
    <tbody>
		<?php 
			$a=1; 
			$totModal = 0;
			foreach ($detail as $rek1){  //turunun rekening 1 
			$tot1 = MyFormatter::formatNumberForPrint($rek1['total'],2);
			if ($rek1['total'] < 0){
				$tot1 = "(".MyFormatter::formatNumberForPrint(abs($rek1['total']),2).")";
			}	
			
			
			
			if ($rek1['id'] != 1){
				$totModal += $rek1['total'];
			}
		?>
				<tr>
					<td><span class="lap-akun-r1"><?php echo (($a==1)?'':$turunan1).$rek1['nama'] ?></span></td>
					<td></td>
					<td style='width:10px;'>&nbsp;</td>
					<td style='width:120px;'></td>
				</tr>		
				<?php 
						foreach ($rek1['det'] as $rek4){ //turunan rekening 4 
                            
                            if ($rek4['total'] == 0) {
                                continue;
                            }
                            
							$tot4 = MyFormatter::formatNumberForPrint($rek4['total'],2);
							if ($rek4['total'] < 0){
								$tot4 = "(".MyFormatter::formatNumberForPrint(abs($rek4['total']),2).")";
							}	
				?>
							<tr>
								<td><font class="lap-akun-r4"><?php echo $turunan2.$rek4['nama']; ?></font></td>
								<td></td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
							</tr>
							<?php 
								foreach ($rek4['det'] as $rek5){ //turuenan rekneing 5 
                                    
									if ($rek5['total'] == 0) {
											continue;
									}
                                    
								$tot5 = MyFormatter::formatNumberForPrint($rek5['total'],2);
								if ($rek5['total'] < 0){
									$tot5 = "(".MyFormatter::formatNumberForPrint(abs($rek5['total']),2).")";
								}								
							?>
								<tr>
									<td><font class="lap-akun-det"><?php echo $turunan3.$rek5['kode'].' '.$rek5['nama']; ?></font></td>
									<td></td>
									<td>&nbsp;</td>
									<td style="text-align: right;"><?php echo $tot5; ?></td>
								</tr>
							<?php } ?>
							<tr>
								<td><span class="lap-akun-subtotal"><?php echo $turunan3.'Total '.$rek4['nama']; ?></span></td>
								<td></td>
								<td>&nbsp;</td>
								<td class="border-sub" style="text-align:right;"><font class="lap-akun-subtotal"><?php echo $tot4; ?></font></td>
							</tr>
				<?php } ?>
				<tr>
					<td><font class="lap-akun-r1"><?php echo 'Total '.$rek1['nama'] ?></font></td>
					<td></td>
					<td class="border-sub">&nbsp;</td>
					<td class="border-sub" style="text-align:right;"><font class="lap-akun-r1"><?php echo $tot1; ?></font></td>
				</tr>					
		<?php $a++; } 
			$grand = MyFormatter::formatNumberForPrint($totModal,2);
			if ($totModal < 0){
				$grand = "(".MyFormatter::formatNumberForPrint(abs($totModal),2).")";
			}	
		?>
				<tr>
					<td><font class="lap-akun-grandtotal"><?php echo 'Total Kewajiban dan Modal' ?></font></td>
					<td></td>
					<td class="border-sub">&nbsp;</td>
					<td class="border-sub" style="text-align:right;"><font class="lap-akun-grandtotal"><?php echo $grand; ?></font></td>
				</tr>	
	</tbody>
</table>


	<?php } endif; ?>
