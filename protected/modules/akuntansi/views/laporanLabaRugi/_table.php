<style>
    .tab_detail {
        width: 100%;
        color: black;
        margin-bottom: 5px;
    }

    .tab_detail th, .tab_detail td {
        padding: 2px;
        font-size: 10px;
    }

    .tab_detail .row_totals {
        border-top: 1px solid black;
    }
    .tab_detail .row_totals_b {
        text-decoration: underline;
    }

    .head_blue td {
        color: dodgerblue;
        font-weight: bold;
    }
    .head_red td {
        color: maroon;
        font-weight: bold;
    }
    .foot_total td {
        padding-bottom: 10px;
    }

    .foot_total_1 {
        border-top: 1px solid black;
        width: 150px;
        float: right;
		font-size:10px;
    }
    .foot_total_2 {
        border-top: 1px solid black;
        width: 100px;
        float: right;
		font-size:10px;
    }

    .tab_level2 {
        padding-left: 50px !important;
    }

    .tab_level3 {
        padding-left: 100px !important;
    }
    .tab_level4 {
        padding-left: 150px !important;
    }

</style>



<?php
function buildTree($rek_id, $branch) {
    $rek = Rekening5M::model()->findByPk($rek_id);
    
    if(!empty($rek)){
        $branch['rek_'.$rek->levelrek]['rekening_id'] = $rek->rekening5_id;
        $branch['rek_'.$rek->levelrek]['rekening_nama'] = $rek->nmrekening5;
        $branch['rek_'.$rek->levelrek]['rekening_kode'] = $rek->kdrekening5;
        $branch['rek_'.$rek->levelrek]['saldonormal'] = $rek->rekening5_nb;
        if(!empty($rek->parent_id)){
            $branch = buildTree($rek->parent_id, $branch);
        }
    }
    return $branch;
}


$dataArray = array();
$dataID = array();
$header = true;
$format = new MyFormatter();
$mergeTanggal = array();
foreach ($models AS $row => $data) {
	array_push($dataID, $data->periodeposting_id);
	$dataArray["$data->tglperiodeposting_awal"] = $data->tglperiodeposting_awal;
}

// var_dump($_GET, $dataID);

$spasi1 = "&emsp;";
$spasi2 = "&emsp;&emsp;";
$spasi3 = "&emsp;&emsp;&emsp;";
$spasi4 = "&emsp;&emsp;&emsp;&emsp;";

// var_dump($_GET, $dataArray, $dataID);

$betwens = "";

if (!is_array($model->periodeposting_id)) {
    if (empty($model->periodeposting_id)) {
        $model->periodeposting_id = array();
    } else {
        $model->periodeposting_id = array($model->periodeposting_id);
    }
}

$criteria = new CDbCriteria;
$criteria->select = "t.*, kel.ishpp, kel.ispendapatan, kel.isbebanusaha, kel.ispendapatanluar, kel.isbebanluar, ((CASE WHEN t.saldonormal::text = 'D'::text THEN t.saldodebit ELSE 0::double precision - t.saldodebit END) + (CASE WHEN t.saldonormal::text = 'D'::text THEN 0::double precision - t.saldokredit ELSE t.saldokredit END)) as jumlah";
$criteria->order = 't.kdrekening5 asc';
$criteria->addCondition("t.tglbukubesar::date between '".$model->tgl_awal."'::date and '".$model->tgl_akhir."'::date");
$criteria->join = "right join kelrekening_m kel on kel.kelrekening_id = t.kelrekening_id";
$criteria->addCondition("t.tiperekening_id = 5");
$modelLaporan = LaporanbukubesarV::model()->findAll($criteria);

$dataRek = array();
foreach ($modelLaporan as $item) {
    $reklastArr = array();
    $dataRek[$item->rekening5_id]['rekening'] = buildTree($item->rekening5_id, $reklastArr);
    $dataRek[$item->rekening5_id]['itemdata'] = $item;
}


$detail = array(
	'pendapatan'=>array(
		'total'=>0,
		'rek2'=>array(),
	),
	'beban'=>array(
		'total'=>0,
		'rek2'=>array(),
	),
);
$labarugi = 0;
$totals = 0;
$flag = '';


$mrek1 = array();
$mrek2 = array();

// $kelkotor = array('400000', '500000'); // akun laba/rugi kotor
// $kelop = array('600000');    // akun laba/rugi operasional
// $kelluar = array('700000', '800000');    // akun laba/rugi diluar usaha
// $kelpajak = array('9'); // beban pajak

$mainlap = array(
    'kotor'=>array(
        'nama'=>'Kotor Penjualan',
        'detail'=>array(),
    ),
    'operasi'=>array(
        'nama'=>'Usaha',
        'detail'=>array(),
    ),
    'luar'=>array(
        'nama'=>'Bersih Sebelum Pajak',
        'detail'=>array(),
    ),
    'pajak'=>array(
        'nama'=>'Bersih Setelah Pajak',
        'detail'=>array(),
    ),
);

$laporankeu = LaporankeuanganK::model()->findByAttributes(array('menu_url'=>$this->module->id . '/' . ucfirst(Yii::app()->controller->id) . '/' . Yii::app()->controller->action->id));

if(!empty($laporankeu)){
    // $levelRekLaporan = explode(',',$laporankeu->levelrek);

    $levelRekLaporan = [1, 2, 3, 4];

    asort($levelRekLaporan);
    foreach ($dataRek as $item) {
        $word = '';
        $jenis = "";

        $level1 = (!empty($levelRekLaporan[0])? $levelRekLaporan[0] : null);
        if(empty($level1)) continue;
        $level2 = (!empty($levelRekLaporan[1])? $levelRekLaporan[1] : null);
        if(empty($level2)) continue;
        $level3 = (!empty($levelRekLaporan[2])? $levelRekLaporan[2] : null);
        if(empty($level3)) continue;

        $rek1 = $item['rekening']['rek_'.$level1];
        $rek2 = $item['rekening']['rek_'.$level2];
        $rek3 = $item['rekening']['rek_'.$level3];

        if ($item['itemdata']['ispendapatan']==true || $item['itemdata']['ishpp']==true) {
            $word = 'kotor';
            if($item['itemdata']['ispendapatan'] == true){
                $jenis = "pendapatan";
            }else{
                $jenis = "project";
            }
        } else if ($item['itemdata']['isbebanusaha'] == true) {
            $word = 'operasi';
            if($item['itemdata']['isbebanusaha'] == true){
                $jenis = "operasional";
            }
        } else if ($item['itemdata']['ispendapatanluar'] == true  || $item['itemdata']['isbebanluar'] == true) {
            $word = 'luar';
            $jenis = "pendapatanluar";
            if($item['itemdata']['isbebanluar'] == true && $rek2['rekening_kode']== '61.12'){
                $jenis = "bebanluar";
            }
        } else if ($item['itemdata']['ispendapatanluar'] == true  || $item['itemdata']['isbebanluar'] == true) {
            $word = 'pajak';
        }

        $reklast_id = $item['itemdata']['rekening5_id'];
        $reklast_kode = $item['itemdata']['kdrekening5'];
        $reklast_nama = $item['itemdata']['nmrekening5'];

        if (empty($mainlap[$word]['detail'][$rek1['rekening_id']])) {
            $mainlap[$word]['detail'][$rek1['rekening_id']] = array(
                'kode'=>$rek1['rekening_kode'],
                'nama'=>$rek1['rekening_nama'],
                'debitkredit'=>$rek1['saldonormal'],
                'jenis'=>$jenis,
                'total'=>0,
                'detail'=>array(),
            );
        }

        if (empty($mainlap[$word]['detail'][$rek1['rekening_id']]['detail'][$rek2['rekening_id']])) {
            $mainlap[$word]['detail'][$rek1['rekening_id']]['detail'][$rek2['rekening_id']] = array(
                'kode'=>$rek2['rekening_kode'],
                'nama'=>$rek2['rekening_nama'],
                'jenis'=>$jenis,
                'total'=>0,
                'detail'=>array(),
            );
        }
        if (empty($mainlap[$word]['detail'][$rek1['rekening_id']]['detail'][$rek2['rekening_id']]['detail'][$rek3['rekening_id']])) {
            $mainlap[$word]['detail'][$rek1['rekening_id']]['detail'][$rek2['rekening_id']]['detail'][$rek3['rekening_id']] = array(
                'kode'=>$rek3['rekening_kode'],
                'nama'=>$rek3['rekening_nama'],
                'total'=>0,
                'detail'=>array(),
            );
        }

        if (empty($mainlap[$word]['detail'][$rek1['rekening_id']]['detail'][$rek2['rekening_id']]['detail'][$rek3['rekening_id']]['detail'][$reklast_id])) {
            $mainlap[$word]['detail'][$rek1['rekening_id']]['detail'][$rek2['rekening_id']]['detail'][$rek3['rekening_id']]['detail'][$reklast_id] = array(
                'kode'=>$reklast_kode,
                'nama'=>$reklast_nama,
                'total'=>0,
                'detail'=>array(),
            );
        }

        if ($item['itemdata']['ispendapatan'] == true || $item['itemdata']['ispendapatanluar'] == true) {
            $totals = $item['itemdata']['jumlah'];
        } else if ($item['itemdata']['isbebanusaha'] == true || $item['itemdata']['isbebanluar'] == true) {
            $totals = $item['itemdata']['jumlah'];
        }

        $mainlap[$word]['detail'][$rek1['rekening_id']]['total'] += $totals;
        $mainlap[$word]['detail'][$rek1['rekening_id']]['detail'][$rek2['rekening_id']]['total'] += $totals;
        $mainlap[$word]['detail'][$rek1['rekening_id']]['detail'][$rek2['rekening_id']]['detail'][$rek3['rekening_id']]['total'] += $totals;
        $mainlap[$word]['detail'][$rek1['rekening_id']]['detail'][$rek2['rekening_id']]['detail'][$rek3['rekening_id']]['detail'][$reklast_id]['total'] += $totals;

        

    }
}


if (isset($_GET['caraPrint'])) :
	if ($_GET['caraPrint'] == 'PDF'){
		echo $this->renderPartial('_tablePDFBaru', array(
        'mainlap'=>$mainlap,
        'detail'=>$detail,
        'print_periode'=>$print_periode,
        'caraPrint'=>$_GET['caraPrint']), true);
	}else{
		echo $this->renderPartial('_tablePrint', array(
        'mainlap'=>$mainlap,
        'detail'=>$detail,
        'print_periode'=>$print_periode,
        'caraPrint'=>$_GET['caraPrint']), true);
	}
else :

?>

    
	<table class="tab_detail">
		<tbody>
        <?php

$gtotal = 0;
$totalpend = 0;
$totalproject = 0;
$totalop_expenses = 0;
$totalop_keluar = 0;

$total_pendluar = 0;
$total_bebanluar = 0;

 $arrAkhir = array();   
foreach ($mainlap as $item):
    if ($item['detail'] == 0) continue;
    ?>

            <?php foreach ($item['detail'] as $level1):
                $stotal = 0;

                ?>
            <tr class="head_blue">
                <td colspan="2"><b><?php echo $level1['kode']." ".$level1['nama']; ?></b></td>
            </tr>

            <?php foreach ($level1['detail'] as $level2):
                $stotal2 = 0;

               
                ?>

            <tr class="head_blue" data-kode="<?php echo str_replace(".","",$level2['kode']) ?>" data-show="0">
                <td class="tab_level2"><b>
                    <?php echo CHtml::link($level2['kode']." ".$level2['nama'], '#', array(
                        'onclick'=>'toggleRekening(this); return false;',
                        'style'=>'color: dodgerblue;'
                    )); ?>

                </b></td>
                <td style="text-align: right;" class="acc_total"><?php
                    if ($level2['total'] < 0) {
                        echo "(".MyFormatter::formatNumberForPrint(abs($level2['total']), 2).")";
                    } else {
                        echo MyFormatter::formatNumberForPrint($level2['total'], 2);
                    }
                ?>
                </td>
            </tr>


            <?php foreach ($level2['detail'] as $level3):

                if ($level3['total'] == 0) {
                    continue;
                }

                ?>

            <tr class="det_<?php echo str_replace(".","",$level2['kode']); ?>" hidden>
                <td class="tab_level3" style="font-weight: bold;"><?php echo $level3['kode'].' '.$level3['nama']; ?></td>
                <td style="text-align: right;">
                </td>
            </tr>


            <?php foreach ($level3['detail'] as $level4):

                if ($level4['total'] == 0) {
                    continue;
                }
                ?>

            <tr class="det_<?php echo str_replace(".","",$level2['kode']); ?>" hidden>
                <td class="tab_level4"><?php echo $level4['kode'].' '.$level4['nama']; ?></td>
                <td style="text-align: right;">
                    <?php
                    if(!empty($level1['jenis'])){
                        if($level1['jenis'] == 'pendapatan'){
                            $totalpend += $level4['total'];
                        }
                        else if($level1['jenis'] == 'project'){
                            $totalproject += $level4['total'];
                        }
                        else if($level1['jenis'] == 'operasional'){
                            $totalop_expenses += $level4['total'];
                        }else if($level1['jenis'] == 'bebanluar'){
                            $totalop_keluar += $level4['total'];
                        }
                    }
                    else{
                        $gtotal += $level4['total'];
                    }
                    
                    if(!empty($level2['jenis'])){
                        if($level2['jenis'] == 'pendapatanluar'){
                            $total_pendluar += $level4['total'];
                        }
                        else if($level2['jenis'] == 'bebanluar'){
                            $total_bebanluar += $level4['total'];
                        }
                    }
                   
                    $stotal += $level4['total'];
                    $stotal2 += $level4['total'];

                    if ($level4['total'] < 0) {
                        echo "(".MyFormatter::formatNumberForPrint(abs($level4['total']), 2).")";
                    } else {
                        echo MyFormatter::formatNumberForPrint($level4['total'], 2);
                    }
                    ?>
                </td>
            </tr>

            <?php endforeach; ?>

            <?php endforeach; ?>

            <tr class="head_blue foot_total det_<?php echo str_replace(".","",$level2['kode']); ?>" hidden>
                <td class="tab_level2"><?php echo "TOTAL ".$level2['nama']?></td>
                <td style="text-align: right;">
                    <div class="foot_total_2">
                        <?php
                        if ($level2['total'] < 0) {
                            echo "(".MyFormatter::formatNumberForPrint(abs($level2['total']), 2).")";
                        } else {
                            echo MyFormatter::formatNumberForPrint($level2['total'], 2);
                        }
                    ?>
                    </div>
                </td>
            </tr>

            <?php endforeach; ?>

            <tr class="head_blue foot_total">
                <td><?php echo "TOTAL ". $level1['nama']?></td>
                <td style="text-align: right;">
                    <div class="foot_total_1">
                    <?php
                    $totalnilai1 = $level1['total'];
                        
                    if($level2['jenis'] == 'pendapatanluar' || $level2['jenis'] == 'bebanluar'){
                        $totalnilai1 = ($total_pendluar - $total_bebanluar);
                    }

                    // if($level1['kode'] == '800000'){
                    //     $totalnilai1 = ($total_pendluar - $total_bebanluar);
                    // }
                    if ($totalnilai1 < 0) {
                        echo "(".MyFormatter::formatNumberForPrint(abs($totalnilai1), 2).")";
                    } else {
                        echo MyFormatter::formatNumberForPrint($totalnilai1, 2);
                    }
                    
                    ?>
                        </div>
                </td>
            </tr>

            <?php endforeach; ?>
             <?php 
             
                if(!empty($item['nama'])){
                   
                    if($item['nama'] == 'Kotor Penjualan'){
                        $gtotal = ($totalpend - $totalproject);
                    }else if($item['nama'] == 'Usaha'){
                        $gtotal = (($totalpend - $totalproject) - $totalop_expenses - $totalop_keluar);
                    }else{
                        $totalSebelum = ((($totalpend - $totalproject) - $totalop_expenses - $totalop_keluar) + ($total_pendluar - $total_bebanluar));

                        if($item['nama'] == 'Bersih Sebelum Pajak'){
                            $arrAkhir[] = array('nama'=>$item['nama'],'total'=> $totalSebelum);
                        }else if($item['nama'] == 'Bersih Setelah Pajak'){
                            $arrAkhir[] = array('nama'=>$item['nama'],'total'=>$totalSebelum);
    
                        }
                    }
                }
                
             ?> 
             
            <?php if((!empty($item['nama'])) && ($item['nama'] == 'Kotor Penjualan' || $item['nama'] == 'Usaha')){ ?>
            <tr class="head_red foot_total">
                <td style="padding-bottom: 0px;"><?php echo "TOTAL ".strtoupper(($gtotal < 0 ? "Rugi" : "Laba")." ".(empty($item['nama']) ? "" : $item['nama'])); ?></td>
                <td style="text-align: right; border-bottom: 3px double black; width: 155px; padding-bottom: 0px;">
                    <?php
                    if ($gtotal < 0) {
                        echo "(".MyFormatter::formatNumberForPrint(abs($gtotal), 2).")";
                    } else {
                        echo MyFormatter::formatNumberForPrint($gtotal, 2);
                    }
                    ?>
                </td>
            </tr>
            <?php } ?>

           <?php endforeach; ?>    
           <?php if(!empty($arrAkhir)){
            foreach($arrAkhir as $dataAkhir){
                $nilai = 0;
                $nama = "";

            if(!empty($dataAkhir['nama'] == 'Bersih Sebelum Pajak')){
                $nilai = $dataAkhir['total'];
                $nama = $dataAkhir['nama'];
            }else if(!empty($dataAkhir['nama'] == 'Bersih Setelah Pajak')){
                $nilai = $dataAkhir['total'];
                $nama = $dataAkhir['nama'];
            }
                ?>
                <tr class="head_red foot_total">
                <td style="padding-bottom: 0px;"><?php echo "TOTAL ".strtoupper((($nilai) < 0 ? "Rugi" : "Laba")." ".$nama); ?></td>
                <td style="text-align: right; border-bottom: 3px double black; width: 155px; padding-bottom: 0px;">
                    <?php
                    if ($nilai < 0) {
                        echo "(".MyFormatter::formatNumberForPrint(abs($nilai), 2).")";
                    } else {
                        echo MyFormatter::formatNumberForPrint($nilai, 2);
                    }
                    ?>
                </td>
            </tr>
                <?php
            }   
            
            ?>
            <?php } ?>      
		</tbody>
	</table>
    
    

<?php


$labarugi = $detail['pendapatan']['total'] - $detail['beban']['total'];
if ($labarugi < 0) {
	$labarugi = "(".MyFormatter::formatNumberForPrint($labarugi, 2).")";
} else {
	$labarugi = MyFormatter::formatNumberForPrint($labarugi, 2);
}

?>


<style>
	.tots td {
		font-weight: bold;
	}
	.tot {
		text-align: right !important;
		font-weight: bold;
		font-style: italic;
	}
	.totlr {
		text-align: right !important;
		font-weight: bold;
		font-style: italic;
		text-decoration: underline;
	}
</style>


<script>
function toggleRekening(obj) {
    var kode = $(obj).parents("tr").data('kode');
    var show = $(obj).parents("tr").data('show');

    if (show == 0) {
        $(obj).parents("tr").find(".acc_total").hide();
        $(".det_" + kode).show();
        show = 1;
    } else {
        $(obj).parents("tr").find(".acc_total").show();
        $(".det_" + kode).hide();
        show = 0;
    }

    $(obj).parents("tr").data('show', show);
}
</script>




<?php endif; ?>
