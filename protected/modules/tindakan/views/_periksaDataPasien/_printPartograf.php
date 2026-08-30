<style>
	 @page {
        margin-top: 12mm;
    }
	
	@media print {
        #headers {
            position: fixed;
            top: 0;
        }
        
        body {
            display:table;
            table-layout:fixed;
            padding-top:4cm;
            padding-left: 1mm;
            height:auto;
			width:297mm;
        }
    }
    
    body {
        padding-left: 1mm;
        width: 297mm;
    }
	
	
	  table:nth-of-type(2) td.garis {
		background-image: linear-gradient(
		  to bottom right,
		  white calc(50% - 1px),
		  black,
		  white calc(50% + 1px)
		);
	  }
	
	.putar{
		-webkit-transform: rotate(270deg);	
		-moz-transform: rotate(270deg);
		-ms-transform: rotate(270deg);
		-o-transform: rotate(270deg);
		transform: rotate(270deg);
		font-size:10px;
		position:relative;	
		right: 12px;
		bottom: 80px;
		border-top:1px solid #333;
		height:1px;
	}
	
	.putar2{
		-webkit-transform: rotate(270deg);	
		-moz-transform: rotate(270deg);
		-ms-transform: rotate(270deg);
		-o-transform: rotate(270deg);
		transform: rotate(270deg);
		font-size:10px;
		position:relative;	
		right: -50px;
		bottom: 100px;
		border-top:1px solid #333;
		height:1px;
		width:100px;
	}
	
	.putar3{
		-webkit-transform: rotate(270deg);	
		-moz-transform: rotate(270deg);
		-ms-transform: rotate(270deg);
		-o-transform: rotate(270deg);
		transform: rotate(270deg);
		font-size:10px;
		position:relative;	
		right: -100px;
		bottom: 100px;		
		height:1px;
		width:100px;
	}
	
	#serviks{
		position: relative;
		left: -7px;
		bottom: -5px;
		height: 1px;
	}
	
	#tekanan{
		position: relative;
		left: -5px;
		bottom:-11px;
		height: 1px;
	}
	
	#tekanan-arrow-up{
		position: relative;
		left: -16px;
		bottom:-2px;
		height: 1px;
		font-size:20px;
	}
	
	#tekanan-arrow-down{
		position: relative;
		left: -16px;
		top:-13px;
		height: 1px;
		font-size:20px;
	}
	
	.tekanandarah-up{
		position: relative;
		text-align: right;
		right: -17px;
		font-size: 20px;
		top:-10px;
	}
	
	.tekanandarah-down{
		position: relative;
		text-align: right;
		right: -17px;
		font-size: 20px;
		bottom: -110px;
	}
	
	#serviks2{
		position: relative;
		left: -7px;
		bottom: -5px;
		height: 1px;
	}
	
	#turunkepala{
		position: relative;
		left: -7px;
		bottom: -5px;
		height: 1px;
	}
		
	.urutan-no{
		font-size: 10px;
		margin-top: 8px;
		height: 1px;
	}
</style>
<?php 
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/themes/neon/assets/js/daterangepicker/moment.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/Chart.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/chartjs-plugin/annotation/chartjs-plugin-annotation.js', CClientScript::POS_END);
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/prinout.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/prinout_partograf.css');
?>

<table style="width: 100%; border: none;">
    <tr>
        <td width="12.5%">No. Register</td>
        <td width="12.5%">: <?php echo $pendaftaran->no_pendaftaran; ?></td>
        <td width="12.5%">Nama Ibu</td>
        <td width="12.5%">: <?php echo $pasien->namadepan.$pasien->nama_pasien; ?></td>
        <td width="12.5%">Umur</td>
        <td width="12.5%">: <?php echo $pendaftaran->umur; ?></td>
        <td colspan="2">
            G : <?php echo empty($mod->gravida) ? "-" : $mod->gravida ?>, 
            P : <?php echo empty($mod->para) ? "-" : $mod->para ?>, 
            A : <?php echo empty($mod->abortus) ? "-" : $mod->abortus ?>
        
        </td>
    </tr>
    <tr>
        <td>Tanggal</td>
        <td>: <?php echo MyFormatter::formatDateTimeForUser(date('Y-m-d', strtotime($mod->tglperiksa))); ?></td>
        <td>Jam</td>
        <td>: <?php echo (date('H:i:s', strtotime($mod->tglperiksa))); ?></td>
        <td>Alamat</td>
        <td colspan="3">: <?php echo $pasien->alamat_pasien; ?></td>
    </tr>
    <tr>
        <td>Ketuban Pecah sejak jam</td>
        <td>: <?php echo (!empty($mod->tglketubanpecah)?date("d-m-Y H:i:s", strtotime($mod->tglketubanpecah)):'-'); ?></td>
        <td>Mules sejak jam</td>
        <td>: <?php echo (!empty($mod->tglmules)?date("d-m-Y H:i:s", strtotime($mod->tglmules)):'-'); ?></td>
    </tr>
</table>

<?php
//echo "<div id='headers'>";
//echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksiPDF',array('judulLaporan'=>'',  'periode'=> '', 'colspan'=>10));  
//echo "</div>";

//var_dump($partograf['tekanan']['nadi']); die;

$nadi = array();
$nadi_ibu = array();

$turunkepala = array();
$serviks = array();

$systolic = array();
$diastolic = array();

$label_waktu = array();

$waspada = array(
    0=>4,
    1=>null,
    2=>null,
    3=>null,
    4=>null,
    5=>null,
    6=>null,
    7=>null,
    8=>null,
    9=>null,
    10=>null,
    11=>null,
    12=>10,
);
$bertindak = array(
    0=>null,
    1=>null,
    2=>null,
    3=>null,
    4=>null,
    5=>null,
    6=>null,
    7=>null,
    8=>4,
    9=>null,
    10=>null,
    11=>null,
    12=>null,
    13=>null,
    14=>null,
    15=>null,
    16=>null,
    17=>null,
    18=>null,
    19=>null,
    20=>10,
);


$tgl_awal = new DateTime(date('Y-m-d 00:00:00'));
$tgl_akhir = new DateTime(date('Y-m-d 16:30:00'));

$range = new DatePeriod($tgl_awal, new DateInterval('PT30M'), $tgl_akhir);

foreach ($range as $item) {
    $label_waktu[] = $item->format('H:i:s');
}

$time = "00:00:00";
$time_ref = array();
for($i = 0; $i < 32; $i++) {
    $res_time = date("H:i", strtotime($time));
    $time_ref[$res_time] = $i;
    $time = date("H:i:s", strtotime($time." + 30 minute"));
    
    $nadi[$i] = null;
    $nadi_ibu[$i] = null;
//    $label_waktu[$i] = null;
    $systolic[$i] = null;
    $diastolic[$i] = null;
    $serviks[$i] = null;
    $turunkepala[$i] = null;
}

//$time1 = strtotime("01:23:32");
//$time2 = strtotime("02:35:34");
//
//$time1 = round($time1/(1800)) * 1800;
//$time2 = round($time2/(1800)) * 1800;
//
//var_dump(date("H:i:s", $time1), date("H:i:s", $time2)); die;

foreach ($det as $item) {
    
    $times = strtotime($item->waktucatat);
    $times = round($times/(1800)) * 1800;
    $times = date("H:i", $times);
    
    $point = $time_ref[$times] + $offset;
    
    $nadi[$point] = $item->p1_djj_menit;
    $nadi_ibu[$point] = $item->p6_nadi;
    $label_waktu[] = $item->waktucatat;
    $systolic[$point] = $item->p6_systolic;
    $diastolic[$point] = $item->p6_diastolic;
    
    $serviks[$point] = $item->p3_pembukaanserviks;
    $turunkepala[$point] = $item->p3_turunnyakepala;
    
//    var_dump($item->attributes);
}

// var_dump($nadi); die;
$kotak = 27;
$kotak16 = $kotak * 2;

$chart_width = ($kotak * 32) + 100;
$chart_margin_left = 61.5;

//die;


?>

<table style="width: 100%; border: none;">
    <tr>
        <td width="150" style="text-align: center; vertical-align: middle;">Denyut <br>Jantung <br>Janin <br>( / menit)</td>
        <td colspan="2"  style="text-align: right;">
            <canvas id="chart_denyut">
                
            </canvas>
        </td>
    </tr>
    <tr>
        <td colspan="2" width="200"></td>
        <td>
            
        </td>
    </tr>
</table>
<script>

var imgPA = new Image(12, 12);
imgPA.src ='<?php echo Yii::app()->getBaseUrl('webroot').'/images/panah_atas.png'; ?>';

var imgDA = new Image(12, 12);
imgDA.src ='<?php echo Yii::app()->getBaseUrl('webroot').'/images/panah_bawah.png'; ?>';

var imgS = new Image(12, 12);
imgS.src ='<?php echo Yii::app()->getBaseUrl('webroot').'/images/silang.png'; ?>';

function generateChartNadi() {
    var denyut1 = $("#chart_denyut");
    denyut1[0].height = 200;
    denyut1[0].width = <?php echo $chart_width; ?>;
    
    
    var lineChart1 = new Chart(denyut1, {
        type: 'line',
        data: {
            labels: <?php echo CJSON::encode($label_waktu); ?>,
            datasets: [
                // Pre Operatif
                {
                    label: 'Nadi',
                    lineTension: 0,
                    display: false,
                    data: <?php echo CJSON::encode($nadi); ?>,
                    backgroundColor: 'black',
                    pointStyle: 'circle',
                    pointRadius: 5,
                    pointBorderColor: 'black',
                    fill: false,
                    borderColor: "black",
                }

            ]
        },
        options: {
            animation: {
                duration: 0
            },
            spanGaps: true,
            bezierCurve: false,
            layout: {
                padding: {
                    left: <?php echo $chart_margin_left; ?>,
                    right: 0,
                    top: 0,
                    bottom: 0
                }
            },
            legend: {
                display: false,
                labels: {
                    usePointStyle: true,
                },
            },
            scales: {
                xAxes: [{
                    type: "time",
                    time: {
                        parser: "HH:mm",
                        unit: 'minute',
                        unitStepSize: 30,
                        displayFormats: {
                            'hour': 'HH:mm',
                            'minute': 'HH:mm',
                        },
                        //tooltipFormat: 'HH:mm'
                    },
                    ticks: {
                        callback: function(value, index, values) {

                            return "";

                            var arr_val = value.substring(3);

                            console.log(value, arr_val);
                            if (arr_val == "00") {
                                return value;
                            } else {
                                return "";
                            }

                        }
                    },
                    gridLines: {
                        zeroLineWidth: 4,
                        drawBorder: false,
                        color: 'rgba(0, 0, 0, 1)'
                    }
                }],
                yAxes: [{
                    gridLines: {
                        color: 'rgba(0, 0, 0, 1)'
                    },
                    ticks: {
                        min: 80,
                        max: 200,
                        stepSize: 10,
                        beginAtZero: true,
                        fontSize: 10,
                        padding: 5
                    }
                }]
            },
            responsive: false,
            /*
             tooltips: {
             mode: 'nearest',
             intersect: false,
             },
             responsive: true,

             */

        }
    });
    
    
}
function generateChartNadiIbu() {
    var denyut2 = $("#chart_tekanan");
    denyut2[0].height = 200;
    denyut2[0].width = <?php echo $chart_width; ?>;
    
    
    var lineChart2 = new Chart(denyut2, {
        type: 'line',
        data: {
            labels: <?php echo CJSON::encode($label_waktu); ?>,
            datasets: [
                // Pre Operatif
                {
                    label: 'Nadi',
                    lineTension: 0,
                    display: false,
                    data: <?php echo CJSON::encode($nadi_ibu); ?>,
                    backgroundColor: 'black',
                    pointStyle: 'circle',
                    pointRadius: 5,
                    pointBorderColor: 'black',
                    fill: false,
                    borderColor: "black",
                },
                { 
                    type:'line',
                    label: 'Diastolic',
                    yAxisID: 'C',
                    display: false,
                    fill: false,
                    showLine: false,
                    data: <?php echo CJSON::encode($diastolic); ?>,
                    backgroundColor: 'black',
                    borderColor: 'black',
                    pointStyle: imgDA,              
                    pointRadius: 2,                        
                },
                { 
                    type:'line',
                    label: 'Systolic',
                    yAxisID: 'C',
                    display: false,
                    fill: false,
                    showLine: false,
                    data: <?php echo CJSON::encode($systolic); ?>,
                    backgroundColor: 'black',
                    borderColor: 'black',
                    pointStyle: imgPA,                       
                    pointRadius: 2,                        
                }

            ]
        },
        options: {
            animation: {
                duration: 0
            },
            spanGaps: true,
            bezierCurve: false,
            layout: {
                padding: {
                    left: <?php echo $chart_margin_left; ?>,
                    right: 0,
                    top: 0,
                    bottom: 0
                }
            },
            legend: {
                display: false,
                labels: {
                    usePointStyle: true,
                },
            },
            scales: {
                xAxes: [{
                    type: "time",
                    time: {
                        parser: "HH:mm",
                        unit: 'minute',
                        unitStepSize: 30,
                        displayFormats: {
                            'hour': 'HH:mm',
                            'minute': 'HH:mm',
                        },
                        //tooltipFormat: 'HH:mm'
                    },
                    ticks: {
                        callback: function(value, index, values) {

                            return "";

                            var arr_val = value.substring(3);

                            console.log(value, arr_val);
                            if (arr_val == "00") {
                                return value;
                            } else {
                                return "";
                            }

                        }
                    },
                    gridLines: {
                        zeroLineWidth: 4,
                        drawBorder: false,
                        color: 'rgba(0, 0, 0, 1)'
                    }
                }],
                yAxes: [{
                    id: 'C',
                    gridLines: {
                        color: 'rgba(0, 0, 0, 1)'
                    },
                    ticks: {
                        min: 60,
                        max: 180,
                        stepSize: 10,
                        beginAtZero: true,
                        fontSize: 10,
                        padding: 5
                    }
                }]
            },
            responsive: false,
            /*
             tooltips: {
             mode: 'nearest',
             intersect: false,
             },
             responsive: true,

             */

        }
    });
}

function generateChartServiks() {
    var denyut2 = $("#chart_serviks");
    denyut2[0].height = 200;
    denyut2[0].width = <?php echo $chart_width; ?>;
    
    
    
    
    var lineChart2 = new Chart(denyut2, {
        type: 'line',
        data: {
            labels: <?php echo CJSON::encode($label_waktu); ?>,
            datasets: [
                // Pre Operatif
                
                {
                    label: 'Serviks',
                    lineTension: 0,
                    display: false,
                    data: <?php echo CJSON::encode($serviks); ?>,
                    backgroundColor: 'black',
                    pointStyle: imgS,
                    pointRadius: 5,
                    pointBorderColor: 'black',
                    fill: false,
                    borderColor: "black",
                },
                {
                    label: 'Turun Kepala',
                    lineTension: 0,
                    display: false,
                    data: <?php echo CJSON::encode($turunkepala); ?>,
                    backgroundColor: 'white',
                    pointStyle: 'circle',
                    pointRadius: 5,
                    pointBorderColor: 'black',
                    fill: false,
                    borderColor: "black",
                },
                {
                    label: 'WASPADA',
                    lineTension: 0,
                    display: false,
                    data: <?php echo CJSON::encode($waspada); ?>,
                    backgroundColor: 'black',
                    pointStyle: false,
                    borderWidth: 1,
                    pointRadius: 1,
                    pointBorderColor: 'black',
                    fill: false,
                    borderColor: "black",
                },
                {
                    label: 'BERTINDAK',
                    lineTension: 0,
                    display: false,
                    data: <?php echo CJSON::encode($bertindak); ?>,
                    backgroundColor: 'black',
                    pointStyle: false,
                    borderWidth: 1,
                    pointRadius: 1,
                    pointBorderColor: 'black',
                    fill: false,
                    borderColor: "black",
                },

            ]
        },
        options: {
            events: [],
            tooltips: {
                 enabled: false
            },
            animation: {
                duration: 0,
                onComplete: function() {
                    
                }
            },
            spanGaps: true,
            bezierCurve: false,
            layout: {
                padding: {
                    left: <?php echo $chart_margin_left + 7; ?>,
                    right: 0,
                    top: 0,
                    bottom: 0
                }
            },
            legend: {
                display: false,
                labels: {
                    usePointStyle: true,
                },
            },
            scales: {
                xAxes: [{
                    type: "time",
                    time: {
                        parser: "HH:mm",
                        unit: 'minute',
                        unitStepSize: 30,
                        displayFormats: {
                            'hour': 'HH:mm',
                            'minute': 'HH:mm',
                        },
                        //tooltipFormat: 'HH:mm'
                    },
                    ticks: {
                        callback: function(value, index, values) {

                            return "";

                            var arr_val = value.substring(3);

                            console.log(value, arr_val);
                            if (arr_val == "00") {
                                return value;
                            } else {
                                return "";
                            }

                        }
                    },
                    gridLines: {
                        zeroLineWidth: 4,
                        drawBorder: false,
                        color: 'rgba(0, 0, 0, 1)'
                    }
                }],
                yAxes: [{
                    id: 'C',
                    gridLines: {
                        color: 'rgba(0, 0, 0, 1)'
                    },
                    ticks: {
                        min: 0,
                        max: 10,
                        stepSize: 1,
                        beginAtZero: true,
                        fontSize: 10,
                        padding: 3
                    }
                }]
            },
            responsive: false,
            /*
             tooltips: {
             mode: 'nearest',
             intersect: false,
             },
             responsive: true,

             */

        }
    });
    
    var ctx = denyut2[0].getContext("2d");
    ctx.save();
    ctx.font = "bold 14px arial";
    ctx.rotate(-16 * Math.PI / 180);
    ctx.fillText("WASPADA", 150, 115);
    ctx.fillText("TINDAKAN", 360, 175);
    ctx.restore();
    // tambah label
    
    
}

$(document).ready(function() {
    generateChartNadi();
    generateChartNadiIbu();
    generateChartServiks();
});

</script>
<div style="padding-right: 5px;">
<table class="table paddingtext2">
    <tr>
        <td style="border:none !important; text-align: right; padding-right: 15px;">
            Air Ketuban
        </td>
        <?php
        
        
            
        
            foreach($partograf['airketuban'] as $det){
        ?>
            <td width='<?php echo $kotak; ?>'><?php echo $det ?></td>
        <?php
            }						
            for ($i=1;$i<=(32-count((array)$partograf['airketuban']));$i++){
                echo "<td width='".$kotak."'>&nbsp;</td>";
            }
        ?>
    </tr>
    <tr>
        <td style="border:none !important; text-align: right; padding-right: 15px;">
            Penyusupan
        </td>
        <?php
            foreach($partograf['penyusupan'] as $det){
        ?>
            <td width=''><?php echo $det ?></td>
        <?php
            }						
            for ($i=1;$i<=(32-count((array)$partograf['penyusupan']));$i++){
                echo "<td width=''>&nbsp;</td>";
            }
        ?>
    </tr>
</table>
</div>
<table style="width: 100%; border: none;">
    <tr>
        <td class='paddingtext2' width="150" style="border:none !important;text-align:center;vertical-align:bottom;padding-bottom:10px;">
            <div class="putar">
                Pembukaan serviks (cm) beri tanda x						
            </div>						
            <hr>
            <div class="putar2">
                Turunya kepala beri tanda O					
            </div>	
            <hr>
            <div class="putar3">
                Sentimeter (cm)
            </div>
        </td>
        <td>
            <canvas id="chart_serviks">
                
            </canvas>
        </td>
    </tr>
</table>
<div style="padding-right: 5px;">
<table class="table paddingtext2">
    <tr>
		
        <td style="border:none !important;" width="231">
            &nbsp;
        </td>			
        <?php

            $kotak16a = 50.5;
        
            for ($i=1;$i<=16;$i++){
                echo "<td style='text-align:right;' width='".$kotak16a."'>".$i."</td>";
            }
        ?>
    </tr>
    <tr>

        <td style="border:none !important;text-align:right; padding: 15px;">
            Waktu <br>(jam)
        </td>
        <?php
            $offset2 = $offset / 2;
            for ($i = 0; $i < $offset2; $i++) {
        ?>
        <td width='<?php echo $kotak16a; ?>'>&nbsp;</td>
        <?php
            }
        
            foreach($partograf['waktu'] as $det){
        ?>
        <td width='<?php echo $kotak16a; ?>'><?php echo $det ?></td>
        <?php
            }
            for ($i=1;$i<=(16-(count((array)$partograf['waktu']) + $offset2));$i++){
                
                $det = date('H:i', strtotime($det." + 1 hour"));
                
                echo "<td width='".($kotak16a)."'>".$det."</td>";
            }
        ?>
    </tr>
</table>
</div>



<div style="padding-right: 5px;">
<table class="table paddingtext2">
    <?php //kontraksi 
        for($b=5;$b>=1;$b--){
		?>		<?php 
                $rows = 1;
                if ($b == 4){
                    $nm = '<span class="detikk20" style="width:20px;margin-right:12px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>  '.Params::PARTOGRAF_KONTRAK_KURANG.' '.$b; 
                }elseif ($b == 3){
                    $nm = '<span class="detik20sd40" style="width:20px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>  '.Params::PARTOGRAF_KONTRAK_SD.' '.$b; 
                }elseif ($b == 2){						
                    $nm = '<span class="detikl40" style="width:20px;margin-right:12px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>  '.Params::PARTOGRAF_KONTRAK_LEBIH.' '.$b; 
                }elseif ($b == 1){						
                    $nm = '<span style="width:10px;border:1px solid #333;">&nbsp;(dtk)&nbsp;</span>  '.$b; 
                }else{
                    $nm = $b; 
                }
            ?>
            <tr>
                <?php if ($b == 5){ ?>
                <td rowspan="<?php echo $b ?>"  width="100" style="border:none !important;text-align:center;vertical-align:bottom;padding-bottom:10px;">
                    <?php 
                    echo '<div  style="border:1px solid #333;font-size:10px;">Kontraksi<br>tiap<br>10 menit</div>'; 
                    ?>
                </td>
                <?php } ?>

                <td style="border:none !important;text-align:right; text-align: right; padding-right: 15px;">
                    <?php echo $nm; ?>
                </td>					

                <?php
                    foreach($partograf['kontraksi']['jml'] as $key => $det){
                        $class='';

                        if ($partograf['kontraksi']['mnt'][$key] == Params::PARTOGRAF_KONTRAK_KURANG){
                            $class='detikk20';
                        }elseif ($partograf['kontraksi']['mnt'][$key] == Params::PARTOGRAF_KONTRAK_SD){
                            $class='detik20sd40';
                        }elseif ($partograf['kontraksi']['mnt'][$key] == Params::PARTOGRAF_KONTRAK_LEBIH){
                            $class='detikl40';
                        }

                        if ($b > $det){

                            $class='';
                        }

                        $det = '';
                ?>
                    <td width='<?php echo $kotak; ?>' class='<?php echo $class; ?>'><?php echo $det ?></td>
                <?php
                    }						
                    for ($i=1;$i<=(32-count((array)$partograf['kontraksi']['jml']));$i++){
                        echo "<td width='".$kotak."'>&nbsp;</td>";
                    }
                ?>
            </tr>
    <?php }//kontraksi ?>
            
    <tr>
        <td colspan="34" style="border:none !important;">&nbsp;</td>
    </tr>
    <tr>
        <td width="" style="border:none !important;">
            &nbsp;
        </td>
        <td width=""  style="border:none !important; text-align: right; padding-right: 15px;">
            Oksilosin U/L
        </td>
        <?php
            foreach($partograf['oksilosin'] as $det){
        ?>
            <td width=''><?php echo $det ?></td>
        <?php
            }						
            for ($i=1;$i<=(32-count((array)$partograf['oksilosin']));$i++){
                echo "<td width=''>&nbsp;</td>";
            }
        ?>
    </tr>
    <tr>
        <td width="" style="border:none !important;">
            &nbsp;
        </td>
        <td width=""  style="border:none !important; text-align: right; padding-right: 15px;">
            tetes/menit
        </td>
        <?php
            foreach($partograf['tetesmenit'] as $det){
        ?>
            <td width=''><?php echo $det ?></td>
        <?php
            }						
            for ($i=1;$i<=(32-count((array)$partograf['tetesmenit']));$i++){
                echo "<td width=''>&nbsp;</td>";
            }
        ?>
    </tr>        
    <tr>
        <td colspan="34" style="border:none !important;">&nbsp;</td>
    </tr>
    
    <tr>
        <td width="" style="border:none !important;">
            &nbsp;
        </td>
        <td width=""  style="border:none !important; text-align: right; padding-right: 15px;">
            Obat dan<br>
            Cairan IV
        </td>
        <?php
        
            for ($i = 0; $i < $offset2; $i++) {
                echo "<td colspan='2' width=''>&nbsp;</td>";
            }
        
            foreach($partograf['obat'] as $det){
                $ol = '<ol style="padding: 0;margin: 0;font-size:7px;">';
                foreach ($det['det'] as $o){
                    $ol .= "<li>".$o."</li>";
                }
                $ol .= '</ol>';
        ?>
            <td colspan='2' width=''><?php echo $ol ?></td>
        <?php
            }						
            for ($i=1;$i<=(16-(count((array)$partograf['obat']) + $offset2));$i++){
                echo "<td colspan='2' width=''>&nbsp;</td>";
            }
        ?>
    </tr>
    
</table>
</div>

<table style="width: 100%; border: none;">
    <tr>
        <td width="150" style="text-align: center; vertical-align: middle;">
            <table class='table noborder paddingtext2' style='text-align:center;'>
                <tr>		
                    <td></td>
                    <td width='15px' style='text-align:center;'><span style = "box-shadow:  inset -100px -100px 0px 100px rgb(0, 3, 51);font-weight:bold;font-size:4pt;background-color:#333;border-radius:50%;">10</span>Nadi</td>
                </tr>
                <tr>
                    <td style='border-right:2px solid #333 !important;'><div class="tekanandarah-up"><i class='entypo-up-open'></i></div></div><div class="tekanandarah-down"><i class='entypo-down-open'></i></div></td>
                    <td style='vertical-align: middle;text-align:center;'><div  style='height:140px;font-size:11px;'><br><br><br><br><br><br>Tekanan<br>Darah</div></td>
                </tr>							
            </table>
        </td>
        <td colspan="2">
            <canvas id="chart_tekanan">
                
            </canvas>
        </td>
    </tr>
    <tr>
        <td colspan="2" width="200"></td>
        <td>
            
        </td>
    </tr>
</table>



<div style="padding-right: 5px;">
    <table class="table paddingtext2">
        <tr>
			<td colspan="34" style="border:none !important;">&nbsp;</td>
		</tr>
		<tr>
			<td width="" style="border:none !important;">
				
			</td>
			<td width=""  style="border:none !important; text-align: right; padding-right: 15px;">
				Suhu &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<sup>o</sup>C
			</td>
			<?php
				foreach($partograf['suhu'] as $det){
			?>
				<td width='<?php echo $kotak; ?>'><?php echo $det ?></td>
			<?php
				}						
				for ($i=1;$i<=(32-count((array)$partograf['suhu']));$i++){
					echo "<td width='".$kotak."'>&nbsp;</td>";
				}
			?>
		</tr>	
		<tr>
			<td colspan="34" style="border:none !important;">&nbsp;</td>
		</tr>
		<tr>
			<td width="150" style="text-align:right;border:none !important;vertical-align: middle; text-align: right; padding-right: 15px; border-right: 1px solid black !important;" rowspan="3">
				Urin
			</td>
			<td width=""  style="border:none !important; text-align: right; padding-right: 15px;">
				Protein
			</td>
			<?php
				foreach($partograf['urinprotein'] as $det){
			?>
				<td width=''><?php echo $det ?></td>
			<?php
				}						
				for ($i=1;$i<=(32-count((array)$partograf['urinprotein']));$i++){
					echo "<td width=''>&nbsp;</td>";
				}
			?>
		</tr>				
		<tr>
			
			<td width=""  style="border:none !important; text-align: right; padding-right: 15px;">
				Asolon
			</td>
			<?php
				foreach($partograf['urinaseton'] as $det){
			?>
				<td width=''><?php echo $det ?></td>
			<?php
				}						
				for ($i=1;$i<=(32-count((array)$partograf['urinaseton']));$i++){
					echo "<td width=''>&nbsp;</td>";
				}
			?>
		</tr>	
		<tr>
			
			<td width=""  style="border:none !important; text-align: right; padding-right: 15px;">
				Volume
			</td>
			<?php
				foreach($partograf['urinvolume'] as $det){
			?>
				<td width=''><?php echo $det ?></td>
			<?php
				}						
				for ($i=1;$i<=(32-count((array)$partograf['urinvolume']));$i++){
					echo "<td width=''>&nbsp;</td>";
				}
			?>
		</tr>
    </table>
</div>
