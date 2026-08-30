<style>
    .table td {
        padding: 3px !important;
    }
    
    .table .subhead td {
        font-weight: bold;
        color: dodgerblue;
    }
    
    .table thead tr th {
        border-bottom: 1px solid black !important;
        text-align: center;
    } 
    
    .table .tabfoot td {
        color: maroon;
        font-weight: bold;
        border-top: 1px solid black !important;
    }
</style>

<?php

$imp = ' !important';
if (isset($caraPrint)){
	if ($caraPrint == 'PDF'){
		$imp = '';
	}
}

Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/prinout.css');

    Yii::app()->clientScript->registerScript('cari cari', "
        $('#search-form').submit(function(){
                $('#tableLaporan').addClass('srbacLoading');
            $.fn.yiiGridView.update('tableLaporan', {
                data: $(this).serialize()
            });
            return false;
        });
    ");
?>
<?php
	$criteria = new CDbCriteria;
        $criteria->group = 'rekening5_id,nmrekening5';
        $criteria->select = $criteria->group . " ,sum(jumlah) as jumlah";
        $criteria->order = 'rekening5_id,nmrekening5';
	
	if(!empty($_GET['AKLaporanperubahanmodalV']['periodeposting_id']) || $model->periodeposting_id){		
		$periodeposting_id = (isset($_GET['AKLaporanperubahanmodalV']['periodeposting_id']) ? $_GET['AKLaporanperubahanmodalV']['periodeposting_id'] : (isset($model->periodeposting_id) ? $model->periodeposting_id : null));
		
		
			$criteria->addCondition('periodeposting_id = '.$periodeposting_id);
		
			$modPeriode = AKPeriodepostingM::model()->findByPk($periodeposting_id);
	}else{
		$criteria->addCondition('periodeposting_id is null ');
	}
	
	if(!empty($_GET['AKLaporanperubahanmodalV']['ruangan_id']) || $model->ruangan_id){		
		$ruangan_id = (isset($_GET['AKLaporanperubahanmodalV']['ruangan_id']) ? $_GET['AKLaporanperubahanmodalV']['ruangan_id'] : (isset($model->ruangan_id) ? $model->ruangan_id : null));
		$criteria->addCondition('ruangan_id = '.$ruangan_id);
	}
    $modelLaporan = AKLaporanperubahanmodalV::model()->findAll($criteria);

	$spasi = '&nbsp;&nbsp;&nbsp;&nbsp;';
?>
<div id="tableLaporan" class="grid-view">
<table class="table noborder paddingtext">   
    <thead>
        <tr>
            <th></th>
            <th width="120">Modal Saham</th>
            <th width="120">Modal Inbreng</th>
            <th width="120">Disetor</th>
            <th width="120">Saldo Laba</th>
            <th width="120">Jumlah</th>
        </tr>
    </thead>
    <tbody>
    
			<?php
            
            
            
            
            $rek_map = array(
                'saham'=>array(511, 832, 833, 834),
                'setor'=>array(336),
                'laba'=>array(337),
            );
            
            
            $tgl_awal = $model->tgl_awal;
            $tgl_akhir = $model->tgl_akhir;
            
            
            // saldo_awal
            
            $saldo_awal = array();
            $saldo_jalan = array();
            $saldo_saham = array();
            
            $waktu_periode_awal = "";
            $status_saldo_awal = "Awal";
            foreach ($rek_map as $key => $item) {
                
                $saldo_awal[$key] = 0;
                $saldo_jalan[$key] = 0;
                $saldo_saham[$key] = 0;
                
                foreach ($item as $id) {
                
                    $saldodebit = 0;
                    $saldokredit = 0;

                    $cr = new CDbCriteria();
                    $cr->compare('nourut', $id);
                    $cr->addCondition("tglbukubesar::date <= '".$tgl_awal."'::date and saldoawal_id is not null");
                    $cr->order = "tglbukubesar::date desc";
                    
                    $cr2 = new CDbCriteria();
                    $cr2->select = "sum(case when saldodebit is null then 0 else saldodebit end) as saldodebit, "
                    . "sum(case when saldokredit is null then 0 else saldokredit end) as saldokredit";
                    $cr2->compare('nourut', $id);
                    $cr2->addCondition("tglbukubesar::date <= '".$tgl_akhir."'::date and saldoawal_id is null");

                    $dat = LaporanbukubesarV::model()->find($cr);

                    
                    if (!empty($dat)) {
                        $saldodebit = $dat->saldodebit;
                        $saldokredit = $dat->saldokredit;
                        $periode = PeriodepostingM::model()->findByPk($dat->periodeposting_id);
                        if (!empty($periode)) {
                            $cr2->addCondition("tglbukubesar::date >= '".$periode->tglperiodeposting_awal."'");
                            $waktu_periode_awal = date('Y-m-d', strtotime($periode->tglperiodeposting_awal." - 1 day"));
                        }
                    }
                    
                    
                    if ($key == 'saham') {
                        $saldo_awal[$key] += $saldokredit - $saldodebit;
                    } else if (in_array($key, array("laba", "setor"))) {
                        $saldo_awal[$key] += $saldodebit - $saldokredit;
                    }
                    
                    
                    
                    // labe rugi
                    $saldodebit = 0;
                    $saldokredit = 0;
                    
                    
                    $dat2 = LaporanbukubesarV::model()->find($cr2);
                    if (!empty($dat)) {
                        $saldodebit = $dat->saldodebit;
                        $saldokredit = $dat->saldokredit;
                    }
                    
                    if ($key == 'saham') {
                        $saldo_saham[$key] += $saldokredit - $saldodebit;
                    } else if (in_array($key, array("laba", "setor"))) {
                        $saldo_jalan[$key] += $saldodebit - $saldokredit;
                    }
                    
                    
                }
            }
            
            
            $cr_jalan = new CDbCriteria();
            $cr_jalan->select = "sum(case when saldodebit is null then 0 else saldodebit end) as saldodebit, "
                . "sum(case when saldokredit is null then 0 else saldokredit end) as saldokredit";
            $cr_jalan->compare('tiperekening_id', 5);
            $cr_jalan->addCondition("tglbukubesar::date <= '".$tgl_akhir."'::date and saldoawal_id is null");
            
            
            if (empty($waktu_periode_awal)) {
                $periode = PeriodepostingM::model()->find(array(
                    'condition'=>"'".$tgl_awal."'::date between tglperiodeposting_awal and tglperiodeposting_akhir"
                ));
                if (!empty($periode)) {
                    $waktu_periode_awal = $periode->tglperiodeposting_awal;
                }
            } else {
                $status_saldo_awal = "Akhir";
                $cr_jalan->addCondition("tglbukubesar::date > '".$waktu_periode_awal."'::date");
            }
            
            $dat3 = LaporanbukubesarV::model()->find($cr_jalan);
            if (!empty($dat3)) {
                $saldo_jalan['laba'] += $dat3->saldokredit - $dat3->saldodebit;
            }
            
            
            
            
            
            // var_dump($status_saldo_awal, $waktu_periode_awal, $saldo_awal, $saldo_jalan); die;
            
            
            
            
            
            
            
            
            
            
            
			$spasi1 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			$spasi2 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			$spasi3 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			$spasi4 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";            
            $vals2 = 0;
            
            $roll_total = 0;
            $total_laba = 0;
            $total_inbreng = 0;
            
            $res = array();
            
                ?>
    
    <tr>
        <td>Saldo <?php echo $status_saldo_awal." ".(empty($waktu_periode_awal) ? "-" : MyFormatter::formatDateTimeForUser($waktu_periode_awal)); ?></td>
        
        <?php 
        
        
        $roll_total += $saldo_awal['saham'] + $saldo_awal['laba'];
        
        
        
        ?>
        
        <td style="text-align: right;">
            <?php
            $vals = 0;
            $total_saham = 0;
            
            $vals += $saldo_awal['saham'];
            $total_saham += $saldo_awal['saham'];
            
            
            if ($vals < 0) echo "(".MyFormatter::formatNumberForPrint(abs($vals), 2).")";
            else echo MyFormatter::formatNumberForPrint($vals, 2);
            ?>
        </td>
        <td style="text-align: right;">
            <?php
            $vals = 0;
            
            
            if ($vals < 0) echo "(".MyFormatter::formatNumberForPrint(abs($vals), 2).")";
            else echo MyFormatter::formatNumberForPrint($vals, 2);
            ?>
        </td>
        <td style="text-align: right;">
            0,00
        </td>
        <td style="text-align: right;">
            <?php
            $vals = $saldo_awal['laba'];
            $total_laba += $saldo_awal['laba'];
            
            if ($vals < 0) echo "(".MyFormatter::formatNumberForPrint(abs($vals), 2).")";
            else echo MyFormatter::formatNumberForPrint($vals, 2);
            ?>
        </td>
        <td style="text-align: right;">
            <?php 
            if ($roll_total < 0) echo "(".MyFormatter::formatNumberForPrint(abs($roll_total), 2).")";
            else echo MyFormatter::formatNumberForPrint($roll_total, 2);
            ?>
        </td>
    </tr>
    
     <?php 
    // MODAL SAHAM
    
        
        $vals1 = 0;
        $vals1 += $saldo_saham['saham'];
        $total_saham += $saldo_saham['saham'];
        $roll_total += $saldo_saham['saham'];
        
        $vals2 = $roll_total;
    
        if ($vals1 < 0) $vals1 = "(".MyFormatter::formatNumberForPrint(abs($vals1), 2).")";
        else $vals1 = MyFormatter::formatNumberForPrint($vals1, 2);
        
        if ($vals2 < 0) $vals2 = "(".MyFormatter::formatNumberForPrint(abs($vals2), 2).")";
        else $vals2 = MyFormatter::formatNumberForPrint($vals2, 2);
        
        ?>
    <tr>
        <td>Penambahan Modal Saham</td>
        <td style="text-align: right;"><?php echo $vals1; ?></td>
        <td style="text-align: right;">0,00</td>
        <td style="text-align: right;">0,00</td>
        <td style="text-align: right;">0,00</td>
        <td style="text-align: right;"><?php echo $vals1; ?></td>
    </tr>
    
    <?php  /* 
    // MODAL INBRENG
    if (!empty($res["3120101"])): 
        
        $res["3120101"]->saldokredit -= $res["3120101"]->saldodebit;
        
        $roll_total += $res["3120101"]->saldokredit;
        $total_inbreng += $res["3120101"]->saldokredit;
        $vals1 = $res["3120101"]->saldokredit;
        $vals2 = $roll_total;
    
        if ($vals1 < 0) $vals1 = "(".MyFormatter::formatNumberForPrint(abs($vals1), 2).")";
        else $vals1 = MyFormatter::formatNumberForPrint($vals1, 2);
        
        if ($vals2 < 0) $vals2 = "(".MyFormatter::formatNumberForPrint(abs($vals2), 2).")";
        else $vals2 = MyFormatter::formatNumberForPrint($vals2, 2);
        
        ?>
    <tr>
        <td>Penambahan Modal Inbreng</td>
        <td style="text-align: right;">0</td>
        <td style="text-align: right;"><?php echo $vals1; ?></td>
        <td style="text-align: right;">0</td>
        <td style="text-align: right;">0</td>
        <td style="text-align: right;"><?php echo $vals1; ?></td>
    </tr>
    <?php endif; 
     * ?>
     */
    ?>
    
    <?php 
    // LABA BERJALAN
        
        $roll_total += $saldo_jalan['laba'];
        $total_laba += $saldo_jalan['laba'];
        $vals1 = $saldo_jalan['laba'];
        $vals2 = $roll_total;
    
        if ($vals1 < 0) $vals1 = "(".MyFormatter::formatNumberForPrint(abs($vals1), 2).")";
        else $vals1 = MyFormatter::formatNumberForPrint($vals1, 2);
        
        if ($vals2 < 0) $vals2 = "(".MyFormatter::formatNumberForPrint(abs($vals2), 2).")";
        else $vals2 = MyFormatter::formatNumberForPrint($vals2, 2);
        
        ?>
    <tr>
        <td>Laba Bersih Periode Berjalan</td>
        <td style="text-align: right;">0,00</td>
        <td style="text-align: right;">0,00</td>
        <td style="text-align: right;">0,00</td>
        <td style="text-align: right;"><?php echo $vals1; ?></td>
        <td style="text-align: right;"><?php echo $vals1; ?></td>
    </tr>
    
    
    </tbody>
    <tfoot>
    
        <tr class="tabfoot">
            <td>Saldo Akhir <?php echo MyFormatter::formatDateTimeForUser($tgl_akhir); ?></td>
            <td style="text-align: right;"><?php 

            if ($total_saham < 0) echo "(".MyFormatter::formatNumberForPrint(abs($total_saham), 2).")";
            else echo MyFormatter::formatNumberForPrint($total_saham, 2);

            ?>

            </td>
            <td style="text-align: right;"><?php 

            if ($total_inbreng < 0) echo "(".MyFormatter::formatNumberForPrint(abs($total_inbreng), 2).")";
            else echo MyFormatter::formatNumberForPrint($total_inbreng, 2);

            ?></td>
            <td style="text-align: right;">0,00</td>
            <td style="text-align: right;"><?php 

            if ($total_laba < 0) echo "(".MyFormatter::formatNumberForPrint(abs($total_laba), 2).")";
            else echo MyFormatter::formatNumberForPrint($total_laba, 2);

            ?></td>
            <td style="text-align: right;"><?php echo $vals2; ?></td>
        </tr>
    </tfoot>
    
	</table>
</div>