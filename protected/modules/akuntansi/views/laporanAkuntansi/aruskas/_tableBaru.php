<style>
    .row_foot td {
        color: maroon;
        font-weight: bold;
    }

    .row_subfoot td {
        font-weight: bold;
    }
</style>

<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/prinoutTable.css');

Yii::app()->clientScript->registerScript('search', "
		$('.search-button').click(function(){
			$('.search-form').toggle();
			return false;
		});
		//$('#searchLaporan').submit(function(){
			//$('#Grafik').attr('src','').css('height','0px');
			//$.fn.yiiGridView.update('tableLaporan', {
			//		data: $(this).serialize()
			//});
			//return false;
		//});
	");
?>
<?php
$model->tgl_awal = $model->tgl_awal ? MyFormatter::formatDateTimeForDb($model->tgl_awal) : date('Y-m-d');
$model->tgl_akhir = $model->tgl_akhir ?  MyFormatter::formatDateTimeForDb($model->tgl_akhir) : date('Y-m-d');

$spasi = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
$spasi2 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
$spasi3 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";

$table = 'ext.bootstrap.widgets.HeaderGroupGridView';
$sort = true;
$imp = ' !important ';
if (isset($caraPrint)) {
    $template = "{items}";
    $sort = false;
    if ($caraPrint == "EXCEL") {
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
    }
    if ($caraPrint == "PDF") {
        $imp = "";
    }
} else {
}
$criteria = new CDbCriteria;
$periodeposting_id = '';
$ruangan_id = '';
if (!empty($_GET['AKLaporanaruskasV']['periodeposting_id']) || $model->periodeposting_id) {
    $periodeposting_id = (isset($_GET['AKLaporanaruskasV']['periodeposting_id']) ? $_GET['AKLaporanaruskasV']['periodeposting_id'] : (isset($model->periodeposting_id) ? $model->periodeposting_id : null));
    $criteria->addCondition('periodeposting_id = ' . $periodeposting_id);
}
if (!empty($_GET['AKLaporanaruskasV']['ruangan_id']) || $model->ruangan_id) {
    $ruangan_id = (isset($_GET['AKLaporanaruskasV']['ruangan_id']) ? $_GET['AKLaporanaruskasV']['ruangan_id'] : (isset($model->ruangan_id) ? $model->ruangan_id : null));
    $criteria->addCondition('ruangan_id = ' . $ruangan_id);
}

/*
    $modelLaporan = AKLaporanaruskasV::model()->find($criteria);
	if(count((array)$modelLaporan) <= 0){
		$modelLaporan = new AKLaporanaruskasV();
		$modelLaporan->periodeposting_id = $periodeposting_id;
		$modelLaporan->ruangan_id = $ruangan_id;
	}
     * 
     */

$kasawal = LaporanbukubesarV::model()->findByAttributes(array(
    //        'kdrekening5'=>array('111'),
    //        'periodeposting_id'=>$periodeposting_id,
), array(
    'condition' => "saldoawal_id is not null and (date(tglbukubesar) between '" . $model->tgl_awal . "' and '" . $model->tgl_akhir . "') ",
    'order' => 'kdrekening5',
    'group' => 'kdrekening5',
    'select' => " sum(saldodebit - saldokredit) as saldodebit",
));

$penyesuaian = LaporanbukubesarV::model()->findAllByAttributes(array(
    'kdrekening5' => array('115000'),
    //        'periodeposting_id'=>$periodeposting_id,
), array(
    'condition' => "saldoawal_id is null and (date(tglbukubesar) between '" . $model->tgl_awal . "' and '" . $model->tgl_akhir . "')",
    'order' => ' kdrekening5',
    'group' => ' kdrekening5, nourut, nmrekening5',
    'select' => " kdrekening5, nourut as rekening5_id, nmrekening5, sum(case when kdrekening5 = '115000' then (saldodebit - saldokredit) else (saldokredit - saldodebit) end) as saldodebit",
));

$investasi = LaporanbukubesarV::model()->findAllByAttributes(array(
    'kdrekening5' => array('113000'),
    //        'periodeposting_id'=>$periodeposting_id,
), array(
    'condition' => "saldoawal_id is null and (date(tglbukubesar) between '" . $model->tgl_awal . "' and '" . $model->tgl_akhir . "')",
    'order' => 'nmrekening5',
    'group' => ' nmrekening5',
    'select' => " nmrekening5, sum(saldokredit - saldodebit) as saldodebit",
));

$pendanaan = LaporanbukubesarV::model()->findAllByAttributes(array(
    //        'periodeposting_id'=>$periodeposting_id,
), array(
    'condition' => "saldoawal_id is null and (kdrekening5 in ('111000','112000')) and (date(tglbukubesar) between '" . $model->tgl_awal . "' and '" . $model->tgl_akhir . "')",
    // 'condition' => "saldoawal_id is null and (kdrekening5 in ('111000','112000') or kdrekening2 in ('110000')) and (date(tglbukubesar) between '" . $model->tgl_awal . "' and '" . $model->tgl_akhir . "')",
    'order' => ' kdrekening5 ',
    'select' => " kdrekening5, nourut as rekening5_id, nmrekening5, sum(saldokredit - saldodebit) as saldodebit",
    'group' => 'kdrekening5, nourut, nmrekening5',

));

$lain2 = LaporanbukubesarV::model()->findAllByAttributes(array(
    //        'kdrekening5'=>array('711'),
    //        'periodeposting_id'=>$periodeposting_id,
), array(
    'condition' => "saldoawal_id is null AND kdrekening5 in ('113000','115000','111000','112000') and (kdrekening5 in ('111102', '112102')) and (date(tglbukubesar) between '" . $model->tgl_awal . "' and '" . $model->tgl_akhir . "')",
    // 'condition' => "saldoawal_id is null AND kdrekening5 in ('113000','115000','111000','112000') AND kdrekening2 in ('110000') and (kdrekening5 in ('111102', '112102')) and (date(tglbukubesar) between '" . $model->tgl_awal . "' and '" . $model->tgl_akhir . "')",
    'order' => ' kdrekening5',
    'group' => ' kdrekening5, nourut, nmrekening5',
    'select' => " kdrekening5, nourut as rekening5_id, nmrekening5, sum(saldokredit - saldodebit) as saldodebit",
));

$crop = new CDbCriteria();
$crop->addBetweenCondition('date(tglbukubesar)', $model->tgl_awal, $model->tgl_akhir);
//    $crop->compare('periodeposting_id', $periodeposting_id);
$crop->addCondition("saldoawal_id is null and (kdrekening5 in ('111102', '112102'))");
$crop->order = 'kdrekening5';
$crop->select = 'kdrekening5, nmrekening5, sum(saldokredit - saldodebit) as saldodebit';
$crop->group = 'kdrekening5, nmrekening5';
$operasional = LaporanbukubesarV::model()->findAll($crop);


$modLaba = BukubesarT::model()->findByAttributes(array(
    'rekening2_id' => 14,
    //        'periodeposting_id'=>$periodeposting_id,
), array(
    'condition' => "saldoawal_id is null and (date(tglbukubesar) between '" . $model->tgl_awal . "' and '" . $model->tgl_akhir . "')",
));
$tot_laba = 0;
if (!empty($modLaba)) {
    $tot_laba = $modLaba->saldokredit - $modLaba->saldodebit;
}

$modPajak = BukubesarT::model()->findAllByAttributes(array(
    'rekening1_id' => 1,
), array(
    'condition' => 'saldoawal_id is null',
));

foreach ($modPajak as $item) {
    $tot_laba += $item->saldodebit - $item->saldokredit;
}

$greatTotal = 0;
?>

<div id="tableLaporan">

    <table class="tabel-akun">
        <tr>
            <td colspan="4">
                <span class="lap-akun-subtotal"><?php echo strtoupper("Arus Kas Dari Aktivitas Operasi"); ?></span>
            </td>
        </tr>
        <tr>
            <td><?php echo $spasi3 . strtoupper("Laporan sebelum pajak penghasilan badan"); ?></td>
            <td>&nbsp;</td>
            <td style="width:10px;">&nbsp;</td>
            <td style="width:50px;">&nbsp;</td>
            <td style="width:120px; text-align: right;">
                <?php
                $val = $tot_laba;
                if ($val < 0) $val = "(" . MyFormatter::formatNumberForPrint(abs($val), 2) . ")";
                else  $val = MyFormatter::formatNumberForPrint($val, 2);
                echo $val;

                ?>
            </td>
        </tr>
        <tr>
            <td colspan="4">
                <span class="lap-akun-subtotal"><?php echo strtoupper("Penyesuaian"); ?></span>
            </td>
        </tr>
        <?php foreach ($penyesuaian as $item) :
            if ($item->saldodebit == 0) continue;
            $tot_laba += -$item->saldodebit;
            $val = -$item->saldodebit;

            if ($val < 0) $val = "(" . MyFormatter::formatNumberForPrint(abs($val), 2) . ")";
            else  $val = MyFormatter::formatNumberForPrint($val, 2);

        ?>
            <tr>
                <td><?php echo $spasi3 . strtoupper($item->nmrekening5); ?></td>
                <td>&nbsp;</td>
                <td style="width:10px;">&nbsp;</td>
                <td style="width:50px;">&nbsp;</td>
                <td style="width:120px; text-align: right;">
                    <?php echo $val; ?>
                </td>
            </tr>

        <?php endforeach; ?>
        <tr class='row_foot'>
            <td><?php echo strtoupper("Kenaikan/Penurunan dari transaksi yang tidak mempengaruhi saldo kas"); ?></td>
            <td>&nbsp;</td>
            <td style="width:10px;">&nbsp;</td>
            <td style="width:50px;">&nbsp;</td>
            <td style="width:120px; text-align: right; border-top: 1px solid black;">
                <?php
                $val = $tot_laba;
                if ($val < 0) $val = "(" . MyFormatter::formatNumberForPrint(abs($val), 2) . ")";
                else  $val = MyFormatter::formatNumberForPrint($val, 2);
                echo $val;
                ?>
            </td>
        </tr>

        <!------------------- PERUBAHAN PADA MODAL KERJA ----------------------------->

        <tr>
            <td colspan="4">
                <span class="lap-akun-subtotal"><?php echo strtoupper("Perubahan Pada Modal Kerja"); ?></span>
            </td>
        </tr>

        <?php
        $stotal = 0;
        foreach ($operasional as $item) :
            if ($item->saldodebit == 0) continue;
            $tot_laba += $item->saldodebit;
            $stotal += $item->saldodebit;
            $val = $item->saldodebit;

            if ($val < 0) $val = "(" . MyFormatter::formatNumberForPrint(abs($val), 2) . ")";
            else  $val = MyFormatter::formatNumberForPrint($val, 2);

        ?>
            <tr>
                <td><?php echo $spasi3 . strtoupper($item->nmrekening5); ?></td>
                <td>&nbsp;</td>
                <td style="width:10px;">&nbsp;</td>
                <td style="width:50px;">&nbsp;</td>
                <td style="width:120px; text-align: right;">
                    <?php echo $val; ?>
                </td>
            </tr>

        <?php endforeach; ?>

        <tr class='row_subfoot'>
            <td><?php echo $spasi3 . "JUMLAH"; ?></td>
            <td>&nbsp;</td>
            <td style="width:10px;">&nbsp;</td>
            <td style="width:50px;">&nbsp;</td>
            <td style="width:120px; text-align: right; border-top: 1px solid black;">
                <?php
                $val = $stotal;
                if ($val < 0) $val = "(" . MyFormatter::formatNumberForPrint(abs($val), 2) . ")";
                else  $val = MyFormatter::formatNumberForPrint($val, 2);
                echo $val;
                ?>
            </td>
        </tr>

        <?php foreach ($lain2 as $item) :

            if ($item->saldodebit == 0) continue;
            $tot_laba += $item->saldodebit;
            $stotal += $item->saldodebit;
            $val = $item->saldodebit;

            if ($val < 0) $val = "(" . MyFormatter::formatNumberForPrint(abs($val), 2) . ")";
            else  $val = MyFormatter::formatNumberForPrint($val, 2);

        ?>

            <tr>
                <td><?php echo $spasi3 . strtoupper($item->nmrekening5); ?></td>
                <td>&nbsp;</td>
                <td style="width:10px;">&nbsp;</td>
                <td style="width:50px;">&nbsp;</td>
                <td style="width:120px; text-align: right;">
                    <?php echo $val; ?>
                </td>
            </tr>

        <?php endforeach; ?>

        <tr class='row_foot'>
            <td><?php echo strtoupper("Arus Kas Bersih yang dihasilkan dari aktivitas operasi"); ?></td>
            <td>&nbsp;</td>
            <td style="width:10px;">&nbsp;</td>
            <td style="width:50px;">&nbsp;</td>
            <td style="width:120px; text-align: right; border-top: 1px solid black;">
                <?php
                $val = $tot_laba;
                if ($val < 0) $val = "(" . MyFormatter::formatNumberForPrint(abs($val), 2) . ")";
                else  $val = MyFormatter::formatNumberForPrint($val, 2);
                echo $val;
                ?>
            </td>
        </tr>

        <!------------------------ ARUS KAS INVESTASI ---------------------------------->
        <tr>
            <td colspan="4">
                <span class="lap-akun-subtotal"><?php echo strtoupper("Arus kas dari Aktivitas Investasi"); ?></span>
            </td>
        </tr>

        <?php
        $stotal = 0;

        foreach ($investasi as $item) :

            if ($item->saldodebit == 0) continue;
            $tot_laba += $item->saldodebit;
            $stotal += $item->saldodebit;
            $val = $item->saldodebit;

            if ($val < 0) $val = "(" . MyFormatter::formatNumberForPrint(abs($val), 2) . ")";
            else  $val = MyFormatter::formatNumberForPrint($val, 2);

        ?>

            <tr>
                <td><?php echo $spasi3 . strtoupper($item->nmrekening5); ?></td>
                <td>&nbsp;</td>
                <td style="width:10px;">&nbsp;</td>
                <td style="width:50px;">&nbsp;</td>
                <td style="width:120px; text-align: right;">
                    <?php echo $val; ?>
                </td>
            </tr>

        <?php endforeach; ?>

        <tr class='row_foot'>
            <td><?php echo strtoupper("Arus Kas Bersih yang digunakan dari aktivitas investasi"); ?></td>
            <td>&nbsp;</td>
            <td style="width:10px;">&nbsp;</td>
            <td style="width:50px;">&nbsp;</td>
            <td style="width:120px; text-align: right; border-top: 1px solid black;">
                <?php
                $val = $stotal;
                if ($val < 0) $val = "(" . MyFormatter::formatNumberForPrint(abs($val), 2) . ")";
                else  $val = MyFormatter::formatNumberForPrint($val, 2);
                echo $val;
                ?>
            </td>
        </tr>

        <!----------------------- ARUS KAS PENDANAAN ----------------------------------->

        <tr>
            <td colspan="4">
                <span class="lap-akun-subtotal"><?php echo strtoupper("Arus kas dari Aktivitas Pendanaan"); ?></span>
            </td>
        </tr>

        <?php
        $stotal = 0;
        foreach ($pendanaan as $item) :

            if ($item->saldodebit == 0) continue;
            $tot_laba += $item->saldodebit;
            $stotal += $item->saldodebit;
            $val = $item->saldodebit;

            if ($val < 0) $val = "(" . MyFormatter::formatNumberForPrint(abs($val), 2) . ")";
            else  $val = MyFormatter::formatNumberForPrint($val, 2);

        ?>

            <tr>
                <td><?php echo $spasi3 . strtoupper($item->nmrekening5); ?></td>
                <td>&nbsp;</td>
                <td style="width:10px;">&nbsp;</td>
                <td style="width:50px;">&nbsp;</td>
                <td style="width:120px; text-align: right;">
                    <?php echo $val; ?>
                </td>
            </tr>

        <?php endforeach; ?>

        <tr class='row_foot'>
            <td><?php echo strtoupper("Arus Kas Bersih yang digunakan dari Aktivitas Pendanaan"); ?></td>
            <td>&nbsp;</td>
            <td style="width:10px;">&nbsp;</td>
            <td style="width:50px;">&nbsp;</td>
            <td style="width:120px; text-align: right; border-top: 1px solid black;">
                <?php
                $val = $stotal;
                if ($val < 0) $val = "(" . MyFormatter::formatNumberForPrint(abs($val), 2) . ")";
                else  $val = MyFormatter::formatNumberForPrint($val, 2);
                echo $val;
                ?>
            </td>
        </tr>

        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr class='row_foot'>
            <td><?php echo strtoupper(($tot_laba < 0 ? "Penurunan" : "Kenaikan") . " bersih pada kas"); ?></td>
            <td>&nbsp;</td>
            <td style="width:10px;">&nbsp;</td>
            <td style="width:50px;">&nbsp;</td>
            <td style="width:120px; text-align: right;">
                <?php
                $val = $tot_laba;
                if ($val < 0) $val = "(" . MyFormatter::formatNumberForPrint(abs($val), 2) . ")";
                else  $val = MyFormatter::formatNumberForPrint($val, 2);
                echo $val;
                ?>
            </td>
        </tr>

        <tr class='row_foot'>
            <td><?php echo strtoupper("Saldo kas Awal"); ?></td>
            <td>&nbsp;</td>
            <td style="width:10px;">&nbsp;</td>
            <td style="width:50px;">&nbsp;</td>
            <td style="width:120px; text-align: right;">
                <?php
                $nilaikasawal = empty($kasawal->saldodebit) ? 0 : $kasawal->saldodebit;
                $val = $nilaikasawal;
                if ($val < 0) $val = "(" . MyFormatter::formatNumberForPrint(abs($val), 2) . ")";
                else  $val = MyFormatter::formatNumberForPrint($val, 2);
                echo $val;
                ?>
            </td>
        </tr>

        <tr class='row_foot'>
            <td><?php echo strtoupper("Saldo kas Akhir"); ?></td>
            <td>&nbsp;</td>
            <td style="width:10px;">&nbsp;</td>
            <td style="width:50px;">&nbsp;</td>
            <td style="width:120px; text-align: right; border-top: 1px solid black;">
                <?php
                $val = $tot_laba + $nilaikasawal;
                if ($val < 0) $val = "(" . MyFormatter::formatNumberForPrint(abs($val), 2) . ")";
                else  $val = MyFormatter::formatNumberForPrint($val, 2);
                echo $val;
                ?>
            </td>
        </tr>

    </table>
</div>

    <?php /*
    <table class="tabel-akun">      	        
		<tr>
			<td colspan="4">
				<span class="lap-akun-subtotal">Aktivitas Operasi</span>
			</td>
		</tr>			
		<?php 
			$crOp = new CDbCriteria;			
			$crOp->join = " JOIN rekening5_m r5 ON r5.rekening5_id = t.rekening5_id ";
			$crOp->addCondition("t.kdrekening1 in ('2', '4', '5') or t.kdrekening2 in ('11')");
			$crOp->order = "t.kdrekening5";
			$crOp->group = "t.kdrekening5, t.nmrekening5, r5.rekening5_nb, t.nmrekening5, t.rekening4_id, t.rekening5_id";
			$crOp->select = $crOp->group.', sum(t.saldodebit) as saldodebit, sum(t.saldokredit) as saldokredit';
			if (empty($periodeposting_id)) $periodeposting_id = '0';
			$crOp->compare('t.periodeposting_id', $periodeposting_id);
			$op = LaporanaruskasV::model()->findAll($crOp);

			$granTotal = 0;
			$opDetail = array();
			foreach($op as $detOp){								
				$opDetail[$detOp->rekening4_id]['nama'] = $detOp->nmrekening5;
				$opDetail[$detOp->rekening4_id]['det'][$detOp->rekening5_id]['nama'] = $detOp->nmrekening5;
				$opDetail[$detOp->rekening4_id]['det'][$detOp->rekening5_id]['kode'] = $detOp->kdrekening5;
				$opDetail[$detOp->rekening4_id]['det'][$detOp->rekening5_id]['saldodebit'] = $detOp->saldodebit;
				$opDetail[$detOp->rekening4_id]['det'][$detOp->rekening5_id]['saldokredit'] = $detOp->saldokredit;
				$opDetail[$detOp->rekening4_id]['det'][$detOp->rekening5_id]['saldonormal'] = $detOp->rekening5_nb;
			}
			
			foreach ($opDetail as $rek4):				
				//if ($item->saldodebit == $item->saldokredit) continue;
		?>		
				<tr>
					<td><span class="lap-akun-r1"><?php echo $spasi3.$rek4['nama']; ?></td>
					<td>&nbsp;</td>
					<td style="width:10px;">&nbsp;</td>
					<td style="width:50px;">&nbsp;</td>
					<td style="width:120px;">&nbsp;</td>
				</tr>
		<?php
				$subTotal = 0;
				foreach($rek4['det'] as $rek5){					
					if ($rek5['saldonormal'] == 'D'){
						$saldototal = $rek5['saldodebit'] - $rek5['saldokredit'];
					}elseif ($rek5['saldonormal'] == 'K'){
						$saldototal = $rek5['saldokredit'] - $rek5['saldodebit'];
					}else{
						$saldototal = $rek5['saldodebit'] - $rek5['saldokredit'];
					}

					$granTotal += $saldototal;
					$greatTotal += $saldototal;
					$subTotal += $saldototal;
		?>
					<tr>
						<td><?php echo $spasi.$rek5['kode'].' '.$rek5['nama']; ?></td>
						<td style="width:50px;">&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td style='text-align:right;width:120px;'>
							<?php
								if ($saldototal < 0)
									echo "(".MyFormatter::formatNumberForPrint(abs($saldototal), 2).")";
								else
									echo MyFormatter::formatNumberForPrint($saldototal, 2);
							?>
						</td>
					</tr>
		
		<?php
				}
		?>
					<tr>
						<td><span class="lap-akun-r1"><?php echo $spasi.'Total '.$rek4['nama']; ?></td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td class="border-sub">&nbsp;</td>
						<td class="border-sub"><span class="lap-akun-r1"><?php 
								if($subTotal < 0){
									echo "(".MyFormatter::formatNumberForPrint(abs($subTotal), 2).")";
								}else{
									echo MyFormatter::formatNumberForPrint($subTotal, 2);
								}
						
						?></span></td>
					</tr>	
		<?php
		endforeach;
		?>
		
		<tr>
			<td style="text-align: left;"><span class="lap-akun-subtotal"><?php echo $spasi2; ?><b>Total Aktivitas Operasi </b></span></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td class="border-sub">&nbsp;</td>
			<td class="border-sub">&nbsp;<span class="lap-akun-subtotal"><b>
				<?php 
					if ($granTotal < 0){
						echo "(".MyFormatter::formatNumberForPrint(abs($granTotal), 2).")";
					}else{
						echo MyFormatter::formatNumberForPrint($granTotal, 2); 
					}
				?>
				</b></span></td>
		</tr>
        
        <tr><th colspan="5"></th></tr>        
            <tr>
				<td colspan="5">
					<span class="lap-akun-subtotal"><b>Aktivitas Investasi</b></span>
				</td>
			</tr>	
			<?php 
			$crOp = new CDbCriteria;
			$crOp->join = " JOIN rekening5_m r5 ON r5.rekening5_id = t.rekening5_id ";
			$crOp->addCondition("t.kdrekening2 in ('12', '13')");
			$crOp->order = "t.kdrekening5";
			$crOp->group = "t.kdrekening5, t.nmrekening5, r5.rekening5_nb, t.nmrekening5, t.rekening4_id, t.rekening5_id";
			$crOp->select = $crOp->group.', sum(t.saldodebit) as saldodebit, sum(t.saldokredit) as saldokredit';
			if (empty($periodeposting_id)) $periodeposting_id = '0';
			$crOp->compare('t.periodeposting_id', $periodeposting_id);
			$op = LaporanaruskasV::model()->findAll($crOp);
			
			$granTotal = 0;
			
			$opTotal = array();
			foreach($op as $detOp){								
				$opTotal[$detOp->rekening4_id]['nama'] = $detOp->nmrekening5;
				$opTotal[$detOp->rekening4_id]['det'][$detOp->rekening5_id]['nama'] = $detOp->nmrekening5;
				$opTotal[$detOp->rekening4_id]['det'][$detOp->rekening5_id]['kode'] = $detOp->kdrekening5;
				$opTotal[$detOp->rekening4_id]['det'][$detOp->rekening5_id]['saldodebit'] = $detOp->saldodebit;
				$opTotal[$detOp->rekening4_id]['det'][$detOp->rekening5_id]['saldokredit'] = $detOp->saldokredit;
				$opTotal[$detOp->rekening4_id]['det'][$detOp->rekening5_id]['saldonormal'] = $detOp->rekening5_nb;
			}
			
			foreach ($opTotal as $rek4):
			?>
				<tr>
					<td><span class="lap-akun-r1"><?php echo $spasi3.$rek4['nama']; ?></td>
					<td>&nbsp;</td>
					<td style="width:10px;">&nbsp;</td>
					<td style="width:50px;">&nbsp;</td>
					<td style="width:120px;">&nbsp;</td>
				</tr>
			<?php
				$subTotal = 0;
				foreach ($rek4['det'] as $rek5):								
					if ($rek5['saldonormal'] == 'D'){
						$saldototal = $rek5['saldodebit'] - $rek5['saldokredit'];
					}elseif ($rek5['saldonormal'] == 'K'){
						$saldototal = $rek5['saldokredit'] - $rek5['saldodebit'];
					}else{
						$saldototal = $rek5['saldodebit'] - $rek5['saldokredit'];
					}					
					$granTotal += $saldototal;
					$greatTotal += $saldototal;
					$subTotal += $saldototal;
			?>
					<tr>
						<td><?php echo $spasi.$rek5['kode'].' '.$rek5['nama']; ?></td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td></td>
						<td style='text-align:right;'>
							<?php
								if ($saldototal < 0)
									echo "(".MyFormatter::formatNumberForPrint(abs($saldototal), 2).")";
								else
									echo MyFormatter::formatNumberForPrint($saldototal, 2);
							?>
						</td>
					</tr>

			<?php
			endforeach;
			?>
					<tr>
						<td><span class="lap-akun-r1"><?php echo $spasi.'Total '.$rek4['nama']; ?></td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td class="border-sub">&nbsp;</td>
						<td class="border-sub"><span class="lap-akun-r1"><?php 
								if($subTotal < 0){
									echo "(".MyFormatter::formatNumberForPrint(abs($subTotal), 2).")";
								}else{
									echo MyFormatter::formatNumberForPrint($subTotal, 2);
								}
						
						?></span></td>
					</tr>	
					
			<?php
			endforeach;
			?>
            <tr>
               <td style="text-align: left;"><span class="lap-akun-subtotal"><?php echo $spasi2; ?><b>Total Aktivitas Investasi </b></span></td>
				<td>&nbsp;</td>
				<td></td>
				<td class="border-sub">&nbsp;</td>
                <td class='border-sub'><span class="lap-akun-subtotal"><b>
					<?php 
					if ($granTotal < 0)
						echo "(".MyFormatter::formatNumberForPrint(abs($granTotal), 2).")";
					else
						echo MyFormatter::formatNumberForPrint($granTotal, 2);
					
				?>
					</b></span></td>
            </tr>
			<tr><th colspan="5"></th></tr>        
            <tr>
				
				<td colspan="5">
					<span class="lap-akun-subtotal"><b>Aktivitas Pendanaan</b></span>
				</td>
			</tr>
			<?php 
			$crOp = new CDbCriteria;
			$crOp->join = " JOIN rekening5_m r5 ON r5.rekening5_id = t.rekening5_id ";
			$crOp->addCondition("t.kdrekening1 in ('3')");			
			$crOp->order = "t.kdrekening5";
			$crOp->group = "t.kdrekening5, t.nmrekening5, r5.rekening5_nb, t.nmrekening5, t.rekening4_id, t.rekening5_id";
			$crOp->select = $crOp->group.', sum(t.saldodebit) as saldodebit, sum(t.saldokredit) as saldokredit';
			if (empty($periodeposting_id)) $periodeposting_id = '0';
			$crOp->compare('t.periodeposting_id', $periodeposting_id);
			$op = LaporanaruskasV::model()->findAll($crOp);
			
			$granTotal = 0;
			
			$opDana = array();
			foreach($op as $detOp){								
				$opDana[$detOp->rekening4_id]['nama'] = $detOp->nmrekening5;
				$opDana[$detOp->rekening4_id]['det'][$detOp->rekening5_id]['nama'] = $detOp->nmrekening5;
				$opDana[$detOp->rekening4_id]['det'][$detOp->rekening5_id]['kode'] = $detOp->kdrekening5;
				$opDana[$detOp->rekening4_id]['det'][$detOp->rekening5_id]['saldodebit'] = $detOp->saldodebit;
				$opDana[$detOp->rekening4_id]['det'][$detOp->rekening5_id]['saldokredit'] = $detOp->saldokredit;
				$opDana[$detOp->rekening4_id]['det'][$detOp->rekening5_id]['saldonormal'] = $detOp->rekening5_nb;
			}
			
			foreach ($opDana as $rek4):
			?>
				<tr>
					<td><span class="lap-akun-r1"><?php echo $spasi3.$rek4['nama']; ?></td>
					<td>&nbsp;</td>
					<td style="width:10px;">&nbsp;</td>
					<td style="width:50px;">&nbsp;</td>
					<td style="width:120px;">&nbsp;</td>
				</tr>
			<?php
				
				foreach ($rek4['det'] as $rek5):
					if ($rek5['saldonormal'] == 'D'){
						$saldototal = $rek5['saldodebit'] - $rek5['saldokredit'];
					}elseif ($rek5['saldonormal'] == 'K'){
						$saldototal = $rek5['saldokredit'] - $rek5['saldodebit'];
					}else{
						$saldototal = $rek5['saldodebit'] - $rek5['saldokredit'];
					}					
					$granTotal += $saldototal;
					$greatTotal += $saldototal;
					$subTotal += $saldototal;
			?>
					<tr>
						<td><?php echo $spasi.$rek5['kode'].' '.$rek5['nama']; ?></td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td></td>
						<td style='text-align:right;'>
							<?php
								if ($saldototal < 0)
									echo "(".MyFormatter::formatNumberForPrint(abs($saldototal), 2).")";
								else
									echo MyFormatter::formatNumberForPrint($saldototal, 2);
								?></b></span>
						</td>
					</tr>

			<?php
			endforeach;
			?>
			
			<?php
			endforeach;
			?>
            <tr>
                <td style="text-align: left;"><span class="lap-akun-subtotal"><?php echo $spasi2; ?><b>Total Aktivitas Pendanaan</b></span></td>
				<td>&nbsp;</td>
				<td></td>
				<td class="border-sub">&nbsp;</td>
                <td class="border-sub"><span class="lap-akun-subtotal"><b>
					<?php 
					if ($granTotal < 0)
						echo "(".MyFormatter::formatNumberForPrint(abs($granTotal), 2).")";
					else
						echo MyFormatter::formatNumberForPrint($granTotal, 2);										
					?>
					</b></span></td>                
            </tr>
       <tr><th colspan="5"></th></tr>
        <tr>
			<td style="text-alignn:left;"><span class="lap-akun-subtotal"><?php echo $spasi2; ?><b>Total Keluar/Masuk Kas</b></span></td>
			<td></td>
			<td>&nbsp;</td>
			<td class='border-sub' style='text-align:left;'><span class="lap-akun-subtotal"><b>Rp</b></span></td>
			<td class='border-sub'>
				<span class="lap-akun-subtotal">
				<b>
				<?php 
				if ($greatTotal < 0)
					echo "(".MyFormatter::formatNumberForPrint(abs($greatTotal), 2).")";
				else
					echo MyFormatter::formatNumberForPrint($greatTotal, 2);
				
				?>
				</b></span></td>                    
		</tr>
	
		<tr>
			<td><span class="lap-akun-subtotal"><?php echo $spasi2 ?><b>Saldo Awal</b></span></td>
			<td></td>
			<td></td>
			<td class="border-sub" style='text-align:left;'><span class="lap-akun-subtotal"><b>Rp</b></span></td>
			<td class='border-sub'>
				<span class="lap-akun-subtotal">
				<b>
					<?php 
						$salAwal = $modelLaporan->getSaldoAwalPeriode($periodeposting_id, $ruangan_id);
						
						if ($salAwal < 0){
							echo "(".MyFormatter::formatNumberForPrint(abs($salAwal), 2).")";
						}else{
							echo MyFormatter::formatNumberForPrint($salAwal,2);
						}
					?>					
				</b></span></td>
		</tr>
		<?php //for($i=1;$i<=100;$i++){ ?>
		<tr>
			<td><?php echo $spasi2 ?><span class="lap-akun-subtotal"><b>Saldo Akhir</b></span></td>
			<td></td>
			<td></td>
			<td class="border-sub" style="text-align:left;"><span class="lap-akun-subtotal"><b>Rp</b></span></td>
			<td class="border-sub">
				<span class="lap-akun-subtotal">
				<b>
				<?php 
					$salAkhir = $modelLaporan->getSaldoAkhirPeriode($periodeposting_id, $ruangan_id);
						
						if ($salAkhir < 0){
							echo "(".MyFormatter::formatNumberForPrint(abs($salAkhir), 2).")";
						}else{
							echo MyFormatter::formatNumberForPrint($salAkhir,2) ;
						}
					
				?>
				</b></span></td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td></td>
			<td class="border-sub"></td>
			<td class="border-sub"><b>
				</td>
		</tr>
		<?php //} ?>
    </table>
     * 
     */ ?>